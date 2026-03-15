@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold">User Management</h2>
            <p class="text-muted">Promote teachers to <strong>Academic Master</strong> or assign <strong>Department</strong> roles to manage staff access.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">User</th>
                            <th>Email</th>
                            <th>Current Role</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="fw-semibold">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge rounded-pill bg-outline-{{ $user->role === 'super_admin' ? 'danger' : ($user->role === 'academic_master' ? 'success' : ($user->role === 'academic_department' ? 'warning' : 'info')) }}" style="border: 1px solid currentColor;">
                                    {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('users.update-role', $user->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group input-group-sm">
                                        <select name="role" class="form-select form-select-sm border-secondary shadow-none" style="width: 160px;">
                                            <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                            <option value="academic_department" {{ $user->role === 'academic_department' ? 'selected' : '' }}>Department</option>
                                            <option value="academic_master" {{ $user->role === 'academic_master' ? 'selected' : '' }}>Academic Master</option>
                                            <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                        </select>
                                        <button type="submit" class="btn btn-secondary btn-sm">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-outline-success { color: #198754; }
    .bg-outline-warning { color: #ffc107; }
    .bg-outline-info { color: #0dcaf0; }
    .bg-outline-danger { color: #dc3545; }
</style>
@endsection
