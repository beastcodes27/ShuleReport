@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Register New Student</h2>

            <div class="card">
                <div class="card-body p-4">
                    @if(session('move_warning'))
                        <div class="alert alert-warning border-0 shadow-sm mb-4">
                            <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Existing Student Found</h6>
                            <p class="small mb-3">{{ session('move_warning')['message'] }}</p>
                            <form action="{{ route('students.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="admission_number" value="{{ session('move_warning')['admission_number'] }}">
                                <input type="hidden" name="name" value="{{ old('name') }}">
                                <input type="hidden" name="gender" value="{{ old('gender') }}">
                                <input type="hidden" name="school_class_id" value="{{ old('school_class_id') }}">
                                <input type="hidden" name="academic_year_id" value="{{ old('academic_year_id') }}">
                                <input type="hidden" name="confirm_move" value="1">
                                <button type="submit" class="btn btn-warning btn-sm">Yes, Move Student</button>
                            </form>
                        </div>
                    @endif

                    <form action="{{ route('students.store') }}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="admission_number" class="form-label fw-bold">Admission Number</label>
                                <input type="text" class="form-control @error('admission_number') is-invalid @enderror" 
                                       id="admission_number" name="admission_number" value="{{ old('admission_number') }}" 
                                       placeholder="e.g. ADM/2025/001" required>
                                @error('admission_number')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">School Number</label>
                                <input type="text" class="form-control bg-light" value="{{ $schoolNumber }}" readonly tabindex="-1">
                                <div class="form-text mt-1 small">Constant for this school.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                    <option value="">Select Gender...</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="school_class_id" class="form-label">Class</label>
                                <select class="form-control @error('school_class_id') is-invalid @enderror" id="school_class_id" name="school_class_id" required>
                                    <option value="">Select Class...</option>
                                    @foreach($classes as $c)
                                        <option value="{{ $c->id }}" {{ old('school_class_id') == $c->id ? 'selected' : '' }}>{{ $c->class_name }}</option>
                                    @endforeach
                                </select>
                                @error('school_class_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="academic_year_id" class="form-label">Academic Year</label>
                                <select class="form-control @error('academic_year_id') is-invalid @enderror" id="academic_year_id" name="academic_year_id" required>
                                    <option value="">Select Year...</option>
                                    @foreach($years as $y)
                                        <option value="{{ $y->id }}" {{ old('academic_year_id') == $y->id ? 'selected' : '' }}>{{ $y->year_name }}</option>
                                    @endforeach
                                </select>
                                @error('academic_year_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back to Students</a>
                            <button type="submit" class="btn btn-primary">Register Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const center = document.getElementById('reg_center');
        const student = document.getElementById('reg_student');
        const year = document.getElementById('reg_year');
        const final = document.getElementById('registration_number');

        function updateFinal() {
            if(center.value && student.value && year.value) {
                final.value = `${center.value.toUpperCase()}/${student.value.padStart(4, '0')}/${year.value}`;
            }
        }

        center.addEventListener('input', updateFinal);
        student.addEventListener('input', updateFinal);
        year.addEventListener('input', updateFinal);
    });
</script>
@endsection
@endsection
