@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="admin-dashboard">
    <h1>Tableau de bord</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📋</div>
            <div class="stat-info">
                <h3>Programmes</h3>
                <p class="stat-number">{{ $stats['programs'] }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">💪</div>
            <div class="stat-info">
                <h3>Exercices</h3>
                <p class="stat-number">{{ $stats['exercises'] }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🏋️</div>
            <div class="stat-info">
                <h3>Séances</h3>
                <p class="stat-number">{{ $stats['sessions'] }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-info">
                <h3>Utilisateurs</h3>
                <p class="stat-number">{{ $stats['users'] }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-row">
        <div class="dashboard-section">
            <div class="section-header">
                <h2>Programmes récents</h2>
                <a href="{{ route('admin.programs.index') }}" class="btn-link">Voir tout</a>
            </div>
            <div class="list-group">
                @forelse($recentPrograms as $program)
                    <div class="list-item">
                        <div>
                            <h4>{{ $program->name }}</h4>
                            <p>{{ $program->phase }}</p>
                        </div>
                        <a href="{{ route('admin.programs.edit', $program) }}" class="btn-edit">Modifier</a>
                    </div>
                @empty
                    <p class="empty-message">Aucun programme</p>
                @endforelse
            </div>
        </div>

        <div class="dashboard-section">
            <div class="section-header">
                <h2>Exercices récents</h2>
                <a href="{{ route('admin.exercises.index') }}" class="btn-link">Voir tout</a>
            </div>
            <div class="list-group">
                @forelse($recentExercises as $exercise)
                    <div class="list-item">
                        <div>
                            <h4>{{ $exercise->name }}</h4>
                            <p>{{ $exercise->category }}</p>
                        </div>
                        <a href="{{ route('admin.exercises.edit', $exercise) }}" class="btn-edit">Modifier</a>
                    </div>
                @empty
                    <p class="empty-message">Aucun exercice</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection