@extends('layouts.app')

@section('title', $ticket->protocol . ' | HelpDesk')

@section('content')
<nav class="breadcrumbs" aria-label="Navegação estrutural"><a href="{{ route('tickets.index') }}">Chamados</a><span>›</span><span>{{ $ticket->protocol }}</span></nav>

<section class="ticket-hero">
    <div class="ticket-hero-main">
        <div class="ticket-protocol-row">
            <span>{{ $ticket->protocol }}</span>
            <button type="button" class="copy-button" data-copy="{{ $ticket->protocol }}" aria-label="Copiar protocolo" title="Copiar protocolo">▣</button>
            <span class="badge status-{{ $ticket->status }}"><i></i>{{ $ticket->status_label }}</span>
            <span class="badge priority-{{ $ticket->priority }}">{{ $ticket->priority_label }}</span>
        </div>
        <h1>{{ $ticket->title }}</h1>
        <p>Aberto por <strong>{{ $ticket->user->name ?? 'Usuário' }}</strong> em {{ $ticket->created_at->format('d/m/Y \à\s H:i') }}</p>
    </div>
    <div class="ticket-hero-actions">
        <a href="#reply" class="btn btn-primary">↩ Responder</a>
        <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" data-confirm="Excluir o chamado {{ $ticket->protocol }}? Esta ação não poderá ser desfeita.">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-icon-danger" aria-label="Excluir chamado" title="Excluir chamado">⌫</button>
        </form>
    </div>
</section>

<section class="ticket-detail-layout">
    <div class="ticket-detail-main">
        <article class="panel description-card">
            <div class="panel-header compact"><div class="panel-title"><span class="panel-icon">≡</span><div><h2>Descrição do problema</h2><p>Contexto informado na abertura</p></div></div></div>
            <div class="description-content">{!! nl2br(e($ticket->description)) !!}</div>
        </article>

        <article class="panel conversation-card">
            <div class="panel-header"><div class="panel-title"><span class="panel-icon">◌</span><div><h2>Histórico do atendimento</h2><p>{{ $ticket->comments->count() }} {{ $ticket->comments->count() === 1 ? 'resposta' : 'respostas' }}</p></div></div></div>
            <div class="timeline">
                <div class="timeline-item system-event">
                    <span class="timeline-marker">＋</span>
                    <div><strong>Chamado aberto</strong><p>{{ $ticket->user->name ?? 'Usuário' }} registrou a solicitação.</p><time>{{ $ticket->created_at->format('d/m/Y H:i') }}</time></div>
                </div>
                @foreach($ticket->comments as $comment)
                    <div class="timeline-item comment-item">
                        <span class="comment-avatar">{{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}</span>
                        <div class="comment-content">
                            <header><strong>{{ $comment->user->name ?? 'Usuário' }}</strong><span>Equipe de suporte</span><time>{{ $comment->created_at->format('d/m/Y H:i') }}</time></header>
                            <p>{!! nl2br(e($comment->message)) !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="reply-section" id="reply">
                <form action="{{ route('tickets.comments.store', $ticket) }}" method="POST" class="reply-form">
                    @csrf
                    <div class="field">
                        <label for="message">Adicionar resposta</label>
                        <textarea name="message" id="message" rows="5" maxlength="5000" placeholder="Compartilhe uma atualização com o solicitante..." required data-counter data-counter-target="messageCount">{{ old('message') }}</textarea>
                        <div class="field-meta"><span>A resposta ficará registrada no histórico.</span><span id="messageCount">0 / 5000</span></div>
                        @error('message')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="reply-actions"><button type="submit" class="btn btn-primary" data-loading-label="Enviando...">Enviar resposta <span>→</span></button></div>
                </form>
            </div>
        </article>
    </div>

    <aside class="ticket-detail-side">
        <div class="panel details-card">
            <div class="panel-header compact"><div class="panel-title"><span class="panel-icon">◎</span><div><h2>Detalhes</h2><p>Informações do chamado</p></div></div></div>
            <dl class="details-list">
                <div><dt>Categoria</dt><dd>{{ $ticket->category->icon ?? '◇' }} {{ $ticket->category->name ?? 'Não informada' }}</dd></div>
                <div><dt>Solicitante</dt><dd>{{ $ticket->user->name ?? 'Usuário' }}</dd></div>
                <div><dt>Responsável</dt><dd>{{ $ticket->assignedUser->name ?? 'Não atribuído' }}</dd></div>
                <div><dt>Última atualização</dt><dd>{{ $ticket->updated_at->diffForHumans() }}</dd></div>
                @if($ticket->resolved_at)<div><dt>Resolvido em</dt><dd>{{ $ticket->resolved_at->format('d/m/Y H:i') }}</dd></div>@endif
            </dl>
        </div>

        <div class="panel update-card">
            <div class="panel-header compact"><div class="panel-title"><span class="panel-icon">↻</span><div><h2>Atualizar chamado</h2><p>Altere o fluxo do atendimento</p></div></div></div>
            <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="update-form">
                @csrf @method('PUT')
                <div class="field"><label for="status">Status</label><select name="status" id="status">
                    <option value="open" @selected(old('status', $ticket->status) === 'open')>Aberto</option>
                    <option value="in_progress" @selected(old('status', $ticket->status) === 'in_progress')>Em atendimento</option>
                    <option value="waiting" @selected(old('status', $ticket->status) === 'waiting')>Aguardando usuário</option>
                    <option value="resolved" @selected(old('status', $ticket->status) === 'resolved')>Resolvido</option>
                    <option value="closed" @selected(old('status', $ticket->status) === 'closed')>Fechado</option>
                </select></div>
                <div class="field"><label for="priority">Prioridade</label><select name="priority" id="priority">
                    <option value="low" @selected(old('priority', $ticket->priority) === 'low')>Baixa</option>
                    <option value="normal" @selected(old('priority', $ticket->priority) === 'normal')>Normal</option>
                    <option value="high" @selected(old('priority', $ticket->priority) === 'high')>Alta</option>
                    <option value="urgent" @selected(old('priority', $ticket->priority) === 'urgent')>Urgente</option>
                </select></div>
                <div class="field"><label for="assigned_to">Responsável</label><select name="assigned_to" id="assigned_to"><option value="">Não atribuído</option>@foreach($users as $user)<option value="{{ $user->id }}" @selected(old('assigned_to', $ticket->assigned_to) == $user->id)>{{ $user->name }}</option>@endforeach</select></div>
                <button type="submit" class="btn btn-primary btn-block" data-loading-label="Salvando...">Salvar alterações</button>
            </form>
        </div>
    </aside>
</section>
@endsection
