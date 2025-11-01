@extends('user.layout')

@section('title', 'Carnet d\'Entraînement ')

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
                    <div class="program-selector">
                        <label for="programSelect">
                            <span class="selector-label">Programme actuel :</span>
                        </label>
                        <select id="programSelect" class="program-select" onchange="changeProgram(this.value)">
                            @foreach ($programs as $prog)
                                <option value="{{ $prog->id }}" {{ $prog->id == $program->id ? 'selected' : '' }}>
                                    {{ $prog->name }} ({{ $prog->phase }})
                                </option>
                            @endforeach
                        </select>
                    </div>

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
@endsection

@if ($program)
    <!-- Bouton flottant Chronomètre -->
    <button onclick="openChronoModal()" class="floating-chrono-btn" id="floatingChronoBtn"
        title="Ouvrir le chronomètre">
        <span class="floating-icon" id="floatingIcon">⏱️</span>
        <span class="floating-text" id="floatingText">Chrono</span>
        <span class="floating-timer" id="floatingTimer" style="display: none;">00:00</span>
    </button>

    <!-- Modal Chronomètre -->
    <div id="chronoModal" class="chrono-modal" style="display: none;">
        <div class="chrono-modal-overlay" onclick="closeChronoModal()"></div>
        <div class="chrono-modal-content">
            <div class="chrono-modal-header">
                <h3>⏱️ Chronomètre de Repos</h3>
                <button onclick="closeChronoModal()" class="chrono-close-btn">✕</button>
            </div>

            <div class="chrono-modal-body">
                <!-- Timer Display -->
                <div class="chrono-display">
                    <div id="modalTimerDisplay" class="timer-display">00:00</div>
                    <div id="modalTimerStatus" class="timer-status">Prêt</div>
                </div>

                <!-- Boutons de contrôle -->
                <div class="chrono-controls">
                    <button onclick="modalStartTimer()" id="modalStartBtn" class="chrono-btn chrono-btn-start">▶
                        Démarrer</button>
                    <button onclick="modalPauseTimer()" id="modalPauseBtn" class="chrono-btn chrono-btn-pause"
                        style="display: none;">⏸ Pause</button>
                    <button onclick="modalResumeTimer()" id="modalResumeBtn" class="chrono-btn chrono-btn-resume"
                        style="display: none;">▶ Reprendre</button>
                    <button onclick="modalStopTimer()" id="modalStopBtn" class="chrono-btn chrono-btn-stop">⏹
                        Stop</button>
                    <button onclick="modalResetTimer()" id="modalResetBtn" class="chrono-btn chrono-btn-reset">🔄
                        Reset</button>
                </div>

                <!-- Temps prédéfinis -->
                <div class="chrono-presets">
                    <button onclick="modalSetTimer(30)" class="preset-btn">30s</button>
                    <button onclick="modalSetTimer(45)" class="preset-btn">45s</button>
                    <button onclick="modalSetTimer(60)" class="preset-btn">1min</button>
                    <button onclick="modalSetTimer(90)" class="preset-btn">1m30</button>
                    <button onclick="modalSetTimer(120)" class="preset-btn">2min</button>
                    <button onclick="modalSetTimer(180)" class="preset-btn">3min</button>
                </div>

                <!-- Timer personnalisé -->
                <div class="chrono-custom">
                    <input type="number" id="modalCustomMinutes" placeholder="Min" min="0" max="59"
                        class="time-input">
                    <span>:</span>
                    <input type="number" id="modalCustomSeconds" placeholder="Sec" min="0" max="59"
                        class="time-input">
                    <button onclick="modalSetCustomTimer()" class="chrono-btn-custom">Définir</button>
                </div>

                <!-- Historique compact -->
                <div class="chrono-history-compact">
                    <h4>Dernières séries</h4>
                    <div id="modalHistory" class="history-list-compact"></div>
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

            // Changer de programme
            function changeProgram(programId) {
                window.location.href = `/carnet?program_id=${programId}`;
            }

            // ========================================
            // GESTION DES SEMAINES ET SESSIONS
            // ========================================

            function selectWeek(weekId, weekNumber) {
                currentWeekId = weekId;

                // Mettre à jour les boutons actifs
                document.querySelectorAll('.week-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                event.target.classList.add('active');

                // Trouver la semaine dans les données
                const week = programData.weeks.find(w => w.id === weekId);

                if (!week || !week.sessions || week.sessions.length === 0) {
                    document.getElementById('sessionSelector').innerHTML =
                        '<p style="color: #999; padding: 1rem; text-align: center;">Aucune séance disponible</p>';
                    document.getElementById('workoutContent').innerHTML = '';
                    return;
                }

                // Afficher les sessions de cette semaine
                let sessionsHtml = '';
                week.sessions.forEach((session, index) => {
                    sessionsHtml += `
                <button class="session-btn ${index === 0 ? 'active' : ''}" 
                        onclick="selectSession(${session.id})" 
                        data-session-id="${session.id}">
                    ${session.name}<br>
                    <small>${session.focus || ''}</small>
                </button>
            `;
                });

                document.getElementById('sessionSelector').innerHTML = sessionsHtml;

                // Charger la première session
                selectSession(week.sessions[0].id);
            }

            function selectSession(sessionId) {
                currentSessionId = sessionId;

                // Mettre à jour les boutons actifs
                document.querySelectorAll('.session-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                const activeBtn = document.querySelector(`[data-session-id="${sessionId}"]`);
                if (activeBtn) {
                    activeBtn.classList.add('active');
                }

                // Trouver la session dans les données
                let session = null;
                for (const week of programData.weeks) {
                    session = week.sessions.find(s => s.id === sessionId);
                    if (session) break;
                }

                if (!session || !session.session_exercises || session.session_exercises.length === 0) {
                    document.getElementById('workoutContent').innerHTML =
                        '<p style="color: #999; padding: 2rem; text-align: center;">Aucun exercice dans cette séance</p>';
                    return;
                }

                // Afficher les exercices
                let workoutHtml = '';
                session.session_exercises.forEach(sessionExercise => {
                    workoutHtml += `
                <div class="exercise-block">
                    <div class="exercise-header">
                        <div class="exercise-name">${sessionExercise.exercise.name}</div>
                        <div class="exercise-details">${sessionExercise.sets} × ${sessionExercise.reps}</div>
                    </div>
                    <div class="sets-container">
            `;

                    for (let i = 1; i <= sessionExercise.sets; i++) {
                        workoutHtml += `
                    <div class="set-row">
                        <div class="set-number">Série ${i}</div>
                        <div class="input-with-unit">
                            <input type="number" class="set-input weight-input" placeholder="Poids"
                                data-session-exercise-id="${sessionExercise.id}"
                                data-set-number="${i}" 
                                data-field="weight">
                            <span class="unit-label">kg</span>
                        </div>
                        <div class="input-with-unit">
                            <input type="number" class="set-input reps-input" placeholder="Reps"
                                data-session-exercise-id="${sessionExercise.id}"
                                data-set-number="${i}" 
                                data-field="reps">
                            <span class="unit-label">reps</span>
                        </div>
                        <button class="check-btn"
                            data-session-exercise-id="${sessionExercise.id}"
                            data-set-number="${i}"
                            onclick="toggleCheck(this)">✓</button>
                    </div>
                `;
                    }

                    workoutHtml += `
                    </div>
                </div>
            `;
                });

                document.getElementById('workoutContent').innerHTML = workoutHtml;

                // Charger les données sauvegardées
                loadWorkoutData();
            }

            // ========================================
            // CHARGEMENT DES DONNÉES
            // ========================================

            function loadWorkoutData() {
                const today = new Date().toISOString().split('T')[0];

                fetch(`/workout/data?date=${today}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Données chargées:', data);

                        data.forEach(workout => {
                            const weightInput = document.querySelector(
                                `input[data-session-exercise-id="${workout.session_exercise_id}"][data-set-number="${workout.set_number}"][data-field="weight"]`
                            );
                            const repsInput = document.querySelector(
                                `input[data-session-exercise-id="${workout.session_exercise_id}"][data-set-number="${workout.set_number}"][data-field="reps"]`
                            );
                            const checkBtn = document.querySelector(
                                `button[data-session-exercise-id="${workout.session_exercise_id}"][data-set-number="${workout.set_number}"]`
                            );

                            if (weightInput && workout.weight) {
                                weightInput.value = workout.weight;
                            }
                            if (repsInput && workout.reps) {
                                repsInput.value = workout.reps;
                            }
                            if (checkBtn && workout.completed) {
                                checkBtn.classList.add('checked');
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des données:', error);
                    });
            }

            // ========================================
            // SAUVEGARDE DES DONNÉES
            // ========================================

            function toggleCheck(button) {
                button.classList.toggle('checked');
            }

            function saveWorkout() {
                const today = new Date().toISOString().split('T')[0];
                const inputs = document.querySelectorAll('.set-input');
                const promises = [];

                inputs.forEach(input => {
                    const sessionExerciseId = input.dataset.sessionExerciseId;
                    const setNumber = input.dataset.setNumber;
                    const field = input.dataset.field;
                    const value = input.value;

                    if (!value) return;

                    const otherField = field === 'weight' ? 'reps' : 'weight';
                    const otherInput = document.querySelector(
                        `input[data-session-exercise-id="${sessionExerciseId}"][data-set-number="${setNumber}"][data-field="${otherField}"]`
                    );
                    const otherValue = otherInput ? otherInput.value : null;

                    const checkBtn = document.querySelector(
                        `button[data-session-exercise-id="${sessionExerciseId}"][data-set-number="${setNumber}"]`
                    );
                    const completed = checkBtn ? checkBtn.classList.contains('checked') : false;

                    const data = {
                        session_exercise_id: sessionExerciseId,
                        set_number: setNumber,
                        workout_date: today,
                        completed: completed
                    };

                    if (field === 'weight') {
                        data.weight = value;
                        data.reps = otherValue;
                    } else {
                        data.reps = value;
                        data.weight = otherValue;
                    }

                    promises.push(
                        fetch('/workout/save', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(data)
                        })
                    );
                });

                Promise.all(promises)
                    .then(() => {
                        alert('✅ Entraînement sauvegardé !');
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('❌ Erreur lors de la sauvegarde');
                    });
            }

            function resetWorkout() {
                if (!confirm('Voulez-vous vraiment réinitialiser tous les champs ?')) {
                    return;
                }

                document.querySelectorAll('.set-input').forEach(input => {
                    input.value = '';
                });
                document.querySelectorAll('.check-btn').forEach(btn => {
                    btn.classList.remove('checked');
                });
            }

            function exportWorkout() {
                alert('Fonction d\'export à venir !');
            }

            function saveNotes() {
                const notes = document.getElementById('sessionNotes').value;
                const today = new Date().toISOString().split('T')[0];

                fetch('/workout/notes', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            session_id: currentSessionId,
                            notes: notes,
                            workout_date: today
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert('✅ Notes sauvegardées !');
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('❌ Erreur lors de la sauvegarde des notes');
                    });
            }

            // Charger les données au chargement de la page
            document.addEventListener('DOMContentLoaded', function() {
                if (currentSessionId) {
                    loadWorkoutData();
                }
            });

            // ========================================
            // CHRONOMÈTRE MODAL
            // ========================================

            let modalTimerInterval = null;
            let modalTimeRemaining = 0;
            let modalTimerDuration = 0;
            let modalIsPaused = false;
            let modalSetsHistory = [];

            // Ouvrir la modal
            function openChronoModal() {
                document.getElementById('chronoModal').style.display = 'flex';
                updateModalHistoryDisplay();
            }

            // Fermer la modal
            function closeChronoModal() {
                document.getElementById('chronoModal').style.display = 'none';
            }

            // Définir le temps
            function modalSetTimer(seconds) {
                modalStopTimer();
                modalTimerDuration = seconds;
                modalTimeRemaining = seconds;
                updateModalTimerDisplay();
                document.getElementById('modalTimerStatus').textContent = 'Prêt';
            }

            // Timer personnalisé
            function modalSetCustomTimer() {
                const minutes = parseInt(document.getElementById('modalCustomMinutes').value) || 0;
                const seconds = parseInt(document.getElementById('modalCustomSeconds').value) || 0;
                const totalSeconds = (minutes * 60) + seconds;

                if (totalSeconds > 0) {
                    modalSetTimer(totalSeconds);
                    document.getElementById('modalCustomMinutes').value = '';
                    document.getElementById('modalCustomSeconds').value = '';
                }
            }

            // Démarrer le timer
            function modalStartTimer() {
                if (modalTimeRemaining === 0) {
                    alert('⚠️ Définissez d\'abord un temps !');
                    return;
                }

                document.getElementById('modalStartBtn').style.display = 'none';
                document.getElementById('modalPauseBtn').style.display = 'inline-block';
                document.getElementById('modalTimerStatus').textContent = 'En cours...';

                modalIsPaused = false;

                modalTimerInterval = setInterval(() => {
                    if (!modalIsPaused) {
                        modalTimeRemaining--;
                        updateModalTimerDisplay();

                        if (modalTimeRemaining <= 0) {
                            modalTimerComplete();
                        }
                    }
                }, 1000);
            }

            // Pause
            function modalPauseTimer() {
                modalIsPaused = true;
                document.getElementById('modalPauseBtn').style.display = 'none';
                document.getElementById('modalResumeBtn').style.display = 'inline-block';
                document.getElementById('modalTimerStatus').textContent = 'En pause';
            }

            // Reprendre
            function modalResumeTimer() {
                modalIsPaused = false;
                document.getElementById('modalResumeBtn').style.display = 'none';
                document.getElementById('modalPauseBtn').style.display = 'inline-block';
                document.getElementById('modalTimerStatus').textContent = 'En cours...';
            }

            // Stop
            function modalStopTimer() {
                clearInterval(modalTimerInterval);
                modalTimerInterval = null;
                modalIsPaused = false;
                modalTimeRemaining = modalTimerDuration;

                document.getElementById('modalStartBtn').style.display = 'inline-block';
                document.getElementById('modalPauseBtn').style.display = 'none';
                document.getElementById('modalResumeBtn').style.display = 'none';
                document.getElementById('modalTimerStatus').textContent = 'Prêt';

                updateModalTimerDisplay();
            }

            // Reset
            function modalResetTimer() {
                clearInterval(modalTimerInterval);
                modalTimerInterval = null;
                modalIsPaused = false;
                modalTimeRemaining = 0;
                modalTimerDuration = 0;

                document.getElementById('modalStartBtn').style.display = 'inline-block';
                document.getElementById('modalPauseBtn').style.display = 'none';
                document.getElementById('modalResumeBtn').style.display = 'none';
                document.getElementById('modalTimerStatus').textContent = 'Réinitialisé';

                updateModalTimerDisplay();
            }

            // Timer terminé
            function modalTimerComplete() {
                clearInterval(modalTimerInterval);
                modalTimerInterval = null;
                modalTimeRemaining = 0;
                updateModalTimerDisplay();

                document.getElementById('modalTimerStatus').textContent = '✅ Terminé !';
                document.getElementById('modalStartBtn').style.display = 'inline-block';
                document.getElementById('modalPauseBtn').style.display = 'none';
                document.getElementById('modalResumeBtn').style.display = 'none';

                // Son de notification
                const beep = document.getElementById('beep');
                if (beep) {
                    beep.play().catch(e => console.log('Son non disponible'));
                }

                // Ajouter à l'historique
                const now = new Date();
                modalSetsHistory.unshift({
                    duration: modalTimerDuration,
                    time: now.toLocaleTimeString('fr-FR', {
                        hour: '2-digit',
                        minute: '2-digit'
                    })
                });

                // Garder seulement les 5 dernières
                if (modalSetsHistory.length > 5) {
                    modalSetsHistory = modalSetsHistory.slice(0, 5);
                }

                updateModalHistoryDisplay();

                // Reset pour la prochaine série
                modalTimeRemaining = modalTimerDuration;
            }

            // Mettre à jour l'affichage
            function updateModalTimerDisplay() {
                const minutes = Math.floor(modalTimeRemaining / 60);
                const seconds = modalTimeRemaining % 60;
                const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                document.getElementById('modalTimerDisplay').textContent = timeString;

                // Mettre à jour le bouton flottant aussi
                updateFloatingButton(timeString);
            }

            // Mettre à jour le bouton flottant
            function updateFloatingButton(timeString) {
                const floatingBtn = document.getElementById('floatingChronoBtn');
                const floatingIcon = document.getElementById('floatingIcon');
                const floatingText = document.getElementById('floatingText');
                const floatingTimer = document.getElementById('floatingTimer');

                if (!floatingBtn) return;

                // Si le timer est en cours
                if (modalTimerInterval !== null) {
                    floatingIcon.style.display = 'none';
                    floatingText.style.display = 'none';
                    floatingTimer.style.display = 'block';
                    floatingTimer.textContent = timeString;
                    floatingBtn.classList.add('timer-active');
                } else {
                    floatingIcon.style.display = 'block';
                    floatingText.style.display = 'block';
                    floatingTimer.style.display = 'none';
                    floatingBtn.classList.remove('timer-active');
                }
            }

            // Mettre à jour l'historique
            function updateModalHistoryDisplay() {
                const historyDiv = document.getElementById('modalHistory');

                if (modalSetsHistory.length === 0) {
                    historyDiv.innerHTML =
                        '<p style="color: #999; font-size: 0.9rem; text-align: center;">Aucune série enregistrée</p>';
                    return;
                }

                historyDiv.innerHTML = modalSetsHistory.map((set, index) => {
                    const minutes = Math.floor(set.duration / 60);
                    const seconds = set.duration % 60;
                    return `
                        <div class="history-item-compact">
                            <span class="history-number">#${index + 1}</span>
                            <span class="history-time">${minutes}:${seconds.toString().padStart(2, '0')}</span>
                            <span class="history-timestamp">${set.time}</span>
                        </div>
                    `;
                }).join('');
            }

            // Fermer avec Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeChronoModal();
                }
            });
        </script>
    @endpush
@endif
