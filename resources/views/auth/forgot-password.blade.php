<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - Coach Pro Training</title>
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

                <h2 class="auth-title">Mot de passe oublié</h2>

                <div class="auth-description">
                    <p>Vous avez oublié votre mot de passe ? Pas de problème. Indiquez-nous simplement votre adresse e-mail et nous vous enverrons un lien de réinitialisation.</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input">
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-auth-primary">
                        Envoyer le lien de réinitialisation
                    </button>
                </form>

                <div class="auth-back">
                    <a href="{{ route('login') }}" class="auth-link">← Retour à la connexion</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>