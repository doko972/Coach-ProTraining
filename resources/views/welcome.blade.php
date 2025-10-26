<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach - Pro Training</title>
    @vite(['resources/scss/app.scss'])
</head>
<body class="welcome-page">
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Coach - Pro Training" class="logo-img">
            </div>
            <ul class="nav-menu">
                <li><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
                <li><a class="nav-link" href="{{ route('register') }}">Inscription</a></li>
            </ul>
        </div>
    </nav>

    <main class="welcome-content">
        <div class="hero-section">
            <h1 class="hero-title">Bienvenue sur Coach</h1>
            <p class="hero-subtitle">Votre application de coaching sportif professionnel</p>
            <p class="hero-description">
                Suivez vos programmes d'entraînement, gérez vos performances et atteignez vos objectifs avec Coach Pro Training.
            </p>
            
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn-hero-primary">Commencer maintenant</a>
                <a href="{{ route('login') }}" class="btn-hero-secondary">Se connecter</a>
            </div>
        </div>

        <div class="features-section">
            <h2 class="features-title">Fonctionnalités</h2>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <h3>Carnet d'Entraînement</h3>
                    <p>Suivez vos séances, notez vos performances et progressez semaine après semaine.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">⏱️</div>
                    <h3>Chronomètre de Repos</h3>
                    <p>Gérez vos temps de repos entre les séries pour optimiser votre entraînement.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💪</div>
                    <h3>Calcul 1RM</h3>
                    <p>Calculez automatiquement vos charges d'entraînement en fonction de votre 1RM.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Statistiques</h3>
                    <p>Visualisez votre progression et vos statistiques d'entraînement.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>Responsive</h3>
                    <p>Utilisez l'application sur tous vos appareils : mobile, tablette, ordinateur.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3>Programmes Personnalisés</h3>
                    <p>Accédez à des programmes d'entraînement structurés et adaptés à vos objectifs.</p>
                </div>
            </div>
        </div>

        <div class="cta-section">
            <h2>Prêt à commencer ?</h2>
            <p>Rejoignez Coach Pro Training et transformez votre entraînement dès aujourd'hui.</p>
            <a href="{{ route('register') }}" class="btn-cta">Créer mon compte gratuitement</a>
        </div>
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
            <p style="margin-top: 1rem; font-size: 0.8rem; color: #666;">© 2025 Coach - doko972 - Tous droits réservés</p>
        </div>
    </footer>
</body>
</html>