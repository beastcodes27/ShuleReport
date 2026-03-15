@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Add New Class</h2>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('classes.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="class_name" class="form-label">Class Name</label>
                            <input type="text" class="form-control @error('class_name') is-invalid @enderror" id="class_name" name="class_name" required autofocus placeholder="e.g. Form 1">
                            @error('class_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">Back to Classes</a>
                            <button type="submit" class="btn btn-primary">Save Class</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
