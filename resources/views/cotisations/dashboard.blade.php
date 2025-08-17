<x-guest-layout>
<div class="container">
    <h1 class="text-2xl font-bold mb-6">Espace Trésorier</h1>

    <div class="grid md:grid-cols-2 gap-6">
        <a href="{{ route('cotisations.index') }}"
           class="block p-6 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700">
            <i class="fas fa-coins mr-2"></i> Gérer les cotisations
        </a>
        <a href="{{ route('dashboard') }}"
           class="block p-6 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i> Retour au Dashboard
        </a>
    </div>
</div>
</x-guest-layout>
