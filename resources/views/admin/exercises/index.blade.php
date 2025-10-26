@extends('admin.layout')

@section('title', 'Exercices')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <h1>Gestion des Exercices</h1>
        <a href="{{ route('admin.exercises.create') }}" class="btn-primary">+ Nouvel Exercice</a>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Difficulté</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exercises as $exercise)
                    <tr>
                        <td><strong>{{ $exercise->name }}</strong></td>
                        <td>{{ $exercise->category ?? '-' }}</td>
                        <td>
                            @if($exercise->difficulty)
                                <span class="badge 
                                    @if($exercise->difficulty == 'Débutant') badge-success 
                                    @elseif($exercise->difficulty == 'Intermédiaire') badge-warning 
                                    @else badge-danger 
                                    @endif">
                                    {{ $exercise->difficulty }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="actions">
                            <a href="{{ route('admin.exercises.show', $exercise) }}" class="btn-view">Voir</a>
                            <a href="{{ route('admin.exercises.edit', $exercise) }}" class="btn-edit">Modifier</a>
                            <form action="{{ route('admin.exercises.destroy', $exercise) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet exercice ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-row">Aucun exercice disponible</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $exercises->links() }}
    </div>
</div>
@endsection