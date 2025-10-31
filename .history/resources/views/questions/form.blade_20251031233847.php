@csrf
<div class="mb-3">
    <label for="text" class="form-label">Question Text</label>
    <textarea name="text" id="text" class="form-control" rows="3" required>{{ old('text', $question->text ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="type" class="form-label">Type</label>
    <select name="type" id="type" class="form-select" required>
        <option value="">Select Type</option>
        <option value="multiple" {{ old('type', $question->type ?? '') == 'multiple' ? 'selected' : '' }}>Multiple Choice</option>
        <option value="true_false" {{ old('type', $question->type ?? '') == 'true_false' ? 'selected' : '' }}>True/False</option>
    </select>
</div>

<div class="mb-3">
    <label for="section_id" class="form-label">Section</label>
    <select name="section_id" id="section_id" class="form-select">
        <option value="">Select Section</option>
        @foreach($sections as $section)
        <option value="{{ $section->id }}" {{ old('section_id', $question->section_id ?? '') == $section->id ? 'selected' : '' }}>
            {{ $section->name }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="certification_id" class="form-label">Certification</label>
    <select name="certification_id" id="certification_id" class="form-select">
        <option value="">Select Certification</option>
        @foreach($certifications as $cert)
        <option value="{{ $cert->id }}" {{ old('certification_id', $question->certification_id ?? '') == $cert->id ? 'selected' : '' }}>
            {{ $cert->name }}
        </option>
        @endforeach
    </select>
</div>

<div class="text-end">
    <button type="submit" class="btn btn-success">Save</button>
    <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancel</a>
</div>