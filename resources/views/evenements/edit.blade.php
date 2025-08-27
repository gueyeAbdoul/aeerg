<x-app-layout>
    <div class="container mx-auto py-10 max-w-3xl">
        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">✏️ Modifier l'Événement</h2>

            <form action="{{ route('evenements.update', $evenement) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Titre --}}
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Titre</label>
                    <input type="text" name="titre" value="{{ $evenement->titre }}"
                           class="border p-2 w-full rounded-lg focus:ring-2 focus:ring-blue-400" required>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Description</label>
                    <textarea name="description" rows="4"
                              class="border p-2 w-full rounded-lg focus:ring-2 focus:ring-blue-400" required>{{ $evenement->description }}</textarea>
                </div>

                {{-- Lieu --}}
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Lieu</label>
                    <input type="text" name="lieu" value="{{ $evenement->lieu }}"
                           class="border p-2 w-full rounded-lg focus:ring-2 focus:ring-blue-400" required>
                </div>

                {{-- Dates --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Date début</label>
                        <input type="date" name="date_debut"
                               value="{{ \Carbon\Carbon::parse($evenement->date_debut)->format('Y-m-d') }}"
                               class="border p-2 w-full rounded-lg focus:ring-2 focus:ring-blue-400" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Date fin</label>
                        <input type="date" name="date_fin"
                               value="{{ \Carbon\Carbon::parse($evenement->date_fin)->format('Y-m-d') }}"
                               class="border p-2 w-full rounded-lg focus:ring-2 focus:ring-blue-400" required>
                    </div>
                </div>

                {{-- Bouton mise à jour --}}
                <div class="flex justify-end mt-4">
                    <button class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                        Mettre à jour
                    </button>
                </div>
            </form>

            {{-- Bouton retour --}}
            <div class="mt-6 text-center">
                <a href="{{ route('evenements.index') }}"
                   class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded-lg transition">
                    ← Retour
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
