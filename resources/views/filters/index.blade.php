@extends('layouts.app')

@section('title', 'Довідник міток')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Довідник міток</h1>
        <a href="{{ route('filters.create') }}" class="btn btn-primary">+ Додати мітку</a>
    </div>

    <table class="table table-striped border align-middle">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Назва</th>
            <th>Опис</th>
            <th>Записів</th>
            <th>Дії</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($filters as $filter)
            <tr>
                <td>{{ $filters->firstItem() + $loop->index }}</td>
                <td>
                    <a href="{{ route('blog.index', ['filter' => $filter->filter_id]) }}">
                        {{ $filter->filter_name }}
                    </a>
                </td>
                <td>{{ $filter->filter_description ?? '—' }}</td>
                <td>{{ $filter->blogs_count }}</td>
                <td class="d-flex gap-2">
                    <a href="{{ route('filters.edit', $filter) }}"
                       class="btn btn-sm btn-outline-primary">Редагувати</a>
                    <form method="POST" action="{{ route('filters.destroy', $filter) }}"
                          onsubmit="return confirm('Видалити мітку?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Видалити</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted">Міток немає.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $filters->links() }}
@endsection
