<!DOCTYPE html>
<html>
<head>
    <title>Multi-Role Auth System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">MultiRole Auth</a>
            <div class="navbar-nav">
                @auth
                    <span class="nav-item nav-link">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>
    
    <div class="py-4">
        @yield('content')
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
</body>
</html>