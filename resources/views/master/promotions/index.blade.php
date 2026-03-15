@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4">Batch Promote Students</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-warning">{{ session('error') }}</div>
            @endif

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">Perform Academic Promotion</h5>
                </div>
                <div class="card-body p-4 bg-light">
                    <form method="POST" action="{{ route('promotions.promote') }}">
                        @csrf
                        
                        <div class="row mb-5 g-4">
                            <div class="col-md-5">
                                <div class="p-3 border rounded bg-white h-100">
                                    <h6 class="text-secondary border-bottom pb-2 mb-3"><i class="bi bi-box-arrow-right me-2"></i>From (Current State)</h6>
                                    
                                    <div class="mb-3">
                                        <label for="from_year_id" class="form-label fw-bold">Academic Year</label>
                                        <select class="form-select @error('from_year_id') is-invalid @enderror" id="from_year_id" name="from_year_id" required>
                                            <option value="">Select current year...</option>
                                            @foreach($years as $year)
                                                <option value="{{ $year->id }}" {{ old('from_year_id') == $year->id ? 'selected' : '' }}>{{ $year->year_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="from_class_id" class="form-label fw-bold">Class</label>
                                        <select class="form-select @error('from_class_id') is-invalid @enderror" id="from_class_id" name="from_class_id" required>
                                            <option value="">Select current class...</option>
                                            @foreach($classes as $c)
                                                <option value="{{ $c->id }}" {{ old('from_class_id') == $c->id ? 'selected' : '' }}>{{ $c->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                <div class="text-center text-primary">
                                    <span class="d-none d-md-block fs-1">➔</span>
                                    <span class="d-block d-md-none fs-1">⬇️</span>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="p-3 border rounded bg-white border-primary border-2 h-100 shadow-sm">
                                    <h6 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-box-arrow-in-right me-2"></i>To (Target State)</h6>
                                    
                                    <div class="mb-3">
                                        <label for="to_year_id" class="form-label fw-bold">Academic Year</label>
                                        <select class="form-select @error('to_year_id') is-invalid @enderror" id="to_year_id" name="to_year_id" required>
                                            <option value="">Select target year...</option>
                                            @foreach($years as $year)
                                                <option value="{{ $year->id }}" {{ old('to_year_id') == $year->id ? 'selected' : '' }}>{{ $year->year_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('to_year_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="to_class_id" class="form-label fw-bold">Class to Promote To</label>
                                        <select class="form-select @error('to_class_id') is-invalid @enderror" id="to_class_id" name="to_class_id" required>
                                            <option value="">Select target class...</option>
                                            @foreach($classes as $c)
                                                <option value="{{ $c->id }}" {{ old('to_class_id') == $c->id ? 'selected' : '' }}>{{ $c->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info py-2 small">
                            <strong>Note:</strong> Promoting students will update their profiles to the new class and academic year selected. Make sure results have been generated for the target group before migrating them.
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('master.dashboard') }}" class="btn btn-outline-secondary">Go Back</a>
                            <button type="submit" class="btn btn-primary px-5" onclick="return confirm('Please confirm! This will batch-update all matching students. Continue?')">Execute Promotion</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
