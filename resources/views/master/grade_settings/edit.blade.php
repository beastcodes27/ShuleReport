@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="d-flex align-items-center mb-4 gap-3">
                <a href="{{ route('grade-settings.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back</a>
                <h4 class="mb-0">Edit Grade Interval</h4>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('grade-settings.update', $gradeSetting->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('master.grade_settings._form', ['gradeSetting' => $gradeSetting])
                        <button type="submit" class="btn btn-primary w-100 mt-3">Update Grade Interval</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
