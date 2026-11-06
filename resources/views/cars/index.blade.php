@extends('layouts.app')

@section('title', 'Автомобілі')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Автомобілі в наявності</h1>
        <a href="{{ route('cars.create') }}" class="btn btn-primary">+ Додати авто</a>
    </div>

    <form method="GET" action="{{ route('cars.index') }}" class="row g-2 mb-3">
        <div class="col-auto">
            <select name="brand" class="form-select">
                <option value="">Усі марки</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand }}" @selected(request('brand') === $brand)>{{ $brand }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-secondary">Фільтрувати</button>
            @if (request('brand'))
                <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">Скинути</a>
            @endif
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-dark-header table-striped table-hover align-middle border">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Марка</th>
                <th>Модель</th>
                <th>Назва ({{ strtoupper(app()->getLocale()) }})</th>
                <th>Рік</th>
                <th>Ціна, $</th>
                <th>Пробіг, км</th>
                <th>Паливо</th>
                <th>КПП</th>
                <th>Опцій</th>
                <th>Дії</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($cars as $car)
                <tr>
                    <td>{{ $cars->firstItem() + $loop->index }}</td>
                    <td>{{ $car->brand }}</td>
                    <td>
                        <a href="{{ route('cars.show', $car) }}" class="fw-bold text-decoration-none">
                            {{ $car->model }}
                        </a>
                    </td>
                    <td>
                        {{ $car->title }}
                        @if ($car->isFallback())
                            <span class="badge bg-warning text-dark">{{ strtoupper(config('app.fallback_locale')) }}</span>
                        @endif
                    </td>
                    <td>{{ $car->year }}</td>
                    <td>{{ number_format($car->price, 0, '.', ' ') }}</td>
                    <td>{{ number_format($car->mileage, 0, '.', ' ') }}</td>
                    <td>{{ $car->fuel_type->value }}</td>
                    <td>{{ $car->transmission->value }}</td>
                    <td>{{ $car->features_count }}</td>
                    <td>
                        <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-outline-primary">Редагувати</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center text-muted">Автомобілі не знайдено.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $cars->links() }}
    </div>
@endsection
