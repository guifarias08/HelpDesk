@extends('layouts.app')

@section('title', 'Chamados | HelpDesk')

@section('content')


{{-- =====================================================
     CABEÇALHO
===================================================== --}}

<section class="page-heading page-heading-with-art">

    <div class="page-heading-content">

        <span class="eyebrow">
            CENTRAL DE ATENDIMENTO
        </span>

        <h1>
            Chamados
        </h1>

        <p>
            Visualize, filtre e acompanhe todos os chamados cadastrados.
        </p>

    </div>


    <div class="page-heading-actions">

        <div class="support-art">
            <div class="support-art-lines">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="support-art-icon">
                ☎
            </div>
        </div>


        <a
            href="{{ route('tickets.create') }}"
            class="btn btn-primary"
        >
            <span class="btn-icon">+</span>

            Novo chamado
        </a>

    </div>

</section>


{{-- =====================================================
     FILTROS
===================================================== --}}

<section class="panel filters-panel">

    <div class="panel-title compact">

        <div class="panel-title-icon">
            ⌕
        </div>

        <div>
            <h2>Filtros de busca</h2>
        </div>

    </div>


    <form
        action="{{ route('tickets.index') }}"
        method="GET"
        class="filters-grid"
    >

        <div class="field search-field">

            <label for="search">
                Buscar chamado
            </label>

            <div class="control-with-icon">

                <span class="control-icon">
                    ⌕
                </span>

                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Protocolo ou título..."
                >

            </div>

        </div>


        <div class="field">

            <label for="status">
                Status
            </label>

            <select
                id="status"
                name="status"
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
                id="priority"
                name="priority"
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
                id="category"
                name="category"
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


        <div class="filter-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                ⌕ Filtrar
            </button>

            <a
                href="{{ route('tickets.index') }}"
                class="btn btn-secondary"
            >
                ↻ Limpar
            </a>

        </div>

    </form>

</section>


{{-- =====================================================
     LISTAGEM
===================================================== --}}

<section class="panel tickets-panel">

    <div class="tickets-panel-header">

        <div class="panel-title">

            <div class="panel-title-icon blue">
                ☷
            </div>

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


        <div class="sort-box">

            <span>
                Ordenar por
            </span>

            <select>
                <option>
                    Mais recentes
                </option>
            </select>

        </div>

    </div>


    <div class="tickets-table-wrapper">

        <table class="tickets-table">

            <thead>

                <tr>
                    <th>Protocolo</th>
                    <th>Título</th>
                    <th>Solicitante • Categoria</th>
                    <th>Data</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th class="text-center">Ações</th>
                </tr>

            </thead>


            <tbody>

                @forelse($tickets as $ticket)

                    <tr
                        onclick="window.location='{{ route('tickets.show', $ticket) }}'"
                    >

                        <td>

                            <div class="protocol-cell">

                                <span class="protocol-icon">
                                    ▣
                                </span>

                                <strong>
                                    {{ $ticket->protocol }}
                                </strong>

                            </div>

                        </td>


                        <td>

                            <strong class="ticket-title">
                                {{ $ticket->title }}
                            </strong>

                        </td>


                        <td>

                            <span class="ticket-requester">

                                {{ $ticket->user->name ?? 'Usuário' }}

                                @if($ticket->category)

                                    <span class="dot">•</span>

                                    {{ $ticket->category->name }}

                                @endif

                            </span>

                        </td>


                        <td>

                            <div class="date-cell">
                                <span>▣</span>

                                {{ $ticket->created_at->format('d/m/Y') }}
                            </div>

                        </td>


                        <td>

                            <span class="badge priority-{{ $ticket->priority }}">
                                {{ $ticket->priority_label }}
                            </span>

                        </td>


                        <td>

                            <span class="badge status-{{ $ticket->status }}">

                                <span class="badge-dot"></span>

                                {{ $ticket->status_label }}

                            </span>

                        </td>


                        <td class="text-center">

                            <a
                                href="{{ route('tickets.show', $ticket) }}"
                                class="row-action"
                                onclick="event.stopPropagation()"
                            >
                                ⋮
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="no-tickets-cell"
                        >

                            <div class="empty-state">

                                <div class="empty-icon">
                                    ☷
                                </div>

                                <h3>
                                    Nenhum chamado encontrado
                                </h3>

                                <p>
                                    Nenhum chamado corresponde aos filtros selecionados.
                                </p>

                                <a
                                    href="{{ route('tickets.create') }}"
                                    class="btn btn-primary"
                                >
                                    + Criar chamado
                                </a>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <div class="tickets-footer">

        <span>
            Mostrando
            {{ $tickets->count() }}
            de
            {{ $tickets->total() }}
            chamados
        </span>


        @if($tickets->hasPages())

            <div class="pagination-wrapper">
                {{ $tickets->links() }}
            </div>

        @endif

    </div>

</section>


@endsection