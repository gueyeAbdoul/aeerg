<x-app-layout>
    <div class="container mx-auto py-10 max-w-2xl">
        <h2 class="text-xl font-bold mb-4">➕ Nouvel Événement</h2>

        <form action="{{ route('evenements.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block">Titre</label>
                <input type="text" name="titre" class="border p-2 w-full" required>
            </div>

            <div>
                <label class="block">Description</label>
                <textarea name="description" class="border p-2 w-full" rows="4" required></textarea>
            </div>

            <div>
                <label class="block">Lieu</label>
                <input type="text" name="lieu" class="border p-2 w-full" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block">Date début</label>
                    <input type="date" name="date_debut" class="border p-2 w-full" required>
                </div>
                <div>
                    <label class="block">Date fin</label>
                    <input type="date" name="date_fin" class="border p-2 w-full" required>
                </div>
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">
                Enregistrer
            </button>
        </form>
    </div>
</x-app-layout>
