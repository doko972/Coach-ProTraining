<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Coach Pro Training</title>
    @vite(['resources/scss/app.scss'])
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h1>Coach</h1>
                    <p>Pro Training</p>
                </div>

                <h2 class="auth-title">Connexion</h2>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-input">
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="form-input">
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember">
                            <span>Se souvenir de moi</span>
                        </label>
                    </div>

                    <div class="auth-actions">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-link">
                                Mot de passe oublié ?
                            </a>
                        @endif

                        <button type="submit" class="btn-auth-primary">
                            Se connecter
                        </button>
                    </div>
                </form>

                <div class="auth-footer">
                    <p>Pas encore de compte ?</p>
                    <a href="{{ route('register') }}" class="auth-link-primary">Créer un compte</a>
                </div>

                <div class="auth-back">
                    <a href="{{ route('home') }}" class="auth-link">← Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>