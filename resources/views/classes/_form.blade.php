@php
    $class = $schoolClass ?? null;
    $class_name = old('class_name', $class->class_name ?? '');
    $stream = old('stream', $class->stream ?? '');
    $combination = old('combination', $class->combination ?? '');
    $isALevel = $class ? $class->is_a_level : false;
@endphp

<div class="mb-3">
    <label for="class_name" class="form-label fw-bold">Class Name / Level</label>
    <input type="text" class="form-control @error('class_name') is-invalid @enderror"
           id="class_name" name="class_name" value="{{ $class_name }}"
           required autofocus placeholder="e.g. Form One or Form Five" data-alvel-value="{{ $isALevel ? '1' : '0' }}">
    <div class="form-text mt-1 small">Examples: Form One, Form Two ... Form Five, Form Six</div>
    @error('class_name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label for="stream" class="form-label fw-bold">Stream <span class="text-muted fw-normal">(optional)</span></label>
        <input type="text" class="form-control @error('stream') is-invalid @enderror"
               id="stream" name="stream" value="{{ $stream }}"
               placeholder="e.g. A, B, C or West" maxlength="20">
        <div class="form-text mt-1 small">Leave blank if the class has no streams.</div>
        @error('stream')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-6">
        <div id="combinationField" style="{{ $isALevel ? '' : 'display: none;' }}">
            <label for="combination" class="form-label fw-bold">Subject Combination <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('combination') is-invalid @enderror"
                   id="combination" name="combination" value="{{ $combination }}"
                   placeholder="e.g. PCM, PCB, HGE" list="combinationSuggestions" maxlength="20">
            <datalist id="combinationSuggestions">
                <option value="PCM"></option>
                <option value="PCB"></option>
                <option value="CBG"></option>
                <option value="HGE"></option>
                <option value="EGM"></option>
                <option value="PGM"></option>
                <option value="HGL"></option>
                <option value="HKL"></option>
                <option value="ECA"></option>
                <option value="CBA"></option>
                <option value="HKM"></option>
                <option value="HGK"></option>
            </datalist>
            <div class="form-text mt-1 small">Required for Form 5/6 (A-Level) classes.</div>
            @error('combination')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.getElementById('class_name');
        const comboField = document.getElementById('combinationField');
        const comboInput = document.getElementById('combination');

        function isALevel(value) {
            const n = value.toLowerCase()
                .replace(/\bform\s*(five|v)\b/g, 'form 5')
                .replace(/\bform\s*(six|vi)\b/g, 'form 6');
            return /\bform\s*[56]\b/.test(n);
        }

        function syncCombinationField() {
            if (!comboField) return;
            const show = nameInput ? isALevel(nameInput.value) : false;
            comboField.style.display = show ? '' : 'none';
            if (comboInput) comboInput.required = show;
        }

        if (nameInput) {
            nameInput.addEventListener('input', syncCombinationField);
        }
        syncCombinationField();
    });
</script>

