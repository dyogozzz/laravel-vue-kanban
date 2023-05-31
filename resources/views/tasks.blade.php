@extends('layouts.master')
@section('title', 'Tasks')

@section('content')

@if (Route::has('login'))
@auth
    <App />
@else
@endauth

@endif
@endsection