@extends('profile.layout')

@section('title', 'Profil')

@section('content')
<div class="profile-page">
    <div class="profile-container">
        <h1 class="profile-title">Mon Profil</h1>

        <div class="profile-grid">
            <!-- Section Informations du profil -->
            <div class="profile-card">
                <div class="profile-card-header">
                    <h2>Informations du profil</h2>
                    <p>Mettez à jour les informations de votre compte.</p>
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="profile-form">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="email-verification-notice">
                                <p>
                                    Votre adresse e-mail n'est pas vérifiée.
                                    <button form="send-verification" class="btn-link">
                                        Cliquez ici pour renvoyer l'email de vérification.
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="verification-sent">
                                        Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Sauvegarder</button>

                        @if (session('status') === 'profile-updated')
                            <p class="success-message">Profil mis à jour avec succès.</p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Section Mise à jour du mot de passe -->
            <div class="profile-card">
                <div class="profile-card-header">
                    <h2>Mettre à jour le mot de passe</h2>
                    <p>Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.</p>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="profile-form">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="update_password_current_password">Mot de passe actuel</label>
                        <input id="update_password_current_password" name="current_password" type="password" class="form-input" autocomplete="current-password">
                        @error('current_password', 'updatePassword')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="update_password_password">Nouveau mot de passe</label>
                        <input id="update_password_password" name="password" type="password" class="form-input" autocomplete="new-password">
                        @error('password', 'updatePassword')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="update_password_password_confirmation">Confirmer le mot de passe</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password">
                        @error('password_confirmation', 'updatePassword')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Sauvegarder</button>

                        @if (session('status') === 'password-updated')
                            <p class="success-message">Mot de passe mis à jour avec succès.</p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Section Suppression du compte -->
            <div class="profile-card danger-card">
                <div class="profile-card-header">
                    <h2>Supprimer le compte</h2>
                    <p>Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.</p>
                </div>

                <button type="button" onclick="openDeleteModal()" class="btn-delete-account">
                    Supprimer le compte
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div id="deleteModal" class="modal" style="display: none;">
    <div class="modal-overlay" onclick="closeDeleteModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Êtes-vous sûr de vouloir supprimer votre compte ?</h3>
            <p>Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Veuillez entrer votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.</p>
        </div>

        <form method="post" action="{{ route('profile.destroy') }}" class="modal-form">
            @csrf
            @method('delete')

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input id="password" name="password" type="password" class="form-input" placeholder="Mot de passe" required>
                @error('password', 'userDeletion')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="modal-actions">
                <button type="button" onclick="closeDeleteModal()" class="btn-secondary">Annuler</button>
                <button type="submit" class="btn-delete">Supprimer le compte</button>
            </div>
        </form>
    </div>
</div>

<!-- Form caché pour la vérification d'email -->
@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display: none;">
        @csrf
    </form>
@endif

<script>
function openDeleteModal() {
    document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Fermer la modal avec Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
@endsection