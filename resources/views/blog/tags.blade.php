@extends('layouts.app')

@section('title', 'Керування мітками')

@section('content')
    <h1 class="h3">Мітки: {{ $blog->title }}</h1>

    <form method="POST" action="{{ route('blog.tags.store', $blog) }}">
        @csrf

        <label for="duallist" class="form-label">Оберіть мітки запису</label>
        <select id="duallist" name="filters[]" multiple>
            @foreach ($filters as $id => $name)
                <option value="{{ $id }}"
                    @selected(in_array($id, old('filters', $selected)))>
                    {{ $name }}
                </option>
            @endforeach
        </select>
        @error('filters') <p class="text-danger">{{ $message }}</p> @enderror
        @error('filters.*') <p class="text-danger">{{ $message }}</p> @enderror

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Зберегти мітки</button>
            <a href="{{ route('blog.show', $blog) }}" class="btn btn-link">Скасувати</a>
        </div>
    </form>
@endsection
