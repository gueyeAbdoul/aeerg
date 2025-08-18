<x-app-layout>
    <div class="container mx-auto py-10 flex justify-center">
        <div class="w-4/5">
            <h1 class="text-2xl font-bold mb-6 text-center">Ajouter une cotisation</h1>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cotisations.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Sélection du membre -->
                    <div>
                        <label class="block font-medium mb-1">Membre</label>
                        <select name="user_id" id="user-select" class="w-full border rounded px-3 py-2" required>
                            <option value="">-- Choisir un membre --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" data-statut="{{ $user->statut }}">
                                    {{ $user->prenom }} {{ $user->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Affichage du statut du membre -->
                    <div>
                        <label class="block font-medium mb-1">Statut membre</label>
                        <span id="membre-statut" class="px-3 py-2 w-full inline-block border rounded">
                            --
                        </span>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Montant</label>
                        <input type="number" name="montant" step="0.01" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Date Paiement</label>
                        <input type="date" name="date_paiement" class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Statut</label>
                        <select name="statut" class="w-full border rounded px-3 py-2" required>
                            <option value="en_attente">En attente</option>
                            <option value="payé">Payé</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Méthode</label>
                        <select name="methode" class="w-full border rounded px-3 py-2">
                            <option value="">-- Choisir --</option>
                            <option value="cash">Cash</option>
                            <option value="mobile_money">Mobile Money</option>
                            <option value="virement">Virement</option>
                        </select>
                    </div>
                </div>

                <div>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded mt-4">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const userSelect = document.getElementById('user-select');
        const statutSpan = document.getElementById('membre-statut');

        userSelect.addEventListener('change', function() {
            const selectedOption = userSelect.options[userSelect.selectedIndex];
            const statut = selectedOption.getAttribute('data-statut') || '--';
            statutSpan.textContent = statut;
        });
    </script>
</x-app-layout>
