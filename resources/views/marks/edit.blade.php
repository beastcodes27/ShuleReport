@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h2 class="mb-0">Edit Mark</h2>
            </div>

            <div class="card assignment-card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h5 class="text-secondary fw-bold mb-1">{{ $mark->student->name }}</h5>
                        <p class="text-muted small mb-0">
                            Reg. No: <code>{{ $mark->student->registration_number }}</code> | 
                            Subject: <strong>{{ $mark->subject->subject_name }}</strong> | 
                            Semester: <strong>{{ $mark->semester }}</strong>
                        </p>
                    </div>

                    <form action="{{ route('marks.update', $mark->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="score" class="form-label fw-bold">Score (0-100)</label>
                            <input type="number" 
                                   class="form-control form-control-lg @error('score') is-invalid @enderror" 
                                   id="score" 
                                   name="score" 
                                   value="{{ old('score', $mark->score) }}" 
                                   min="0" 
                                   max="100" 
                                   step="0.1"
                                   required 
                                   autofocus>
                            @error('score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check2-circle me-2"></i> Update Mark
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .assignment-card {
        background: var(--light);
        border: 1px solid var(--border-color) !important;
    }
    .btn-primary {
        background-color: var(--secondary);
        border-color: var(--secondary);
    }
    .btn-primary:hover {
        background-color: var(--dark);
        border-color: var(--dark);
    }
</style>
@endsection
