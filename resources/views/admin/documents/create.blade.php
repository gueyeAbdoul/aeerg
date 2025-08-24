<x-app-layout>
    <div class="container mx-auto py-10 flex justify-center">
        <div class="w-4/5">
            <h2 class="text-xl font-bold mb-4">➕ Ajouter un Document</h2>

            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block">Titre</label>
                    <input type="text" name="titre" class="border p-2 w-full" required>
                </div>

                <div>
                    <label class="block">Fichier (PDF, DOC, PPT...)</label>
                    <input type="file" name="chemin_fichier" class="border p-2 w-full" required>
                </div>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
            </form>
        </div>
    </div>
</x-app-layout>
