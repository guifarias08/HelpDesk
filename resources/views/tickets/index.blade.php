@extends('layouts.app')

@section('title', 'Chamados | HelpDesk')

@section('content')


<section class="page-banner">

    <div class="page-banner-content">

        <span class="page-badge">
            CENTRAL DE ATENDIMENTO
        </span>

        <h1>
            Chamados
        </h1>

        <p>
            Visualize, filtre e acompanhe todos os chamados cadastrados.
        </p>

    </div>


    <div class="page-banner-actions">

        <a
            href="{{ route('tickets.create') }}"
            class="btn-primary"
        >
            + Novo chamado
        </a>

    </div>

</section>


<section class="filter-panel">

    <form
        action="{{ route('tickets.index') }}"
        method="GET"
        class="filter-panel-grid"
    >

        <div class="field field-search">

            <label for="search">
                Buscar chamado
            </label>

            <input
                type="text"
                id="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Protocolo ou título..."
            >

        </div>


        <div class="field">

            <label for="status">
                Status
            </label>

            <select
                name="status"
                id="status"
            >

                <option value="">
                    Todos
                </option>

                <option
                    value="open"
                    @selected(request('status') === 'open')
                >
                    Aberto
                </option>

                <option
                    value="in_progress"
                    @selected(request('status') === 'in_progress')
                >
                    Em atendimento
                </option>

                <option
                    value="waiting"
                    @selected(request('status') === 'waiting')
                >
                    Aguardando usuário
                </option>

                <option
                    value="resolved"
                    @selected(request('status') === 'resolved')
                >
                    Resolvido
                </option>

                <option
                    value="closed"
                    @selected(request('status') === 'closed')
                >
                    Fechado
                </option>

            </select>

        </div>


        <div class="field">

            <label for="priority">
                Prioridade
            </label>

            <select
                name="priority"
                id="priority"
            >

                <option value="">
                    Todas
                </option>

                <option
                    value="low"
                    @selected(request('priority') === 'low')
                >
                    Baixa
                </option>

                <option
                    value="normal"
                    @selected(request('priority') === 'normal')
                >
                    Normal
                </option>

                <option
                    value="high"
                    @selected(request('priority') === 'high')
                >
                    Alta
                </option>

                <option
                    value="urgent"
                    @selected(request('priority') === 'urgent')
                >
                    Urgente
                </option>

            </select>

        </div>


        <div class="field">

            <label for="category">
                Categoria
            </label>

            <select
                name="category"
                id="category"
            >

                <option value="">
                    Todas
                </option>

                @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        @selected(request('category') == $category->id)
                    >
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

        </div>


        <div class="filter-buttons">

            <button
                type="submit"
                class="btn-primary"
            >
                Filtrar
            </button>

            <a
                href="{{ route('tickets.index') }}"
                class="btn-secondary"
            >
                Limpar
            </a>

        </div>

    </form>

</section>


<section class="list-panel">

    <div class="list-panel-header">

        <div>

            <h2>
                Lista de chamados
            </h2>

            <p>
                {{ $tickets->total() }}
                chamado(s) encontrado(s)
            </p>

        </div>

    </div>


    <div class="ticket-cards">

        @forelse($tickets as $ticket)

            <a
                href="{{ route('tickets.show', $ticket) }}"
                class="ticket-card"
            >

                <div class="ticket-card-left">

                    <div class="ticket-card-icon">
                        🎫
                    </div>


                    <div class="ticket-card-info">

                        <span class="ticket-code">
                            {{ $ticket->protocol }}
                        </span>

                        <h3>
                            {{ $ticket->title }}
                        </h3>

                        <p>

                            {{ $ticket->user->name ?? 'Usuário' }}

                            @if($ticket->category)

                                • {{ $ticket->category->name }}

                            @endif

                        </p>

                    </div>

                </div>


                <div class="ticket-card-right">

                    <span class="tag priority-{{ $ticket->priority }}">
                        {{ $ticket->priority_label }}
                    </span>

                    <span class="tag status-{{ $ticket->status }}">
                        {{ $ticket->status_label }}
                    </span>

                    <span class="ticket-date">
                        {{ $ticket->created_at->format('d/m/Y') }}
                    </span>

                    <span class="ticket-arrow">
                        →
                    </span>

                </div>

            </a>

        @empty

            <div class="empty-box">

                <div class="empty-box-icon">
                    📭
                </div>

                <h3>
                    Nenhum chamado encontrado
                </h3>

                <p>
                    Nenhum chamado corresponde aos filtros selecionados.
                </p>

                <a
                    href="{{ route('tickets.create') }}"
                    class="btn-primary"
                >
                    + Criar chamado
                </a>

            </div>

        @endforelse

    </div>


    @if($tickets->hasPages())

        <div class="pagination-box">
            {{ $tickets->links() }}
        </div>

    @endif

</section>

@endsection