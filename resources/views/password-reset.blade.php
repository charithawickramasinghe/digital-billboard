<x-layout title="Reset Password">
    <div class="content">
        <div class="container mt-3" style="max-width: 600px;">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-key"></i> Reset Password
                    </h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle"></i> 
                            <strong>Error:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('password-reset.update') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input 
                                type="password" 
                                class="form-control @error('current_password') is-invalid @enderror" 
                                id="current_password" 
                                name="current_password" 
                                required
                                placeholder="Enter your current password"
                            >
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                required
                                placeholder="Enter your new password"
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted d-block mt-2">
                                Password must be at least 8 characters and contain uppercase, lowercase, number, and special character.
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input 
                                type="password" 
                                class="form-control @error('password_confirmation') is-invalid @enderror" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required
                                placeholder="Confirm your new password"
                            >
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Password
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .container {
            padding-top: 20px;
            padding-bottom: 40px;
        }

        .card {
            border: none;
            border-radius: 8px;
        }

        .card-header {
            border-radius: 8px 8px 0 0;
            padding: 20px;
        }

        .card-header h4 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control {
            padding: 10px 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn {
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .alert {
            border-radius: 6px;
            border: none;
        }
    </style>
</x-layout>
