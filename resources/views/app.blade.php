<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AEERG - Association des Élèves et Étudiants de Gouye Reine</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans bg-gray-50">
    <!-- Header -->
    <header class="bg-indigo-900 text-white shadow-lg">
        <div class="container mx-auto px-4 py-6 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo-aeerg.png') }}" alt="Logo AEERG" class="h-12">
                <h1 class="text-2xl font-bold">AEERG</h1>
            </div>
            <nav class="hidden md:flex space-x-8">
                <a href="#about" class="hover:text-yellow-300 transition">À propos</a>
                <a href="#services" class="hover:text-yellow-300 transition">Services</a>
                <a href="#events" class="hover:text-yellow-300 transition">Événements</a>
                <a href="#contact" class="hover:text-yellow-300 transition">Contact</a>
                <a href="{{ route('login') }}" class="bg-yellow-500 text-indigo-900 px-4 py-2 rounded-lg font-bold hover:bg-yellow-400 transition">Espace membre</a>
            </nav>
            <button class="md:hidden text-2xl" id="mobile-menu-button">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-800 to-purple-700 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-6xl font-bold mb-6">Bienvenue à l'AEERG</h2>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                Unis pour l'excellence académique et le développement communautaire
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#join" class="bg-yellow-500 text-indigo-900 px-8 py-3 rounded-lg font-bold text-lg hover:bg-yellow-400 transition">
                    Nous rejoindre
                </a>
                <a href="#activities" class="bg-white text-indigo-900 px-8 py-3 rounded-lg font-bold text-lg hover:bg-gray-100 transition">
                    Nos activités
                </a>
            </div>
        </div>
    </section>

    <!-- À propos -->
    <section id="about" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-indigo-900">Qui sommes-nous ?</h2>
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="md:w-1/2">
                    <img src="{{ asset('images/group-photo.jpg') }}" alt="Membres AEERG" class="rounded-lg shadow-xl w-full">
                </div>
                <div class="md:w-1/2">
                    <p class="text-lg mb-6 text-gray-700">
                        L'Association des Élèves et Étudiants Ressortissants de Gouye Reine (AEERG) œuvre depuis 2010 pour soutenir la réussite académique et professionnelle de ses membres.
                    </p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>+500 membres actifs</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Bibliothèque de +1000 ressources</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>12 événements annuels minimum</span>
                        </li>
                    </ul>
                    <a href="/about" class="inline-block bg-indigo-100 text-indigo-800 px-6 py-2 rounded-lg font-semibold hover:bg-indigo-200 transition">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section id="services" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-indigo-900">Nos Services</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Carte 1 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="text-indigo-600 text-4xl mb-4">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Ressources pédagogiques</h3>
                    <p class="text-gray-600">
                        Accès à une bibliothèque riche en livres, annales et supports de cours pour toutes les filières.
                    </p>
                </div>

                <!-- Carte 2 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="text-indigo-600 text-4xl mb-4">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Événements formatifs</h3>
                    <p class="text-gray-600">
                        Ateliers, séminaires et conférences pour le développement académique et professionnel.
                    </p>
                </div>

                <!-- Carte 3 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="text-indigo-600 text-4xl mb-4">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Solidarité</h3>
                    <p class="text-gray-600">
                        Fonds d'entraide et parrainage pour soutenir les membres dans le besoin.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Événements à venir
    <section id="events" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-indigo-900">Événements à venir</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                foreach($events as $event)
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                    <div class="bg-indigo-800 text-white p-4">
                        <div class="font-bold"> $event->date->format('d M') }}</div>
                        <h3 class="text-xl font-bold">$event->title }}</h3>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 mb-4"> Str::limit($event->description, 100) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-map-marker-alt mr-1"></i> $event->location }}
                            </span>
                            <a href="/events/ $event->id }}" class="text-indigo-600 hover:underline">Détails</a>
                        </div>
                    </div>
                </div>
                endforeach
            </div>
            <div class="text-center mt-8">
                <a href="/events" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Voir tous les événements
                </a>
            </div>
        </div>
    </section>
-->
    <!-- CTA Rejoindre -->
    <section id="join" class="py-16 bg-indigo-900 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Prêt à nous rejoindre ?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Bénéficiez de tous nos services et intégrez une communauté dynamique
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-yellow-500 text-indigo-900 px-8 py-3 rounded-lg font-bold text-lg hover:bg-yellow-400 transition">
                    S'inscrire maintenant
                </a>
                <a href="/contact" class="bg-white text-indigo-900 px-8 py-3 rounded-lg font-bold text-lg hover:bg-gray-100 transition">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">AEERG</h3>
                    <p>Promouvoir l'excellence académique depuis 2010</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Liens rapides</h4>
                    <ul class="space-y-2">
                        <li><a href="/about" class="hover:text-yellow-300 transition">À propos</a></li>
                        <li><a href="/events" class="hover:text-yellow-300 transition">Événements</a></li>
                        <li><a href="/resources" class="hover:text-yellow-300 transition">Ressources</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Contact</h4>
                    <address class="not-italic">
                        <p><i class="fas fa-map-marker-alt mr-2"></i> Dakar, Sénégal</p>
                        <p><i class="fas fa-phone mr-2"></i> +221 77 123 45 67</p>
                        <p><i class="fas fa-envelope mr-2"></i> contact@aeerg.org</p>
                    </address>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Réseaux sociaux</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-2xl hover:text-yellow-300 transition"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-2xl hover:text-yellow-300 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-2xl hover:text-yellow-300 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-2xl hover:text-yellow-300 transition"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p>&copy; {{ date('Y') }} AEERG. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Menu mobile
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const nav = document.querySelector('header nav');
            nav.classList.toggle('hidden');
            nav.classList.toggle('flex');
            nav.classList.toggle('flex-col');
            nav.classList.toggle('absolute');
            nav.classList.toggle('top-20');
            nav.classList.toggle('left-0');
            nav.classList.toggle('right-0');
            nav.classList.toggle('bg-indigo-900');
            nav.classList.toggle('p-4');
            nav.classList.toggle('space-y-4');
        });
    </script>
</body>
</html>
