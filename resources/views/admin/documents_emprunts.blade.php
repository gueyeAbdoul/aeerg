<x-app-layout>
    <div class="container mx-auto py-10 flex justify-center">
        <div class="w-4/5">
            <h1 class="text-2xl font-bold mb-4">Gestion des documents et emprunts</h1>

            <!-- Ajouter un document -->
            <div class="mb-6">
                <a href="{{ route('documents.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ajouter un document</a>
                <a href="{{ route('emprunts.create') }}" class="ml-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Nouvel emprunt</a>
            </div>

            <!-- Tableau combiné -->
            <table class="w-full border border-gray-200 rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Document</th>
                        <th class="px-4 py-2 border">Propriétaire</th>
                        <th class="px-4 py-2 border">Disponible</th>
                        <th class="px-4 py-2 border">Emprunteur</th>
                        <th class="px-4 py-2 border">Date emprunt</th>
                        <th class="px-4 py-2 border">Retour prévu</th>
                        <th class="px-4 py-2 border">Retour effectif</th>
                        <th class="px-4 py-2 border">Statut</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $doc->titre }}</td>
                        <td class="px-4 py-2 border">{{ $doc->proprietaire->nom }}</td>
                        <td class="px-4 py-2 border">{{ $doc->is_disponible ? 'Oui' : 'Non' }}</td>

                        @php
                            $emprunt = $doc->emprunt_actif ?? null;
                        @endphp

                        <td class="px-4 py-2 border">{{ $emprunt?->user->nom ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $emprunt?->date_emprunt ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $emprunt?->date_retour_prevue ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $emprunt?->date_retour_effective ?? '-' }}</td>
                        <td class="px-4 py-2 border capitalize">{{ $emprunt?->statut ?? '-' }}</td>
                        <td class="px-4 py-2 border flex flex-col space-y-1">
                            @if($doc->is_disponible)
                            <form action="{{ route('emprunts.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="document_id" value="{{ $doc->id }}">
                                <input type="date" name="date_retour_prevue" required class="border px-2 py-1 rounded mb-1">
                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Emprunter</button>
                            </form>
                            @elseif($emprunt && $emprunt->statut != 'rendu')
                            <form action="{{ route('emprunts.update', $emprunt) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Marquer rendu</button>
                            </form>
                            @endif

                            <a href="{{ route('documents.edit', $doc) }}" class="text-blue-500 hover:underline">Éditer</a>

                            <form action="{{ route('documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('Supprimer ce document ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
