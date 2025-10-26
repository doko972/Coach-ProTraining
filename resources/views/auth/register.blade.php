<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Coach Pro Training</title>
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

                <h2 class="auth-title">Créer un compte</h2>

                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-input">
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-input">
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="form-input">
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-input">
                        @error('password_confirmation')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-auth-primary">
                        S'inscrire
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Vous avez déjà un compte ?</p>
                    <a href="{{ route('login') }}" class="auth-link-primary">Se connecter</a>
                </div>

                <div class="auth-back">
                    <a href="{{ route('home') }}" class="auth-link">← Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>