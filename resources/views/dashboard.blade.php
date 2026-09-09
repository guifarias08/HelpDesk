@extends('layouts.app')

@section('title', 'Dashboard | HelpDesk')

@section('content')


{{-- =====================================================
     CABEÇALHO
===================================================== --}}

<section class="page-heading page-heading-with-art">

    <div class="page-heading-content">

        <span class="eyebrow">
            VISÃO GERAL
        </span>

        <h1>
            Central de chamados
        </h1>

        <p>
            Acompanhe o volume de atendimentos, prioridades
            e o andamento dos chamados em um único lugar.
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


  
        </a>

    </div>

</section>


{{-- =====================================================
     CARDS DE ESTATÍSTICA
===================================================== --}}

<section class="dashboard-stats">

    <div class="dashboard-stat-card">

        <div class="dashboard-stat-top">

            <div class="dashboard-stat-icon open">
                A
            </div>

            <span>
                Chamados abertos
            </span>

        </div>

        <div class="dashboard-stat-value">
            {{ $openTickets }}
        </div>

        <p>
            Aguardando início ou acompanhamento.
        </p>

    </div>


    <div class="dashboard-stat-card">

        <div class="dashboard-stat-top">

            <div class="dashboard-stat-icon progress">
                E
            </div>

            <span>
                Em atendimento
            </span>

        </div>

        <div class="dashboard-stat-value">
            {{ $inProgressTickets }}
        </div>

        <p>
            Chamados sendo tratados pela equipe.
        </p>

    </div>


    <div class="dashboard-stat-card">

        <div class="dashboard-stat-top">

            <div class="dashboard-stat-icon resolved">
                R
            </div>

            <span>
                Resolvidos
            </span>

        </div>

        <div class="dashboard-stat-value">
            {{ $resolvedTickets }}
        </div>

        <p>
            Atendimentos concluídos com sucesso.
        </p>

    </div>


    <div class="dashboard-stat-card">

        <div class="dashboard-stat-top">

            <div class="dashboard-stat-icon urgent">
                U
            </div>

            <span>
                Urgentes
            </span>

        </div>

        <div class="dashboard-stat-value">
            {{ $urgentTickets }}
        </div>

        <p>
            Precisam de atenção prioritária.
        </p>

    </div>

</section>


{{-- =====================================================
     CONTEÚDO PRINCIPAL
===================================================== --}}

<section class="dashboard-grid">


    {{-- =================================================
         CHAMADOS RECENTES
    ================================================== --}}

    <div class="panel dashboard-recent-panel">

        <div class="dashboard-panel-header">

            <div class="panel-title">

                <div class="panel-title-icon blue">
                    ☷
                </div>

                <div>

                    <h2>
                        Chamados recentes
                    </h2>

                    <p>
                        Últimas solicitações registradas no sistema.
                    </p>

                </div>

            </div>


            <a
                href="{{ route('tickets.index') }}"
                class="dashboard-panel-link"
            >
                Ver todos →
            </a>

        </div>


        <div class="dashboard-ticket-list">

            @forelse($recentTickets as $ticket)

                <a
                    href="{{ route('tickets.show', $ticket) }}"
                    class="dashboard-ticket-item"
                >

                    <div class="dashboard-ticket-main">

                        <div class="dashboard-ticket-protocol">
                            {{ $ticket->protocol }}
                        </div>

                        <h3>
                            {{ $ticket->title }}
                        </h3>

                        <p>

                            {{ $ticket->user->name ?? 'Usuário' }}

                            @if($ticket->category)

                                <span>•</span>

                                {{ $ticket->category->name }}

                            @endif

                        </p>

                    </div>


                    <div class="dashboard-ticket-meta">

                        <span class="badge priority-{{ $ticket->priority }}">
                            {{ $ticket->priority_label }}
                        </span>

                        <span class="badge status-{{ $ticket->status }}">

                            <span class="badge-dot"></span>

                            {{ $ticket->status_label }}

                        </span>

                        <span class="dashboard-ticket-date">
                            {{ $ticket->created_at->format('d/m/Y') }}
                        </span>

                    </div>

                </a>

            @empty

                <div class="empty-state">

                    <div class="empty-icon">
                        ☷
                    </div>

                    <h3>
                        Nenhum chamado recente
                    </h3>

                    <p>
                        Ainda não existem chamados cadastrados.
                    </p>

                    <a
                        href="{{ route('tickets.create') }}"
                        class="btn btn-primary"
                    >
                        + Criar chamado
                    </a>

                </div>

            @endforelse

        </div>

    </div>


    {{-- =================================================
         RESUMO
    ================================================== --}}

    <aside class="panel dashboard-summary-panel">

        <div class="dashboard-panel-header simple">

            <div class="panel-title">

                <div class="panel-title-icon">
                    ◉
                </div>

                <div>

                    <h2>
                        Resumo
                    </h2>

                    <p>
                        Situação atual dos atendimentos.
                    </p>

                </div>

            </div>

        </div>


        <div class="dashboard-summary-content">

            @php
                $dashboardTotal = $openTickets
                    + $inProgressTickets
                    + $resolvedTickets;
            @endphp


            <div class="summary-total">

                <span>
                    Total acompanhado
                </span>

                <strong>
                    {{ $dashboardTotal }}
                </strong>

            </div>


            <div class="summary-progress-list">


                <div class="summary-progress-item">

                    <div class="summary-progress-header">

                        <span>
                            Abertos
                        </span>

                        <strong>
                            {{ $openTickets }}
                        </strong>

                    </div>

                    <div class="summary-progress-track">

                        <span
                            class="summary-progress-bar open"
                            style="width:
                                {{ $dashboardTotal > 0
                                    ? ($openTickets / $dashboardTotal) * 100
                                    : 0 }}%"
                        ></span>

                    </div>

                </div>


                <div class="summary-progress-item">

                    <div class="summary-progress-header">

                        <span>
                            Em atendimento
                        </span>

                        <strong>
                            {{ $inProgressTickets }}
                        </strong>

                    </div>

                    <div class="summary-progress-track">

                        <span
                            class="summary-progress-bar progress"
                            style="width:
                                {{ $dashboardTotal > 0
                                    ? ($inProgressTickets / $dashboardTotal) * 100
                                    : 0 }}%"
                        ></span>

                    </div>

                </div>


                <div class="summary-progress-item">

                    <div class="summary-progress-header">

                        <span>
                            Resolvidos
                        </span>

                        <strong>
                            {{ $resolvedTickets }}
                        </strong>

                    </div>

                    <div class="summary-progress-track">

                        <span
                            class="summary-progress-bar resolved"
                            style="width:
                                {{ $dashboardTotal > 0
                                    ? ($resolvedTickets / $dashboardTotal) * 100
                                    : 0 }}%"
                        ></span>

                    </div>

                </div>

            </div>


            <div class="summary-action">

                <p>
                    Precisa registrar um novo atendimento?
                </p>

                <a
                    href="{{ route('tickets.create') }}"
                    class="btn btn-primary"
                >
                    + Abrir chamado
                </a>

            </div>

        </div>

    </aside>


</section>


@endsection