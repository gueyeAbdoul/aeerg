<x-app-layout>
    <div class="container mx-auto py-10 max-w-3xl">
        {{-- Carte principale --}}
        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
            {{-- Titre --}}
            <h2 class="text-3xl font-bold mb-2 text-gray-800">{{ $evenement->titre }}</h2>

            {{-- Dates & Lieu --}}
            <div class="flex flex-wrap gap-4 mb-4">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-semibold text-sm">
                    📅 {{ \Carbon\Carbon::parse($evenement->date_debut)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($evenement->date_fin)->format('d/m/Y') }}
                </span>
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-semibold text-sm">
                    📍 {{ $evenement->lieu }}
                </span>
            </div>

            {{-- Description --}}
            <p class="text-gray-700 mb-6">{{ $evenement->description }}</p>

            {{-- Participants --}}
            <h3 class="text-xl font-semibold mb-2 text-gray-800">Participants :</h3>
            <ul class="mb-6 list-disc list-inside text-gray-700">
                @forelse($evenement->participants as $participant)
                    <li>{{ $participant->prenom }} {{ $participant->nom }}</li>
                @empty
                    <li>Aucun inscrit pour l’instant</li>
                @endforelse
            </ul>

            {{-- Actions inscription/désinscription --}}
            <div class="flex flex-wrap gap-3 mb-6">
                @if(!$evenement->participants->contains(auth()->id()))
                    <form action="{{ route('evenements.inscrire', $evenement) }}" method="POST">
                        @csrf
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg transition">
                            S’inscrire
                        </button>
                    </form>
                @else
                    <form action="{{ route('evenements.desinscrire', $evenement) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg transition">
                            Se désinscrire
                        </button>
                    </form>
                @endif

                @if(auth()->user()->isAdmin() || auth()->user()->isResponsablePedagogique())
                    <a href="{{ route('evenements.edit', $evenement) }}"
                       class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-5 py-2 rounded-lg transition">
                        Modifier
                    </a>

                    <form action="{{ route('evenements.destroy', $evenement) }}" method="POST"
                          onsubmit="return confirm('Supprimer cet événement ?');">
                        @csrf
                        @method('DELETE')
                        <button class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-lg transition">
                            Supprimer
                        </button>
                    </form>
                @endif
            </div>

            {{-- Bouton retour --}}
            <div class="text-center">
                <a href="{{ route('evenements.index') }}"
                   class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded-lg transition">
                    ← Retour
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
