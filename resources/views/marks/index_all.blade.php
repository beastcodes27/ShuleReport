@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold">My Consolidated Marks</h2>
                    <p class="text-muted">A complete list of all marks you have entered across all assigned classes.</p>
                </div>
                <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-speedometer2 me-2"></i> Teacher Dashboard
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Student</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Semester</th>
                                    <th>Score</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($marks as $mark)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">{{ $mark->student->name ?? 'N/A' }}</div>
                                        <div class="text-muted small">{{ $mark->student->admission_number ?? 'N/A' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-outline-secondary" style="border: 1px solid currentColor; color: var(--secondary);">
                                            {{ $mark->student->schoolClass->class_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ $mark->subject->subject_name ?? 'N/A' }}</td>
                                    <td>Semester {{ $mark->semester }}</td>
                                    <td>
                                        <span class="badge bg-secondary fs-6">{{ $mark->score }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('marks.edit', $mark->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-journal-x fs-1 d-block mb-3"></i>
                                        No marks have been recorded yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
