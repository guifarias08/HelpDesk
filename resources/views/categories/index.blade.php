@extends('layouts.app')

@section('title', 'Categorias | HelpDesk')

@section('content')
<section class="page-heading">
    <div class="page-heading-content">
        <span class="eyebrow"><i></i> ORGANIZAÇÃO DA CENTRAL</span>
        <h1>Categorias</h1>
        <p>Organize a triagem e acompanhe onde a demanda está concentrada.</p>
    </div>
</section>

<section class="categories-layout">
    <aside class="panel category-create-card">
        <div class="panel-header compact"><div class="panel-title"><span class="panel-icon">＋</span><div><h2>Nova categoria</h2><p>Crie um novo assunto para triagem</p></div></div></div>
        <form action="{{ route('categories.store') }}" method="POST" class="category-form">
            @csrf
            <div class="field"><label for="name">Nome <em>*</em></label><input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="80" placeholder="Ex.: Infraestrutura" required></div>
            <div class="field"><label for="icon">Ícone ou emoji</label><input type="text" id="icon" name="icon" value="{{ old('icon') }}" maxlength="12" placeholder="Ex.: 🖥️"><span class="field-hint">Opcional. Ajuda a reconhecer a categoria.</span></div>
            <button type="submit" class="btn btn-primary btn-block" data-loading-label="Criando...">Criar categoria</button>
        </form>
        <div class="category-tip"><span>i</span><p>Categorias em uso não podem ser excluídas, protegendo o histórico dos chamados.</p></div>
    </aside>

    <div class="panel categories-panel">
        <div class="panel-header"><div class="panel-title"><span class="panel-icon">◇</span><div><h2>Categorias cadastradas</h2><p>{{ $categories->count() }} {{ $categories->count() === 1 ? 'categoria ativa' : 'categorias ativas' }}</p></div></div></div>
        <div class="category-list">
            @forelse($categories as $category)
                <article class="category-row">
                    <span class="category-big-icon">{{ $category->icon ?: '◇' }}</span>
                    <div class="category-info"><h3>{{ $category->name }}</h3><p>{{ $category->tickets_count }} {{ $category->tickets_count === 1 ? 'chamado no total' : 'chamados no total' }} · <strong>{{ $category->active_tickets_count }} ativos</strong></p></div>
                    <a href="{{ route('tickets.index', ['category' => $category->id]) }}" class="btn btn-ghost btn-small">Ver chamados</a>
                    <details class="category-edit">
                        <summary aria-label="Editar {{ $category->name }}">•••</summary>
                        <div class="category-popover">
                            <form action="{{ route('categories.update', $category) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="field"><label for="category-name-{{ $category->id }}">Nome</label><input id="category-name-{{ $category->id }}" name="name" value="{{ $category->name }}" required maxlength="80"></div>
                                <div class="field"><label for="category-icon-{{ $category->id }}">Ícone</label><input id="category-icon-{{ $category->id }}" name="icon" value="{{ $category->icon }}" maxlength="12"></div>
                                <button class="btn btn-primary btn-block" type="submit" data-loading-label="Salvando...">Salvar</button>
                            </form>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" data-confirm="Excluir a categoria {{ $category->name }}?">
                                @csrf @method('DELETE')
                                <button class="danger-link" type="submit" @disabled($category->tickets_count > 0)>Excluir categoria</button>
                            </form>
                        </div>
                    </details>
                </article>
            @empty
                <div class="empty-state"><span class="empty-icon">◇</span><h3>Nenhuma categoria ainda</h3><p>Crie a primeira categoria usando o formulário ao lado.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
