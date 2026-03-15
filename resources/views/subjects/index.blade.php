@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Subjects</h2>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary">+ Add New Subject</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Subject Name</th>
                        <th>Subject Code</th>
                        <th>Abbreviation</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $item)
                    <tr>
                        <td><strong>{{ $item->subject_name }}</strong></td>
                        <td><code>{{ $item->subject_code ?? '—' }}</code></td>
                        <td><span class="badge bg-secondary">{{ $item->abbreviation ?? '—' }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('subjects.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('subjects.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">No subjects found. Add one above!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
