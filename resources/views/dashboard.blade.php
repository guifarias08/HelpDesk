@extends('layouts.app')

@section('title', 'Dashboard | HelpDesk')

@section('content')


<div class="page-header">


    <div class="page-heading">

        <small>
            VISÃO GERAL
        </small>

        <h1>
            Central de chamados
        </h1>

        <p>
            Acompanhe tickets, atendimentos e resoluções
            em uma interface organizada e objetiva.
        </p>

    </div>


    <a
        href="{{ route('tickets.create') }}"
        class="btn-primary"
    >
        + Novo chamado
    </a>


</div>


<section class="stats-grid-modern">


    <div class="stat-modern">

        <div class="stat-modern-top">

            <div class="stat-modern-icon">
                A
            </div>

            <span>
                Abertos
            </span>

        </div>

        <strong>
            {{ $openTickets }}
        </strong>

    </div>


    <div class="stat-modern">

        <div class="stat-modern-top">

            <div class="stat-modern-icon">
                E
            </div>

            <span>
                Em atendimento
            </span>

        </div>

        <strong>
            {{ $inProgressTickets }}
        </strong>

    </div>


    <div class="stat-modern">

        <div class="stat-modern-top">

            <div class="stat-modern-icon">
                R
            </div>

            <span>
                Resolvidos
            </span>

        </div>

        <strong>
            {{ $resolvedTickets }}
        </strong>

    </div>


    <div class="stat-modern">

        <div class="stat-modern-top">

            <div class="stat-modern-icon">
                U
            </div>

            <span>
                Urgentes
            </span>

        </div>

        <strong>
            {{ $urgentTickets }}
        </strong>

    </div>


</section>


<section class="modern-panel">


    <div class="modern-panel-header">


        <div>

            <h2>
                Chamados recentes
            </h2>

            <p>
                Últimas solicitações registradas no sistema.
            </p>

        </div>


        <a
            href="{{ route('tickets.index') }}"
            class="panel-link"
        >
            Ver todos →
        </a>


    </div>


    <div class="modern-ticket-list">


        @forelse($recentTickets as $ticket)


            <a
                href="{{ route('tickets.show', $ticket) }}"
                class="modern-ticket-row"
            >


                <div class="modern-ticket-main">


                    <span class="ticket-protocol">
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


                <div class="modern-ticket-tags">


                    <span class="tag priority-{{ $ticket->priority }}">
                        {{ $ticket->priority_label }}
                    </span>


                    <span class="tag status-{{ $ticket->status }}">
                        {{ $ticket->status_label }}
                    </span>


                </div>


            </a>


        @empty


            <div class="empty-state">


                <div class="empty-state-icon">
                    —
                </div>


                <h3>
                    Nenhum chamado recente
                </h3>


                <p>
                    Ainda não existem chamados cadastrados.
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


</section>


@endsection