@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <h1 class="text-primary fw-bold">ShuleReport</h1>
                <p class="text-muted">Teacher Onboarding Registration</p>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white text-center py-4 border-bottom-0">
                    <h5 class="mb-0">You've been invited to join as a Teacher!</h5>
                </div>

                <div class="card-body px-5 pb-5">
                    <form method="POST" action="{{ route('register.invite.store', $invitation->token) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ $invitation->email }}" readonly>
                            <div class="form-text text-muted">Your email is bound to this specific invitation.</div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Create Password</label>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-bold">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Complete Registration
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
