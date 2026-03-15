<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card – {{ $student->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }
        .report-card { max-width: 800px; margin: 30px auto; background: #fff; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden; }
        .report-header { background: linear-gradient(135deg, #4f46e5, #0ea5e9); color: white; padding: 30px; }
        .school-name { font-size: 1.8rem; font-weight: 700; letter-spacing: 1px; }
        .report-title { font-size: 1rem; opacity: 0.85; letter-spacing: 3px; text-transform: uppercase; }
        .student-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 20px 30px; border-bottom: 1px solid #e2e8f0; }
        .info-item label { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 1px; }
        .info-item span { font-size: 1rem; font-weight: 600; color: #1e293b; display: block; }
        .summary-bar { display: flex; gap: 0; }
        .summary-item { flex: 1; text-align: center; padding: 20px 10px; border-right: 1px solid #e2e8f0; }
        .summary-item:last-child { border-right: none; }
        .summary-item .value { font-size: 2rem; font-weight: 700; }
        .summary-item .label { font-size: 0.7rem; text-transform: uppercase; color: #64748b; letter-spacing: 1px; }
        .grade-A { color: #16a34a; }
        .grade-B { color: #2563eb; }
        .grade-C { color: #0891b2; }
        .grade-D { color: #d97706; }
        .grade-F { color: #dc2626; }
        .marks-table th { background: #f8fafc; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #64748b; }
        .score-badge { padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.9rem; }
        .score-high { background: #dcfce7; color: #16a34a; }
        .score-mid { background: #dbeafe; color: #2563eb; }
        .score-pass { background: #e0f2fe; color: #0891b2; }
        .score-low { background: #fef9c3; color: #d97706; }
        .score-fail { background: #fee2e2; color: #dc2626; }
        .footer-bar { background: #f8fafc; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2e8f0; font-size: 0.8rem; color: #94a3b8; }
        @media print {
            body { background: white; }
            .no-print { display: none !important; }
            .report-card { box-shadow: none; margin: 0; border-radius: 0; }
        }
    </style>
</head>
<body>

<!-- Toolbar (hidden on print) -->
<div class="container no-print mt-3 mb-3">
    <div class="d-flex gap-2 align-items-center">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">&larr; Back to Reports</a>
        <button onclick="window.print()" class="btn btn-primary btn-sm ms-auto">🖨️ Print / Save as PDF</button>
    </div>
    <div class="text-muted small mt-2"><strong>Tip:</strong> To save as PDF, click <strong>Print</strong> and then select "Save as PDF" in your printer dialog.</div>
</div>

<div class="report-card">
    <!-- Header -->
    <div class="report-header text-center">
        <div class="school-name">{{ $schoolName }}</div>
        <div class="report-title mt-1">{{ $schoolNumber }} - Official Academic Report Card</div>
        <div class="mt-2 small opacity-75">
            @if($district){{ $district }}, @endif @if($region){{ $region }}@endif
        </div>
    </div>

    <!-- Student Info -->
    <div class="student-info-grid">
        <div class="info-item">
            <label>Student Name</label>
            <span>{{ $student->name }}</span>
        </div>
        <div class="info-item">
            <label>Registration Number</label>
            <span>{{ $student->registration_number }}</span>
        </div>
        <div class="info-item">
            <label>Class</label>
            <span>{{ $student->schoolClass->class_name ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
            <label>Year / Semester</label>
            <span>{{ $academicYear->year_name ?? 'N/A' }} — Sem {{ $selectedSemester }}</span>
        </div>
    </div>

    <!-- Summary Bar -->
    <div class="summary-bar">
        <div class="summary-item">
            <div class="value grade-{{ $grade }}">{{ $grade }}</div>
            <div class="label">Overall Grade</div>
        </div>
        @if($isNecta)
        <div class="summary-item">
            <div class="value text-dark fw-bold">{{ $aggregate }}</div>
            <div class="label">Aggregate Points</div>
        </div>
        <div class="summary-item">
            <div class="value text-primary" style="font-size:1.3rem">{{ $division }}</div>
            <div class="label">Division</div>
        </div>
        @else
        <div class="summary-item">
            <div class="value text-dark">{{ $totalScore }}</div>
            <div class="label">Total Marks</div>
        </div>
        @endif
        <div class="summary-item">
            <div class="value text-secondary">{{ number_format($average, 1) }}%</div>
            <div class="label">Average Score</div>
        </div>
        <div class="summary-item">
            <div class="value text-info">{{ $rank }} / {{ $totalInClass }}</div>
            <div class="label">Class Rank</div>
        </div>
    </div>

    <!-- Detailed Marks -->
    <div class="p-4">
        <h6 class="fw-bold text-uppercase text-muted mb-3" style="letter-spacing:1px; font-size: 0.75rem;">Subject Performance Breakdown</h6>
        @if($marks->count() > 0)
        <table class="table marks-table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th class="text-center">Score</th>
                    <th class="text-center">Grade</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($marks as $i => $mark)
                    @php
                        $s = $mark->score;
                        if($s >= 80) { $g = 'A'; $rem = 'Excellent'; $cls = 'score-high'; }
                        elseif($s >= 60) { $g = 'B'; $rem = 'Good'; $cls = 'score-mid'; }
                        elseif($s >= 40) { $g = 'C'; $rem = 'Average'; $cls = 'score-pass'; }
                        elseif($s >= 30) { $g = 'D'; $rem = 'Below Average'; $cls = 'score-low'; }
                        else { $g = 'F'; $rem = 'Fail'; $cls = 'score-fail'; }
                    @endphp
                    <tr>
                        <td class="text-muted small">{{ $i + 1 }}</td>
                        <td><strong>{{ $mark->subject->subject_name ?? 'N/A' }}</strong></td>
                        <td class="text-center"><span class="score-badge {{ $cls }}">{{ $s }}</span></td>
                        <td class="text-center fw-bold grade-{{ $g }}">{{ $g }}</td>
                        <td class="text-muted small">{{ $rem }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center text-muted py-4">No marks have been entered for this student this semester.</div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer-bar">
        <span>Generated: {{ now()->format('d M Y, H:i') }}</span>
        <span>ShuleReport System &copy; {{ date('Y') }}</span>
    </div>
</div>

</body>
</html>
