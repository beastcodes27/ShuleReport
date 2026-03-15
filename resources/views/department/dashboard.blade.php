@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Academic Department Dashboard</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-primary text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Manage Students</h5>
                            <p class="card-text">Register and view students.</p>
                            <a href="{{ route('students.index') }}" class="btn btn-light btn-sm mt-2">Go to Students</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Manage Classes</h5>
                            <p class="card-text">Setup school classes.</p>
                            <a href="{{ route('classes.index') }}" class="btn btn-light btn-sm mt-2">Go to Classes</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Manage Subjects</h5>
                            <p class="card-text">Setup school subjects.</p>
                            <a href="{{ route('subjects.index') }}" class="btn btn-light btn-sm mt-2">Go to Subjects</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="card bg-warning text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Assign Teachers</h5>
                            <p class="card-text">Link teachers to subjects and classes.</p>
                            <a href="{{ route('assignments.index') }}" class="btn btn-light btn-sm mt-2">Go to Assignments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
