<x-app-layout>
    <div class="container mx-auto py-10 flex justify-center">
        <div class="w-4/5">
            <h2 class="text-xl font-bold mb-4">✏️ Modifier un Document</h2>

            <form action="{{ route('documents.update', $document) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block">Titre</label>
                    <input type="text" name="titre" value="{{ $document->titre }}" class="border p-2 w-full" required>
                </div>

                <div>
                    <label class="block">Catégorie</label>
                    <select name="categorie" class="border p-2 w-full" required>
                        <option value="Procès-verbal" {{ $document->categorie == 'Procès-verbal' ? 'selected' : '' }}>Procès-verbal</option>
                        <option value="Rapport" {{ $document->categorie == 'Rapport' ? 'selected' : '' }}>Rapport</option>
                        <option value="Statuts" {{ $document->categorie == 'Statuts' ? 'selected' : '' }}>Statuts</option>
                        <option value="Autre" {{ $document->categorie == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div>
                    <label class="block">Disponibilité</label>
                    <select name="is_disponible" class="border p-2 w-full">
                        <option value="1" {{ $document->is_disponible ? 'selected' : '' }}>Disponible</option>
                        <option value="0" {{ !$document->is_disponible ? 'selected' : '' }}>Indisponible</option>
                    </select>
                </div>

                <button class="bg-green-600 text-white px-4 py-2 rounded">Mettre à jour</button>
            </form>
        </div>
    </div>
</x-app-layout>
