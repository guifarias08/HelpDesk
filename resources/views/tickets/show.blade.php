@extends('layouts.app')

@section('title', $ticket->protocol . ' | HelpDesk')

@section('content')

<div class="ticket-header">

    <a href="{{ route('tickets.index') }}">
        ← Voltar
    </a>

    <span>
        {{ $ticket->protocol }}
    </span>

    <h1>
        {{ $ticket->title }}
    </h1>

    <p>
        Aberto por
        <strong>{{ $ticket->user->name }}</strong>

        em

        {{ $ticket->created_at->format('d/m/Y H:i') }}
    </p>

</div>


<div class="ticket-layout">


    <main class="ticket-main">


        <section class="ticket-description">

            <h2>Descrição</h2>

            <p>
                {{ $ticket->description }}
            </p>

        </section>


        <section class="conversation">

            <h2>
                Conversa
            </h2>


            @forelse($ticket->comments as $comment)

                <div class="message">

                    <div class="message-avatar">

                        {{ strtoupper(
                            substr(
                                $comment->user->name,
                                0,
                                1
                            )
                        ) }}

                    </div>

                    <div>

                        <div class="message-header">

                            <strong>
                                {{ $comment->user->name }}
                            </strong>

                            <span>
                                {{ $comment->created_at->diffForHumans() }}
                            </span>

                        </div>

                        <p>
                            {{ $comment->message }}
                        </p>

                    </div>

                </div>

            @empty

                <p>
                    Nenhuma resposta ainda.
                </p>

            @endforelse


            <form
                action="{{ route(
                    'tickets.comments.store',
                    $ticket
                ) }}"
                method="POST"
                class="reply-form"
            >

                @csrf

                <textarea
                    name="message"
                    rows="5"
                    placeholder="Escreva sua resposta..."
                    required
                ></textarea>

                <button
                    class="btn-primary"
                >
                    Enviar resposta
                </button>

            </form>

        </section>

    </main>


    <aside class="ticket-sidebar">

        <form
            action="{{ route(
                'tickets.update',
                $ticket
            ) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            <div class="form-group">

                <label>Status</label>

                <select name="status">

                    <option
                        value="open"
                        @selected(
                            $ticket->status === 'open'
                        )
                    >
                        🟡 Aberto
                    </option>

                    <option
                        value="in_progress"
                        @selected(
                            $ticket->status === 'in_progress'
                        )
                    >
                        🔵 Em atendimento
                    </option>

                    <option
                        value="waiting"
                        @selected(
                            $ticket->status === 'waiting'
                        )
                    >
                        🟣 Aguardando usuário
                    </option>

                    <option
                        value="resolved"
                        @selected(
                            $ticket->status === 'resolved'
                        )
                    >
                        🟢 Resolvido
                    </option>

                    <option
                        value="closed"
                        @selected(
                            $ticket->status === 'closed'
                        )
                    >
                        ⚫ Fechado
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>
                    Prioridade
                </label>

                <select name="priority">

                    <option value="low">
                        🟢 Baixa
                    </option>

                    <option value="normal">
                        🔵 Normal
                    </option>

                    <option value="high">
                        🟠 Alta
                    </option>

                    <option value="urgent">
                        🔴 Urgente
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>
                    Responsável
                </label>

                <select name="assigned_to">

                    <option value="">
                        Não atribuído
                    </option>

                    @foreach($agents as $agent)

                        <option
                            value="{{ $agent->id }}"
                            @selected(
                                $ticket->assigned_to ===
                                $agent->id
                            )
                        >
                            {{ $agent->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <button
                class="btn-primary"
            >
                Atualizar chamado
            </button>

        </form>

    </aside>

</div>

@endsection