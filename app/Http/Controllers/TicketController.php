<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->filteredQuery($request);
        $sorts = [
            'newest' => ['created_at', 'desc'],
            'oldest' => ['created_at', 'asc'],
            'priority' => ['priority', 'desc'],
            'title' => ['title', 'asc'],
        ];
        [$column, $direction] = $sorts[$request->input('sort', 'newest')] ?? $sorts['newest'];

        if ($column === 'priority') {
            $query->orderByRaw("CASE priority WHEN 'urgent' THEN 4 WHEN 'high' THEN 3 WHEN 'normal' THEN 2 ELSE 1 END {$direction}");
        } else {
            $query->orderBy($column, $direction);
        }

        $tickets = $query->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    public function board(Request $request)
    {
        $tickets = $this->filteredQuery($request)
            ->orderByRaw("CASE priority WHEN 'urgent' THEN 4 WHEN 'high' THEN 3 WHEN 'normal' THEN 2 ELSE 1 END DESC")
            ->latest('updated_at')
            ->get()
            ->groupBy('status');

        $categories = Category::orderBy('name')->get();
        $statuses = [
            'open' => 'Abertos',
            'in_progress' => 'Em atendimento',
            'waiting' => 'Aguardando',
            'resolved' => 'Resolvidos',
            'closed' => 'Fechados',
        ];

        return view('tickets.board', compact('tickets', 'categories', 'statuses'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'category_id' => ['required', 'exists:categories,id'],
            'priority' => ['required', 'in:low,normal,high,urgent'],
        ]);

        $user = User::firstOrFail();
        $nextId = (Ticket::max('id') ?? 0) + 1;

        $ticket = Ticket::create([
            ...$validated,
            'protocol' => 'HD-'.date('Y').'-'.str_pad($nextId, 5, '0', STR_PAD_LEFT),
            'user_id' => $user->id,
            'status' => 'open',
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Chamado criado com sucesso.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'category', 'assignedUser', 'comments.user']);
        $users = User::orderBy('name')->get();

        return view('tickets.show', compact('ticket', 'users'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:open,in_progress,waiting,resolved,closed'],
            'priority' => ['required', 'in:low,normal,high,urgent'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $ticket->fill($validated);
        $ticket->resolved_at = in_array($validated['status'], ['resolved', 'closed'], true)
            ? ($ticket->resolved_at ?? now())
            : null;
        $ticket->save();

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Chamado atualizado com sucesso.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Chamado removido.');
    }

    private function filteredQuery(Request $request): Builder
    {
        $query = Ticket::with(['user', 'category', 'assignedUser']);

        if ($request->filled('search')) {
            $search = trim((string) $request->search);
            $query->where(fn (Builder $builder) => $builder
                ->where('title', 'like', "%{$search}%")
                ->orWhere('protocol', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"));
        }

        foreach (['status', 'priority'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->integer('category'));
        }

        return $query;
    }
}
