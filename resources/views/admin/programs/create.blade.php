@extends('admin.layout')

@section('title', 'Nouveau Programme')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <h1>Créer un nouveau programme</h1>
        <a href="{{ route('admin.programs.index') }}" class="btn-secondary">← Retour</a>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.programs.store') }}" method="POST" class="admin-form">
            @csrf

            <div class="form-group">
                <label for="name">Nom du programme *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-input">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phase">Phase</label>
                <input type="text" id="phase" name="phase" value="{{ old('phase') }}" placeholder="Ex: Phase 1 (Semaines 1-4)" class="form-input">
                @error('phase')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="objective">Objectif</label>
                <input type="text" id="objective" name="objective" value="{{ old('objective') }}" placeholder="Ex: Hypertrophie - Volume" class="form-input">
                @error('objective')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" class="form-textarea">{{ old('description') }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span>Programme actif</span>
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Créer le programme</button>
                <a href="{{ route('admin.programs.index') }}" class="btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection