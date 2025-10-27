@extends('admin.layout')

@section('title', 'Assigner des programmes')

@section('content')
    <div class="admin-page">
        <div class="page-header">
            <h1>Gestion des programmes utilisateurs</h1>
        </div>

        <div class="assign-section">
            <h2>Assigner un programme</h2>
            <form action="{{ route('admin.user-programs.assign') }}" method="POST" class="admin-form">
                @csrf

                <div class="form-group">
                    <label for="user_id">Utilisateur</label>
                    <select name="user_id" id="user_id" required class="form-input">
                        <option value="">-- Sélectionner un utilisateur --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="program_id">Programme</label>
                    <select name="program_id" id="program_id" required class="form-input">
                        <option value="">-- Sélectionner un programme --</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}">{{ $program->name }} ({{ $program->phase }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="start_date">Date de début</label>
                    <input type="date" name="start_date" id="start_date" class="form-input" value="{{ date('Y-m-d') }}">
                </div>

                <button type="submit" class="btn-primary">Assigner le programme</button>
            </form>
        </div>

        <div class="users-programs-list">
            <h2>Programmes assignés</h2>

            @foreach ($users as $user)
                <div class="user-card">
                    <h3>{{ $user->name }}</h3>
                    <p>{{ $user->email }}</p>

                    @if ($user->assignedPrograms->count() > 0)
                        <ul class="assigned-programs">
                            @foreach ($user->assignedPrograms as $program)
                                <li>
                                    <strong>{{ $program->name }}</strong>
                                    @if ($program->pivot->is_current)
                                        <span class="badge-current">Actuel</span>
                                    @else
                                        <form action="{{ route('admin.user-programs.set-current') }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="program_id" value="{{ $program->id }}">
                                            <button type="submit" class="btn-set-current">Définir comme actuel</button>
                                        </form>
                                    @endif
                                    @if ($program->pivot->start_date)
                                        <small class="program-date">Début :
@if ($program->pivot->start_date)
    <small class="program-date">
        📅 Début : {{ \Carbon\Carbon::parse($program->pivot->start_date)->format('d/m/Y') }}
    </small>
@endif

@if ($program->pivot->end_date)
    <small class="program-date">
        🏁 Fin : {{ \Carbon\Carbon::parse($program->pivot->end_date)->format('d/m/Y') }}
    </small>
@endif
                                        </small>
                                    @endif
                                    <form action="{{ route('admin.user-programs.remove') }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="program_id" value="{{ $program->id }}">
                                        <button type="submit" class="btn-delete-small">Retirer</button>
                                    </form>
                                </li>
                            @endforeach

                        </ul>
                    @else
                        <p class="empty-message">Aucun programme assigné</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
