@extends('layouts.app')

@section('title', 'Novo chamado | HelpDesk')

@section('content')


{{-- =====================================================
     CABEÇALHO
===================================================== --}}

<section class="page-heading page-heading-with-art">

    <div class="page-heading-content">

        <span class="eyebrow">
            NOVO ATENDIMENTO
        </span>

        <h1>
            Abrir chamado
        </h1>

        <p>
            Descreva o problema para que o atendimento possa ser iniciado.
        </p>

    </div>


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

</section>


<section class="create-grid">


    {{-- =================================================
         FORMULÁRIO
    ================================================== --}}

    <div class="panel create-form-panel">


        <div class="panel-title form-title">

            <div class="panel-title-icon blue large">
                ✎
            </div>

            <div>

                <h2>
                    Informações do chamado
                </h2>

                <p>
                    Preencha os dados abaixo para abrir um novo atendimento.
                </p>

            </div>

        </div>


        <form
            action="{{ route('tickets.store') }}"
            method="POST"
            class="ticket-form"
        >

            @csrf


            <div class="field">

                <label for="title">

                    Título do chamado

                    <span class="required">*</span>

                </label>


                <div class="control-with-icon large-control">

                    <span class="control-icon">
                        ⌕
                    </span>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Ex: Computador não inicia"
                        required
                    >

                </div>


                @error('title')

                    <span class="field-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            <div class="form-row">


                <div class="field">

                    <label for="category_id">

                        Categoria

                        <span class="required">*</span>

                    </label>


                    <select
                        id="category_id"
                        name="category_id"
                        required
                    >

                        <option
                            value=""
                            disabled
                            @selected(!old('category_id'))
                        >
                            Selecione uma categoria
                        </option>


                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>


                    @error('category_id')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <div class="field">

                    <label for="priority">

                        Prioridade

                        <span class="required">*</span>

                    </label>


                    <select
                        id="priority"
                        name="priority"
                        required
                    >

                        <option
                            value="low"
                            @selected(old('priority') === 'low')
                        >
                            Baixa
                        </option>

                        <option
                            value="normal"
                            @selected(old('priority', 'normal') === 'normal')
                        >
                            Normal
                        </option>

                        <option
                            value="high"
                            @selected(old('priority') === 'high')
                        >
                            Alta
                        </option>

                        <option
                            value="urgent"
                            @selected(old('priority') === 'urgent')
                        >
                            Urgente
                        </option>

                    </select>


                    @error('priority')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>

            </div>


            <div class="field">

                <label for="description">

                    Descrição do problema

                    <span class="required">*</span>

                </label>


                <textarea
                    id="description"
                    name="description"
                    rows="8"
                    maxlength="5000"
                    placeholder="Descreva com o máximo de detalhes possível..."
                    required
                >{{ old('description') }}</textarea>


                <div class="textarea-meta">

                    <small>
                        Descreva com o máximo de detalhes possível.
                    </small>

                    <span id="descriptionCount">
                        0 / 5000
                    </span>

                </div>


                @error('description')

                    <span class="field-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            <div class="form-footer">

                <a
                    href="{{ route('tickets.index') }}"
                    class="btn btn-secondary"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary btn-submit"
                >
                    ➤ Abrir chamado
                </button>

            </div>


        </form>

    </div>


    {{-- =================================================
         DICAS
    ================================================== --}}

    <aside class="panel tips-panel">

        <div class="tips-heading">

            <div class="tips-icon">
                ◉
            </div>

            <div>

                <h2>
                    Antes de abrir
                </h2>

                <p>
                    Essas informações ajudam a equipe a resolver
                    o problema mais rápido.
                </p>

            </div>

        </div>


        <div class="tips-list">


            <div class="tip-step">

                <div class="tip-number">
                    01
                </div>

                <div>

                    <strong>
                        Use um título objetivo
                    </strong>

                    <p>
                        Descreva o problema de forma clara e direta.
                    </p>

                    <small>
                        Exemplo: "Impressora não liga".
                    </small>

                </div>

            </div>


            <div class="tip-step">

                <div class="tip-number">
                    02
                </div>

                <div>

                    <strong>
                        Escolha a categoria
                    </strong>

                    <p>
                        Ajuda a organizar o atendimento no setor correto.
                    </p>

                </div>

            </div>


            <div class="tip-step">

                <div class="tip-number">
                    03
                </div>

                <div>

                    <strong>
                        Explique os detalhes
                    </strong>

                    <p>
                        Informe o erro e o que você já tentou fazer.
                    </p>

                </div>

            </div>

        </div>


        <div class="tip-highlight">

            <div class="highlight-check">
                ✓
            </div>

            <div>

                <strong>
                    Mais clareza, mais agilidade
                </strong>

                <p>
                    Quanto mais detalhes você informar,
                    mais rápido poderemos encontrar uma solução.
                </p>

            </div>

        </div>

    </aside>


</section>


@endsection