@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Academic Master Dashboard</h2>
            
            <!-- Quick Actions -->
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-calendar-event"></i> Manage Academic Years</h5>
                            <p class="card-text small">Set active terms and semesters.</p>
                            <a href="{{ route('academic-years.index') }}" class="btn btn-light btn-sm mt-2">Manage Terms</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-person-plus"></i> Invite Teachers</h5>
                            <p class="card-text small">Send invites to new subject teachers.</p>
                            <a href="{{ route('invitations.index') }}" class="btn btn-light btn-sm mt-2">Invite</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-arrow-up-circle"></i> Promote Students</h5>
                            <p class="card-text small">Move students to the next class.</p>
                            <a href="{{ route('promotions.index') }}" class="btn btn-light btn-sm mt-2">Promote</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-file-earmark-bar-graph"></i> Generate Reports</h5>
                            <p class="card-text small">Produce class report cards.</p>
                            <a href="{{ route('reports.index') }}" class="btn btn-light btn-sm mt-2">View Reports</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics Section -->
            <h4 class="mb-3">System Analytics Overview</h4>
            <div class="row">
                <!-- Metrics -->
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 h-100 p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted text-uppercase mb-1">Total Students</h6>
                                        <h2 class="mb-0 display-5 fw-bold">{{ $totalStudents }}</h2>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 h-100 p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted text-uppercase mb-1">Total Teachers</h6>
                                        <h2 class="mb-0 display-5 fw-bold">{{ $totalTeachers }}</h2>
                                    </div>
                                    <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                            <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                            <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 h-100 p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted text-uppercase mb-1">Total Classes</h6>
                                        <h2 class="mb-0 display-5 fw-bold">{{ $totalClasses }}</h2>
                                    </div>
                                    <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-building-fill" viewBox="0 0 16 16">
                                            <path d="M3 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3v-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V16h3a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H3Zm1 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 h-100 p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted text-uppercase mb-1">Total Subjects</h6>
                                        <h2 class="mb-0 display-5 fw-bold">{{ $totalSubjects }}</h2>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-book-fill" viewBox="0 0 16 16">
                                            <path d="M8 1.783C7.015.936 5.587.814 5 1c-.3.093-.5.22-.5.3v11c.0.08.2.207.5.3.587.186 2.015.308 3-.539v-10.278zM8.5 2.1c.985.847 2.413.969 3 .783C12.8.2.78 13.064 12.985 13c-.587-.186-2.015-.308-3 .539V3.278A9.76 9.76 0 0 1 8.5 2.1z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Highlight / Pass Rate -->
                <div class="col-md-4 mt-4 mt-md-0">
                    <div class="card shadow-sm border-0 h-100 bg-dark text-white p-4 d-flex flex-column justify-content-center text-center">
                        <h5 class="fw-light mb-3">Overall Pass Rate (≥40%)</h5>
                        
                        <div class="position-relative d-inline-block mx-auto mb-3" style="width: 150px; height: 150px;">
                            <svg class="w-100 h-100" viewBox="0 0 100 100">
                                <!-- Background Circle -->
                                <circle 
                                    cx="50" cy="50" r="40" 
                                    fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="8" />
                                
                                <!-- Progress Circle -->
                                <circle 
                                    cx="50" cy="50" r="40" 
                                    fill="none" 
                                    stroke="{{ $passRate >= 50 ? '#28a745' : '#dc3545' }}" 
                                    stroke-width="8" 
                                    stroke-dasharray="{{ ($passRate / 100) * 251.2 }} 251.2" 
                                    stroke-linecap="round" 
                                    transform="rotate(-90 50 50)" />
                                
                                <!-- Percentage Text -->
                                <text x="50" y="50" class="display-6 fw-bold" text-anchor="middle" fill="white" dy=".3em">{{ $passRate }}%</text>
                            </svg>
                        </div>
                        
                        <p class="mb-0 text-white-50">
                            Current Academic Year:<br>
                            <span class="text-white fw-bold">{{ $activeYear->year_name ?? 'Not Set' }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Top Students -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-trophy-fill text-warning me-2"></i>Top 5 Performing Students</h5>
                            <span class="badge bg-secondary">{{ $activeYear->year_name ?? 'All-Time' }}</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Rank</th>
                                            <th>Student</th>
                                            <th>Class</th>
                                            <th>Reg. Number</th>
                                            <th class="text-end pe-4">Average Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(isset($topStudents) ? $topStudents : [] as $index => $student)
                                        <tr>
                                            <td class="ps-4">
                                                @if($index == 0) <span class="badge bg-warning text-dark fs-6 px-3">🥇 1st</span>
                                                @elseif($index == 1) <span class="badge bg-secondary fs-6 px-3 text-white">🥈 2nd</span>
                                                @elseif($index == 2) <span class="badge bg-danger fs-6 px-3 text-white" style="background-color: #cd7f32 !important">🥉 3rd</span>
                                                @else <span class="badge bg-light text-dark fs-6 px-3">#{{ $index + 1 }}</span>
                                                @endif
                                            </td>
                                            <td><strong class="text-dark">{{ $student->name }}</strong></td>
                                            <td>{{ $student->schoolClass->class_name ?? 'N/A' }}</td>
                                            <td><code>{{ $student->registration_number }}</code></td>
                                            <td class="text-end pe-4">
                                                <span class="fs-5 fw-bold {{ $student->average >= 80 ? 'text-success' : 'text-primary' }}">{{ number_format($student->average, 1) }}%</span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bi bi-inbox fs-2 d-block mb-3"></i>
                                                Not enough academic data to determine top students yet.
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
    </div>

    <!-- Graph Analysis Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="mb-3">📊 Graph Analysis</h4>
        </div>

        <!-- Grade Distribution Doughnut -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">Grade Distribution</h6>
                    <small class="text-muted">All marks breakdown by grade</small>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center" style="min-height:280px;">
                    <canvas id="gradeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pass vs Fail Pie -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">Pass vs Fail Rate</h6>
                    <small class="text-muted">Students scoring ≥40 vs below</small>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center" style="min-height:280px;">
                    <canvas id="passFailChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Class Average Bar -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">Class Average Scores</h6>
                    <small class="text-muted">Average mark per class (active year)</small>
                </div>
                <div class="card-body" style="min-height:280px;">
                    <canvas id="classChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Grade Distribution Doughnut Chart
    new Chart(document.getElementById('gradeChart'), {
        type: 'doughnut',
        data: {
            labels: ['A (≥80)', 'B (60-79)', 'C (40-59)', 'D (30-39)', 'F (<30)'],
            datasets: [{
                data: [
                    {{ $gradeCounts['A'] }},
                    {{ $gradeCounts['B'] }},
                    {{ $gradeCounts['C'] }},
                    {{ $gradeCounts['D'] }},
                    {{ $gradeCounts['F'] }}
                ],
                backgroundColor: ['#16a34a','#2563eb','#0891b2','#d97706','#dc2626'],
                hoverOffset: 6,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 14, font: { size: 11 } } },
                tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.raw}` } }
            }
        }
    });

    // Pass vs Fail Pie Chart
    new Chart(document.getElementById('passFailChart'), {
        type: 'pie',
        data: {
            labels: ['Passed (≥40)', 'Failed (<40)'],
            datasets: [{
                data: [
                    {{ $gradeCounts['A'] + $gradeCounts['B'] + $gradeCounts['C'] }},
                    {{ $gradeCounts['D'] + $gradeCounts['F'] }}
                ],
                backgroundColor: ['#16a34a','#dc2626'],
                borderColor: '#fff',
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 14 } },
                tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.raw}` } }
            }
        }
    });

    // Class Average Bar Chart
    new Chart(document.getElementById('classChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($classLabels) !!},
            datasets: [{
                label: 'Avg. Score (%)',
                data: {!! json_encode($classAverages) !!},
                backgroundColor: '#4f46e5',
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: { color: '#f1f5f9' },
                    ticks: { callback: val => val + '%' }
                },
                x: { grid: { display: false } }
            },
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` Average: ${ctx.raw}%` } }
            }
        }
    });

});
</script>
@endsection
