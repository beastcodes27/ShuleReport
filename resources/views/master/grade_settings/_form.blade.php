{{-- Shared form fields for create/edit --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Grade Label <span class="text-danger">*</span></label>
        <input type="text" name="grade" maxlength="2" class="form-control @error('grade') is-invalid @enderror"
               placeholder="e.g. A, B, C, D, F"
               value="{{ old('grade', $gradeSetting->grade ?? '') }}">
        @error('grade')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Division <span class="text-danger">*</span></label>
        <input type="text" name="division" maxlength="50" class="form-control @error('division') is-invalid @enderror"
               placeholder="e.g. Division I, Division II"
               value="{{ old('division', $gradeSetting->division ?? '') }}">
        @error('division')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Minimum Score <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="number" name="min_score" min="0" max="100" class="form-control @error('min_score') is-invalid @enderror"
                   placeholder="0"
                   value="{{ old('min_score', $gradeSetting->min_score ?? '') }}">
            <span class="input-group-text">%</span>
        </div>
        @error('min_score')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Maximum Score <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="number" name="max_score" min="0" max="100" class="form-control @error('max_score') is-invalid @enderror"
                   placeholder="100"
                   value="{{ old('max_score', $gradeSetting->max_score ?? '') }}">
            <span class="input-group-text">%</span>
        </div>
        @error('max_score')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Remarks <span class="text-danger">*</span></label>
        <input type="text" name="remarks" maxlength="100" class="form-control @error('remarks') is-invalid @enderror"
               placeholder="e.g. Excellent, Very Good, Pass, Fail"
               value="{{ old('remarks', $gradeSetting->remarks ?? '') }}">
        @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
