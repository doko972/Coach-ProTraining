@extends('admin.layout')

@section('title', 'Détails Séance')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <h1>{{ $session->name }}</h1>
        <div class="header-actions">
            <a href="{{ route('admin.sessions.edit', $session) }}" class="btn-primary">Modifier</a>
            <a href="{{ route('admin.sessions.index') }}" class="btn-secondary">← Retour</a>
        </div>
    </div>

    <div class="program-details">
        <div class="detail-card">
            <h3>Informations de la séance</h3>
            <div class="detail-row">
                <strong>Programme :</strong>
                <span>{{ $session->week->program->name }}</span>
            </div>
            <div class="detail-row">
                <strong>Semaine :</strong>
                <span>{{ $session->week->name }}</span>
            </div>
            <div class="detail-row">
                <strong>Numéro de séance :</strong>
                <span>{{ $session->session_number }}</span>
            </div>
            <div class="detail-row">
                <strong>Nom :</strong>
                <span>{{ $session->name }}</span>
            </div>
            <div class="detail-row">
                <strong>Focus :</strong>
                <span>{{ $session->focus ?? '-' }}</span>
            </div>
        </div>

        <div class="detail-card">
            <h3>Exercices de la séance</h3>
            @if($session->sessionExercises->count() > 0)
                <ul class="exercise-list">
                    @foreach($session->sessionExercises->sortBy('order') as $sessionExercise)
                        <li>
                            <div>
                                <strong>{{ $sessionExercise->exercise->name }}</strong>
                                <br>
                                <span style="font-size: 0.85rem; color: #999;">
                                    Catégorie: {{ $sessionExercise->exercise->category ?? 'Non définie' }}
                                </span>
                            </div>
                            <span class="exercise-meta">{{ $sessionExercise->sets }} × {{ $sessionExercise->reps }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="empty-message">Aucun exercice dans cette séance</p>
            @endif
        </div>
    </div>
</div>
@endsection