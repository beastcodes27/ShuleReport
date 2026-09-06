@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Edit Class</h2>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('classes.update', $schoolClass->id) }}">
                        @csrf
                        @method('PUT')
                        @include('classes._form', ['schoolClass' => $schoolClass])

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">Back to Classes</a>
                            <button type="submit" class="btn btn-primary">Update Class</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
