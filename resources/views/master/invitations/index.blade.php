@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4">Teacher Invitations</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">Generate New Invitation Link</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('invitations.store') }}" class="d-flex align-items-center">
                        @csrf
                        <div class="flex-grow-1 me-3">
                            <label for="email" class="visually-hidden">Teacher's Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter teacher's email address" required>
                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary px-4">Generate Link</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Email</th>
                                    <th>Status</th>
                                    <th>Link</th>
                                    <th class="text-end pe-4">Sent On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invitations as $invitation)
                                <tr>
                                    <td class="ps-4"><strong>{{ $invitation->email }}</strong></td>
                                    <td>
                                        @if($invitation->accepted_at)
                                            <span class="badge bg-success">Accepted</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$invitation->accepted_at)
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" value="{{ route('register.invite', $invitation->token) }}" id="link-{{ $invitation->id }}" readonly>
                                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('link-{{ $invitation->id }}')"><i class="bi bi-clipboard"></i> Copy</button>
                                            </div>
                                        @else
                                            <span class="text-muted small">Account created</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4 text-muted small">{{ $invitation->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No invitations sent yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('master.dashboard') }}" class="btn btn-outline-secondary">Go Back</a>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(elementId) {
    var copyText = document.getElementById(elementId);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value).then(function() {
        alert("Copied link to clipboard!");
    });
}
</script>
@endsection
