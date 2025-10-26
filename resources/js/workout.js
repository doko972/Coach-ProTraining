// Récupérer les variables globales
let programData = window.programData || null;
let currentWeekId = window.currentWeekId || null;
let currentSessionId = window.currentSessionId || null;
let workoutData = window.workoutData || {};

// Récupérer le token CSRF
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

// Charger les données au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    if (programData) {
        loadWorkoutData();
    }
});

// Sélectionner une semaine
window.selectWeek = function(weekId, weekNumber) {
    currentWeekId = weekId;
    
    document.querySelectorAll('.week-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('data-week-id') == weekId) {
            btn.classList.add('active');
        }
    });
    
    loadSessionsForWeek(weekId);
}

function loadSessionsForWeek(weekId) {
    const week = programData.weeks.find(w => w.id == weekId);
    if (!week) {
        console.error('Semaine non trouvée:', weekId);
        return;
    }
    
    const sessionSelector = document.getElementById('sessionSelector');
    sessionSelector.innerHTML = '';
    
    week.sessions.forEach((session, index) => {
        const btn = document.createElement('button');
        btn.className = 'session-btn' + (index === 0 ? ' active' : '');
        btn.setAttribute('data-session-id', session.id);
        btn.onclick = () => selectSession(session.id);
        btn.innerHTML = `${session.name}<br><small>${session.focus}</small>`;
        sessionSelector.appendChild(btn);
    });
    
    if (week.sessions.length > 0) {
        selectSession(week.sessions[0].id);
    }
}

window.selectSession = function(sessionId) {
    currentSessionId = sessionId;
    
    document.querySelectorAll('.session-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('data-session-id') == sessionId) {
            btn.classList.add('active');
        }
    });
    
    loadExercisesForSession(sessionId);
    loadWorkoutData();
}

function loadExercisesForSession(sessionId) {
    let session = null;
    
    for (const week of programData.weeks) {
        const found = week.sessions.find(s => s.id == sessionId);
        if (found) {
            session = found;
            break;
        }
    }
    
    if (!session) {
        console.error('Séance non trouvée:', sessionId);
        return;
    }
    
    const workoutContent = document.getElementById('workoutContent');
    workoutContent.innerHTML = '';
    
    session.session_exercises.forEach(sessionExercise => {
        const exerciseBlock = document.createElement('div');
        exerciseBlock.className = 'exercise-block';
        
        let setsHTML = '';
        for (let i = 1; i <= sessionExercise.sets; i++) {
            setsHTML += `
                <div class="set-row">
                    <div class="set-number">Série ${i}</div>
                    <div class="input-with-unit">
                        <input type="number" 
                               class="set-input weight-input" 
                               placeholder="Poids" 
                               data-session-exercise-id="${sessionExercise.id}"
                               data-set-number="${i}"
                               data-field="weight"
                               onchange="saveSetData(this)">
                        <span class="unit-label">kg</span>
                    </div>
                    <div class="input-with-unit">
                        <input type="number" 
                               class="set-input reps-input" 
                               placeholder="Reps" 
                               data-session-exercise-id="${sessionExercise.id}"
                               data-set-number="${i}"
                               data-field="reps"
                               onchange="saveSetData(this)">
                        <span class="unit-label">reps</span>
                    </div>
                    <button class="check-btn" 
                            data-session-exercise-id="${sessionExercise.id}"
                            data-set-number="${i}"
                            onclick="toggleCheck(this)">✓</button>
                </div>
            `;
        }
        
        exerciseBlock.innerHTML = `
            <div class="exercise-header">
                <div class="exercise-name">${sessionExercise.exercise.name}</div>
                <div class="exercise-details">${sessionExercise.sets} × ${sessionExercise.reps}</div>
            </div>
            <div class="sets-container">
                ${setsHTML}
            </div>
        `;
        
        workoutContent.appendChild(exerciseBlock);
    });
    
    loadWorkoutData();
}

window.saveSetData = function(input) {
    const sessionExerciseId = input.getAttribute('data-session-exercise-id');
    const setNumber = input.getAttribute('data-set-number');
    const field = input.getAttribute('data-field');
    const value = input.value;
    
    const key = `${sessionExerciseId}-${setNumber}`;
    
    if (!workoutData[key]) {
        workoutData[key] = { weight: '', reps: '', completed: false };
    }
    
    workoutData[key][field] = value;
}

window.toggleCheck = function(button) {
    const sessionExerciseId = button.getAttribute('data-session-exercise-id');
    const setNumber = button.getAttribute('data-set-number');
    const key = `${sessionExerciseId}-${setNumber}`;
    
    if (!workoutData[key]) {
        workoutData[key] = { weight: '', reps: '', completed: false };
    }
    
    workoutData[key].completed = !workoutData[key].completed;
    
    if (workoutData[key].completed) {
        button.classList.add('checked');
    } else {
        button.classList.remove('checked');
    }
    
    updateWorkoutStats();
}

window.saveWorkout = async function() {
    const today = new Date().toISOString().split('T')[0];
    const promises = [];
    
    for (const key in workoutData) {
        const [sessionExerciseId, setNumber] = key.split('-');
        const data = workoutData[key];
        
        promises.push(
            fetch('/workout/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    session_exercise_id: sessionExerciseId,
                    set_number: setNumber,
                    weight: data.weight || null,
                    reps: data.reps || null,
                    completed: data.completed || false,
                    workout_date: today
                })
            })
        );
    }
    
    try {
        await Promise.all(promises);
        alert('✅ Séance sauvegardée avec succès !');
    } catch (error) {
        console.error('Erreur:', error);
        alert('❌ Erreur lors de la sauvegarde');
    }
}

async function loadWorkoutData() {
    const today = new Date().toISOString().split('T')[0];
    
    try {
        const response = await fetch(`/workout/data?date=${today}`);
        const data = await response.json();
        
        workoutData = {};
        
        data.forEach(workout => {
            const key = `${workout.session_exercise_id}-${workout.set_number}`;
            workoutData[key] = {
                weight: workout.weight || '',
                reps: workout.reps || '',
                completed: workout.completed
            };
        });
        
        document.querySelectorAll('.set-input').forEach(input => {
            const sessionExerciseId = input.getAttribute('data-session-exercise-id');
            const setNumber = input.getAttribute('data-set-number');
            const field = input.getAttribute('data-field');
            const key = `${sessionExerciseId}-${setNumber}`;
            
            if (workoutData[key]) {
                input.value = workoutData[key][field] || '';
            }
        });
        
        document.querySelectorAll('.check-btn').forEach(btn => {
            const sessionExerciseId = btn.getAttribute('data-session-exercise-id');
            const setNumber = btn.getAttribute('data-set-number');
            const key = `${sessionExerciseId}-${setNumber}`;
            
            if (workoutData[key] && workoutData[key].completed) {
                btn.classList.add('checked');
            } else {
                btn.classList.remove('checked');
            }
        });
        
        updateWorkoutStats();
        
    } catch (error) {
        console.error('Erreur lors du chargement:', error);
    }
}

function updateWorkoutStats() {
    let totalVolume = 0;
    let completedSets = 0;
    
    for (const key in workoutData) {
        if (workoutData[key].completed) {
            completedSets++;
            const weight = parseFloat(workoutData[key].weight) || 0;
            const reps = parseFloat(workoutData[key].reps) || 0;
            totalVolume += weight * reps;
        }
    }
    
    document.getElementById('totalVolume').textContent = Math.round(totalVolume);
    document.getElementById('totalSessions').textContent = completedSets > 0 ? '1' : '0';
    document.getElementById('weekSessions').textContent = completedSets > 0 ? '1/3' : '0/3';
    document.getElementById('progression').textContent = '0%';
}

window.resetWorkout = function() {
    if (confirm('⚠️ Êtes-vous sûr de vouloir réinitialiser cette séance ?')) {
        workoutData = {};
        document.querySelectorAll('.set-input').forEach(input => input.value = '');
        document.querySelectorAll('.check-btn').forEach(btn => btn.classList.remove('checked'));
        updateWorkoutStats();
    }
}

window.exportWorkout = function() {
    let exportText = 'SÉANCE D\'ENTRAÎNEMENT\n';
    exportText += '='.repeat(50) + '\n\n';
    
    const blob = new Blob([exportText], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `seance_${new Date().toISOString().split('T')[0]}.txt`;
    a.click();
}

window.saveNotes = async function() {
    const notes = document.getElementById('sessionNotes').value;
    const today = new Date().toISOString().split('T')[0];
    
    try {
        await fetch('/workout/notes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                session_id: currentSessionId,
                notes: notes,
                workout_date: today
            })
        });
        
        alert('📝 Notes sauvegardées !');
    } catch (error) {
        console.error('Erreur:', error);
        alert('❌ Erreur lors de la sauvegarde des notes');
    }
}