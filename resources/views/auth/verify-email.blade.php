<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification d'email - Coach Pro Training</title>
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

                <h2 class="auth-title">Vérifiez votre email</h2>

                <div class="auth-description">
                    <p>Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer ? Si vous n'avez pas reçu l'e-mail, nous vous en enverrons un autre avec plaisir.</p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success">
                        Un nouveau lien de vérification a été envoyé à l'adresse e-mail que vous avez fournie lors de votre inscription.
                    </div>
                @endif

                <div class="auth-actions" style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn-auth-primary">
                            Renvoyer l'email de vérification
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="auth-link" style="background: none; border: none; cursor: pointer; padding: 0;">
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>