<x-app-layout>
    <div class="container mx-auto py-10 flex justify-center">
        <div class="w-4/5">
            <h1 class="text-2xl font-semibold mb-6">Modifier la cotisation</h1>

            <form action="{{ route('cotisations.update', $cotisation) }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow-md">
                @csrf
                @method('PUT')

                {{-- Membre --}}
                <div>
                    <label class="block mb-1 font-medium">Membre</label>
                    <select name="user_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $cotisation->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->prenom ?? '' }} {{ $user->nom ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Montant --}}
                <div>
                    <label class="block mb-1 font-medium">Montant</label>
                    <input type="number" name="montant" step="0.01" value="{{ $cotisation->montant }}" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Date Paiement --}}
                <div>
                    <label class="block mb-1 font-medium">Date Paiement</label>
                    <input type="date" name="date_paiement" value="{{ $cotisation->date_paiement }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Statut --}}
                <div>
                    <label class="block mb-1 font-medium">Statut</label>
                    <select name="statut" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="en_attente" {{ $cotisation->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="payé" {{ $cotisation->statut == 'payé' ? 'selected' : '' }}>Payé</option>
                    </select>
                </div>

                {{-- Méthode --}}
                <div>
                    <label class="block mb-1 font-medium">Méthode</label>
                    <select name="methode" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Choisir --</option>
                        <option value="cash" {{ $cotisation->methode == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="mobile_money" {{ $cotisation->methode == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                        <option value="virement" {{ $cotisation->methode == 'virement' ? 'selected' : '' }}>Virement</option>
                    </select>
                </div>

                {{-- Bouton --}}
                <div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
