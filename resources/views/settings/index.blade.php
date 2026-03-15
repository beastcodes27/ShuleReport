@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">System Settings</h2>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold">School Configuration</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="school_name" class="form-label fw-bold">School Name</label>
                                <input type="text" class="form-control @error('school_name') is-invalid @enderror" 
                                       id="school_name" name="school_name" 
                                       value="{{ old('school_name', $schoolName) }}" required>
                                @error('school_name')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="school_number" class="form-label fw-bold">School Number</label>
                                <input type="text" class="form-control @error('school_number') is-invalid @enderror" 
                                       id="school_number" name="school_number" 
                                       value="{{ old('school_number', $schoolNumber) }}" required placeholder="e.g. S0101">
                                @error('school_number')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="district" class="form-label fw-bold">District</label>
                                <input type="text" class="form-control @error('district') is-invalid @enderror" 
                                       id="district" name="district" 
                                       value="{{ old('district', $district) }}">
                                @error('district')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="region" class="form-label fw-bold">Region</label>
                                <input type="text" class="form-control @error('region') is-invalid @enderror" 
                                       id="region" name="region" 
                                       value="{{ old('region', $region) }}">
                                @error('region')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="report_template" class="form-label fw-bold">Student Report Template</label>
                            <select class="form-select @error('report_template') is-invalid @enderror" 
                                    id="report_template" name="report_template">
                                <option value="standard" {{ old('report_template', $reportTemplate) == 'standard' ? 'selected' : '' }}>Standard (Default)</option>
                                <option value="elegant" {{ old('report_template', $reportTemplate) == 'elegant' ? 'selected' : '' }}>Elegant (Premium)</option>
                                <option value="professional" {{ old('report_template', $reportTemplate) == 'professional' ? 'selected' : '' }}>Professional (Compact)</option>
                            </select>
                            <div class="form-text mt-2 text-muted">
                                Choose the visual style for student report cards.
                            </div>
                            @error('report_template')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 card shadow-sm border-0 border-start border-4 border-info">
                <div class="card-body">
                    <h6 class="fw-bold"><i class="bi bi-info-circle me-2"></i>Necta Class Notice</h6>
                    <p class="small text-muted mb-0">
                        Division and Aggregate calculations are automatically applied ONLY to classes named <strong>"Form 2"</strong> or <strong>"Form 4"</strong>. Other classes use standard grading.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
