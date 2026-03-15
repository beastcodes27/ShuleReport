@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Academic Years & Terms</h2>
        <a href="{{ route('academic-years.create') }}" class="btn btn-primary">+ Add Academic Year</a>
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
                            <th>Year / Term Name</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($years as $year)
                        <tr>
                            <td class="align-middle"><strong>{{ $year->year_name }}</strong></td>
                            <td class="align-middle">
                                @if($year->is_active)
                                    <span class="badge bg-success">Active Current Year</span>
                                @else
                                    <span class="badge bg-secondary">Archived / Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('academic-years.edit', $year->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('academic-years.destroy', $year->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this year? Associated records may be affected.')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">No academic years configured. Set one up to get started!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
