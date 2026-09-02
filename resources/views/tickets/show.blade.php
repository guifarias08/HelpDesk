@extends('layouts.app')

@section('title', 'Chamado ' . $ticket->protocol . ' | HelpDesk')

@section('content')

<section class="ticket-show-header">

    <div class="ticket-show-header-top">
        <a
            href="{{ route('tickets.index') }}"
            class="back-link"
        >
            ← Voltar para chamados
        </a>

        <div class="ticket-show-badges">
            <span class="tag priority-{{ $ticket->priority }}">
                {{ $ticket->priority_label ?? ucfirst($ticket->priority) }}
            </span>

            <span class="tag status-{{ $ticket->status }}">
                {{ $ticket->status_label ?? ucfirst(str_replace('_', ' ', $ticket->status)) }}
            </span>
        </div>
    </div>

    <div class="ticket-show-title-area">
        <div>
            <span class="ticket-protocol-large">
                {{ $ticket->protocol }}
            </span>

            <h1 class="ticket-show-title">
                {{ $ticket->title }}
            </h1>

            <p class="ticket-show-meta">
                Aberto por
                <strong>{{ $ticket->user->name ?? 'Usuário' }}</strong>

                @if($ticket->category)
                    • Categoria: <strong>{{ $ticket->category->name }}</strong>
                @endif

                • {{ $ticket->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

</section>


<section class="ticket-show-layout">

    <div class="ticket-show-main">

        <div class="content-card">

            <div class="content-card-header">
                <h2>Descrição do problema</h2>
            </div>

            <div class="description-box">
                {{ $ticket->description }}
            </div>

        </div>


        <div class="content-card">

            <div class="content-card-header">
                <h2>Conversa</h2>
                <p>Acompanhe as respostas do chamado.</p>
            </div>


            <div class="comments-list">

                @forelse($ticket->comments as $comment)

                    <div class="comment-item">

                        <div class="comment-avatar">
                            {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                        </div>

                        <div class="comment-bubble">

                            <div class="comment-top">
                                <strong>{{ $comment->user->name ?? 'Usuário' }}</strong>
                                <span>{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                            </div>

                            <p>
                                {{ $comment->message }}
                            </p>

                        </div>

                    </div>

                @empty

                    <div class="empty-conversation">
                        <div class="empty-conversation-icon">💬</div>
                        <h3>Nenhuma resposta ainda</h3>
                        <p>Envie a primeira atualização deste chamado.</p>
                    </div>

                @endforelse

            </div>


            <div class="reply-box">

                <form
                    action="{{ route('tickets.comments.store', $ticket) }}"
                    method="POST"
                    class="reply-form"
                >
                    @csrf

                    <div class="field">
                        <label for="message">
                            Adicionar resposta
                        </label>

                        <textarea
                            name="message"
                            id="message"
                            rows="5"
                            placeholder="Escreva sua resposta..."
                            required
                        >{{ old('message') }}</textarea>

                        <div class="textarea-meta">
                            <small>Explique o andamento do atendimento.</small>
                            <span id="messageCharacterCount">0 caracteres</span>
                        </div>

                        @error('message')
                            <span class="error-text">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="reply-actions">
                        <button
                            type="submit"
                            class="btn-primary"
                        >
                            Enviar resposta
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>


    <aside class="ticket-show-sidebar">

        <div class="content-card sidebar-card">

            <div class="content-card-header">
                <h2>Resumo do chamado</h2>
            </div>

            <div class="ticket-summary-list">

                <div class="summary-item">
                    <span>Protocolo</span>
                    <strong>{{ $ticket->protocol }}</strong>
                </div>

                <div class="summary-item">
                    <span>Status</span>
                    <strong>{{ $ticket->status_label ?? ucfirst(str_replace('_', ' ', $ticket->status)) }}</strong>
                </div>

                <div class="summary-item">
                    <span>Prioridade</span>
                    <strong>{{ $ticket->priority_label ?? ucfirst($ticket->priority) }}</strong>
                </div>

                <div class="summary-item">
                    <span>Categoria</span>
                    <strong>{{ $ticket->category->name ?? 'Não informada' }}</strong>
                </div>

                <div class="summary-item">
                    <span>Responsável</span>
                    <strong>{{ $ticket->assignedUser->name ?? 'Não atribuído' }}</strong>
                </div>

            </div>

        </div>


        <div class="content-card sidebar-card">

            <div class="content-card-header">
                <h2>Atualizar chamado</h2>
                <p>Altere status, prioridade e responsável.</p>
            </div>

            <form
                action="{{ route('tickets.update', $ticket) }}"
                method="POST"
                class="ticket-update-form"
            >
                @csrf
                @method('PUT')

                <div class="field">
                    <label for="status">Status</label>
                    <select
                        name="status"
                        id="status"
                    >
                        <option value="open" @selected(old('status', $ticket->status) === 'open')>
                            Aberto
                        </option>
                        <option value="in_progress" @selected(old('status', $ticket->status) === 'in_progress')>
                            Em atendimento
                        </option>
                        <option value="waiting" @selected(old('status', $ticket->status) === 'waiting')>
                            Aguardando usuário
                        </option>
                        <option value="resolved" @selected(old('status', $ticket->status) === 'resolved')>
                            Resolvido
                        </option>
                        <option value="closed" @selected(old('status', $ticket->status) === 'closed')>
                            Fechado
                        </option>
                    </select>
                </div>

                <div class="field">
                    <label for="priority">Prioridade</label>
                    <select
                        name="priority"
                        id="priority"
                    >
                        <option value="low" @selected(old('priority', $ticket->priority) === 'low')>
                            Baixa
                        </option>
                        <option value="normal" @selected(old('priority', $ticket->priority) === 'normal')>
                            Normal
                        </option>
                        <option value="high" @selected(old('priority', $ticket->priority) === 'high')>
                            Alta
                        </option>
                        <option value="urgent" @selected(old('priority', $ticket->priority) === 'urgent')>
                            Urgente
                        </option>
                    </select>
                </div>

                <div class="field">
                    <label for="assigned_to">Responsável</label>
                    <select
                        name="assigned_to"
                        id="assigned_to"
                    >
                        <option value="">
                            Não atribuído
                        </option>

                        @foreach($users as $user)
                            <option
                                value="{{ $user->id }}"
                                @selected(old('assigned_to', $ticket->assigned_to) == $user->id)
                            >
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sidebar-actions">
                    <button
                        type="submit"
                        class="btn-primary"
                    >
                        Salvar alterações
                    </button>
                </div>

            </form>

        </div>

    </aside>

</section>

@endsection