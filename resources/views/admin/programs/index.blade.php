@extends('admin.layout')

@section('title', 'Programmes')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <h1>Gestion des Programmes</h1>
        <a href="{{ route('admin.programs.create') }}" class="btn-primary">+ Nouveau Programme</a>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Phase</th>
                    <th>Objectif</th>
                    <th>Semaines</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programs as $program)
                    <tr>
                        <td><strong>{{ $program->name }}</strong></td>
                        <td>{{ $program->phase ?? '-' }}</td>
                        <td>{{ $program->objective ?? '-' }}</td>
                        <td>{{ $program->weeks_count }} semaines</td>
                        <td>
                            <span class="badge {{ $program->is_active ? 'badge-success' : 'badge-inactive' }}">
                                {{ $program->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="actions">
                            <a href="{{ route('admin.programs.show', $program) }}" class="btn-view">Voir</a>
                            <a href="{{ route('admin.programs.edit', $program) }}" class="btn-edit">Modifier</a>
                            <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce programme ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-row">Aucun programme disponible</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $programs->links() }}
    </div>
</div>
@endsection