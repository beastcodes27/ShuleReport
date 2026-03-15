@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4">Enter Marks: {{ $assignment->subject->subject_name }}</h2>
            <h5 class="text-muted">Class: {{ $assignment->schoolClass->class_name }} | Year: {{ $academicYear->year_name ?? 'N/A' }}</h5>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card mt-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('marks.store') }}">
                        @csrf
                        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                        
                        <div class="mb-4 w-25">
                            <label for="semester" class="form-label fw-bold">Select Semester</label>
                            <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                                <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Semester 1</option>
                                <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Semester 2</option>
                            </select>
                        </div>

                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Reg. No.</th>
                                    <th>Student Name</th>
                                    <th width="200">Score (0-100)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                    <td class="align-middle"><code>{{ $student->registration_number }}</code></td>
                                    <td class="align-middle"><strong>{{ $student->name }}</strong></td>
                                    <td>
                                        <input type="number" 
                                               name="marks[{{ $student->id }}]" 
                                               class="form-control" 
                                               min="0" max="100" 
                                               step="0.1" 
                                               placeholder="Enter score">
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No students assigned to this class yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
                            <button type="submit" class="btn btn-primary px-4" {{ $students->isEmpty() ? 'disabled' : '' }}>Save Marks</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
