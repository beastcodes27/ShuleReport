@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manage Teachers</h2>
            <p class="text-muted mb-0">Create and manage teacher accounts.</p>
        </div>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary"><i class="bi bi-person-plus-fill me-2"></i>Add New Teacher</a>
    </div>

    <div class="row g-3 mb-4 align-items-end">
        <div class="col-md-6">
            <form action="{{ route('teachers.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control border-0 shadow-sm" placeholder="Search by name or email...">
                <button type="submit" class="btn btn-light shadow-sm"><i class="bi bi-search"></i></button>
                @if($search)
                    <a href="{{ route('teachers.index') }}" class="btn btn-light shadow-sm"><i class="bi bi-x-circle"></i></a>
                @endif
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Teacher</th>
                            <th>Email</th>
                            <th>Subject Assignments</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                        {{ substr($teacher->name, 0, 1) }}
                                    </div>
                                    <span class="fw-semibold">{{ $teacher->name }}</span>
                                </div>
                            </td>
                            <td>{{ $teacher->email }}</td>
                            <td>
                                <span class="badge rounded-pill {{ $teacher->teacher_subjects_count > 0 ? 'text-bg-success' : 'text-bg-secondary' }}">
                                    {{ $teacher->teacher_subjects_count }} subject(s)
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this teacher account?{{ $teacher->teacher_subjects_count > 0 ? ' Their subject assignments will also be removed.' : '' }}')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-person-x fs-1 d-block mb-3 opacity-25"></i>
                                No teachers found{{ $search ? ' matching your search' : '' }}. Add one above!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
