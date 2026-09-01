<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTickets = Ticket::count();

        $openTickets = Ticket::where(
            'status',
            'open'
        )->count();

        $inProgressTickets = Ticket::where(
            'status',
            'in_progress'
        )->count();

        $resolvedTickets = Ticket::where(
            'status',
            'resolved'
        )->count();

        $urgentTickets = Ticket::where(
            'priority',
            'urgent'
        )
        ->whereNotIn('status', [
            'resolved',
            'closed'
        ])
        ->count();

        $recentTickets = Ticket::with([
            'user',
            'category',
            'assignedUser'
        ])
        ->latest()
        ->take(6)
        ->get();

        return view(
            'dashboard', compact(
                'totalTickets',
                'openTickets',
                'inProgressTickets',
                'resolvedTickets',
                'urgentTickets',
                'recentTickets'
            )
        );
    }
}