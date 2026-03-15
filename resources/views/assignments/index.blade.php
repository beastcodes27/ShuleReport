@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Teacher Assignments</h2>
        <a href="{{ route('assignments.create') }}" class="btn btn-warning text-white">+ Assign Teacher</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Teacher Name</th>
                            <th>Subject</th>
                            <th>Class</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assignment)
                        <tr>
                            <td><strong>{{ $assignment->user->name ?? 'N/A' }}</strong></td>
                            <td>{{ $assignment->subject->subject_name ?? 'N/A' }}</td>
                            <td>{{ $assignment->schoolClass->class_name ?? 'N/A' }}</td>
                            <td class="text-end">
                                <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove assignment?')">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No teachers assigned yet. Click 'Assign Teacher' above!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
