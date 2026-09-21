<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = Ticket::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN status = 'open' THEN 1 ELSE 0 END) as open_count")
            ->selectRaw("SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as progress_count")
            ->selectRaw("SUM(CASE WHEN status = 'waiting' THEN 1 ELSE 0 END) as waiting_count")
            ->selectRaw("SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved_count")
            ->selectRaw("SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as closed_count")
            ->first();

        $totalTickets = (int) $counts->total;
        $openTickets = (int) $counts->open_count;
        $inProgressTickets = (int) $counts->progress_count;
        $waitingTickets = (int) $counts->waiting_count;
        $resolvedTickets = (int) $counts->resolved_count;
        $closedTickets = (int) $counts->closed_count;

        $urgentTickets = Ticket::where('priority', 'urgent')
            ->whereNotIn('status', ['resolved', 'closed'])
            ->count();

        $unassignedTickets = Ticket::whereNull('assigned_to')
            ->whereNotIn('status', ['resolved', 'closed'])
            ->count();

        $recentTickets = Ticket::with([
            'user',
            'category',
            'assignedUser',
        ])
            ->latest()
            ->take(6)
            ->get();

        $categoryStats = Category::withCount([
            'tickets as active_tickets_count' => fn ($query) => $query
                ->whereNotIn('status', ['resolved', 'closed']),
        ])->orderByDesc('active_tickets_count')->orderBy('name')->take(5)->get();

        $completionRate = $totalTickets > 0
            ? (int) round((($resolvedTickets + $closedTickets) / $totalTickets) * 100)
            : 0;

        return view(
            'dashboard', compact(
                'totalTickets',
                'openTickets',
                'inProgressTickets',
                'waitingTickets',
                'resolvedTickets',
                'closedTickets',
                'urgentTickets',
                'unassignedTickets',
                'completionRate',
                'categoryStats',
                'recentTickets'
            )
        );
    }
}
