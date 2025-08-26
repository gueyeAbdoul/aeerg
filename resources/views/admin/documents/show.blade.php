<x-app-layout>
    <div class="container mx-auto py-10 flex justify-center">
        <div class="w-3/4 bg-white p-6 rounded shadow">
            <h2 class="text-2xl font-bold mb-4 text-center">📖 Lecture du document</h2>

            {{-- Infos document --}}
            <div class="mb-4">
                <p><strong>Titre :</strong> {{ $document->titre }}</p>
                <p><strong>Catégorie :</strong> {{ $document->categorie ?? '-' }}</p>
                <p><strong>Propriétaire :</strong> {{ $document->proprietaire->nom ?? '-' }}</p>
                <p><strong>Date ajout :</strong> {{ $document->date_ajout }}</p>
            </div>

            {{-- dd($document->chemin_fichier) }}

            {{-- Aperçu fichier --}}
            @php
                $ext = strtolower(pathinfo($document->chemin_fichier, PATHINFO_EXTENSION));
                $url = asset('storage/' . $document->chemin_fichier);
            @endphp

            @if($ext == 'pdf')
                {{-- PDF directement --}}
                <iframe src="{{ $url }}" class="w-full h-[600px] border rounded" frameborder="0"></iframe>

            @elseif(in_array($ext, ['jpg','jpeg','png','gif']))
                {{-- Images --}}
                <img src="{{ $url }}" class="w-full border rounded" alt="Document">

            @elseif(in_array($ext, ['doc','docx','xls','xlsx','ppt','pptx']))
                {{-- Word, Excel, PowerPoint via Google Docs Viewer --}}
                <iframe src="https://docs.google.com/gview?url={{ urlencode($url) }}&embedded=true"
                        class="w-full h-[600px] border rounded" frameborder="0"></iframe>

            @else
                {{-- Autres fichiers --}}
                <a href="{{ $url }}" target="_blank"
                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded">
                   📂 Télécharger / Ouvrir le document
                </a>
            @endif

            {{-- Retour --}}
            <div class="mt-6 text-center">
                <a href="{{ route('documents.index') }}"
                   class="bg-gray-700 text-white px-6 py-2 rounded hover:bg-gray-600">
                    ← Retour à la liste
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
