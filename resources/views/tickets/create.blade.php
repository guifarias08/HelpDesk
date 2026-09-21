@extends('layouts.app')

@section('title', 'Novo chamado | HelpDesk')

@section('content')
<nav class="breadcrumbs" aria-label="Navegação estrutural"><a href="{{ route('tickets.index') }}">Chamados</a><span>›</span><span>Novo chamado</span></nav>

<section class="page-heading create-heading">
    <div class="page-heading-content">
        <span class="eyebrow"><i></i> NOVA SOLICITAÇÃO</span>
        <h1>Como podemos ajudar?</h1>
        <p>Conte o que aconteceu. Quanto mais contexto, mais rápido será o atendimento.</p>
    </div>
</section>

<section class="create-layout">
    <form action="{{ route('tickets.store') }}" method="POST" class="panel ticket-form" id="ticketCreateForm">
        @csrf
        <div class="form-section">
            <div class="form-section-heading"><span>1</span><div><h2>Identifique a solicitação</h2><p>Dê um nome curto e escolha o assunto correto.</p></div></div>

            <div class="field">
                <label for="title">Título do chamado <em>*</em></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" maxlength="255" placeholder="Ex.: Notebook não conecta à rede" required autofocus data-preview-title>
                @error('title')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-row">
                <div class="field">
                    <label for="category_id">Categoria <em>*</em></label>
                    <select id="category_id" name="category_id" required data-preview-category>
                        <option value="" disabled @selected(!old('category_id'))>Selecione uma categoria</option>
                        @foreach($categories as $category)<option value="{{ $category->id }}" data-icon="{{ $category->icon ?: '◇' }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>@endforeach
                    </select>
                    @error('category_id')<span class="field-error">{{ $message }}</span>@enderror
                    @if($categories->isEmpty())<span class="field-hint warning">Cadastre uma categoria antes de abrir o chamado.</span>@endif
                </div>
                <div class="field">
                    <label for="priority">Prioridade <em>*</em></label>
                    <select id="priority" name="priority" required data-preview-priority>
                        <option value="low" @selected(old('priority') === 'low')>Baixa — pode aguardar</option>
                        <option value="normal" @selected(old('priority', 'normal') === 'normal')>Normal — impacto moderado</option>
                        <option value="high" @selected(old('priority') === 'high')>Alta — trabalho prejudicado</option>
                        <option value="urgent" @selected(old('priority') === 'urgent')>Urgente — operação parada</option>
                    </select>
                    @error('priority')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-heading"><span>2</span><div><h2>Explique o problema</h2><p>Inclua mensagens de erro e o que você já tentou.</p></div></div>
            <div class="field">
                <label for="description">Descrição <em>*</em></label>
                <textarea id="description" name="description" rows="9" maxlength="5000" placeholder="Descreva o problema, quando começou e quais pessoas ou sistemas foram afetados..." required data-counter data-counter-target="descriptionCount">{{ old('description') }}</textarea>
                <div class="field-meta"><span>Evite incluir senhas ou dados sensíveis.</span><span id="descriptionCount">0 / 5000</span></div>
                @error('description')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('tickets.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary" data-loading-label="Abrindo chamado..." @disabled($categories->isEmpty())>Abrir chamado <span>→</span></button>
        </div>
    </form>

    <aside class="create-side">
        <div class="panel preview-card">
            <span class="side-label">PRÉ-VISUALIZAÇÃO</span>
            <div class="preview-ticket">
                <div class="preview-top"><span>NOVO</span><span class="badge priority-normal" id="previewPriority">Normal</span></div>
                <h3 id="previewTitle">Título do seu chamado</h3>
                <p id="previewCategory">◇ Categoria não selecionada</p>
            </div>
            <div class="preview-note"><span>i</span><p>O protocolo será gerado automaticamente depois do envio.</p></div>
        </div>

        <div class="panel tips-card">
            <span class="side-label">PARA RESOLVER MAIS RÁPIDO</span>
            <ul>
                <li><span>✓</span><p><strong>Seja específico</strong>Informe o equipamento ou sistema afetado.</p></li>
                <li><span>✓</span><p><strong>Conte o contexto</strong>Diga quando começou e se o erro se repete.</p></li>
                <li><span>✓</span><p><strong>Classifique o impacto</strong>Use “urgente” apenas se a operação parou.</p></li>
            </ul>
        </div>
    </aside>
</section>
@endsection
