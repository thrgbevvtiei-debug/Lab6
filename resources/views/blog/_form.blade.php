<div class="mb-3">
    <label for="title" class="form-label">Заголовок</label>
    <input type="text" id="title" name="title" class="form-control"
           value="{{ old('title', $blog->title ?? '') }}">
    @error('title') <p class="text-danger">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Короткий опис</label>
    <input type="text" id="description" name="description" class="form-control"
           value="{{ old('description', $blog->description ?? '') }}">
    @error('description') <p class="text-danger">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label for="text" class="form-label">Текст</label>
    <textarea id="text" name="text" rows="6" class="form-control">{{ old('text', $blog->text ?? '') }}</textarea>
    @error('text') <p class="text-danger">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label for="category_id" class="form-label">Категорія</label>
    <select id="category_id" name="category_id" class="form-select">
        <option value="">— Без категорії —</option>
        @foreach ($categories as $id => $name)
            <option value="{{ $id }}" @selected(old('category_id', $blog->category_id ?? '') == $id)>
                {{ $name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <p class="text-danger">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label for="filters" class="form-label">Мітки (кілька значень)</label>
    <select id="filters" name="filters[]" multiple>
        @foreach ($filters as $id => $name)
            <option value="{{ $id }}"
                @selected(in_array($id, old('filters', $selected ?? [])))>
                {{ $name }}
            </option>
        @endforeach
    </select>
    @error('filters') <p class="text-danger">{{ $message }}</p> @enderror
    @error('filters.*') <p class="text-danger">{{ $message }}</p> @enderror
</div>
