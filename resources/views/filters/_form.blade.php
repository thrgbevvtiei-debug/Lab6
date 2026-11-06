<div class="mb-3">
    <label for="filter_name" class="form-label">Назва</label>
    <input type="text" id="filter_name" name="filter_name" class="form-control"
           value="{{ old('filter_name', $filter->filter_name ?? '') }}">
    @error('filter_name') <p class="text-danger">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label for="filter_description" class="form-label">Опис</label>
    <textarea id="filter_description" name="filter_description" rows="3"
              class="form-control">{{ old('filter_description', $filter->filter_description ?? '') }}</textarea>
    @error('filter_description') <p class="text-danger">{{ $message }}</p> @enderror
</div>
