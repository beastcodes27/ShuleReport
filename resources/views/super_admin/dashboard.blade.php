@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Super Admin Dashboard</h2>
            <p class="text-muted">Overview of system users and administrative actions.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4 h-100">
                <div class="rounded-circle bg-primary text-white mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-people fs-3"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $stats['total_users'] }}</h3>
                <p class="text-muted small mb-0">Total Users</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4 h-100">
                <div class="rounded-circle bg-secondary text-white mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-person-badge fs-3"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $stats['academic_masters'] }}</h3>
                <p class="text-muted small mb-0">Academic Masters</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4 h-100">
                <div class="rounded-circle bg-dark text-white mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-building fs-3"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $stats['academic_departments'] }}</h3>
                <p class="text-muted small mb-0">Departments</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4 h-100">
                <div class="rounded-circle bg-info text-white mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-person-video3 fs-3"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $stats['teachers'] }}</h3>
                <p class="text-muted small mb-0">Teachers</p>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold mb-1">User Management</h4>
                    <p class="text-muted mb-0">Assign roles and manage staff access levels.</p>
                </div>
                <a href="{{ route('users.index') }}" class="btn btn-secondary px-4 py-2">
                    Manage Users <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
