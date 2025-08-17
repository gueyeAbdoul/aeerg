<x-guest-layout>
    <div class="container mx-auto pt-24 flex flex-col min-h-screen">
        <h1 class="text-3xl font-bold mb-6">Gestion des utilisateurs</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto mb-6 flex-grow">
            <table class="w-full border border-gray-300 border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-left">Nom</th>
                        <th class="border p-2 text-left">Prénom</th>
                        <th class="border p-2 text-left">Email</th>
                        <th class="border p-2 text-left">Rôle actuel</th>
                        <th class="border p-2 text-left">Changer rôle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="border p-2">{{ $user->nom }}</td>
                            <td class="border p-2">{{ $user->prenom }}</td>
                            <td class="border p-2">{{ $user->email }}</td>
                            <td class="border p-2">{{ $user->role->nom ?? 'Non défini' }}</td>
                            <td class="border p-2">
                                <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <select name="role_id" class="border rounded p-1">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                {{ $role->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                        ✔
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer avec bouton Retour -->
        <footer class="mt-auto py-4 bg-gray-100 text-center">
            <a href="{{ route('home') }}" class="inline-block bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-700 transition">
                ← Retour à l'accueil
            </a>
        </footer>
    </div>
</x-guest-layout>
