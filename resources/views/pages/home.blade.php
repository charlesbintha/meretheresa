@extends('layouts.app')

@section('title', 'Accueil')

@section('content')

{{-- ============================================================== --}}
{{-- HERO SECTION --}}
{{-- ============================================================== --}}
<section class="relative min-h-[85vh] flex items-center overflow-hidden" style="background: linear-gradient(135deg, #FFFDF8 0%, #EFF2FB 100%);">
    {{-- Floating decorative elements --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        {{-- Star top-left --}}
        <svg class="absolute top-16 left-10 w-10 h-10 text-yellow-400 animate-float" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/>
        </svg>
        {{-- Circle top-right --}}
        <svg class="absolute top-24 right-20 w-16 h-16 text-sky-200 animate-float" style="animation-delay: 1s;" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="12" cy="12" r="10"/>
        </svg>
        {{-- Cloud mid-left --}}
        <svg class="absolute top-1/3 left-5 w-20 h-12 text-pink-200 animate-float" style="animation-delay: 2s;" viewBox="0 0 64 32" fill="currentColor">
            <path d="M56 20a8 8 0 00-8-8 10 10 0 00-18-4 12 12 0 00-22 6 8 8 0 000 16h44a8 8 0 008-10z"/>
        </svg>
        {{-- Star bottom-right --}}
        <svg class="absolute bottom-32 right-10 w-8 h-8 text-pink-300 animate-float" style="animation-delay: 0.5s;" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/>
        </svg>
        {{-- Circle bottom-left --}}
        <svg class="absolute bottom-20 left-1/4 w-12 h-12 text-green-200 animate-float" style="animation-delay: 1.5s;" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="12" cy="12" r="10"/>
        </svg>
        {{-- Small star mid-right --}}
        <svg class="absolute top-1/2 right-1/3 w-6 h-6 text-orange-300 animate-float" style="animation-delay: 3s;" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/>
        </svg>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            {{-- Left: Text Content --}}
            <div class="animate-on-scroll">
                <span class="inline-block bg-pink-100 text-primary-800 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-6">
                    Groupe Scolaire Mere Theresa
                </span>
                <h1 class="text-5xl md:text-6xl font-heading font-bold text-gray-900 leading-tight mb-6">
                    Un monde de <span class="text-primary-800">decouvertes</span> pour votre enfant
                </h1>
                <p class="text-lg text-gray-600 font-body mb-8 max-w-lg">
                    Dans un environnement chaleureux et bienveillant, nous accompagnons chaque enfant dans son epanouissement et ses premiers apprentissages, de la garderie au CM2.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('programmes') }}" class="btn-primary inline-flex items-center gap-2 bg-primary-800 text-white font-heading font-semibold px-8 py-4 rounded-full hover:bg-opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Decouvrir nos programmes
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('contact') }}" class="btn-secondary inline-flex items-center gap-2 border-2 border-primary-800 text-primary-800 font-heading font-semibold px-8 py-4 rounded-full hover:bg-primary-800 hover:text-white transition-all duration-300">
                        Nous contacter
                    </a>
                </div>
            </div>

            {{-- Right: Image in blob shape --}}
            <div class="relative flex justify-center animate-on-scroll">
                <div class="relative w-[400px] h-[400px] md:w-[480px] md:h-[480px]">
                    <svg class="absolute inset-0 w-full h-full" viewBox="0 0 480 480">
                        <defs>
                            <clipPath id="heroBlob">
                                <path d="M400,240Q380,340,280,380Q180,420,100,340Q20,260,80,160Q140,60,240,60Q340,60,400,150Z"/>
                            </clipPath>
                        </defs>
                    </svg>
                    <div class="absolute inset-0 rounded-full" style="clip-path: url(#heroBlob); -webkit-clip-path: url(#heroBlob);">
                        <img src="{{ asset('images/72276.jpg') }}" alt="Eleve souriante avec livres" class="w-full h-full object-cover">
                    </div>
                    {{-- Decorative ring --}}
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-yellow-300 rounded-full opacity-60 animate-float" style="animation-delay: 0.8s;"></div>
                    <div class="absolute -top-4 -left-4 w-16 h-16 bg-sky-300 rounded-full opacity-50 animate-float" style="animation-delay: 1.2s;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats bar --}}
    <div class="absolute bottom-0 left-0 right-0 bg-white/80 backdrop-blur-sm border-t border-pink-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-3 gap-8 text-center animate-on-scroll">
                <div>
                    <span class="block text-3xl md:text-4xl font-heading font-bold text-primary-800" data-counter="200">+200</span>
                    <span class="text-sm md:text-base text-gray-600 font-body">Eleves</span>
                </div>
                <div>
                    <span class="block text-3xl md:text-4xl font-heading font-bold text-primary-800" data-counter="15">15+</span>
                    <span class="text-sm md:text-base text-gray-600 font-body">Ans d'experience</span>
                </div>
                <div>
                    <span class="block text-3xl md:text-4xl font-heading font-bold text-primary-800" data-counter="20">20+</span>
                    <span class="text-sm md:text-base text-gray-600 font-body">Enseignants qualifies</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- BIENVENUE / A PROPOS --}}
{{-- ============================================================== --}}
<section class="py-20 bg-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center animate-on-scroll">
            {{-- Left: Overlapping images --}}
            <div class="relative">
                <div class="relative z-10 w-3/4 rounded-3xl overflow-hidden shadow-xl border-4 border-sky-200">
                    <img src="{{ asset('images/2148892522.jpg') }}" alt="Enfants en classe" class="w-full h-80 object-cover">
                </div>
                <div class="absolute top-20 right-0 z-20 w-3/5 rounded-3xl overflow-hidden shadow-xl border-4 border-pink-200">
                    <img src="{{ asset('images/7.jpg') }}" alt="Eleve souriant en classe" class="w-full h-64 object-cover">
                </div>
                {{-- Decorative accent --}}
                <div class="absolute -bottom-4 left-8 w-20 h-20 bg-yellow-200 rounded-full -z-0"></div>
                <div class="absolute -top-4 right-12 w-12 h-12 bg-green-200 rounded-full -z-0"></div>
            </div>

            {{-- Right: Welcome text --}}
            <div>
                <span class="inline-block bg-pink-100 text-primary-800 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">A propos de nous</span>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-6">
                    Bienvenue au <span class="text-primary-800">Groupe Scolaire Mere Theresa</span>
                </h2>
                <p class="text-gray-600 font-body mb-6 leading-relaxed">
                    Situe au coeur de Guediawaye, notre etablissement offre un cadre d'apprentissage stimulant et securise pour les enfants de 3 mois a 11 ans. Notre mission est de favoriser l'epanouissement global de chaque enfant a travers une pedagogie bienveillante et adaptee.
                </p>
                <p class="text-gray-600 font-body mb-8 leading-relaxed">
                    Depuis plus de 15 ans, nous accompagnons les familles de la region dans l'education de leurs enfants, en alliant excellence academique et developpement personnel.
                </p>

                {{-- Feature list --}}
                <div class="grid sm:grid-cols-2 gap-4 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <span class="font-body font-semibold text-gray-700">Pedagogie bienveillante</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-sky-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="font-body font-semibold text-gray-700">Suivi personnalise</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <span class="font-body font-semibold text-gray-700">Environnement securise</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                        </div>
                        <span class="font-body font-semibold text-gray-700">Activites variees</span>
                    </div>
                </div>

                {{-- Director's signature --}}
                <div class="border-t border-gray-200 pt-6 flex items-center gap-4">
                    <div class="w-14 h-14 bg-primary-800 rounded-full flex items-center justify-center text-white font-heading font-bold text-lg">MT</div>
                    <div>
                        <p class="font-heading font-bold text-gray-900">La Direction</p>
                        <p class="text-sm text-gray-500 font-body">Groupe Scolaire Mere Theresa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- NOS PROGRAMMES --}}
{{-- ============================================================== --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block bg-sky-100 text-sky-700 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Nos programmes</span>
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                Un parcours adapte a <span class="text-primary-800">chaque age</span>
            </h2>
            <p class="text-gray-600 font-body max-w-2xl mx-auto">
                De la garde des tout-petits au CM2, nous proposons des programmes pedagogiques adaptes a chaque etape du developpement de votre enfant.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 animate-on-scroll">
            {{-- Card 1: Garde --}}
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="h-2 bg-yellow-400"></div>
                <div class="p-8">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-2">Garde</h3>
                    <span class="inline-block bg-yellow-50 text-yellow-700 text-sm font-semibold px-3 py-1 rounded-full mb-4">3 mois - 3 ans</span>
                    <p class="text-gray-600 font-body mb-6">Eveil et garde securisee dans un espace chaleureux adapte aux tout-petits. Activites sensorielles et premieres decouvertes.</p>
                    <a href="{{ route('programmes') }}" class="inline-flex items-center text-yellow-600 font-heading font-semibold hover:text-yellow-700 transition-colors">
                        En savoir plus
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- Card 2: Petite Section --}}
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="h-2 bg-pink-400"></div>
                <div class="p-8">
                    <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-2">Petite Section</h3>
                    <span class="inline-block bg-pink-50 text-pink-700 text-sm font-semibold px-3 py-1 rounded-full mb-4">3 - 4 ans</span>
                    <p class="text-gray-600 font-body mb-6">Premiers apprentissages a travers le jeu et la creativite. Developpement du langage et de la motricite fine.</p>
                    <a href="{{ route('programmes') }}" class="inline-flex items-center text-pink-600 font-heading font-semibold hover:text-pink-700 transition-colors">
                        En savoir plus
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- Card 3: Moyenne Section --}}
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="h-2 bg-sky-400"></div>
                <div class="p-8">
                    <div class="w-16 h-16 bg-sky-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-2">Moyenne Section</h3>
                    <span class="inline-block bg-sky-50 text-sky-700 text-sm font-semibold px-3 py-1 rounded-full mb-4">4 - 5 ans</span>
                    <p class="text-gray-600 font-body mb-6">Developpement et socialisation. Renforcement des competences langagieres et initiation aux premiers concepts.</p>
                    <a href="{{ route('programmes') }}" class="inline-flex items-center text-sky-600 font-heading font-semibold hover:text-sky-700 transition-colors">
                        En savoir plus
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- Card 4: Grande Section --}}
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="h-2 bg-green-400"></div>
                <div class="p-8">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-2">Grande Section</h3>
                    <span class="inline-block bg-green-50 text-green-700 text-sm font-semibold px-3 py-1 rounded-full mb-4">5 - 6 ans</span>
                    <p class="text-gray-600 font-body mb-6">Preparation au primaire avec un programme structure. Initiation a la lecture, l'ecriture et au calcul.</p>
                    <a href="{{ route('programmes') }}" class="inline-flex items-center text-green-600 font-heading font-semibold hover:text-green-700 transition-colors">
                        En savoir plus
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- Card 5: CI - CE2 --}}
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="h-2 bg-orange-400"></div>
                <div class="p-8">
                    <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-2">CI - CE2</h3>
                    <span class="inline-block bg-orange-50 text-orange-700 text-sm font-semibold px-3 py-1 rounded-full mb-4">6 - 9 ans</span>
                    <p class="text-gray-600 font-body mb-6">Apprentissages fondamentaux : lecture, ecriture, mathematiques. Construction de bases solides pour la reussite scolaire.</p>
                    <a href="{{ route('programmes') }}" class="inline-flex items-center text-orange-600 font-heading font-semibold hover:text-orange-700 transition-colors">
                        En savoir plus
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- Card 6: CM1 - CM2 --}}
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="h-2 bg-purple-400"></div>
                <div class="p-8">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-2">CM1 - CM2</h3>
                    <span class="inline-block bg-purple-50 text-purple-700 text-sm font-semibold px-3 py-1 rounded-full mb-4">9 - 11 ans</span>
                    <p class="text-gray-600 font-body mb-6">Approfondissement des connaissances et preparation a l'entree au college. Developpement de l'autonomie et de la reflexion.</p>
                    <a href="{{ route('programmes') }}" class="inline-flex items-center text-purple-600 font-heading font-semibold hover:text-purple-700 transition-colors">
                        En savoir plus
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- POURQUOI NOUS CHOISIR --}}
{{-- ============================================================== --}}
<section class="py-20 bg-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block bg-green-100 text-green-700 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Nos atouts</span>
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                Pourquoi <span class="text-primary-800">nous choisir</span> ?
            </h2>
            <p class="text-gray-600 font-body max-w-2xl mx-auto">
                Nous mettons tout en oeuvre pour offrir a chaque enfant les meilleures conditions d'apprentissage et d'epanouissement.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 animate-on-scroll">
            {{-- Feature 1 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-3">Pedagogie active et bienveillante</h3>
                <p class="text-gray-600 font-body">Une approche centree sur l'enfant qui favorise la curiosite, la confiance en soi et le plaisir d'apprendre.</p>
            </div>

            {{-- Feature 2 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-sky-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-3">Enseignants qualifies et passionnes</h3>
                <p class="text-gray-600 font-body">Une equipe pedagogique experimentee, dediee a l'accompagnement et a la reussite de chaque eleve.</p>
            </div>

            {{-- Feature 3 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-3">Environnement securise</h3>
                <p class="text-gray-600 font-body">Un cadre securise et surveille ou chaque enfant evolue en toute serenite tout au long de la journee.</p>
            </div>

            {{-- Feature 4 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-3">Suivi personnalise de chaque enfant</h3>
                <p class="text-gray-600 font-body">Des effectifs maitrise permettant un accompagnement individuel et un suivi regulier des progres de chaque eleve.</p>
            </div>

            {{-- Feature 5 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-3">Cantine et transport scolaire</h3>
                <p class="text-gray-600 font-body">Un service de cantine equilibre et un transport scolaire couvrant 3 zones pour faciliter le quotidien des familles.</p>
            </div>

            {{-- Feature 6 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-3">Activites extra-scolaires variees</h3>
                <p class="text-gray-600 font-body">Arts plastiques, sport, musique et bien d'autres activites pour developper les talents de chaque enfant.</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- EQUIPE PEDAGOGIQUE --}}
{{-- ============================================================== --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block bg-purple-100 text-purple-700 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Notre equipe</span>
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                Notre <span class="text-primary-800">Equipe Pedagogique</span>
            </h2>
            <p class="text-gray-600 font-body max-w-2xl mx-auto">
                Des professionnels passionnes et experimentes, devoues au developpement et a la reussite de vos enfants.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 animate-on-scroll">
            {{-- Teacher 1 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-24 h-24 bg-pink-200 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-2xl font-heading font-bold text-primary-800">AD</span>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-1">Aminata Diallo</h3>
                <span class="inline-block text-primary-800 font-body text-sm font-semibold mb-3">Directrice</span>
                <p class="text-gray-600 font-body text-sm">Plus de 20 ans d'experience dans l'education. Passionnee par la pedagogie bienveillante et le developpement de l'enfant.</p>
            </div>

            {{-- Teacher 2 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-24 h-24 bg-sky-200 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-2xl font-heading font-bold text-sky-700">FN</span>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-1">Fatou Ndiaye</h3>
                <span class="inline-block text-sky-600 font-body text-sm font-semibold mb-3">Responsable Maternelle</span>
                <p class="text-gray-600 font-body text-sm">Specialiste de la petite enfance, elle cree un environnement stimulant et securisant pour les plus jeunes.</p>
            </div>

            {{-- Teacher 3 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-24 h-24 bg-green-200 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-2xl font-heading font-bold text-green-700">MS</span>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-1">Moussa Sarr</h3>
                <span class="inline-block text-green-600 font-body text-sm font-semibold mb-3">Responsable Primaire</span>
                <p class="text-gray-600 font-body text-sm">Enseignant dedie avec une approche pedagogique innovante qui motive les eleves a donner le meilleur d'eux-memes.</p>
            </div>

            {{-- Teacher 4 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-24 h-24 bg-orange-200 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-2xl font-heading font-bold text-orange-700">KF</span>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-1">Khady Fall</h3>
                <span class="inline-block text-orange-600 font-body text-sm font-semibold mb-3">Educatrice Garde</span>
                <p class="text-gray-600 font-body text-sm">Specialisee en eveil des tout-petits, elle accompagne avec douceur et professionnalisme les premiers pas de chaque enfant.</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- GALERIE --}}
{{-- ============================================================== --}}
<section class="py-20 bg-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block bg-orange-100 text-orange-700 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Galerie photos</span>
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                La Vie a <span class="text-primary-800">l'Ecole</span>
            </h2>
            <p class="text-gray-600 font-body max-w-2xl mx-auto">
                Decouvrez en images le quotidien de nos eleves et les moments forts de notre ecole.
            </p>
        </div>

        <div class="columns-2 md:columns-3 gap-4 space-y-4 animate-on-scroll">
            <div class="break-inside-avoid rounded-3xl overflow-hidden shadow-md group cursor-pointer" data-lightbox="gallery">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/7.jpg') }}" alt="Eleve souriant en classe" class="w-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/20 transition-all duration-300"></div>
                </div>
            </div>
            <div class="break-inside-avoid rounded-3xl overflow-hidden shadow-md group cursor-pointer" data-lightbox="gallery">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/2148892522.jpg') }}" alt="Enfants en train d'etudier" class="w-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/20 transition-all duration-300"></div>
                </div>
            </div>
            <div class="break-inside-avoid rounded-3xl overflow-hidden shadow-md group cursor-pointer" data-lightbox="gallery">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/1226.jpg') }}" alt="Fille avec sac a dos au tableau" class="w-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/20 transition-all duration-300"></div>
                </div>
            </div>
            <div class="break-inside-avoid rounded-3xl overflow-hidden shadow-md group cursor-pointer" data-lightbox="gallery">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/10211.jpg') }}" alt="Fille ecrivant au tableau" class="w-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/20 transition-all duration-300"></div>
                </div>
            </div>
            <div class="break-inside-avoid rounded-3xl overflow-hidden shadow-md group cursor-pointer" data-lightbox="gallery">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/81569.jpg') }}" alt="Garcon avec livres" class="w-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/20 transition-all duration-300"></div>
                </div>
            </div>
            <div class="break-inside-avoid rounded-3xl overflow-hidden shadow-md group cursor-pointer" data-lightbox="gallery">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/25620.jpg') }}" alt="Enfants avec sacs a dos en classe" class="w-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/20 transition-all duration-300"></div>
                </div>
            </div>
            <div class="break-inside-avoid rounded-3xl overflow-hidden shadow-md group cursor-pointer" data-lightbox="gallery">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/275099.jpg') }}" alt="Garcon en uniforme" class="w-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/20 transition-all duration-300"></div>
                </div>
            </div>
            <div class="break-inside-avoid rounded-3xl overflow-hidden shadow-md group cursor-pointer" data-lightbox="gallery">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/8845.jpg') }}" alt="Salle de classe" class="w-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/20 transition-all duration-300"></div>
                </div>
            </div>
        </div>

        <div class="text-center mt-12 animate-on-scroll">
            <a href="{{ route('gallery') }}" class="inline-flex items-center gap-2 bg-white border-2 border-primary-800 text-primary-800 font-heading font-semibold px-8 py-4 rounded-full hover:bg-primary-800 hover:text-white transition-all duration-300">
                Voir toute la galerie
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- TEMOIGNAGES --}}
{{-- ============================================================== --}}
<section class="py-20" style="background: linear-gradient(135deg, #EFF2FB 0%, #E8F4FD 100%);">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block bg-pink-100 text-pink-700 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Temoignages</span>
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                Ce que disent <span class="text-primary-800">les parents</span>
            </h2>
            <p class="text-gray-600 font-body max-w-2xl mx-auto">
                La confiance des familles est notre plus grande fierte. Decouvrez leurs temoignages.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 animate-on-scroll">
            {{-- Testimonial 1 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 relative">
                <div class="absolute -top-4 left-8">
                    <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11H10v10H0z"/></svg>
                    </div>
                </div>
                <p class="text-gray-600 font-body mt-6 mb-6 leading-relaxed italic">
                    "Mon fils est inscrit a Mere Theresa depuis la Petite Section. L'equipe pedagogique est formidable et tres attentive aux besoins de chaque enfant. Il a fait des progres incroyables et adore aller a l'ecole chaque matin !"
                </p>
                <div class="flex items-center gap-3 border-t border-gray-100 pt-4">
                    <div class="w-12 h-12 bg-pink-200 rounded-full flex items-center justify-center">
                        <span class="font-heading font-bold text-primary-800">MD</span>
                    </div>
                    <div>
                        <p class="font-heading font-bold text-gray-900">Mame Diarra Sy</p>
                        <p class="text-sm text-gray-500 font-body">Parent d'eleve - CE1</p>
                    </div>
                </div>
            </div>

            {{-- Testimonial 2 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 relative">
                <div class="absolute -top-4 left-8">
                    <div class="w-10 h-10 bg-sky-400 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11H10v10H0z"/></svg>
                    </div>
                </div>
                <p class="text-gray-600 font-body mt-6 mb-6 leading-relaxed italic">
                    "Ce qui nous a convaincus, c'est la qualite de l'encadrement et la proprete des locaux. Nos deux enfants y sont inscrits et nous sommes tres satisfaits des resultats scolaires. La cantine est egalement un vrai plus !"
                </p>
                <div class="flex items-center gap-3 border-t border-gray-100 pt-4">
                    <div class="w-12 h-12 bg-sky-200 rounded-full flex items-center justify-center">
                        <span class="font-heading font-bold text-sky-700">ON</span>
                    </div>
                    <div>
                        <p class="font-heading font-bold text-gray-900">Ousmane Niang</p>
                        <p class="text-sm text-gray-500 font-body">Parent d'eleves - MS et CM1</p>
                    </div>
                </div>
            </div>

            {{-- Testimonial 3 --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 relative">
                <div class="absolute -top-4 left-8">
                    <div class="w-10 h-10 bg-green-400 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11H10v10H0z"/></svg>
                    </div>
                </div>
                <p class="text-gray-600 font-body mt-6 mb-6 leading-relaxed italic">
                    "Ma fille etait tres timide avant d'integrer Mere Theresa. Grace a la bienveillance des educatrices, elle s'est epanouie et a pris confiance en elle. Je recommande cette ecole a tous les parents du quartier !"
                </p>
                <div class="flex items-center gap-3 border-t border-gray-100 pt-4">
                    <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center">
                        <span class="font-heading font-bold text-green-700">AD</span>
                    </div>
                    <div>
                        <p class="font-heading font-bold text-gray-900">Aissatou Diop</p>
                        <p class="text-sm text-gray-500 font-body">Parent d'eleve - GS</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- ACTUALITES & EVENEMENTS --}}
{{-- ============================================================== --}}
<section class="py-20 bg-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block bg-sky-100 text-sky-700 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Blog</span>
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                Actualites & <span class="text-primary-800">Evenements</span>
            </h2>
            <p class="text-gray-600 font-body max-w-2xl mx-auto">
                Restez informes de la vie de l'ecole, des evenements a venir et des moments forts de l'annee scolaire.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 animate-on-scroll">
            {{-- News 1 --}}
            <div class="bg-white rounded-3xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="relative overflow-hidden h-52">
                    <img src="{{ asset('images/25620.jpg') }}" alt="Rentree scolaire" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 left-4 bg-white rounded-xl px-3 py-1.5 shadow-sm">
                        <span class="text-sm font-heading font-bold text-primary-800">10 Oct 2025</span>
                    </div>
                </div>
                <div class="p-6">
                    <span class="inline-block bg-sky-100 text-sky-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">Rentree</span>
                    <h3 class="text-lg font-heading font-bold text-gray-900 mb-2 group-hover:text-primary-800 transition-colors">Rentree scolaire 2025-2026</h3>
                    <p class="text-gray-600 font-body text-sm mb-4">La rentree scolaire approche ! Decouvrez les dates importantes, les fournitures necessaires et les nouveautes de cette annee.</p>
                    <a href="{{ route('news') }}" class="inline-flex items-center text-primary-800 font-heading font-semibold text-sm hover:text-pink-700 transition-colors">
                        Lire la suite
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- News 2 --}}
            <div class="bg-white rounded-3xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="relative overflow-hidden h-52">
                    <img src="{{ asset('images/8845.jpg') }}" alt="Journee portes ouvertes" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 left-4 bg-white rounded-xl px-3 py-1.5 shadow-sm">
                        <span class="text-sm font-heading font-bold text-primary-800">15 Mar 2026</span>
                    </div>
                </div>
                <div class="p-6">
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">Evenement</span>
                    <h3 class="text-lg font-heading font-bold text-gray-900 mb-2 group-hover:text-primary-800 transition-colors">Journee Portes Ouvertes</h3>
                    <p class="text-gray-600 font-body text-sm mb-4">Venez decouvrir notre ecole lors de notre journee portes ouvertes. Visitez nos locaux, rencontrez les enseignants et inscrivez vos enfants.</p>
                    <a href="{{ route('news') }}" class="inline-flex items-center text-primary-800 font-heading font-semibold text-sm hover:text-pink-700 transition-colors">
                        Lire la suite
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- News 3 --}}
            <div class="bg-white rounded-3xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="relative overflow-hidden h-52">
                    <img src="{{ asset('images/275099.jpg') }}" alt="Fete de fin d'annee" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 left-4 bg-white rounded-xl px-3 py-1.5 shadow-sm">
                        <span class="text-sm font-heading font-bold text-primary-800">28 Jun 2026</span>
                    </div>
                </div>
                <div class="p-6">
                    <span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">Celebration</span>
                    <h3 class="text-lg font-heading font-bold text-gray-900 mb-2 group-hover:text-primary-800 transition-colors">Fete de Fin d'Annee</h3>
                    <p class="text-gray-600 font-body text-sm mb-4">Rejoignez-nous pour celebrer la fin de l'annee scolaire avec spectacles, remise de prix et activites festives pour toute la famille.</p>
                    <a href="{{ route('news') }}" class="inline-flex items-center text-primary-800 font-heading font-semibold text-sm hover:text-pink-700 transition-colors">
                        Lire la suite
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- CTA INSCRIPTION --}}
{{-- ============================================================== --}}
<section class="py-16 bg-primary-800 relative overflow-hidden">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute top-4 left-10 w-12 h-12 text-white/10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/></svg>
        <svg class="absolute bottom-4 right-20 w-16 h-16 text-white/10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
        <svg class="absolute top-1/2 right-1/4 w-8 h-8 text-white/10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/></svg>
        <svg class="absolute bottom-8 left-1/3 w-10 h-10 text-white/10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 animate-on-scroll">
        <h2 class="text-3xl md:text-4xl font-heading font-bold text-white mb-4">
            Prets a rejoindre notre famille ?
        </h2>
        <p class="text-white/80 font-body max-w-2xl mx-auto mb-8 text-lg">
            Les inscriptions sont ouvertes pour l'annee scolaire 2026-2027. Offrez a votre enfant un cadre d'apprentissage exceptionnel.
        </p>
        <a href="{{ route('admissions') }}" class="inline-flex items-center gap-2 bg-white text-primary-800 font-heading font-bold px-10 py-4 rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            Demander une inscription
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>

{{-- ============================================================== --}}
{{-- CONTACT PREVIEW --}}
{{-- ============================================================== --}}
<section class="py-20 bg-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block bg-pink-100 text-primary-800 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Contact</span>
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                <span class="text-primary-800">Contactez</span>-nous
            </h2>
            <p class="text-gray-600 font-body max-w-2xl mx-auto">
                Une question ? N'hesitez pas a nous contacter. Nous serons ravis de vous renseigner.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 animate-on-scroll">
            {{-- Left: Contact Form --}}
            <div class="bg-white rounded-3xl shadow-lg p-8 md:p-10">
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-heading font-semibold text-gray-700 mb-2">Nom complet</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none"
                                placeholder="Votre nom">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-heading font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none"
                                placeholder="votre@email.com">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-heading font-semibold text-gray-700 mb-2">Telephone</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none"
                                placeholder="77 XXX XX XX">
                        </div>
                        <div>
                            <label for="child_age" class="block text-sm font-heading font-semibold text-gray-700 mb-2">Age de l'enfant</label>
                            <input type="text" id="child_age" name="child_age"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none"
                                placeholder="Ex: 5 ans">
                        </div>
                    </div>
                    <div>
                        <label for="level" class="block text-sm font-heading font-semibold text-gray-700 mb-2">Niveau souhaite</label>
                        <select id="level" name="level"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none bg-white">
                            <option value="">Selectionnez un niveau</option>
                            <option value="garde">Garde (3 mois - 3 ans)</option>
                            <option value="ps">Petite Section (3-4 ans)</option>
                            <option value="ms">Moyenne Section (4-5 ans)</option>
                            <option value="gs">Grande Section (5-6 ans)</option>
                            <option value="ci">CI</option>
                            <option value="cp">CP</option>
                            <option value="ce1">CE1</option>
                            <option value="ce2">CE2</option>
                            <option value="cm1">CM1</option>
                            <option value="cm2">CM2</option>
                        </select>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-heading font-semibold text-gray-700 mb-2">Message</label>
                        <textarea id="message" name="message" rows="4" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none resize-none"
                            placeholder="Votre message..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-primary-800 text-white font-heading font-bold py-4 rounded-full hover:bg-opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl">
                        Envoyer le message
                    </button>
                </form>
            </div>

            {{-- Right: Map + Info --}}
            <div class="space-y-8">
                {{-- Map Placeholder --}}
                <div class="bg-gray-200 rounded-3xl overflow-hidden h-64 shadow-md">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3858.5!2d-17.395!3d14.775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTTCsDQ2JzMwLjAiTiAxN8KwMjMnNDIuMCJX!5e0!3m2!1sfr!2ssn!4v1"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="rounded-3xl">
                    </iframe>
                </div>

                {{-- Contact Info Cards --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    {{-- Address --}}
                    <div class="bg-white rounded-2xl p-5 shadow-md flex items-start gap-4">
                        <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-heading font-bold text-gray-900 text-sm mb-1">Adresse</h4>
                            <p class="text-gray-600 font-body text-sm">SHS N&deg; 60 Golf Nord, Guediawaye</p>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="bg-white rounded-2xl p-5 shadow-md flex items-start gap-4">
                        <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-heading font-bold text-gray-900 text-sm mb-1">Telephone</h4>
                            <p class="text-gray-600 font-body text-sm">33-877-81-62</p>
                            <p class="text-gray-600 font-body text-sm">77-148-65-02</p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="bg-white rounded-2xl p-5 shadow-md flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-heading font-bold text-gray-900 text-sm mb-1">Email</h4>
                            <p class="text-gray-600 font-body text-sm">gardebambinos@gmail.com</p>
                        </div>
                    </div>

                    {{-- Hours --}}
                    <div class="bg-white rounded-2xl p-5 shadow-md flex items-start gap-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-heading font-bold text-gray-900 text-sm mb-1">Horaires</h4>
                            <p class="text-gray-600 font-body text-sm">Lun - Ven: 7h30 - 17h30</p>
                            <p class="text-gray-600 font-body text-sm">Sam: 8h00 - 12h00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
