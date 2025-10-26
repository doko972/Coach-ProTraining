<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmer le mot de passe - Coach Pro Training</title>
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

                <h2 class="auth-title">Confirmation requise</h2>

                <div class="auth-description">
                    <p>Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
                    @csrf

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="form-input">
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-auth-primary">
                        Confirmer
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>