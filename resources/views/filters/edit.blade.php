@extends('layouts.app')

@section('title', 'Редагування мітки')

@section('content')
    <h1 class="h3">Редагування мітки</h1>
    <form method="POST" action="{{ route('filters.update', $filter) }}">
        @csrf
        @method('PUT')
        @include('filters._form')
        <button type="submit" class="btn btn-primary">Оновити</button>
        <a href="{{ route('filters.index') }}" class="btn btn-link">Скасувати</a>
    </form>
@endsection
