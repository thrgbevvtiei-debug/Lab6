<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Автосалон')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/js/app.js'])
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('cars.index') }}">Автосалон</a>

        <div class="navbar-nav flex-row gap-3">
            <a class="nav-link {{ request()->routeIs('cars.*') ? 'active' : '' }}"
               href="{{ route('cars.index') }}">Автомобілі</a>
            <a class="nav-link {{ request()->routeIs('countries.*') ? 'active' : '' }}"
               href="{{ route('countries.index') }}">Країни</a>
            <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}"
               href="{{ route('blog.index') }}">Блог</a>
            <a class="nav-link {{ request()->routeIs('stats.*') ? 'active' : '' }}"
               href="{{ route('stats.pages') }}">Статистика</a>
        </div>

        <div class="ms-auto d-flex gap-2">
            @foreach (config('locales') as $code => $name)
                <a class="btn btn-sm {{ app()->getLocale() === $code ? 'btn-light' : 'btn-outline-light' }}"
                   href="{{ request()->fullUrlWithQuery(['lang' => $code]) }}"
                   title="{{ $name }}">{{ strtoupper($code) }}</a>
            @endforeach
        </div>
    </div>
</nav>

<div class="container bg-white p-4 rounded shadow-sm mb-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<footer class="mt-auto bg-dark text-light text-center py-3">
    Виконав: Крикун Сергій, група РС-42
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
