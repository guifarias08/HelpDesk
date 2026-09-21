@extends('layouts.app')

@section('title', 'Chamados | HelpDesk')

@section('content')
<section class="page-heading">
    <div class="page-heading-content">
        <span class="eyebrow"><i></i> CENTRAL DE ATENDIMENTO</span>
        <h1>Chamados</h1>
        <p>Consulte, filtre e acompanhe cada solicitação em um só lugar.</p>
    </div>
    <div class="page-heading-actions">
        <div class="view-switch" aria-label="Modo de visualização">
            <a class="active" href="{{ route('tickets.index', request()->query()) }}" aria-current="page">☷ Lista</a>
            <a href="{{ route('tickets.board', request()->except(['page', 'sort'])) }}">▦ Quadro</a>
        </div>
    </div>
</section>

<section class="panel filters-panel">
    <form action="{{ route('tickets.index') }}" method="GET" class="filters-grid" id="ticketFilters">
        <div class="field search-field">
            <label for="search">Buscar</label>
            <div class="input-icon-wrap"><span>⌕</span><input type="search" id="search" name="search" value="{{ request('search') }}" placeholder="Protocolo, título ou descrição..." autocomplete="off"><kbd>/</kbd></div>
        </div>
        <div class="field">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="">Todos os status</option>
                <option value="open" @selected(request('status') === 'open')>Aberto</option>
                <option value="in_progress" @selected(request('status') === 'in_progress')>Em atendimento</option>
                <option value="waiting" @selected(request('status') === 'waiting')>Aguardando usuário</option>
                <option value="resolved" @selected(request('status') === 'resolved')>Resolvido</option>
                <option value="closed" @selected(request('status') === 'closed')>Fechado</option>
            </select>
        </div>
        <div class="field">
            <label for="priority">Prioridade</label>
            <select id="priority" name="priority">
                <option value="">Todas</option>
                <option value="low" @selected(request('priority') === 'low')>Baixa</option>
                <option value="normal" @selected(request('priority') === 'normal')>Normal</option>
                <option value="high" @selected(request('priority') === 'high')>Alta</option>
                <option value="urgent" @selected(request('priority') === 'urgent')>Urgente</option>
            </select>
        </div>
        <div class="field">
            <label for="category">Categoria</label>
            <select id="category" name="category">
                <option value="">Todas</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="field sort-field">
            <label for="sort">Ordenar</label>
            <select id="sort" name="sort" data-submit-on-change>
                <option value="newest" @selected(request('sort', 'newest') === 'newest')>Mais recentes</option>
                <option value="oldest" @selected(request('sort') === 'oldest')>Mais antigos</option>
                <option value="priority" @selected(request('sort') === 'priority')>Maior prioridade</option>
                <option value="title" @selected(request('sort') === 'title')>Título A–Z</option>
            </select>
        </div>
        <div class="filter-actions">
            <button type="submit" class="btn btn-primary" data-loading-label="Filtrando...">⌕ Filtrar</button>
            @if(request()->hasAny(['search', 'status', 'priority', 'category', 'sort']))
                <a href="{{ route('tickets.index') }}" class="btn btn-ghost">Limpar</a>
            @endif
        </div>
    </form>

    @if(request()->hasAny(['search', 'status', 'priority', 'category']))
        <div class="active-filters">
            <span>Filtros ativos:</span>
            @if(request('search'))<a href="{{ route('tickets.index', request()->except(['search', 'page'])) }}">“{{ request('search') }}” ×</a>@endif
            @if(request('status'))<a href="{{ route('tickets.index', request()->except(['status', 'page'])) }}">Status: {{ ['open'=>'Aberto','in_progress'=>'Em atendimento','waiting'=>'Aguardando','resolved'=>'Resolvido','closed'=>'Fechado'][request('status')] ?? request('status') }} ×</a>@endif
            @if(request('priority'))<a href="{{ route('tickets.index', request()->except(['priority', 'page'])) }}">Prioridade: {{ ['low'=>'Baixa','normal'=>'Normal','high'=>'Alta','urgent'=>'Urgente'][request('priority')] ?? request('priority') }} ×</a>@endif
            @if(request('category'))<a href="{{ route('tickets.index', request()->except(['category', 'page'])) }}">Categoria: {{ $categories->firstWhere('id', (int) request('category'))?->name ?? 'Selecionada' }} ×</a>@endif
        </div>
    @endif
</section>

<section class="panel tickets-panel">
    <div class="panel-header">
        <div class="panel-title"><span class="panel-icon">▤</span><div><h2>Fila de atendimento</h2><p>{{ $tickets->total() }} {{ $tickets->total() === 1 ? 'chamado encontrado' : 'chamados encontrados' }}</p></div></div>
        <span class="result-range">{{ $tickets->firstItem() ?? 0 }}–{{ $tickets->lastItem() ?? 0 }} de {{ $tickets->total() }}</span>
    </div>

    <div class="tickets-table-wrapper">
        <table class="tickets-table">
            <thead><tr><th>Chamado</th><th>Solicitante</th><th>Categoria</th><th>Responsável</th><th>Prioridade</th><th>Status</th><th>Atualizado</th><th><span class="sr-only">Abrir</span></th></tr></thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr data-href="{{ route('tickets.show', $ticket) }}" tabindex="0">
                        <td data-label="Chamado"><a class="ticket-cell" href="{{ route('tickets.show', $ticket) }}"><small>{{ $ticket->protocol }}</small><strong>{{ $ticket->title }}</strong></a></td>
                        <td data-label="Solicitante"><span class="person-cell"><i>{{ strtoupper(substr($ticket->user->name ?? 'U', 0, 1)) }}</i>{{ $ticket->user->name ?? 'Usuário' }}</span></td>
                        <td data-label="Categoria"><span class="subtle-text">{{ $ticket->category->icon ?? '◇' }} {{ $ticket->category->name ?? 'Sem categoria' }}</span></td>
                        <td data-label="Responsável"><span class="subtle-text">{{ $ticket->assignedUser->name ?? 'Não atribuído' }}</span></td>
                        <td data-label="Prioridade"><span class="badge priority-{{ $ticket->priority }}">{{ $ticket->priority_label }}</span></td>
                        <td data-label="Status"><span class="badge status-{{ $ticket->status }}"><i></i>{{ $ticket->status_label }}</span></td>
                        <td data-label="Atualizado"><time datetime="{{ $ticket->updated_at->toIso8601String() }}">{{ $ticket->updated_at->diffForHumans(null, true) }}</time></td>
                        <td><a class="row-action" href="{{ route('tickets.show', $ticket) }}" aria-label="Abrir {{ $ticket->protocol }}">›</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8"><div class="empty-state"><span class="empty-icon">⌕</span><h3>Nenhum chamado encontrado</h3><p>Ajuste os filtros ou use “Novo chamado” no menu superior.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
        <div class="pagination">{{ $tickets->onEachSide(1)->links() }}</div>
    @endif
</section>
@endsection
