@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Edit Student</h2>

            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('students.update', $student->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="admission_number" class="form-label fw-bold">Admission Number</label>
                                <input type="text" class="form-control @error('admission_number') is-invalid @enderror"
                                       id="admission_number" name="admission_number" value="{{ old('admission_number', $student->admission_number) }}"
                                       placeholder="e.g. ADM/2025/001" required>
                                @error('admission_number')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="registration_number" class="form-label">NECTA Reg. No. <small class="text-muted">(optional)</small></label>
                                <input type="text" class="form-control @error('registration_number') is-invalid @enderror"
                                       id="registration_number" name="registration_number"
                                       value="{{ old('registration_number', $student->registration_number) }}"
                                       placeholder="e.g. S0000/0001/2026">
                                @error('registration_number')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $student->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                    <option value="">Select Gender...</option>
                                    <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
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
                                        <option value="{{ $c->id }}" {{ old('school_class_id', $student->school_class_id) == $c->id ? 'selected' : '' }}>{{ $c->display_name }}</option>
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
                                        <option value="{{ $y->id }}" {{ old('academic_year_id', $student->academic_year_id) == $y->id ? 'selected' : '' }}>{{ $y->year_name }}</option>
                                    @endforeach
                                </select>
                                @error('academic_year_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back to Students</a>
                            <button type="submit" class="btn btn-primary">Update Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
