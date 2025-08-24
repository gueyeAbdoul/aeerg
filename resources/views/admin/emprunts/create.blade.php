<x-app-layout>
    <div class="container mx-auto py-10 flex justify-center">
        <div class="w-4/5">
            <h1 class="text-2xl font-bold mb-4">Emprunter un document</h1>

            <form action="{{ route('emprunts.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block font-semibold mb-1">Document</label>
                    <select name="document_id" class="w-full border px-3 py-2 rounded" required>
                        @foreach($documents as $doc)
                            <option value="{{ $doc->id }}" {{ $doc->is_disponible ? '' : 'disabled' }}>
                                {{ $doc->titre }} {{ $doc->is_disponible ? '' : '(Indisponible)' }}
                            </option>
                        @endforeach
                    </select>
                    @error('document_id') <p class="text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Date retour prévue</label>
                    <input type="date" name="date_retour_prevue" class="w-full border px-3 py-2 rounded" required>
                    @error('date_retour_prevue') <p class="text-red-500">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Emprunter</button>
                <a href="{{ route('emprunts.index') }}" class="ml-2 text-gray-600 hover:underline">Annuler</a>
            </form>
        </div>
    </div>
</x-app-layout>
