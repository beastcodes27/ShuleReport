@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4">View Marks: {{ $assignment->subject->subject_name }}</h2>
            <h5 class="text-muted">Class: {{ $assignment->schoolClass->class_name }}</h5>

            <div class="card mt-4">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Reg. No.</th>
                                <th>Student Name</th>
                                <th>Term/Semester</th>
                                <th>Score</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($marks as $mark)
                            <tr>
                                <td><code>{{ $mark->student->registration_number ?? 'N/A' }}</code></td>
                                <td><strong>{{ $mark->student->name ?? 'N/A' }}</strong></td>
                                <td>Semester {{ $mark->semester }}</td>
                                <td><span class="badge bg-secondary fs-6">{{ $mark->score }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('marks.edit', $mark->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No marks have been recorded for this subject yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
                <div class="float-end">
                    <a href="{{ route('export.subject-results') }}?assignment_id={{ $assignment->id }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-file-earmark-spreadsheet"></i> Export Results
                    </a>
                    <a href="{{ route('marks.create', ['assignment_id' => $assignment->id]) }}" class="btn btn-primary">Enter New Marks</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
