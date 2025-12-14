<nav class="navbar navbar-expand-lg navbar-light bg-light ps-3" style="margin-left: 250px;">
    <div class="container-fluid">
        <span class="navbar-brand">
            @csrf
            <h1>{{ $title ?? 'Dashboard' }}</h1>
        </span>

        <div class="flex items-center gap-4 text-end">
            <!-- User Dropdown Menu -->
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle user-dropdown-btn" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i> 
                    <strong>{{ Auth::user()->name }}</strong>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <span class="dropdown-item-text">
                            <small class="text-muted">Logged in as</small><br>
                            <strong>{{ Auth::user()->email }}</strong>
                        </span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('password-reset.show') }}">
                            <i class="bi bi-key"></i> Reset Password
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="dropdown-item-form">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<style>
    .user-dropdown-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        transition: all 0.3s ease;
        color: #212529;
    }

    .user-dropdown-btn:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }

    .user-dropdown-btn:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .dropdown-menu {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
        min-width: 250px;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: #212529;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }

    .dropdown-item i {
        width: 20px;
        text-align: center;
    }

    .dropdown-item-text {
        padding: 0.75rem 1rem;
        display: block;
    }

    .dropdown-item-form {
        margin: 0;
        padding: 0;
    }

    .dropdown-item-form .dropdown-item {
        margin: 0;
    }

    .dropdown-divider {
        margin: 0.5rem 0;
    }
</style>

