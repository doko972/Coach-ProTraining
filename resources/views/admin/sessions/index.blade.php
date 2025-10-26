@extends('admin.layout')

@section('title', 'Séances')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <h1>Gestion des Séances</h1>
        <a href="{{ route('admin.sessions.create') }}" class="btn-primary">+ Nouvelle Séance</a>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Programme</th>
                    <th>Semaine</th>
                    <th>Séance</th>
                    <th>Focus</th>
                    <th>Exercices</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sessions as $session)
                    <tr>
                        <td><strong>{{ $session->week->program->name }}</strong></td>
                        <td>{{ $session->week->name }}</td>
                        <td>{{ $session->name }} (#{{ $session->session_number }})</td>
                        <td>{{ $session->focus ?? '-' }}</td>
                        <td>{{ $session->sessionExercises->count() }} exercices</td>
                        <td class="actions">
                            <a href="{{ route('admin.sessions.show', $session) }}" class="btn-view">Voir</a>
                            <a href="{{ route('admin.sessions.edit', $session) }}" class="btn-edit">Modifier</a>
                            <form action="{{ route('admin.sessions.destroy', $session) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette séance ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-row">Aucune séance disponible</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $sessions->links() }}
    </div>
</div>
@endsection