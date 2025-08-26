<x-app-layout>
    <div class="container mx-auto py-10 flex justify-center">
        <div class="w-4/5">
            <h2 class="text-xl text-center font-bold mb-4">📚 Gestion des Documents</h2>

            @if(session('success'))
                <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Bouton Ajouter document visible seulement pour Admin et Responsable pédagogique --}}
            @if(in_array(Auth::user()->role?->nom, ['Admin','Responsable pédagogique']))
                <a href="{{ route('documents.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Ajouter un document</a>
            @endif


            {{-- Filtre par catégorie --}}
            <form method="GET" action="{{ route('documents.index') }}" class="mb-4 flex items-center gap-2">
                <label for="categorie" class="font-medium">Filtrer par catégorie :</label>
                <select name="categorie" id="categorie"
                        class="border-gray-300 rounded-md shadow-sm"
                        onchange="this.form.submit()">
                    <option value="">-- Toutes les catégories --</option>
                    <option value="Procès-verbal" {{ request('categorie') == 'Procès-verbal' ? 'selected' : '' }}>Procès-verbal</option>
                    <option value="Rapport" {{ request('categorie') == 'Rapport' ? 'selected' : '' }}>Rapport</option>
                    <option value="Statuts" {{ request('categorie') == 'Statuts' ? 'selected' : '' }}>Statuts</option>
                    <option value="Autre" {{ request('categorie') == 'Autre' ? 'selected' : '' }}>Autre</option>
                </select>
            </form>

            <table class="table-auto w-full border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Titre</th>
                        <th class="p-2 border">Catégorie</th>
                        <th class="p-2 border">Propriétaire</th>
                        <th class="p-2 border">Date ajout</th>
                        <th class="p-2 border">Lire</th>
                        @auth
                            @if(auth()->user()->isTresorier() || auth()->user()->isAdmin() || auth()->user()->isResponsablePedagogique())
                                <th class="p-2 border">Actions</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($documents) --}}
                    @foreach($documents as $doc)
                        <tr>
                            <td class="p-2 border">{{ $doc->titre }}</td>
                            <td class="p-2 border">{{ $doc->categorie ?? '-' }}</td>
                            <td class="p-2 border">{{ $doc->proprietaire->nom ?? '-' }}</td>
                            <td class="p-2 border">{{ $doc->date_ajout }}</td>

                            {{-- Colonne lecture seule --}}
                            <td class="p-2 border text-center">
                                <a href="{{ route('documents.show', $doc) }}"
                                   class="bg-green-500 text-white px-2 py-1 rounded" target="_blank">
                                   Lire
                                </a>
                            </td>

                            {{-- Colonne actions --}}
                            @auth
                                @if(auth()->user()->isTresorier() || auth()->user()->isAdmin() || auth()->user()->isResponsablePedagogique())
                                    <td class="p-2 border flex gap-2">
                                        @if(in_array(Auth::user()->role?->nom, ['Admin','Responsable pédagogique']))
                                            <a href="{{ route('documents.edit', $doc) }}"
                                            class="bg-yellow-500 text-white px-2 py-1 rounded">Modifier</a>

                                            <form action="{{ route('documents.destroy', $doc) }}" method="POST"
                                                onsubmit="return confirm('Supprimer ce document ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-500 text-white px-2 py-1 rounded">Supprimer</button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            @endauth
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Footer avec bouton Retour -->
            <footer class="mt-auto py-4 bg-gray-100 text-center">
                <a href="{{ route('home') }}" class="inline-block bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-700 transition">
                    ← Retour à l'accueil
                </a>
            </footer>
        </div>
    </div>
</x-app-layout>
