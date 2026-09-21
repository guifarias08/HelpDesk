@extends('layouts.app')

@section('title', 'Visão geral | HelpDesk')

@section('content')
<section class="page-heading hero-heading">
    <div class="page-heading-content">
        <span class="eyebrow"><i></i> OPERAÇÃO EM TEMPO REAL</span>
        <h1>Olá, Administrador.</h1>
        <p>Veja o que precisa de atenção e mantenha os atendimentos em movimento.</p>
    </div>
    <div class="page-heading-actions">
        <a href="{{ route('tickets.board') }}" class="btn btn-secondary"><span>▦</span> Ver quadro</a>
    </div>
</section>

<section class="stats-grid" aria-label="Indicadores de chamados">
    <a href="{{ route('tickets.index', ['status' => 'open']) }}" class="stat-card stat-open">
        <div class="stat-card-top"><span class="stat-icon">○</span><span class="stat-trend">Ver fila →</span></div>
        <strong>{{ $openTickets }}</strong>
        <div><h2>Abertos</h2><p>Aguardando triagem inicial</p></div>
    </a>
    <a href="{{ route('tickets.index', ['status' => 'in_progress']) }}" class="stat-card stat-progress">
        <div class="stat-card-top"><span class="stat-icon">◒</span><span class="stat-trend">Ver fila →</span></div>
        <strong>{{ $inProgressTickets }}</strong>
        <div><h2>Em atendimento</h2><p>Sendo tratados pela equipe</p></div>
    </a>
    <a href="{{ route('tickets.index', ['status' => 'waiting']) }}" class="stat-card stat-waiting">
        <div class="stat-card-top"><span class="stat-icon">◷</span><span class="stat-trend">Ver fila →</span></div>
        <strong>{{ $waitingTickets }}</strong>
        <div><h2>Aguardando</h2><p>Dependem de retorno do usuário</p></div>
    </a>
    <a href="{{ route('tickets.index', ['priority' => 'urgent']) }}" class="stat-card stat-urgent">
        <div class="stat-card-top"><span class="stat-icon">!</span><span class="stat-trend">Ver críticos →</span></div>
        <strong>{{ $urgentTickets }}</strong>
        <div><h2>Urgentes</h2><p>Exigem atenção prioritária</p></div>
    </a>
</section>

<section class="dashboard-layout">
    <div class="panel recent-panel">
        <div class="panel-header">
            <div class="panel-title"><span class="panel-icon">▤</span><div><h2>Chamados recentes</h2><p>Últimas movimentações registradas</p></div></div>
            <a href="{{ route('tickets.index') }}" class="text-link">Ver todos <span>→</span></a>
        </div>
        <div class="recent-list">
            @forelse($recentTickets as $ticket)
                <a href="{{ route('tickets.show', $ticket) }}" class="recent-ticket">
                    <span class="priority-line priority-line-{{ $ticket->priority }}"></span>
                    <div class="recent-main">
                        <div class="recent-protocol">{{ $ticket->protocol }} <span>•</span> {{ $ticket->created_at->diffForHumans() }}</div>
                        <h3>{{ $ticket->title }}</h3>
                        <p>{{ $ticket->category->name ?? 'Sem categoria' }} · {{ $ticket->assignedUser->name ?? 'Não atribuído' }}</p>
                    </div>
                    <div class="recent-meta">
                        <span class="badge priority-{{ $ticket->priority }}">{{ $ticket->priority_label }}</span>
                        <span class="badge status-{{ $ticket->status }}"><i></i>{{ $ticket->status_label }}</span>
                    </div>
                    <span class="row-chevron">›</span>
                </a>
            @empty
                <div class="empty-state"><span class="empty-icon">▤</span><h3>Sua fila está vazia</h3><p>Use “Novo chamado” no menu superior para começar.</p></div>
            @endforelse
        </div>
    </div>

    <aside class="dashboard-side">
        <div class="panel health-panel">
            <div class="panel-header compact"><div class="panel-title"><span class="panel-icon">◎</span><div><h2>Saúde da operação</h2><p>{{ $totalTickets }} chamados registrados</p></div></div></div>
            <div class="completion-ring" style="--progress: {{ $completionRate }}">
                <div><strong>{{ $completionRate }}%</strong><span>concluídos</span></div>
            </div>
            <div class="health-metrics">
                <div><span>Resolvidos</span><strong>{{ $resolvedTickets + $closedTickets }}</strong></div>
                <div><span>Sem responsável</span><strong class="{{ $unassignedTickets > 0 ? 'text-warning' : '' }}">{{ $unassignedTickets }}</strong></div>
            </div>
        </div>

        <div class="panel category-load-panel">
            <div class="panel-header compact"><div class="panel-title"><span class="panel-icon">◇</span><div><h2>Carga por categoria</h2><p>Chamados ativos</p></div></div><a href="{{ route('categories.index') }}" class="icon-link" aria-label="Gerenciar categorias">→</a></div>
            <div class="category-load-list">
                @forelse($categoryStats as $category)
                    <a href="{{ route('tickets.index', ['category' => $category->id]) }}">
                        <span class="category-symbol">{{ $category->icon ?: '◇' }}</span>
                        <span>{{ $category->name }}</span>
                        <strong>{{ $category->active_tickets_count }}</strong>
                    </a>
                @empty
                    <p class="muted-copy">Nenhuma categoria cadastrada.</p>
                @endforelse
            </div>
        </div>
    </aside>
</section>
@endsection
