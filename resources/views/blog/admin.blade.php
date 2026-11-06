@extends('layouts.app')

@section('title', 'Адміністрування блогу')

@section('content')
    <h1>Адміністрування блогу</h1>
    <p><a href="{{ route('blog.create') }}">Додати запис</a></p>

    <table class="table table-striped border">
        <thead class="table-dark">
        <tr>
            <th>№</th>
            <th>Заголовок</th>
            <th>Категорія</th>
            <th>Міток</th>
            <th>Дата</th>
            <th>Дії</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($blogs as $i => $blog)
            <tr>
                <td>{{ $blogs->firstItem() + $i }}</td>
                <td><a href="{{ route('blog.show', $blog) }}">{{ $blog->t_title }}</a></td>
                <td>{{ $blog->category?->category_name ?? '—' }}</td>
                <td>{{ $blog->filters_count }}</td>
                <td>{{ $blog->dt_created->format('d.m.Y') }}</td>
                <td class="d-flex gap-2">
                    <a href="{{ route('blog.edit', $blog) }}">Редагувати</a>
                    <form method="POST" action="{{ route('blog.destroy', $blog) }}"
                          onsubmit="return confirm('Видалити запис?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Видалити</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">Записів немає.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $blogs->links() }}
@endsection
