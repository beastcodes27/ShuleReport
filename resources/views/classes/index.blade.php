@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Classes</h2>
        <a href="{{ route('classes.create') }}" class="btn btn-primary">+ Add New Class</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Class Name</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                    @forelse($classes as $schoolClass)
                    <tr>
                        <td>{{ $schoolClass->id }}</td>
                        <td><strong>{{ $schoolClass->class_name }}</strong></td>
                        <td class="text-end">
                            <form action="{{ route('classes.destroy', $schoolClass->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">No classes found. Add one above!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
