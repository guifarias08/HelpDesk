<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
{
    $query = Ticket::with([
        'user',
        'category',
        'assignedUser'
    ]);

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where(
                'title',
                'like',
                "%{$search}%"
            )
            ->orWhere(
                'protocol',
                'like',
                "%{$search}%"
            );

        });
    }

    if ($request->filled('status')) {
        $query->where(
            'status',
            $request->status
        );
    }

    if ($request->filled('priority')) {
        $query->where(
            'priority',
            $request->priority
        );
    }

    if ($request->filled('category')) {
        $query->where(
            'category_id',
            $request->category
        );
    }

    $tickets = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    $categories = Category::orderBy('name')->get();

    return view(
        'tickets.index',
        compact(
            'tickets',
            'categories'
        )
    );
}


    public function create()
    {
        $categories =
            Category::orderBy('name')->get();

        return view(
            'tickets.create',
            compact('categories')
        );
    }


    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => [
            'required',
            'string',
            'max:255',
        ],

        'description' => [
            'required',
            'string',
        ],

        'category_id' => [
            'nullable',
            'exists:categories,id',
        ],

        'priority' => [
            'required',
            'in:low,normal,high,urgent',
        ],
    ]);
   
    // Usuário temporário enquanto o login não está configurado
    $user = \App\Models\User::findOrFail(1);

    $nextId = (Ticket::max('id') ?? 0) + 1;

    $protocol = 'HD-'
        . date('Y')
        . '-'
        . str_pad(
            $nextId,
            5,
            '0',
            STR_PAD_LEFT
        );

    $ticket = Ticket::create([
        'title' => $validated['title'],

        'description' => $validated['description'],

        'category_id' =>
            $validated['category_id'] ?? null,

        'priority' => $validated['priority'],

        'protocol' => $protocol,

        'user_id' => $user->id,

        'status' => 'open',
    ]);

    return redirect()
        ->route('tickets.show', $ticket)
        ->with(
            'success',
            'Chamado criado com sucesso!'
        );
}


        public function show(Ticket $ticket)
    {
        $ticket->load([
            'user',
            'category',
            'assignedUser',
            'comments.user',
        ]);

        $users = \App\Models\User::orderBy('name')->get();

        return view('tickets.show', compact(
            'ticket',
            'users'
        ));
    }

public function update(Request $request, Ticket $ticket)
{
    $validated = $request->validate([
        'status' => [
            'required',
            'in:open,in_progress,waiting,resolved,closed',
        ],

        'priority' => [
            'required',
            'in:low,normal,high,urgent',
        ],

        'assigned_to' => [
            'nullable',
            'exists:users,id',
        ],
    ]);

    $ticket->status = $validated['status'];
    $ticket->priority = $validated['priority'];
    $ticket->assigned_to = $validated['assigned_to'] ?? null;

    if ($validated['status'] === 'resolved') {
        $ticket->resolved_at = now();
    } else {
        $ticket->resolved_at = null;
    }

    $ticket->save();

    return redirect()
        ->route('tickets.show', $ticket)
        ->with('success', 'Chamado atualizado com sucesso!');
}


    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with(
                'success',
                'Chamado removido.'
            );
    }
}