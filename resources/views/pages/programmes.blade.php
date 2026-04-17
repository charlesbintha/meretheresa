@extends('layouts.app')

@section('title', 'Nos Programmes')

@section('content')

{{-- ============================================================== --}}
{{-- 1. HERO BANNER --}}
{{-- ============================================================== --}}
<section class="relative bg-primary-800 py-20 overflow-hidden">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute top-8 left-10 w-12 h-12 text-white/10 animate-float" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/></svg>
        <svg class="absolute bottom-8 right-16 w-16 h-16 text-white/10 animate-float" style="animation-delay: 1s;" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
        <svg class="absolute top-1/2 right-1/3 w-8 h-8 text-white/10 animate-float" style="animation-delay: 2s;" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/></svg>
        <svg class="absolute bottom-12 left-1/4 w-10 h-10 text-white/10 animate-float" style="animation-delay: 0.5s;" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="mb-8 animate-on-scroll" aria-label="Fil d'Ariane">
            <ol class="flex items-center gap-2 text-white/60 text-sm font-body">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                        Accueil
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-white/40" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                </li>
                <li class="text-white font-semibold">Programmes</li>
            </ol>
        </nav>

        <div class="text-center max-w-3xl mx-auto animate-on-scroll">
            <span class="inline-block bg-white/10 text-white font-heading font-semibold text-sm px-4 py-2 rounded-full mb-6">
                De la garde au CM2
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-heading font-bold text-white leading-tight mb-6">
                Nos Programmes Educatifs
            </h1>
            <p class="text-lg text-white/80 font-body max-w-2xl mx-auto">
                Un parcours pedagogique complet et adapte a chaque etape du developpement de votre enfant, de 2 ans a 11 ans.
            </p>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 2. OVERVIEW + STATS --}}
{{-- ============================================================== --}}
<section class="py-16 bg-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-12 animate-on-scroll">
            <h2 class="section-title text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-6">
                Une offre educative <span class="text-primary-800">complete</span>
            </h2>
            <p class="text-gray-600 font-body text-lg leading-relaxed">
                Le Groupe Scolaire Mere Theresa propose un parcours educatif complet allant de la garde des tout-petits jusqu'a la fin du cycle elementaire. Chaque programme est concu pour repondre aux besoins specifiques de chaque tranche d'age, avec une pedagogie bienveillante et des enseignants qualifies.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 animate-on-scroll">
            {{-- Stat 1 --}}
            <div class="card bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-primary-800/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-800" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <span class="block text-4xl font-heading font-bold text-primary-800 mb-2">6</span>
                <span class="text-gray-600 font-body font-semibold">Niveaux d'enseignement</span>
            </div>

            {{-- Stat 2 --}}
            <div class="card bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-primary-800/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-800" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/></svg>
                </div>
                <span class="block text-4xl font-heading font-bold text-primary-800 mb-2">+200</span>
                <span class="text-gray-600 font-body font-semibold">Eleves inscrits</span>
            </div>

            {{-- Stat 3 --}}
            <div class="card bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-primary-800/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-800" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342"/></svg>
                </div>
                <span class="block text-4xl font-heading font-bold text-primary-800 mb-2">95%</span>
                <span class="text-gray-600 font-body font-semibold">Taux de reussite</span>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 3. DETAILED PROGRAMMES --}}
{{-- ============================================================== --}}

{{-- ===================== a. Garde ===================== --}}
<section id="garde" class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center animate-on-scroll">
            {{-- Image --}}
            <div class="relative">
                <div class="rounded-3xl overflow-hidden shadow-xl">
                    <img src="{{ asset('images/72276.jpg') }}" alt="Enfants en garde - programme Garde" class="w-full h-80 lg:h-96 object-cover">
                </div>
                <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-yellow-200 rounded-full -z-10"></div>
                <div class="absolute -top-4 -left-4 w-14 h-14 bg-yellow-100 rounded-full -z-10"></div>
            </div>

            {{-- Details --}}
            <div>
                <span class="inline-flex items-center gap-2 bg-yellow-100 border border-yellow-400 text-yellow-800 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    2 ans - 3 ans
                </span>
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    Garde
                </h2>
                <p class="text-gray-600 font-body mb-4 leading-relaxed">
                    Notre programme de garde offre un environnement securise et chaleureux pour les tout-petits. Les enfants beneficient d'une stimulation precoce adaptee a leur age, dans un cadre bienveillant ou ils peuvent s'epanouir en toute confiance.
                </p>
                <p class="text-gray-600 font-body mb-6 leading-relaxed">
                    Nos educatrices specialisees accompagnent chaque enfant dans ses premiers pas de decouverte et de socialisation, avec des activites sensorielles et motrices variees.
                </p>

                {{-- Skills list --}}
                <ul class="space-y-2 mb-6">
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Eveil sensoriel et moteur
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Stimulation precoce et jeux educatifs
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Accompagnement personnalise et bienveillant
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Premieres interactions sociales
                    </li>
                </ul>

                {{-- Schedule --}}
                <div class="flex items-center gap-2 text-gray-600 font-body mb-6">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    <span class="font-semibold">Horaires :</span> 7h30 - 17h30
                </div>

                {{-- Fees table --}}
                <div class="bg-yellow-50 rounded-2xl p-6 mb-6">
                    <h4 class="font-heading font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>
                        Frais de scolarite
                    </h4>
                    <table class="w-full text-sm font-body">
                        <tbody>
                            <tr class="border-b border-yellow-200">
                                <td class="py-2 text-gray-600">Inscription</td>
                                <td class="py-2 text-right font-semibold text-gray-900">39 000 FCFA</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-600">Mensualite</td>
                                <td class="py-2 text-right font-semibold text-gray-900">13 000 FCFA/mois</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('admissions') }}" class="btn-primary inline-flex items-center gap-2 bg-primary-800 text-white font-heading font-semibold px-8 py-4 rounded-full hover:bg-opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Demander une inscription
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===================== b. Petite Section ===================== --}}
<section id="petite-section" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center animate-on-scroll">
            {{-- Details (left on this one for alternating) --}}
            <div class="order-2 lg:order-1">
                <span class="inline-flex items-center gap-2 bg-pink-100 border border-pink-400 text-pink-800 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    3 - 4 ans
                </span>
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    Petite Section
                </h2>
                <p class="text-gray-600 font-body mb-4 leading-relaxed">
                    La Petite Section marque les premiers pas de la socialisation de l'enfant en milieu scolaire. Dans un cadre ludique et securisant, les enfants decouvrent la vie en collectivite et developpent leur motricite, leur langage et leur creativite.
                </p>
                <p class="text-gray-600 font-body mb-6 leading-relaxed">
                    Les activites creatives et les jeux structures favorisent le developpement du langage oral et de la motricite fine, preparant ainsi les enfants aux apprentissages futurs.
                </p>

                <ul class="space-y-2 mb-6">
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-pink-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Premiere socialisation en groupe
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-pink-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Developpement de la motricite fine et globale
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-pink-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Activites creatives (dessin, peinture, collage)
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-pink-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Developpement du langage oral
                    </li>
                </ul>

                <div class="bg-pink-50 rounded-2xl p-6 mb-6">
                    <h4 class="font-heading font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>
                        Frais de scolarite
                    </h4>
                    <table class="w-full text-sm font-body">
                        <tbody>
                            <tr class="border-b border-pink-200">
                                <td class="py-2 text-gray-600">Inscription</td>
                                <td class="py-2 text-right font-semibold text-gray-900">42 000 FCFA</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-600">Mensualite</td>
                                <td class="py-2 text-right font-semibold text-gray-900">12 000 FCFA/mois</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('admissions') }}" class="btn-primary inline-flex items-center gap-2 bg-primary-800 text-white font-heading font-semibold px-8 py-4 rounded-full hover:bg-opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Demander une inscription
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            {{-- Image --}}
            <div class="relative order-1 lg:order-2">
                <div class="rounded-3xl overflow-hidden shadow-xl">
                    <img src="{{ asset('images/81569.jpg') }}" alt="Enfants en Petite Section" class="w-full h-80 lg:h-96 object-cover">
                </div>
                <div class="absolute -bottom-4 -left-4 w-20 h-20 bg-pink-200 rounded-full -z-10"></div>
                <div class="absolute -top-4 -right-4 w-14 h-14 bg-pink-100 rounded-full -z-10"></div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== c. Moyenne Section ===================== --}}
<section id="moyenne-section" class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center animate-on-scroll">
            {{-- Image --}}
            <div class="relative">
                <div class="rounded-3xl overflow-hidden shadow-xl">
                    <img src="{{ asset('images/275099.jpg') }}" alt="Enfants en Moyenne Section" class="w-full h-80 lg:h-96 object-cover">
                </div>
                <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-blue-200 rounded-full -z-10"></div>
                <div class="absolute -top-4 -left-4 w-14 h-14 bg-blue-100 rounded-full -z-10"></div>
            </div>

            {{-- Details --}}
            <div>
                <span class="inline-flex items-center gap-2 bg-blue-100 border border-blue-400 text-blue-800 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    4 - 5 ans
                </span>
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    Moyenne Section
                </h2>
                <p class="text-gray-600 font-body mb-4 leading-relaxed">
                    La Moyenne Section constitue une etape cle dans la preparation aux apprentissages fondamentaux. Les enfants decouvrent les bases de la pre-lecture, de la pre-ecriture et de la numeratie, tout en developpant leur autonomie.
                </p>
                <p class="text-gray-600 font-body mb-6 leading-relaxed">
                    A travers des activites structurees et ludiques, chaque enfant progresse a son rythme vers une meilleure maitrise du langage et des premiers concepts mathematiques.
                </p>

                <ul class="space-y-2 mb-6">
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Initiation a la pre-lecture et pre-ecriture
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Bases de la numeratie (compter, trier, classer)
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Developpement de l'autonomie
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Enrichissement du vocabulaire et expression orale
                    </li>
                </ul>

                <div class="bg-blue-50 rounded-2xl p-6 mb-6">
                    <h4 class="font-heading font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>
                        Frais de scolarite
                    </h4>
                    <table class="w-full text-sm font-body">
                        <tbody>
                            <tr class="border-b border-blue-200">
                                <td class="py-2 text-gray-600">Inscription</td>
                                <td class="py-2 text-right font-semibold text-gray-900">42 000 FCFA</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-600">Mensualite</td>
                                <td class="py-2 text-right font-semibold text-gray-900">12 000 FCFA/mois</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('admissions') }}" class="btn-primary inline-flex items-center gap-2 bg-primary-800 text-white font-heading font-semibold px-8 py-4 rounded-full hover:bg-opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Demander une inscription
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===================== d. Grande Section ===================== --}}
<section id="grande-section" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center animate-on-scroll">
            {{-- Details --}}
            <div class="order-2 lg:order-1">
                <span class="inline-flex items-center gap-2 bg-green-100 border border-green-400 text-green-800 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    5 - 6 ans
                </span>
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    Grande Section
                </h2>
                <p class="text-gray-600 font-body mb-4 leading-relaxed">
                    La Grande Section est l'annee charniere qui prepare l'enfant a l'entree en elementaire. Le programme met l'accent sur la preparation a la lecture, le developpement de la logique et le travail en equipe a travers des projets collaboratifs.
                </p>
                <p class="text-gray-600 font-body mb-6 leading-relaxed">
                    Les enfants acquierent les competences essentielles pour reussir leur transition vers le cycle elementaire, avec une attention particuliere portee a la confiance en soi et a l'autonomie.
                </p>

                <ul class="space-y-2 mb-6">
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Preparation a la lecture et a l'ecriture
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Developpement de la logique et du raisonnement
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Projets d'equipe et travail collaboratif
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Preparation a la transition vers l'elementaire
                    </li>
                </ul>

                <div class="bg-green-50 rounded-2xl p-6 mb-6">
                    <h4 class="font-heading font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>
                        Frais de scolarite
                    </h4>
                    <table class="w-full text-sm font-body">
                        <tbody>
                            <tr class="border-b border-green-200">
                                <td class="py-2 text-gray-600">Inscription</td>
                                <td class="py-2 text-right font-semibold text-gray-900">57 000 FCFA</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-600">Mensualite</td>
                                <td class="py-2 text-right font-semibold text-gray-900">13 000 FCFA/mois</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('admissions') }}" class="btn-primary inline-flex items-center gap-2 bg-primary-800 text-white font-heading font-semibold px-8 py-4 rounded-full hover:bg-opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Demander une inscription
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            {{-- Image --}}
            <div class="relative order-1 lg:order-2">
                <div class="rounded-3xl overflow-hidden shadow-xl">
                    <img src="{{ asset('images/1226.jpg') }}" alt="Enfants en Grande Section" class="w-full h-80 lg:h-96 object-cover">
                </div>
                <div class="absolute -bottom-4 -left-4 w-20 h-20 bg-green-200 rounded-full -z-10"></div>
                <div class="absolute -top-4 -right-4 w-14 h-14 bg-green-100 rounded-full -z-10"></div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== e. CI - CE2 / Elementaire 1 ===================== --}}
<section id="elementaire-1" class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center animate-on-scroll">
            {{-- Image --}}
            <div class="relative">
                <div class="rounded-3xl overflow-hidden shadow-xl">
                    <img src="{{ asset('images/7.jpg') }}" alt="Eleves en classe elementaire CI-CE2" class="w-full h-80 lg:h-96 object-cover">
                </div>
                <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-orange-200 rounded-full -z-10"></div>
                <div class="absolute -top-4 -left-4 w-14 h-14 bg-orange-100 rounded-full -z-10"></div>
            </div>

            {{-- Details --}}
            <div>
                <span class="inline-flex items-center gap-2 bg-orange-100 border border-orange-400 text-orange-800 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    6 - 9 ans
                </span>
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    CI - CE2 / Elementaire 1
                </h2>
                <p class="text-gray-600 font-body mb-4 leading-relaxed">
                    Le cycle Elementaire 1 (CI, CP, CE1, CE2) est consacre a l'acquisition des competences fondamentales : la lecture, l'ecriture, les mathematiques, les sciences et l'histoire-geographie. Les eleves construisent des bases solides pour la suite de leur parcours scolaire.
                </p>
                <p class="text-gray-600 font-body mb-6 leading-relaxed">
                    Les etudes dirigees sont obligatoires a partir de novembre afin de renforcer les acquis et accompagner chaque eleve dans sa progression.
                </p>

                <ul class="space-y-2 mb-6">
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-orange-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Maitrise de la lecture et de l'ecriture
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-orange-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Mathematiques et resolution de problemes
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-orange-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Sciences, histoire et geographie
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-orange-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Etudes dirigees obligatoires (a partir de novembre)
                    </li>
                </ul>

                <div class="bg-orange-50 rounded-2xl p-6 mb-6">
                    <h4 class="font-heading font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>
                        Frais de scolarite
                    </h4>
                    <table class="w-full text-sm font-body">
                        <tbody>
                            <tr class="border-b border-orange-200">
                                <td class="py-2 text-gray-600">Inscription</td>
                                <td class="py-2 text-right font-semibold text-gray-900">59 000 FCFA</td>
                            </tr>
                            <tr class="border-b border-orange-200">
                                <td class="py-2 text-gray-600">Mensualite</td>
                                <td class="py-2 text-right font-semibold text-gray-900">17 500 FCFA/mois</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-600">Etudes dirigees (des novembre)</td>
                                <td class="py-2 text-right font-semibold text-gray-900">2 500 FCFA/mois</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('admissions') }}" class="btn-primary inline-flex items-center gap-2 bg-primary-800 text-white font-heading font-semibold px-8 py-4 rounded-full hover:bg-opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Demander une inscription
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===================== f. CM1 - CM2 / Elementaire 2 ===================== --}}
<section id="elementaire-2" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center animate-on-scroll">
            {{-- Details --}}
            <div class="order-2 lg:order-1">
                <span class="inline-flex items-center gap-2 bg-purple-100 border border-purple-400 text-purple-800 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    9 - 11 ans
                </span>
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    CM1 - CM2 / Elementaire 2
                </h2>
                <p class="text-gray-600 font-body mb-4 leading-relaxed">
                    Le cycle Elementaire 2 (CM1 et CM2) est consacre a l'approfondissement des connaissances et a la preparation aux examens. Les eleves de CM2 sont specifiquement prepares au CFEE (Certificat de Fin d'Etudes Elementaires) et a l'entree au college.
                </p>
                <p class="text-gray-600 font-body mb-6 leading-relaxed">
                    Des sessions d'etudes renforcees sont mises en place pour assurer la reussite de chaque eleve aux examens et leur donner toutes les cles pour une transition reussie vers le secondaire.
                </p>

                <ul class="space-y-2 mb-6">
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Approfondissement des competences academiques
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Preparation au CFEE (CM2)
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Preparation a l'entree au college
                    </li>
                    <li class="flex items-center gap-3 text-gray-700 font-body">
                        <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Sessions d'etudes renforcees
                    </li>
                </ul>

                <div class="bg-purple-50 rounded-2xl p-6 mb-6">
                    <h4 class="font-heading font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>
                        Frais de scolarite
                    </h4>
                    <table class="w-full text-sm font-body">
                        <tbody>
                            <tr class="border-b border-purple-200">
                                <td class="py-2 text-gray-600 font-semibold" colspan="2">CM1</td>
                            </tr>
                            <tr class="border-b border-purple-200">
                                <td class="py-2 text-gray-600 pl-4">Inscription</td>
                                <td class="py-2 text-right font-semibold text-gray-900">59 000 FCFA</td>
                            </tr>
                            <tr class="border-b border-purple-200">
                                <td class="py-2 text-gray-600 pl-4">Mensualite</td>
                                <td class="py-2 text-right font-semibold text-gray-900">17 500 FCFA/mois</td>
                            </tr>
                            <tr class="border-b border-purple-200">
                                <td class="py-2 text-gray-600 font-semibold" colspan="2">CM2</td>
                            </tr>
                            <tr class="border-b border-purple-200">
                                <td class="py-2 text-gray-600 pl-4">Inscription</td>
                                <td class="py-2 text-right font-semibold text-gray-900">65 000 FCFA</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-600 pl-4">Mensualite</td>
                                <td class="py-2 text-right font-semibold text-gray-900">18 500 FCFA/mois</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('admissions') }}" class="btn-primary inline-flex items-center gap-2 bg-primary-800 text-white font-heading font-semibold px-8 py-4 rounded-full hover:bg-opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Demander une inscription
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            {{-- Image --}}
            <div class="relative order-1 lg:order-2">
                <div class="rounded-3xl overflow-hidden shadow-xl">
                    <img src="{{ asset('images/10211.jpg') }}" alt="Eleves en CM1-CM2" class="w-full h-80 lg:h-96 object-cover">
                </div>
                <div class="absolute -bottom-4 -left-4 w-20 h-20 bg-purple-200 rounded-full -z-10"></div>
                <div class="absolute -top-4 -right-4 w-14 h-14 bg-purple-100 rounded-full -z-10"></div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 4. EMPLOI DU TEMPS TYPE --}}
{{-- ============================================================== --}}
<section class="py-16 bg-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <span class="inline-block bg-sky-100 text-sky-700 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Organisation</span>
            <h2 class="section-title text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                Emploi du Temps <span class="text-primary-800">Type</span>
            </h2>
            <p class="text-gray-600 font-body max-w-2xl mx-auto">
                Decouvrez comment se deroule une journee typique pour nos eleves selon leur niveau.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 animate-on-scroll">
            {{-- Prescolaire --}}
            <div class="card bg-white rounded-3xl shadow-md overflow-hidden">
                <div class="bg-pink-500 px-6 py-4">
                    <h3 class="text-xl font-heading font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 0 0 0 6.364L12 20.364l7.682-7.682a4.5 4.5 0 0 0-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 0 0-6.364 0Z"/></svg>
                        Prescolaire (Garde - GS)
                    </h3>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm font-body">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-2 text-left font-heading font-semibold text-gray-900">Horaire</th>
                                <th class="py-2 text-left font-heading font-semibold text-gray-900">Activite</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">7h30 - 8h00</td>
                                <td class="py-3 text-gray-600">Accueil et jeux libres</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">8h00 - 9h30</td>
                                <td class="py-3 text-gray-600">Activites d'apprentissage</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">9h30 - 10h00</td>
                                <td class="py-3 text-gray-600">Recreation et gouter</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">10h00 - 11h30</td>
                                <td class="py-3 text-gray-600">Ateliers creatifs / Motricite</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">11h30 - 12h30</td>
                                <td class="py-3 text-gray-600">Dejeuner</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">12h30 - 14h30</td>
                                <td class="py-3 text-gray-600">Sieste / Temps calme</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">14h30 - 16h00</td>
                                <td class="py-3 text-gray-600">Activites d'eveil / Jeux</td>
                            </tr>
                            <tr>
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">16h00 - 17h30</td>
                                <td class="py-3 text-gray-600">Gouter et depart progressif</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Elementaire --}}
            <div class="card bg-white rounded-3xl shadow-md overflow-hidden">
                <div class="bg-orange-500 px-6 py-4">
                    <h3 class="text-xl font-heading font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                        Elementaire (CI - CM2)
                    </h3>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm font-body">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-2 text-left font-heading font-semibold text-gray-900">Horaire</th>
                                <th class="py-2 text-left font-heading font-semibold text-gray-900">Activite</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">7h30 - 8h00</td>
                                <td class="py-3 text-gray-600">Accueil et montee des couleurs</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">8h00 - 10h00</td>
                                <td class="py-3 text-gray-600">Cours (Francais, Mathematiques)</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">10h00 - 10h30</td>
                                <td class="py-3 text-gray-600">Recreation</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">10h30 - 12h30</td>
                                <td class="py-3 text-gray-600">Cours (Sciences, Histoire-Geo)</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">12h30 - 14h00</td>
                                <td class="py-3 text-gray-600">Pause dejeuner</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">14h00 - 16h00</td>
                                <td class="py-3 text-gray-600">Cours (Activites diverses)</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">16h00 - 16h15</td>
                                <td class="py-3 text-gray-600">Recreation</td>
                            </tr>
                            <tr>
                                <td class="py-3 text-primary-800 font-semibold whitespace-nowrap">16h15 - 17h30</td>
                                <td class="py-3 text-gray-600">Etudes dirigees / Depart</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 5. CTA INSCRIPTION --}}
{{-- ============================================================== --}}
<section class="py-16 bg-primary-800 relative overflow-hidden">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute top-4 left-10 w-12 h-12 text-white/10 animate-float" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/></svg>
        <svg class="absolute bottom-4 right-20 w-16 h-16 text-white/10 animate-float" style="animation-delay: 1s;" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
        <svg class="absolute top-1/2 right-1/4 w-8 h-8 text-white/10 animate-float" style="animation-delay: 2s;" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/></svg>
        <svg class="absolute bottom-8 left-1/3 w-10 h-10 text-white/10 animate-float" style="animation-delay: 0.5s;" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 animate-on-scroll">
        <h2 class="text-3xl md:text-4xl font-heading font-bold text-white mb-4">
            Inscrivez votre enfant des maintenant
        </h2>
        <p class="text-white/80 font-body max-w-2xl mx-auto mb-8 text-lg">
            Les inscriptions sont ouvertes pour l'annee scolaire 2026-2027. Offrez a votre enfant le meilleur depart dans la vie avec un cadre d'apprentissage bienveillant et stimulant.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('admissions') }}" class="btn-primary inline-flex items-center gap-2 bg-white text-primary-800 font-heading font-bold px-10 py-4 rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Demander une inscription
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 border-2 border-white text-white font-heading font-bold px-10 py-4 rounded-full hover:bg-white hover:text-primary-800 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                Nous contacter
            </a>
        </div>
    </div>
</section>

@endsection
