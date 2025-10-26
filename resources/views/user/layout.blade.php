<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Coach Pro Training</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="menu-overlay" onclick="toggleMenu()"></div>

    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <h2>Coach - Pro Training</h2>
            </div>
            <ul class="nav-menu">
                <li><a class="nav-link {{ request()->routeIs('workout.index') ? 'active' : '' }}"
                        href="{{ route('workout.index') }}">Carnet</a></li>
                <li><a class="nav-link {{ request()->routeIs('workout.chrono') ? 'active' : '' }}"
                        href="{{ route('workout.chrono') }}">Chronomètre</a></li>
                <li><a class="nav-link {{ request()->routeIs('workout.calc1rm') ? 'active' : '' }}"
                        href="{{ route('workout.calc1rm') }}">Calcul 1RM</a></li>
                <li><a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                        href="{{ route('profile.edit') }}">Profil</a></li>
                @auth
                    @if (Auth::user()->is_admin)
                        <li><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
                    @endif
                @endauth
            </ul>
            <div class="nav-user">
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout-nav">Déconnexion</button>
                </form>
            </div>
            <div class="burger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <main class="page-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p><strong>Coach</strong> - Pro Training</p>
            <p style="margin-top: 0.5rem; font-size: 0.85rem;">Pas d'Entraînement, pas de résultats</p>
            <div class="footer-links">
                <a href="#" class="footer-link">À propos</a>
                <a href="#" class="footer-link">Contact</a>
                <a href="#" class="footer-link">Confidentialité</a>
            </div>
            <p style="margin-top: 1rem; font-size: 0.8rem; color: #666;">© 2025 Coach - doko972 - Tous droits réservés
            </p>
        </div>
    </footer>

    <audio id="beep" src="https://actions.google.com/sounds/v1/alarms/alarm_clock.ogg"></audio>

    @stack('scripts')
</body>

</html>
