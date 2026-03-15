@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Assign Teacher to Subject</h2>

            <div class="card">
                <div class="card-body">
                    @if(session('reassign_warning'))
                        <div class="alert alert-warning border-0 shadow-sm mb-4">
                            <h5 class="alert-heading"><i class="bi bi-exclamation-triangle-fill me-2"></i>Subject Conflict Detected</h5>
                            <p class="mb-3">{{ session('reassign_warning')['message'] }}</p>
                            <form method="POST" action="{{ route('assignments.store') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ old('user_id') }}">
                                <input type="hidden" name="subject_id" value="{{ old('subject_id') }}">
                                <input type="hidden" name="school_class_id" value="{{ old('school_class_id') }}">
                                <input type="hidden" name="confirm_reassign" value="1">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-warning text-white btn-sm">Yes, Reassign Subject</button>
                                    <a href="{{ route('assignments.create') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
                                </div>
                            </form>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('assignments.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select Teacher</label>
                            <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required autofocus>
                                <option value="">Select Teacher...</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('user_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="subject_id" class="form-label">Subject</label>
                                <select class="form-control @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                                    <option value="">Select Subject...</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-md-6">
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
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('assignments.index') }}" class="btn btn-outline-secondary">Back to Assignments</a>
                            <button type="submit" class="btn btn-warning text-white">Save Assignment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
