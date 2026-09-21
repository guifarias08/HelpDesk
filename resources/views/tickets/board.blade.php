@extends('layouts.app')

@section('title', 'Quadro de chamados | HelpDesk')

@section('content')
<section class="page-heading">
    <div class="page-heading-content">
        <span class="eyebrow"><i></i> FLUXO DE ATENDIMENTO</span>
        <h1>Quadro de chamados</h1>
        <p>Uma visão rápida da carga de trabalho em cada etapa.</p>
    </div>
    <div class="page-heading-actions">
        <div class="view-switch"><a href="{{ route('tickets.index', request()->query()) }}">☷ Lista</a><a class="active" href="{{ route('tickets.board', request()->query()) }}" aria-current="page">▦ Quadro</a></div>
    </div>
</section>

<section class="panel board-toolbar">
    <form action="{{ route('tickets.board') }}" method="GET" class="board-filters">
        <div class="input-icon-wrap"><span>⌕</span><input type="search" name="search" id="search" value="{{ request('search') }}" placeholder="Buscar no quadro..."><kbd>/</kbd></div>
        <select name="priority" aria-label="Filtrar por prioridade" data-submit-on-change>
            <option value="">Todas as prioridades</option>
            <option value="low" @selected(request('priority') === 'low')>Baixa</option>
            <option value="normal" @selected(request('priority') === 'normal')>Normal</option>
            <option value="high" @selected(request('priority') === 'high')>Alta</option>
            <option value="urgent" @selected(request('priority') === 'urgent')>Urgente</option>
        </select>
        <select name="category" aria-label="Filtrar por categoria" data-submit-on-change>
            <option value="">Todas as categorias</option>
            @foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>@endforeach
        </select>
        <button class="btn btn-secondary" type="submit">Buscar</button>
        @if(request()->hasAny(['search','priority','category']))<a href="{{ route('tickets.board') }}" class="btn btn-ghost">Limpar</a>@endif
    </form>
</section>

<section class="kanban-board" aria-label="Quadro Kanban">
    @foreach($statuses as $status => $label)
        @php($columnTickets = $tickets->get($status, collect()))
        <div class="kanban-column kanban-{{ $status }}">
            <header><div><i></i><h2>{{ $label }}</h2></div><span>{{ $columnTickets->count() }}</span></header>
            <div class="kanban-list">
                @forelse($columnTickets as $ticket)
                    <a href="{{ route('tickets.show', $ticket) }}" class="kanban-card">
                        <div class="kanban-card-top"><span>{{ $ticket->protocol }}</span><span class="badge priority-{{ $ticket->priority }}">{{ $ticket->priority_label }}</span></div>
                        <h3>{{ $ticket->title }}</h3>
                        <p>{{ $ticket->category->icon ?? '◇' }} {{ $ticket->category->name ?? 'Sem categoria' }}</p>
                        <footer><span class="mini-avatar">{{ strtoupper(substr($ticket->assignedUser->name ?? '?', 0, 1)) }}</span><span>{{ $ticket->assignedUser->name ?? 'Não atribuído' }}</span><time>{{ $ticket->updated_at->diffForHumans(null, true) }}</time></footer>
                    </a>
                @empty
                    <div class="kanban-empty"><span>＋</span><p>Nenhum chamado nesta etapa.</p></div>
                @endforelse
            </div>
        </div>
    @endforeach
</section>
@endsection
