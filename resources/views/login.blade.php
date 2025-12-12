<x-auth-layout title="Login">
    <div class="card p-4 shadow login-card">
        <h2 class="text-2xl mb-6 ">Login</h2>
        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="mb-3">
                <input type="email" class="form-control" placeholder="Email" placeholder="Email" name="email" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Remember Me
                </label>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</x-auth-layout>