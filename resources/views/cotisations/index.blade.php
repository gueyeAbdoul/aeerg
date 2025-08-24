<x-app-layout>
    <div class="container mx-auto py-10 flex justify-center">
        <div class="w-4/5">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold">Liste des cotisations</h1>

                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->isTresorier())
                        <a href="{{ route('cotisations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter une cotisation</a>
                    @endif
                @endauth
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto shadow-md rounded">
                @php
                    // Regrouper les cotisations par mois
                    $cotisationsGrouped = $cotisations->groupBy(function($cotisation) {
                        return \Carbon\Carbon::parse($cotisation->date_paiement)->format('Y-m');
                    });
                @endphp

                @forelse($cotisationsGrouped as $month => $cotisationsMonth)
                    <h2 class="text-lg font-semibold my-4 text-center bg-gray-200 py-2 rounded">
                        {{ \Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y') }}
                    </h2>

                    <table class="min-w-full divide-y divide-gray-200 mb-6">
                        <thead class="bg-gray-800 text-white text-center">
                            <tr>
                                <th class="px-4 py-2">Membre</th>
                                <th class="px-4 py-2">Montant</th>
                                <th class="px-4 py-2">Date Paiement</th>
                                <th class="px-4 py-2">Statut</th>
                                <th class="px-4 py-2">Méthode</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-center">
                            @foreach($cotisationsMonth as $cotisation)
                                <tr>
                                    <td class="px-4 py-2">{{ $cotisation->user->prenom ?? '' }} {{ $cotisation->user->nom ?? '' }}</td>
                                    <td class="px-4 py-2">{{ number_format($cotisation->montant, 2, ',', ' ') }} €</td>
                                    <td class="px-4 py-2">{{ $cotisation->date_paiement ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        @if($cotisation->statut == 'payé')
                                            <span class="bg-green-200 text-green-800 px-2 py-1 rounded-full text-sm">Payé</span>
                                        @else
                                            <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full text-sm">En attente</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">{{ $cotisation->methode ?? '-' }}</td>
                                    <td class="px-4 py-2 space-x-2">
                                        @auth
                                            @if(auth()->user()->isAdmin() || auth()->user()->isTresorier())
                                                <a href="{{ route('cotisations.edit', $cotisation) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-sm">Modifier</a>
                                                <form action="{{ route('cotisations.destroy', $cotisation) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Supprimer cette cotisation ?')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">Supprimer</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @empty
                    <p class="text-gray-500 text-center py-4">Aucune cotisation disponible.</p>
                @endforelse
            </div>

            <!-- Footer avec bouton Retour -->
            <footer class="mt-auto py-4 bg-gray-100 text-center">
                <a href="{{ route('home') }}" class="inline-block bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-700 transition">
                    ← Retour à l'accueil
                </a>
            </footer>
        </div>
    </div>
</x-app-layout>
