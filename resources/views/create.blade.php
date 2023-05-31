@extends('layouts.master')

@section('title', 'Criar Task')

@section('content')

<a href="/"> Voltar para home</a>

@if (Route::has('login'))
@auth
    <form action="/create/task" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="form-group">
            <label for="title">Título da Task</label>
            <input type="text" id="title" name="title" placeholder="Título da task">
        </div>
        <div class="form-group">
            <label for="description">Descrição da Task</label>
            <input type="text" id="description" name="description" placeholder="Descrição da task">
        </div>
        <div class="form-group">
            <label for="status">Status da Task</label>
            <select name="status" id="status">
                <option value="Pendente">Pendente</option>
                <option value="Em andamento">Em andamento</option>
                <option value="Concluída">Concluída</option>
            </select>
        </div>
        <div class="form-group">
            <label for="vencimento">Vencimento da Task</label>
            <input type="date" id="vencimento" name="vencimento">
        </div>
        <div class="form-group">
            <label for="usuario">Usuário para task</label>
            <input type="text" id="usuario" name="usuario">
        </div>
        <input type="submit" value="criar"></input>
    </form>
@else
    <p>faça login para continuar</p>
    <a href="/login">Fazer login</a>
@endauth
@endif

@endsection
