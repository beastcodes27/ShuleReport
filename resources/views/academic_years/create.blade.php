@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Add Academic Year</h2>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('academic-years.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="year_name" class="form-label">Academic Year / Term Name</label>
                            <input type="text" class="form-control @error('year_name') is-invalid @enderror" id="year_name" name="year_name" value="{{ old('year_name') }}" required autofocus placeholder="e.g. 2025/2026 Academic Year">
                            @error('year_name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Set as Active Current Year</label>
                            <div class="form-text text-muted">Warning: Making this active will deactivate any currently active year.</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('academic-years.index') }}" class="btn btn-outline-secondary">Back</a>
                            <button type="submit" class="btn btn-primary px-4">Save Term</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
