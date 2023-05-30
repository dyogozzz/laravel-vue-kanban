@extends('layouts.master')

@section('content')

@if (Route::has('login'))
@auth
    <App />
@else
    <p>faça login para continuar</p>
    <a href="/login">Fazer login</a>
@endauth

@endif
@endsection