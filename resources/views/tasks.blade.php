@extends('master')

@section('title', 'Tasks')

@section('content')

<a href="/"> Voltar para home</a>

@if (Route::has('login'))
@auth
<div id="events-container" class="col-md-12">
    <h2><App/> </h2>
    <p class="subtitle">Veja os eventos dos próximos dias</p>
    <div id="cards-container" class="row">
        @foreach($tasks as $task)
        <div class="card col-sm-6 col-md-4 col-lg-3">
            <div class="card-body">
                <p class="card-date">{{ date('d/m/Y', strtotime($task->vencimento)) }}</p>
                <h5 class="card-title">{{ $task->title }}</h5>
                <p class="card-participants">X Participantes</p>
                <a href="/tasks/{{ $task->id }}" class="btn btn-primary">Saber mais</a>
            </div>
        </div>
        @endforeach
        @if(count($tasks) == 0)
            <p>Não há eventos disponíveis</p>
        @endif
    </div>
</div>
@else
    <p>faça login para continuar</p>
    <a href="/login">Fazer login</a>
@endauth
@endif

@endsection
