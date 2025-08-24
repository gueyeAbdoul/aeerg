<x-app-layout>
    <div class="container mx-auto py-10 flex justify-center">
        <div class="w-4/5">
            <h2 class="text-xl font-bold mb-4">📑 Gestion des Emprunts</h2>

            @if(session('success'))
                <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table-auto w-full border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Document</th>
                        <th class="p-2 border">Utilisateur</th>
                        <th class="p-2 border">Date emprunt</th>
                        <th class="p-2 border">Retour prévue</th>
                        <th class="p-2 border">Retour effective</th>
                        <th class="p-2 border">Statut</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emprunts as $emprunt)
                        <tr>
                            <td class="p-2 border">{{ $emprunt->document->titre }}</td>
                            <td class="p-2 border">{{ $emprunt->user->nom }}</td>
                            <td class="p-2 border">{{ $emprunt->date_emprunt }}</td>
                            <td class="p-2 border">{{ $emprunt->date_retour_prevue }}</td>
                            <td class="p-2 border">{{ $emprunt->date_retour_effective ?? '-' }}</td>
                            <td class="p-2 border">{{ ucfirst($emprunt->statut) }}</td>
                            <td class="p-2 border">
                                @if(in_array(Auth::user()->role?->nom, ['Admin','Responsable pédagogique']))
                                    <form action="{{ route('emprunts.update', $emprunt) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="statut" class="border">
                                            <option value="actif" {{ $emprunt->statut === 'actif' ? 'selected' : '' }}>Actif</option>
                                            <option value="retard" {{ $emprunt->statut === 'retard' ? 'selected' : '' }}>Retard</option>
                                            <option value="rendu" {{ $emprunt->statut === 'rendu' ? 'selected' : '' }}>Rendu</option>
                                        </select>
                                        <button class="bg-blue-500 text-white px-2 py-1 rounded">Mettre à jour</button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
