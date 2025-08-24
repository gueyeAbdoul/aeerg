<x-app-layout>
    <div class="container mx-auto py-10 flex justify-center">
        <div class="w-4/5">
            <h1 class="text-2xl font-semibold mb-6 text-center">Historique de mes cotisations</h1>

            @php
                // Filtrer les cotisations de l'utilisateur connecté
                $mesCotisations = $cotisations->where('user_id', auth()->id());

                // Regrouper par mois
                $cotisationsGrouped = $mesCotisations->groupBy(function($cotisation) {
                    return \Carbon\Carbon::parse($cotisation->date_paiement)->format('Y-m');
                });
            @endphp

            @forelse($cotisationsGrouped as $month => $cotisationsMonth)
                @php
                    // Calcul des totaux
                    $totalPaye = $cotisationsMonth->where('statut', 'payé')->sum('montant');
                    $totalDuo = $cotisationsMonth->where('statut', '!=', 'payé')->sum('montant');
                @endphp

                <div class="bg-gray-100 p-4 rounded mb-4">
                    <h2 class="text-lg font-semibold text-center">
                        {{ \Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y') }}
                    </h2>
                    <p class="text-center mt-2">
                        <span class="text-green-700 font-semibold">Total payé : {{ number_format($totalPaye, 2, ',', ' ') }} €</span> |
                        <span class="text-yellow-700 font-semibold">Total dû : {{ number_format($totalDuo, 2, ',', ' ') }} €</span>
                    </p>
                </div>

                <table class="min-w-full divide-y divide-gray-200 mb-6">
                    <thead class="bg-gray-800 text-white text-center">
                        <tr>
                            <th class="px-4 py-2">Montant</th>
                            <th class="px-4 py-2">Date Paiement</th>
                            <th class="px-4 py-2">Statut</th>
                            <th class="px-4 py-2">Méthode</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-center">
                        @foreach($cotisationsMonth as $cotisation)
                            <tr>
                                <td class="px-4 py-2">{{ number_format($cotisation->montant, 2, ',', ' ') }} €</td>
                                <td class="px-4 py-2">{{ $cotisation->date_paiement ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @if($cotisation->statut == 'payé')
                                        <span class="bg-green-200 text-green-800 px-2 py-1 rounded-full text-sm">Payé</span>
                                    @else
                                        <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full text-sm">Non payé</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $cotisation->methode ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @empty
                <p class="text-gray-500 text-center py-4">Aucune cotisation enregistrée.</p>
            @endforelse

            <!-- Footer avec bouton Retour -->
            <footer class="mt-auto py-4 bg-gray-100 text-center">
                <a href="{{ route('home') }}" class="inline-block bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-700 transition">
                    ← Retour à l'accueil
                </a>
            </footer>
        </div>
    </div>
</x-app-layout>
