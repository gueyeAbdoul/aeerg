<x-guest-layout>
<div class="container">
    <h1>Liste des cotisations</h1>

    <a href="{{ route('cotisations.create') }}" class="btn btn-primary mb-3">Ajouter une cotisation</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Membre</th>
                <th>Montant</th>
                <th>Date Paiement</th>
                <th>Statut</th>
                <th>Méthode</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cotisations as $cotisation)
                <tr>
                    <td>{{ $cotisation->user->name }}</td>
                    <td>{{ $cotisation->montant }} €</td>
                    <td>{{ $cotisation->date_paiement ?? '-' }}</td>
                    <td>{{ ucfirst($cotisation->statut) }}</td>
                    <td>{{ $cotisation->methode ?? '-' }}</td>
                    <td>
                        <a href="{{ route('cotisations.edit', $cotisation) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('cotisations.destroy', $cotisation) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer cette cotisation ?')" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-guest-layout>
