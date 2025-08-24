{{-- resources/views/emprunts/mesemprunts.blade.php --}}
<x-app-layout>
    <div class="container mx-auto py-10 flex justify-center">
        <div class="w-4/5">

            <h2 class="text-2xl font-bold mb-6">Mes emprunts</h2>

            {{-- Flash / erreurs --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Liste des emprunts existants --}}
            @php
                // Seuls les emprunts non retournés comptent pour la limite
                $empruntsActifsCount = $emprunts->whereNull('date_retour_effective')->count();
                $maxEmprunts = 2;
            @endphp

            @if($emprunts->isEmpty())
                <p>Vous n'avez aucun emprunt.</p>
            @else
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-indigo-100">
                            <th class="py-2 px-4 border-b">Document</th>
                            <th class="py-2 px-4 border-b">Date d'emprunt</th>
                            <th class="py-2 px-4 border-b">Statut</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emprunts as $emprunt)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $emprunt->document->titre ?? 'N/A' }}</td>
                                <td class="py-2 px-4 border-b">
                                    {{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    @switch($emprunt->statut)
                                        @case('rendu')
                                            <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded-full text-sm">Rendu</span>
                                            @break
                                        @case('retard')
                                            <span class="bg-red-200 text-red-800 px-2 py-1 rounded-full text-sm">Retard</span>
                                            @break
                                        @default
                                            <span class="bg-green-200 text-green-800 px-2 py-1 rounded-full text-sm">Actif</span>
                                    @endswitch
                                </td>
                                <td class="py-2 px-4 border-b">
                                    @if(is_null($emprunt->date_retour_effective))
                                        <form action="{{ route('emprunts.retourner', $emprunt->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                Retourner
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-sm text-gray-500">
                                            Retourné le {{ \Carbon\Carbon::parse($emprunt->date_retour_effective)->format('d/m/Y H:i') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            {{-- Formulaire pour emprunter un document (limite : 2 emprunts actifs) --}}
            @if($empruntsActifsCount >= $maxEmprunts)
                <p class="mt-6 text-red-600 font-semibold">
                    Vous avez atteint le nombre maximal d'emprunts actifs ({{ $maxEmprunts }}).
                </p>
            @else
                <div class="mt-8">
                    <h3 class="text-xl font-bold mb-4">Emprunter un document</h3>

                    <form action="{{ route('emprunts.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="document_id" class="block mb-2 font-semibold">Documents disponibles :</label>
                            <select name="document_id" id="document_id" class="border rounded px-3 py-2 w-full" required>
                                @php $auMoinsUn = false; @endphp
                                @foreach($documentsDisponibles as $document)
                                    @php
                                        // Document disponible s’il est marqué disponible ET n’a aucun emprunt actif en cours
                                        $actifs = $document->emprunts->whereNull('date_retour_effective')->count();
                                        $disponible = $document->is_disponible && $actifs === 0;
                                    @endphp
                                    @if($disponible)
                                        @php $auMoinsUn = true; @endphp
                                        <option value="{{ $document->id }}">{{ $document->titre }}</option>
                                    @endif
                                @endforeach
                            </select>

                            @if(!$auMoinsUn)
                                <p class="text-sm text-gray-600 mt-2">
                                    Aucun document disponible pour le moment.
                                </p>
                            @endif
                        </div>

                        <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700"
                                @unless($auMoinsUn) disabled @endunless>
                            Emprunter
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
