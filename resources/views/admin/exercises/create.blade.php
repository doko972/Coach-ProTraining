@extends('admin.layout')

@section('title', 'Nouvel Exercice')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <h1>Créer un nouvel exercice</h1>
        <a href="{{ route('admin.exercises.index') }}" class="btn-secondary">← Retour</a>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.exercises.store') }}" method="POST" class="admin-form">
            @csrf

            <div class="form-group">
                <label for="name">Nom de l'exercice *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-input" placeholder="Ex: Développé couché">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Catégorie</label>
                <select id="category" name="category" class="form-input">
                    <option value="">-- Sélectionner --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="difficulty">Difficulté</label>
                <select id="difficulty" name="difficulty" class="form-input">
                    <option value="">-- Sélectionner --</option>
                    @foreach($difficulties as $diff)
                        <option value="{{ $diff }}" {{ old('difficulty') == $diff ? 'selected' : '' }}>{{ $diff }}</option>
                    @endforeach
                </select>
                @error('difficulty')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" class="form-textarea" placeholder="Décrivez l'exercice, les consignes, etc.">{{ old('description') }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Créer l'exercice</button>
                <a href="{{ route('admin.exercises.index') }}" class="btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection