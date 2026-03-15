@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Generate Class Reports</h2>

            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="year_id" class="form-label fw-bold">Academic Year</label>
                            <select name="year_id" id="year_id" class="form-select" required>
                                <option value="">Select Year...</option>
                                @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" {{ $selectedYear==$year->id ? 'selected' : '' }}>
                                    {{ $year->year_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="semester" class="form-label fw-bold">Semester</label>
                            <select name="semester" id="semester" class="form-select" required>
                                <option value="1" {{ $selectedSemester==1 ? 'selected' : '' }}>Semester 1</option>
                                <option value="2" {{ $selectedSemester==2 ? 'selected' : '' }}>Semester 2</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="class_id" class="form-label fw-bold">Select Class</label>
                            <select name="class_id" id="class_id" class="form-select" required>
                                <option value="">Select Class...</option>
                                @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ $selectedClass==$c->id ? 'selected' : '' }}>
                                    {{ $c->class_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Fetch Results</button>
                        </div>
                    </form>
                </div>
            </div>

            @if($selectedClass && $selectedYear)
            <div class="card">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Class Rankings & Results</h5>
                    <div>
                        <a href="{{ route('export.class-results') }}?class_id={{ $selectedClass }}&year_id={{ $selectedYear }}&semester={{ $selectedSemester }}" class="btn btn-sm btn-outline-dark me-2">
                            <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
                        </a>
                        <button class="btn btn-sm btn-dark" onclick="window.print()">Print Report</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Rank</th>
                                    <th>Reg. No.</th>
                                    <th>Student Name</th>
                                    <th>Total Marks</th>
                                    <th>Average</th>
                                    @if($isNecta)
                                    <th>Aggregate</th>
                                    @endif
                                    <th>Grade</th>
                                    @if($isNecta)
                                    <th>Division</th>
                                    @endif
                                    <th>Report Card</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $index => $student)
                                <tr>
                                    <td><span class="badge bg-secondary fs-6">#{{ $index + 1 }}</span></td>
                                    <td><code>{{ $student->registration_number }}</code></td>
                                    <td><strong>{{ $student->name }}</strong></td>
                                    <td>{{ $student->total_marks }}</td>
                                    <td>{{ $student->average }}</td>
                                    @if($isNecta)
                                    <td>
                                        <span class="badge bg-light text-dark border fw-bold">
                                            {{ $student->aggregate ?? '—' }}
                                        </span>
                                    </td>
                                    @endif
                                    <td>
                                        <span class="badge fs-6 px-3
                                            {{ $student->grade == 'A' ? 'bg-success' :
                                               ($student->grade == 'B' ? 'bg-primary' :
                                               ($student->grade == 'C' ? 'bg-info text-dark' :
                                               ($student->grade == 'D' ? 'bg-warning text-dark' : 'bg-danger'))) }}">
                                            {{ $student->grade }}
                                        </span>
                                    </td>
                                    @if($isNecta)
                                    <td class="text-muted small">{{ $student->division ?? '—' }}</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('reports.show', $student->id) }}?year_id={{ $selectedYear }}&semester={{ $selectedSemester }}"
                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                            🖨️ View Card
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ $isNecta ? 9 : 7 }}" class="text-center py-4 text-muted">No students found or marks have
                                        not been fully entered for this class.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-info py-4 text-center">
                Please select an Academic Year, Semester, and Class to view the computed results and rankings.
            </div>
            @endif

        </div>
    </div>
</div>
@endsection