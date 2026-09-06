@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manage Classes</h2>
            <p class="text-muted mb-0">Classes support streams (e.g. A, B) and A-Level subject combinations (Form 5/6).</p>
        </div>
        <a href="{{ route('classes.create') }}" class="btn btn-primary">+ Add New Class</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Class Name</th>
                        <th>Stream</th>
                        <th>Combination</th>
                        <th class="text-center">Students</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $schoolClass)
                    <tr>
                        <td class="ps-4"><strong>{{ $schoolClass->class_name }}</strong></td>
                        <td>
                            @if($schoolClass->stream)
                                <span class="badge rounded-pill text-bg-secondary">{{ $schoolClass->stream }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($schoolClass->combination)
                                <span class="badge rounded-pill text-bg-success">{{ $schoolClass->combination }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill text-bg-light border">{{ $schoolClass->students_count }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('classes.edit', $schoolClass->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('classes.destroy', $schoolClass->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this class? Its students and teacher assignments will also be removed.')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No classes found. Add one above!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
