<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Report Card – {{ $student->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #fff; font-size: 11pt; color: #333; }
        .professional-card { border: 2px solid #333; padding: 40px; }
        .school-header { border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px; text-align: center; }
        .school-title { font-size: 22pt; font-weight: bold; text-transform: uppercase; margin-bottom: 2px; }
        .school-meta { font-size: 10pt; text-transform: uppercase; }
        .student-details { display: grid; grid-template-columns: 1fr 1fr; margin-bottom: 25px; gap: 10px; }
        .detail-line { border-bottom: 1px dotted #333; display: flex; justify-content: space-between; }
        .results-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .results-table th, .results-table td { border: 1px solid #333; padding: 8px; text-align: left; }
        .results-table th { background: #eee; text-transform: uppercase; font-size: 9pt; }
        .summary-section { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .summary-box { border: 1px solid #333; padding: 10px; text-align: center; }
        .summary-value { font-size: 16pt; font-weight: bold; }
        .summary-label { font-size: 8pt; text-transform: uppercase; font-weight: bold; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="container mt-4 no-print mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ url()->previous() }}" class="btn btn-dark btn-sm">&larr; Back</a>
            <button onclick="window.print()" class="btn btn-primary btn-sm">Download Official PDF</button>
        </div>
    </div>

    <div class="container professional-card shadow-sm">
        <div class="school-header">
            <div class="school-title">{{ $schoolName }}</div>
            <div class="school-meta">
                {{ $schoolNumber }} | @if($district){{ $district }}, @endif @if($region){{ $region }}@endif
            </div>
            <div class="h5 mt-3 fw-bold">ANNUAL ACADEMIC PROGRESS REPORT</div>
        </div>

        <div class="student-details">
            <div class="detail-line"><strong>Name:</strong> <span>{{ $student->name }}</span></div>
            <div class="detail-line"><strong>Reg No:</strong> <span>{{ $student->registration_number ?: 'N/A' }}</span></div>
            <div class="detail-line"><strong>Class:</strong> <span>{{ $student->schoolClass->class_name ?? 'N/A' }}</span></div>
            <div class="detail-line"><strong>Term:</strong> <span>Semester {{ $selectedSemester }} / {{ $academicYear->year_name ?? 'N/A' }}</span></div>
        </div>

        <table class="results-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Score (%)</th>
                    <th>Grade</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($marks as $mark)
                @php
                    $s = $mark->score;
                    if($s >= 80) $g = 'A'; elseif($s >= 60) $g = 'B'; elseif($s >= 40) $g = 'C'; elseif($s >= 30) $g = 'D'; else $g = 'F';
                @endphp
                <tr>
                    <td>{{ $mark->subject->subject_name }}</td>
                    <td>{{ $s }}</td>
                    <td class="fw-bold">{{ $g }}</td>
                    <td>{{ $g == 'F' ? 'Re-sit Required' : 'Passed' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-section">
            <div class="summary-box">
                <div class="summary-label">Average Score</div>
                <div class="summary-value">{{ number_format($average, 1) }}%</div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Grade / Division</div>
                <div class="summary-value">{{ $grade }} {{ $isNecta ? '/ ' . $division : '' }}</div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Class Rank</div>
                <div class="summary-value">{{ $rank }} / {{ $totalInClass }}</div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-4 border-top pt-2 text-center small"><strong>Class Teacher</strong></div>
            <div class="col-4"></div>
            <div class="col-4 border-top pt-2 text-center small"><strong>Head of School</strong></div>
        </div>
    </div>
</body>
</html>
