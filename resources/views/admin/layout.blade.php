<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Coach</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body>
    <nav class="admin-nav">
        <div class="admin-nav-container">
            <div class="admin-logo">
                <h2>Admin - Coach Pro</h2>
            </div>
            <ul class="admin-menu">
                <li><a href="{{ route('workout.index') }}" class="back-link">← Retour à l'app</a></li>
                <li><a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('admin.programs.index') }}"
                        class="{{ request()->routeIs('admin.programs.*') ? 'active' : '' }}">Programmes</a></li>
                <li><a href="{{ route('admin.exercises.index') }}"
                        class="{{ request()->routeIs('admin.exercises.*') ? 'active' : '' }}">Exercices</a></li>
                <li><a href="{{ route('admin.sessions.index') }}"
                        class="{{ request()->routeIs('admin.sessions.*') ? 'active' : '' }}">Séances</a></li>
            </ul>
            <div class="admin-user">
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="admin-content">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>

</html>
