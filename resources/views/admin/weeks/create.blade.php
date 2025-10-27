@extends('admin.layout')

@section('title', 'Nouvelle Semaine')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <h1>Ajouter une semaine à "{{ $program->name }}"</h1>
        <a href="{{ route('admin.programs.edit', $program) }}" class="btn-secondary">← Retour</a>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.weeks.store') }}" method="POST" class="admin-form">
            @csrf
            <input type="hidden" name="program_id" value="{{ $program->id }}">

            <div class="form-group">
                <label for="week_number">Numéro de semaine *</label>
                <input type="number" id="week_number" name="week_number" value="{{ old('week_number', $program->weeks->max('week_number') + 1) }}" required class="form-input" min="1">
                @error('week_number')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Nom de la semaine *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-input" placeholder="Ex: Semaine 1">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Créer la semaine</button>
                <a href="{{ route('admin.programs.edit', $program) }}" class="btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection