@extends('layouts.app')

@section('title', 'Novo chamado | HelpDesk')

@section('content')

<section class="page-banner">
    <div class="page-banner-content">
        <span class="page-badge">ABRIR CHAMADO</span>
        <h1>Novo chamado</h1>
        <p>Registre o problema para que a equipe possa iniciar o atendimento.</p>
    </div>

    <div class="page-banner-actions">
        <a href="{{ route('tickets.index') }}" class="btn-outline">
            ← Voltar
        </a>
    </div>
</section>

<section class="create-ticket-layout">

    <div class="form-panel">
        <div class="form-panel-header">
            <div class="form-panel-icon">🛠️</div>

            <div>
                <h2>Informações do chamado</h2>
                <p>Preencha os dados abaixo com atenção.</p>
            </div>
        </div>

        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="title">Título do chamado</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Ex: Computador não inicia"
                    required
                >
                @error('title')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-grid-2">
                <div class="field">
                    <label for="category_id">Categoria</label>
                    <select name="category_id" id="category_id">
                        <option value="">Selecione</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label for="priority">Prioridade</label>
                    <select name="priority" id="priority" required>
                        <option value="low" @selected(old('priority') === 'low')>Baixa</option>
                        <option value="normal" @selected(old('priority', 'normal') === 'normal')>Normal</option>
                        <option value="high" @selected(old('priority') === 'high')>Alta</option>
                        <option value="urgent" @selected(old('priority') === 'urgent')>Urgente</option>
                    </select>
                    @error('priority')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="field">
                <label for="description">Descrição do problema</label>
                <textarea
                    name="description"
                    id="description"
                    rows="7"
                    placeholder="Explique com detalhes o problema encontrado..."
                    required
                >{{ old('description') }}</textarea>

                <div class="textarea-meta">
                    <small>Descreva com o máximo de detalhes possível.</small>
                    <span id="characterCount">0 caracteres</span>
                </div>

                @error('description')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-actions-modern">
                <a href="{{ route('tickets.index') }}" class="btn-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn-primary">
                    Abrir chamado
                </button>
            </div>
        </form>
    </div>

    <aside class="tips-panel">
        <div class="tips-panel-icon">💡</div>
        <h3>Dicas rápidas</h3>
        <p>Essas informações ajudam a equipe a resolver o problema mais rápido.</p>

        <div class="tip-item">
            <span>01</span>
            <div>
                <strong>Use um título claro</strong>
                <p>Exemplo: “Impressora não liga”.</p>
            </div>
        </div>

        <div class="tip-item">
            <span>02</span>
            <div>
                <strong>Escolha a categoria certa</strong>
                <p>Isso ajuda a organizar o atendimento.</p>
            </div>
        </div>

        <div class="tip-item">
            <span>03</span>
            <div>
                <strong>Explique o problema</strong>
                <p>Informe o que aconteceu e o que você já tentou fazer.</p>
            </div>
        </div>
    </aside>

</section>

@endsection