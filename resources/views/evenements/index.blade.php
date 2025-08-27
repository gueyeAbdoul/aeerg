<x-app-layout>

    <div class="container mx-auto py-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">📅 Calendrier des événements</h2>

            @if(in_array(Auth::user()->role?->nom, ['Admin','Responsable pédagogique']))
                <a href="{{ route('evenements.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Créer un événement
                </a>
            @endif
        </div>



        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Conteneur du calendrier -->
        <div id="calendar"></div>

        {{-- Retour --}}
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}"
                class="bg-gray-700 text-white px-6 py-2 rounded hover:bg-gray-600">
                ← Retour
            </a>
        </div>
    </div>

    <!-- FullCalendar CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr', // calendrier en français
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                events: @json($events)

            });

            calendar.render();
        });

    </script>
</x-app-layout>
