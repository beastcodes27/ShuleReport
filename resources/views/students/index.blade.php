@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Students</h2>
        <a href="{{ route('students.create') }}" class="btn btn-primary">+ Add New Student</a>
    </div>

    <div class="row g-3 mb-4 align-items-end">
        <div class="col-md-6">
            <form action="{{ route('students.index') }}" method="GET" class="d-flex gap-2">
                <select name="school_class_id" class="form-select border-0 shadow-sm" onchange="this.form.submit()">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ ($selectedClass->id ?? '') == $class->id ? 'selected' : '' }}>
                            {{ $class->class_name }}
                        </option>
                    @endforeach
                </select>
                <a href="{{ route('students.index') }}" class="btn btn-light shadow-sm"><i class="bi bi-x-circle"></i></a>
            </form>
        </div>
        <div class="col-md-6 text-end">
            @if($isNecta && $selectedClass)
                <form action="{{ route('students.generate-necta') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="school_class_id" value="{{ $selectedClass->id }}">
                    <button type="submit" class="btn btn-outline-primary shadow-sm" onclick="return confirm('This will re-assign registration numbers alphabetical order. Continue?')">
                        <i class="bi bi-list-ol me-2"></i>Generate NECTA Register
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm py-2"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm py-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4">Adm. No.</th>
                            @if($isNecta)
                            <th>NECTA Reg. No.</th>
                            @endif
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Class</th>
                            <th class="text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td class="px-4"><code>{{ $student->admission_number }}</code></td>
                            @if($isNecta)
                            <td><span class="badge bg-secondary">{{ $student->registration_number ?: 'Pending' }}</span></td>
                            @endif
                            <td><strong>{{ $student->name }}</strong></td>
                            <td>{{ $student->gender }}</td>
                            <td>{{ $student->schoolClass->class_name ?? 'N/A' }}</td>
                            <td class="text-end px-4">
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ $isNecta ? 6 : 5 }}" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                                No students found. Register one above!
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
