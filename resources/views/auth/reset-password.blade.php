<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - Coach Pro Training</title>
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

                <h2 class="auth-title">Nouveau mot de passe</h2>

                <form method="POST" action="{{ route('password.store') }}" class="auth-form">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="form-input">
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Nouveau mot de passe</label>
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
                        Réinitialiser le mot de passe
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>