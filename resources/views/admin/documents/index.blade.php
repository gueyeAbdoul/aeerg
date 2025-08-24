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

            <table class="table-auto w-full border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Titre</th>
                        <th class="p-2 border">Propriétaire</th>
                        <th class="p-2 border">Disponibilité</th>
                        <th class="p-2 border">Date ajout</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                        <tr>
                            <td class="p-2 border">{{ $doc->titre }}</td>
                            <td class="p-2 border">{{ $doc->proprietaire->nom ?? '-' }}</td>
                            <td class="p-2 border">
                                @if($doc->is_disponible)
                                    ✅ Disponible
                                @else
                                    ❌ Emprunté
                                @endif
                            </td>
                            <td class="p-2 border">{{ $doc->date_ajout }}</td>
                            <td class="p-2 border flex gap-2">
                                {{-- Emprunter disponible pour tout le monde si dispo --}}
                                @if($doc->is_disponible)
                                    <form action="{{ route('emprunts.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="document_id" value="{{ $doc->id }}">
                                        <button class="bg-green-500 text-white px-2 py-1 rounded">Emprunter</button>
                                    </form>
                                @endif

                                {{-- Edit & Delete visible que pour Admin + Responsable pédagogique --}}
                                @if(in_array(Auth::user()->role?->nom, ['Admin','Responsable pédagogique']))
                                    <a href="{{ route('documents.edit', $doc) }}"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded">Modifier</a>

                                    <form action="{{ route('documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('Supprimer ce document ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white px-2 py-1 rounded">Supprimer</button>
                                    </form>
                                @endif
                            </td>
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
