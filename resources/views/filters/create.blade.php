@extends('layouts.app')

@section('title', 'Нова мітка')

@section('content')
    <h1 class="h3">Нова мітка</h1>
    <form method="POST" action="{{ route('filters.store') }}">
        @csrf
        @include('filters._form')
        <button type="submit" class="btn btn-primary">Зберегти</button>
        <a href="{{ route('filters.index') }}" class="btn btn-link">Скасувати</a>
    </form>
@endsection
