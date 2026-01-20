<div class="card shadow-sm rounded-lg p-4">
    <form action="{{ $action }}" method="POST" id="{{ $formId ?? 'sliderCategoryForm' }}">
        @csrf
        @isset($method) {{ $method }} @endisset

        <div class="mb-3">
            <label for="name" class="form-label fw-medium text-dark">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $sliderCategory->name ?? '') }}"
                   class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label fw-medium text-dark">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                <option value="1" {{ old('status', $sliderCategory->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $sliderCategory->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-medium text-dark">Description</label>
            <textarea name="description" id="editor" rows="3" class="form-control">{{ old('description', $sliderCategory->description ?? '') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">{{ $submitButtonText ?? 'Save' }}</button>
            <a href="{{ route('admin.slider-categories.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>