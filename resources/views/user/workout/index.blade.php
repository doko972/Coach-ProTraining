@extends('user.layout')

@section('title', 'Carnet d\'Entraînement')

@section('content')
    <div class="page active" id="carnet">
        <h1>Carnet d'Entraînement</h1>
        <div class="container">
            <div class="card full-width">
                @if (!$program)
                    <div class="empty-message" style="padding: 3rem; text-align: center;">
                        <p style="font-size: 1.2rem; color: #ccc;">Aucun programme actif disponible</p>
                        <p style="margin-top: 1rem; color: #666;">Contactez votre coach pour obtenir un programme</p>
                    </div>
                @else
                    {{-- @php
                    $program = $programs->first();
                @endphp --}}

                    <h2>{{ $program->name }}</h2>

                    <div class="program-info">
                        <div class="info-badge">
                            <span class="info-label">Phase:</span>
                            <span class="info-value">{{ $program->phase }}</span>
                        </div>
                        <div class="info-badge">
                            <span class="info-label">Objectif:</span>
                            <span class="info-value">{{ $program->objective }}</span>
                        </div>
                    </div>

                    <div class="week-selector">
                        @foreach ($program->weeks as $index => $week)
                            <button class="week-btn {{ $index === 0 ? 'active' : '' }}"
                                onclick="selectWeek({{ $week->id }}, {{ $week->week_number }})"
                                data-week-id="{{ $week->id }}">
                                {{ $week->name }}
                            </button>
                        @endforeach
                    </div>

                    <div class="session-selector" id="sessionSelector">
                        @if ($program->weeks->isNotEmpty())
                            @foreach ($program->weeks->first()->sessions as $index => $session)
                                <button class="session-btn {{ $index === 0 ? 'active' : '' }}"
                                    onclick="selectSession({{ $session->id }})" data-session-id="{{ $session->id }}">
                                    {{ $session->name }}<br>
                                    <small>{{ $session->focus }}</small>
                                </button>
                            @endforeach
                        @endif
                    </div>

                    <div id="workoutContent" class="workout-content">
                        @if ($program->weeks->isNotEmpty() && $program->weeks->first()->sessions->isNotEmpty())
                            @php
                                $firstSession = $program->weeks->first()->sessions->first();
                            @endphp

                            @foreach ($firstSession->sessionExercises as $sessionExercise)
                                <div class="exercise-block">
                                    <div class="exercise-header">
                                        <div class="exercise-name">{{ $sessionExercise->exercise->name }}</div>
                                        <div class="exercise-details">{{ $sessionExercise->sets }} ×
                                            {{ $sessionExercise->reps }}</div>
                                    </div>

                                    <div class="sets-container">
                                        @for ($i = 1; $i <= $sessionExercise->sets; $i++)
                                            <div class="set-row">
                                                <div class="set-number">Série {{ $i }}</div>
                                                <div class="input-with-unit">
                                                    <input type="number" class="set-input weight-input" placeholder="Poids"
                                                        data-session-exercise-id="{{ $sessionExercise->id }}"
                                                        data-set-number="{{ $i }}" data-field="weight">
                                                    <span class="unit-label">kg</span>
                                                </div>
                                                <div class="input-with-unit">
                                                    <input type="number" class="set-input reps-input" placeholder="Reps"
                                                        data-session-exercise-id="{{ $sessionExercise->id }}"
                                                        data-set-number="{{ $i }}" data-field="reps">
                                                    <span class="unit-label">reps</span>
                                                </div>
                                                <button class="check-btn"
                                                    data-session-exercise-id="{{ $sessionExercise->id }}"
                                                    data-set-number="{{ $i }}"
                                                    onclick="toggleCheck(this)">✓</button>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="workout-actions">
                        <button class="btn-save" onclick="saveWorkout()">Sauvegarder</button>
                        <button class="btn-reset" onclick="resetWorkout()">Réinitialiser</button>
                        <button class="btn-export" onclick="exportWorkout()">Exporter</button>
                    </div>
                @endif
            </div>

            <div class="card full-width">
                <h2>Statistiques & Progression</h2>

                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-label">Séances complétées</div>
                        <div class="stat-value" id="totalSessions">0</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Cette semaine</div>
                        <div class="stat-value" id="weekSessions">0/3</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Volume total (kg)</div>
                        <div class="stat-value" id="totalVolume">0</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Progression</div>
                        <div class="stat-value" id="progression">0%</div>
                    </div>
                </div>

                <div class="notes-section">
                    <h3>Notes de séance</h3>
                    <textarea id="sessionNotes" placeholder="Ajoute tes notes, ressentis, observations..."></textarea>
                    <button class="btn-save-notes" onclick="saveNotes()">Sauvegarder les notes</button>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script>
        window.programData = @json($program);
        window.currentWeekId = {{ $program->weeks->first()->id ?? 'null' }};
        window.currentSessionId = {{ $program->weeks->first()->sessions->first()->id ?? 'null' }};
        window.workoutData = {};
    </script>
@endpush
@endsection
