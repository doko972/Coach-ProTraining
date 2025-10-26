@extends('admin.layout')

@section('title', 'Nouvelle Séance')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <h1>Créer une nouvelle séance</h1>
        <a href="{{ route('admin.sessions.index') }}" class="btn-secondary">← Retour</a>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.sessions.store') }}" method="POST" class="admin-form" id="sessionForm">
            @csrf

            <div class="form-group">
                <label for="week_id">Semaine *</label>
                <select id="week_id" name="week_id" required class="form-input">
                    <option value="">-- Sélectionner une semaine --</option>
                    @foreach($weeks as $week)
                        <option value="{{ $week->id }}" {{ old('week_id') == $week->id ? 'selected' : '' }}>
                            {{ $week->program->name }} - {{ $week->name }}
                        </option>
                    @endforeach
                </select>
                @error('week_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="session_number">Numéro de séance *</label>
                <input type="number" id="session_number" name="session_number" value="{{ old('session_number', 1) }}" required class="form-input" min="1">
                @error('session_number')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Nom de la séance *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-input" placeholder="Ex: Séance 1">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="focus">Focus</label>
                <input type="text" id="focus" name="focus" value="{{ old('focus') }}" class="form-input" placeholder="Ex: Pecs/Épaules/Triceps">
                @error('focus')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <hr style="margin: 2rem 0; border: 1px solid rgba(255, 69, 0, 0.3);">

            <div class="form-group">
                <h3 style="color: #ff4500; margin-bottom: 1rem;">Exercices de la séance</h3>
                <button type="button" class="btn-primary" onclick="addExercise()" style="margin-bottom: 1rem;">+ Ajouter un exercice</button>
                
                <div id="exercisesContainer">
                    <!-- Les exercices seront ajoutés ici dynamiquement -->
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Créer la séance</button>
                <a href="{{ route('admin.sessions.index') }}" class="btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<script>
let exerciseIndex = 0;
const exercises = @json($exercises);

function addExercise() {
    const container = document.getElementById('exercisesContainer');
    const exerciseBlock = document.createElement('div');
    exerciseBlock.className = 'exercise-form-block';
    exerciseBlock.id = `exercise-${exerciseIndex}`;
    
    let optionsHtml = '<option value="">-- Sélectionner --</option>';
    exercises.forEach(ex => {
        optionsHtml += `<option value="${ex.id}">${ex.name}</option>`;
    });
    
    exerciseBlock.innerHTML = `
        <div class="exercise-form-header">
            <h4>Exercice ${exerciseIndex + 1}</h4>
            <button type="button" class="btn-delete-small" onclick="removeExercise(${exerciseIndex})">Supprimer</button>
        </div>
        
        <div class="exercise-form-grid">
            <div class="form-group">
                <label>Exercice *</label>
                <select name="exercises[${exerciseIndex}][exercise_id]" required class="form-input">
                    ${optionsHtml}
                </select>
            </div>
            
            <div class="form-group">
                <label>Séries *</label>
                <input type="number" name="exercises[${exerciseIndex}][sets]" required class="form-input" value="3" min="1">
            </div>
            
            <div class="form-group">
                <label>Répétitions *</label>
                <input type="text" name="exercises[${exerciseIndex}][reps]" required class="form-input" placeholder="Ex: 10-12">
            </div>
            
            <div class="form-group">
                <label>Ordre</label>
                <input type="number" name="exercises[${exerciseIndex}][order]" required class="form-input" value="${exerciseIndex}" min="0">
            </div>
        </div>
    `;
    
    container.appendChild(exerciseBlock);
    exerciseIndex++;
}

function removeExercise(index) {
    const element = document.getElementById(`exercise-${index}`);
    if (element) {
        element.remove();
    }
}

// Ajouter un exercice par défaut au chargement
document.addEventListener('DOMContentLoaded', function() {
    addExercise();
});
</script>
@endsection