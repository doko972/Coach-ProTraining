@extends('admin.layout')

@section('title', 'Modifier Programme')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <h1>Modifier le programme</h1>
        <a href="{{ route('admin.programs.index') }}" class="btn-secondary">← Retour</a>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.programs.update', $program) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nom du programme *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $program->name) }}" required class="form-input">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phase">Phase</label>
                <input type="text" id="phase" name="phase" value="{{ old('phase', $program->phase) }}" placeholder="Ex: Phase 1 (Semaines 1-4)" class="form-input">
                @error('phase')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="objective">Objectif</label>
                <input type="text" id="objective" name="objective" value="{{ old('objective', $program->objective) }}" placeholder="Ex: Hypertrophie - Volume" class="form-input">
                @error('objective')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" class="form-textarea">{{ old('description', $program->description) }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $program->is_active) ? 'checked' : '' }}>
                    <span>Programme actif</span>
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.programs.index') }}" class="btn-secondary">Annuler</a>
            </div>
        </form>
        <!-- Section Semaines du programme -->
        <div class="program-weeks-section">
            <div class="section-header">
                <h3>Semaines de ce programme</h3>
                <a href="{{ route('admin.weeks.create', ['program_id' => $program->id]) }}" class="btn-primary">+ Ajouter une semaine</a>
            </div>

            @if($program->weeks->count() > 0)
                <div class="weeks-list">
                    @foreach($program->weeks->sortBy('week_number') as $week)
                        <div class="week-item">
                            <div class="week-info">
                                <strong>{{ $week->name }}</strong>
                                <span class="week-meta">Semaine {{ $week->week_number }} - {{ $week->sessions->count() }} séances</span>
                            </div>
                            <div class="week-actions">
                                <a href="{{ route('admin.weeks.edit', $week) }}" class="btn-edit-small">Modifier</a>
                                <form action="{{ route('admin.weeks.destroy', $week) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer cette semaine et toutes ses séances ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-small">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="empty-message">Aucune semaine créée pour ce programme.</p>
            @endif
        </div>
    </div>
    </div>
</div>
@endsection