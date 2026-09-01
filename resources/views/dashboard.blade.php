@extends('layouts.app')

@section('title', 'Dashboard | HelpDesk')

@section('content')

<section class="hero-dashboard">

    <div class="hero-content">
        <span class="hero-badge">VISÃO GERAL</span>

        <h1 class="hero-title">
            Central de chamados
        </h1>

        <p class="hero-text">
            Acompanhe tickets, atendimentos e resoluções
            em uma interface mais moderna, organizada e visual.
        </p>

        <div class="hero-actions">
            <a href="{{ route('tickets.create') }}" class="btn-primary">
                + Novo chamado
            </a>

        </div>
    </div>

   

    

    </div>

</section>


<section class="stats-grid stats-grid-modern">

    <div class="stat-modern warning">
        <div class="stat-modern-icon">🟡</div>
        <div>
            <span>Abertos</span>
            <strong>{{ $openTickets }}</strong>
        </div>
    </div>

    <div class="stat-modern info">
        <div class="stat-modern-icon">🔵</div>
        <div>
            <span>Em atendimento</span>
            <strong>{{ $inProgressTickets }}</strong>
        </div>
    </div>

    <div class="stat-modern success">
        <div class="stat-modern-icon">🟢</div>
        <div>
            <span>Resolvidos</span>
            <strong>{{ $resolvedTickets }}</strong>
        </div>
    </div>

    <div class="stat-modern danger">
        <div class="stat-modern-icon">🔴</div>
        <div>
            <span>Urgentes</span>
            <strong>{{ $urgentTickets }}</strong>
        </div>
    </div>

</section>


<section class="modern-panel">
    <div class="modern-panel-header">
        <div>
            <h2>Chamados recentes</h2>
            <p>Últimas solicitações abertas no sistema.</p>
        </div>

        <a href="{{ route('tickets.index') }}" class="panel-link">
            Ver todos →
        </a>
    </div>

    <div class="modern-ticket-list">
        @forelse($recentTickets as $ticket)
            <a href="{{ route('tickets.show', $ticket) }}" class="modern-ticket-row">
                <div class="modern-ticket-main">
                    <small class="ticket-protocol">{{ $ticket->protocol }}</small>
                    <h3>{{ $ticket->title }}</h3>
                    <p>
                        {{ $ticket->user->name ?? 'Administrador' }}
                        @if($ticket->category)
                            • {{ $ticket->category->name }}
                        @endif
                    </p>
                </div>

                <div class="modern-ticket-tags">
                    <span class="tag priority-{{ $ticket->priority }}">
                        {{ $ticket->priority_label ?? ucfirst($ticket->priority) }}
                    </span>

                    <span class="tag status-{{ $ticket->status }}">
                        {{ $ticket->status_label ?? ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                </div>
            </a>
        @empty
            <div class="empty-modern">
                <h3>Nenhum chamado recente</h3>
                <p>Ainda não existem chamados cadastrados.</p>

                <a href="{{ route('tickets.create') }}" class="btn-primary">
                    + Abrir primeiro chamado
                </a>
            </div>
        @endforelse
    </div>
</section>

@endsection