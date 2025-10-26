@extends('admin.layout')

@section('title', 'Détails Programme')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <h1>{{ $program->name }}</h1>
        <div class="header-actions">
            <a href="{{ route('admin.programs.edit', $program) }}" class="btn-primary">Modifier</a>
            <a href="{{ route('admin.programs.index') }}" class="btn-secondary">← Retour</a>
        </div>
    </div>

    <div class="program-details">
        <div class="detail-card">
            <h3>Informations générales</h3>
            <div class="detail-row">
                <strong>Phase :</strong>
                <span>{{ $program->phase ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <strong>Objectif :</strong>
                <span>{{ $program->objective ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <strong>Description :</strong>
                <span>{{ $program->description ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <strong>Statut :</strong>
                <span class="badge {{ $program->is_active ? 'badge-success' : 'badge-inactive' }}">
                    {{ $program->is_active ? 'Actif' : 'Inactif' }}
                </span>
            </div>
        </div>

        <div class="detail-card">
            <h3>Structure du programme</h3>
            @forelse($program->weeks as $week)
                <div class="week-block">
                    <h4>{{ $week->name }}</h4>
                    @foreach($week->sessions as $session)
                        <div class="session-block">
                            <div class="session-header">
                                <strong>{{ $session->name }}</strong>
                                <span class="session-focus">{{ $session->focus }}</span>
                            </div>
                            <ul class="exercise-list">
                                @foreach($session->sessionExercises as $sessionExercise)
                                    <li>
                                        {{ $sessionExercise->exercise->name }}
                                        <span class="exercise-meta">{{ $sessionExercise->sets }} × {{ $sessionExercise->reps }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @empty
                <p class="empty-message">Aucune semaine configurée</p>
            @endforelse
        </div>
    </div>
</div>
@endsection