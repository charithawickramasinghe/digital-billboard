<nav class="navbar navbar-expand-lg navbar-light bg-light ps-3" style="margin-left: 250px;">
    <div class="container-fluid">
        <span class="navbar-brand">
            @csrf
            <h1>{{ $title ?? 'Dashboard' }}</h1>
        </span>

        <div class="flex items-center gap-4 text-end">
            <span>Hello <strong>{{ Auth::user()->name }}</strong>, You are logged in.</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm mt-1">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>


