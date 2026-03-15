@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4">Teacher Dashboard</h2>
            
<div class="row g-4">
    @forelse($assignments as $assignment)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 assignment-card border-0 shadow-sm">
            <div class="card-body p-4 d-flex flex-column">
                <div class="mb-3 d-flex align-items-center justify-content-between">
                    <div class="rounded-circle bg-light-beige p-3 text-secondary">
                        <i class="bi bi-book fs-3"></i>
                    </div>
                    <span class="badge bg-secondary px-3 py-2 rounded-pill">
                        {{ $assignment->schoolClass->class_name ?? 'N/A' }}
                    </span>
                </div>
                
                <h4 class="fw-bold mb-1 text-secondary">
                    {{ $assignment->subject->subject_name ?? 'N/A' }}
                </h4>
                <p class="text-muted small mb-4">
                    Assigned Subject Support
                </p>
                
                <div class="mt-auto d-grid gap-2">
                    <a href="{{ route('marks.create', ['assignment_id' => $assignment->id]) }}" class="btn btn-primary d-flex align-items-center justify-content-center">
                        <i class="bi bi-pencil-square me-2"></i> Enter Marks
                    </a>
                    <a href="{{ route('marks.index', ['assignment_id' => $assignment->id]) }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                        <i class="bi bi-eye me-2"></i> View Marks
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="card bg-light border-0 py-5 shadow-sm">
            <i class="bi bi-journals fs-1 text-muted mb-3"></i>
            <h5 class="text-muted">You have no assignments yet.</h5>
            <p class="text-muted">Please contact the Academic Department to assign your subjects.</p>
        </div>
    </div>
    @endforelse
</div>

<style>
    .bg-light-beige {
        background-color: rgba(194, 178, 128, 0.15) !important;
    }
    .assignment-card {
        background: var(--light);
        transition: all 0.3s ease;
        border: 1px solid var(--border-color) !important;
    }
    .assignment-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px -5px rgba(111, 78, 55, 0.15) !important;
        border-color: var(--secondary) !important;
    }
    .assignment-card .btn-primary {
        background-color: var(--secondary);
        border-color: var(--secondary);
    }
    .assignment-card .btn-primary:hover {
        background-color: var(--dark);
        border-color: var(--dark);
    }
    .assignment-card .btn-outline-secondary {
        border-color: var(--secondary);
        color: var(--secondary);
    }
    .assignment-card .btn-outline-secondary:hover {
        background-color: var(--secondary);
        color: var(--light);
    }
</style>
        </div>
    </div>
</div>
@endsection
