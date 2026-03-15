@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Grade & Division Settings</h2>
            <p class="text-muted small mb-0">Configure score intervals, grades and divisions used across all reports.</p>
        </div>
        <a href="{{ route('grade-settings.create') }}" class="btn btn-primary">+ Add Grade Interval</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Grade</th>
                        <th>Division</th>
                        <th>Score Range</th>
                        <th>Remarks</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grades as $g)
                    <tr>
                        <td class="ps-4">
                            <span class="badge fs-6 px-3
                                {{ $g->grade === 'A' ? 'bg-success' :
                                  ($g->grade === 'B' ? 'bg-primary' :
                                  ($g->grade === 'C' ? 'bg-info text-dark' :
                                  ($g->grade === 'D' ? 'bg-warning text-dark' : 'bg-danger'))) }}">
                                {{ $g->grade }}
                            </span>
                        </td>
                        <td><strong>{{ $g->division }}</strong></td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ $g->min_score }} – {{ $g->max_score }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $g->remarks }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('grade-settings.edit', $g->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('grade-settings.destroy', $g->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this grade interval?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">No grade intervals configured yet. Add one to get started.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
