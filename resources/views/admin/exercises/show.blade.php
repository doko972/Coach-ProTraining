@extends('admin.layout')

@section('title', 'Détails Exercice')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <h1>{{ $exercise->name }}</h1>
        <div class="header-actions">
            <a href="{{ route('admin.exercises.edit', $exercise) }}" class="btn-primary">Modifier</a>
            <a href="{{ route('admin.exercises.index') }}" class="btn-secondary">← Retour</a>
        </div>
    </div>

    <div class="program-details">
        <div class="detail-card">
            <h3>Informations de l'exercice</h3>
            <div class="detail-row">
                <strong>Nom :</strong>
                <span>{{ $exercise->name }}</span>
            </div>
            <div class="detail-row">
                <strong>Catégorie :</strong>
                <span>{{ $exercise->category ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <strong>Difficulté :</strong>
                <span>
                    @if($exercise->difficulty)
                        <span class="badge 
                            @if($exercise->difficulty == 'Débutant') badge-success 
                            @elseif($exercise->difficulty == 'Intermédiaire') badge-warning 
                            @else badge-danger 
                            @endif">
                            {{ $exercise->difficulty }}
                        </span>
                    @else
                        -
                    @endif
                </span>
            </div>
            <div class="detail-row">
                <strong>Description :</strong>
                <span>{{ $exercise->description ?? '-' }}</span>
            </div>
        </div>

        <div class="detail-card">
            <h3>Utilisation dans les programmes</h3>
            @if($exercise->sessionExercises->count() > 0)
                @foreach($exercise->sessionExercises as $sessionExercise)
                    <div class="session-block">
                        <div class="session-header">
                            <strong>{{ $sessionExercise->session->week->program->name }}</strong>
                            <span class="session-focus">
                                {{ $sessionExercise->session->week->name }} - {{ $sessionExercise->session->name }}
                            </span>
                        </div>
                        <p style="color: #ccc; margin: 0.5rem 0 0 0;">
                            {{ $sessionExercise->sets }} séries × {{ $sessionExercise->reps }} répétitions
                        </p>
                    </div>
                @endforeach
            @else
                <p class="empty-message">Cet exercice n'est utilisé dans aucun programme</p>
            @endif
        </div>
    </div>
</div>
@endsection