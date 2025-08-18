<x-app-layout>
    <div class="container mx-auto py-10">
        <div class="w-2/3 mx-auto bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-semibold mb-6 text-center">Modifier mon profil</h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update', $user) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom', $user->nom) }}"
                           class="w-full border-gray-300 rounded p-2 @error('nom') border-red-500 @enderror">
                    @error('nom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Prénom</label>
                    <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}"
                           class="w-full border-gray-300 rounded p-2 @error('prenom') border-red-500 @enderror">
                    @error('prenom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full border-gray-300 rounded p-2 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}"
                           class="w-full border-gray-300 rounded p-2 @error('telephone') border-red-500 @enderror">
                    @error('telephone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Statut</label>
                    <input type="text" name="statut" value="{{ old('statut', $user->statut) }}"
                           class="w-full border-gray-300 rounded p-2 @error('statut') border-red-500 @enderror">
                    @error('statut')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-1 font-semibold">Valide</label>
                    <select name="valide" class="w-full border-gray-300 rounded p-2">
                        <option value="1" {{ $user->valide ? 'selected' : '' }}>Oui</option>
                        <option value="0" {{ !$user->valide ? 'selected' : '' }}>Non</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
