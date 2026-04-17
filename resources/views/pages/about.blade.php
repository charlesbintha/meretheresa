@extends('layouts.app')

@section('title', "À propos — Histoire, mission et équipe de l'école")
@section('description', "Découvrez l'histoire, la mission éducative et l'équipe pédagogique du Groupe Scolaire Mère Thérèsa, école privée au cœur de Guédiawaye depuis plus de 15 ans.")

@section('content')

{{-- ============================================================== --}}
{{-- 1. PAGE HERO BANNER --}}
{{-- ============================================================== --}}
<section class="relative bg-primary-800 py-20 overflow-hidden">
    {{-- Decorative SVG elements --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute top-6 left-10 w-12 h-12 text-white/10 animate-float" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/>
        </svg>
        <svg class="absolute top-10 right-16 w-20 h-12 text-white/10 animate-float" style="animation-delay: 1s;" viewBox="0 0 64 32" fill="currentColor">
            <path d="M56 20a8 8 0 00-8-8 10 10 0 00-18-4 12 12 0 00-22 6 8 8 0 000 16h44a8 8 0 008-10z"/>
        </svg>
        <svg class="absolute bottom-8 left-1/4 w-10 h-10 text-white/10 animate-float" style="animation-delay: 2s;" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="12" cy="12" r="10"/>
        </svg>
        <svg class="absolute bottom-6 right-1/3 w-8 h-8 text-white/10 animate-float" style="animation-delay: 0.5s;" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/>
        </svg>
        <svg class="absolute top-1/2 right-10 w-14 h-14 text-white/10" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="12" cy="12" r="10"/>
        </svg>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-4 animate-on-scroll">
            A Propos de Notre Ecole
        </h1>
        <nav aria-label="Fil d'Ariane" class="animate-on-scroll">
            <ol class="flex items-center justify-center gap-2 text-white/70 font-body text-sm">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Accueil</a>
                </li>
                <li>
                    <svg class="w-4 h-4 inline-block" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                </li>
                <li class="text-white font-semibold">A propos</li>
            </ol>
        </nav>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 2. NOTRE HISTOIRE --}}
{{-- ============================================================== --}}
<section class="py-20 bg-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            {{-- Left: Image --}}
            <div class="animate-on-scroll">
                <div class="relative">
                    <div class="rounded-3xl overflow-hidden shadow-xl border-4 border-pink-200">
                        <img src="{{ asset('images/8845.jpg') }}" alt="Salle de classe du Groupe Scolaire Mere Theresa" class="w-full h-[420px] object-cover">
                    </div>
                    {{-- Decorative accents --}}
                    <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-yellow-300 rounded-full opacity-60 -z-10"></div>
                    <div class="absolute -top-4 -left-4 w-14 h-14 bg-sky-300 rounded-full opacity-50 -z-10"></div>
                    {{-- Years badge --}}
                    <div class="absolute -bottom-6 -left-6 bg-primary-800 text-white rounded-2xl p-5 shadow-lg">
                        <span class="block text-3xl font-heading font-bold">15+</span>
                        <span class="text-sm font-body text-white/80">annees<br>d'experience</span>
                    </div>
                </div>
            </div>

            {{-- Right: Text --}}
            <div class="animate-on-scroll">
                <span class="inline-block bg-pink-100 text-primary-800 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Notre histoire</span>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-6">
                    Une histoire d'<span class="text-primary-800">amour</span> pour l'education
                </h2>
                <p class="text-gray-600 font-body mb-5 leading-relaxed">
                    Tout a commence au debut des annees 2000, lorsqu'une passionnee de l'education a ouvert une petite garderie dans le quartier Golf Nord de Guediawaye, sous le nom d'<strong class="text-primary-800">Ecole privee Les Bambinos</strong>. L'objectif etait simple : offrir aux tout-petits du quartier un espace securise, chaleureux et stimulant pour leurs premiers pas dans la vie.
                </p>
                <p class="text-gray-600 font-body mb-5 leading-relaxed">
                    Face a la confiance grandissante des familles de Guediawaye et des communes environnantes, l'ecole n'a cesse de se developper. De simple garderie, elle est devenue un veritable prescolaire, puis a elargi son offre en ouvrant des classes d'elementaire, du CI au CM2. C'est ainsi qu'est ne le <strong class="text-primary-800">Groupe Scolaire Mere Theresa</strong>, en hommage a l'esprit de devouement et de bienveillance de Mere Teresa.
                </p>
                <p class="text-gray-600 font-body mb-8 leading-relaxed">
                    Aujourd'hui, situee au SHS N&deg; 60 Golf Nord, notre ecole accueille plus de 200 eleves de la garde au CM2. Nous restons fideles a notre vision d'origine : accompagner chaque enfant avec amour, rigueur et engagement, pour qu'il devienne un citoyen epanoui et confiant.
                </p>

                {{-- Quick stats --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center bg-white rounded-2xl p-4 shadow-sm">
                        <span class="block text-2xl font-heading font-bold text-primary-800">200+</span>
                        <span class="text-xs text-gray-500 font-body">Eleves</span>
                    </div>
                    <div class="text-center bg-white rounded-2xl p-4 shadow-sm">
                        <span class="block text-2xl font-heading font-bold text-primary-800">20+</span>
                        <span class="text-xs text-gray-500 font-body">Enseignants</span>
                    </div>
                    <div class="text-center bg-white rounded-2xl p-4 shadow-sm">
                        <span class="block text-2xl font-heading font-bold text-primary-800">15+</span>
                        <span class="text-xs text-gray-500 font-body">Ans</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 3. NOTRE MISSION ET VALEURS --}}
{{-- ============================================================== --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block bg-sky-100 text-sky-700 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Mission & Valeurs</span>
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                Notre <span class="text-primary-800">Mission</span> et nos <span class="text-primary-800">Valeurs</span>
            </h2>
        </div>

        {{-- Mission Statement Card --}}
        <div class="max-w-4xl mx-auto mb-16 animate-on-scroll">
            <div class="bg-white rounded-3xl shadow-lg p-8 md:p-10 border-l-4 border-primary-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-pink-50 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-primary-800 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="text-xl font-heading font-bold text-gray-900">Notre Mission</h3>
                    </div>
                    <p class="text-gray-600 font-body leading-relaxed text-lg">
                        Offrir a chaque enfant un environnement d'apprentissage bienveillant, stimulant et inclusif, ou il peut developper son plein potentiel intellectuel, social et emotionnel. Nous nous engageons a former des citoyens responsables, curieux et confiants, prets a relever les defis de demain, tout en restant ancres dans les valeurs de solidarite et de respect propres a notre communaute.
                    </p>
                </div>
            </div>
        </div>

        {{-- 4 Core Values --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 animate-on-scroll">
            {{-- Value 1: Excellence academique --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-3">Excellence academique</h3>
                <p class="text-gray-600 font-body text-sm">Nous visons les plus hauts standards de qualite dans l'enseignement, en preparant nos eleves a reussir a chaque etape de leur parcours scolaire.</p>
            </div>

            {{-- Value 2: Bienveillance --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-3">Bienveillance</h3>
                <p class="text-gray-600 font-body text-sm">Chaque enfant est accueilli avec respect et attention. Nous creons un climat de confiance ou chacun se sent valorise et en securite.</p>
            </div>

            {{-- Value 3: Epanouissement de l'enfant --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-3">Epanouissement de l'enfant</h3>
                <p class="text-gray-600 font-body text-sm">Le developpement global de l'enfant est au coeur de notre projet : intellectuel, physique, artistique, social et emotionnel.</p>
            </div>

            {{-- Value 4: Engagement communautaire --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-16 h-16 bg-sky-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-3">Engagement communautaire</h3>
                <p class="text-gray-600 font-body text-sm">Nous sommes profondement ancres dans la communaute de Guediawaye et travaillons main dans la main avec les familles pour le bien de chaque enfant.</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 4. NOTRE PEDAGOGIE --}}
{{-- ============================================================== --}}
<section class="py-20 bg-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block bg-green-100 text-green-700 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Notre approche</span>
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                Notre <span class="text-primary-800">Pedagogie</span>
            </h2>
            <p class="text-gray-600 font-body max-w-3xl mx-auto">
                Au Groupe Scolaire Mere Theresa, nous adoptons une pedagogie active et centree sur l'enfant. Notre approche combine les methodes d'enseignement modernes avec un suivi individualise, dans un cadre bilingue (francais et arabe) qui ouvre nos eleves sur le monde. Nous croyons que chaque enfant apprend a son rythme et que notre role est de l'accompagner avec patience et enthousiasme.
            </p>
        </div>

        {{-- 3 Pillars --}}
        <div class="grid md:grid-cols-3 gap-8 animate-on-scroll">
            {{-- Pillar 1: Apprendre en s'amusant --}}
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="h-2 bg-yellow-400"></div>
                <div class="p-8">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-3">Apprendre en s'amusant</h3>
                    <p class="text-gray-600 font-body leading-relaxed">
                        Le jeu est un levier d'apprentissage puissant. A travers des ateliers ludiques, des projets creatifs et des activites sensorielles, nos eleves decouvrent le plaisir d'apprendre. Chaque journee est une aventure ou la curiosite est encouragee et celebree.
                    </p>
                </div>
            </div>

            {{-- Pillar 2: Accompagnement individualise --}}
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="h-2 bg-sky-400"></div>
                <div class="p-8">
                    <div class="w-16 h-16 bg-sky-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-3">Accompagnement individualise</h3>
                    <p class="text-gray-600 font-body leading-relaxed">
                        Grace a des effectifs maitrises, nos enseignants connaissent chaque eleve par son prenom, ses forces et ses besoins. Des evaluations regulieres et des echanges constants avec les parents permettent un suivi personnalise et bienveillant.
                    </p>
                </div>
            </div>

            {{-- Pillar 3: Ouverture sur le monde --}}
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="h-2 bg-green-400"></div>
                <div class="p-8">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-3">Ouverture sur le monde</h3>
                    <p class="text-gray-600 font-body leading-relaxed">
                        Notre programme bilingue francais-arabe, l'initiation a l'informatique et les activites culturelles variees preparent nos eleves a evoluer dans un monde globalise, tout en restant fiers de leurs racines et de leur identite.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 5. NOTRE EQUIPE COMPLETE --}}
{{-- ============================================================== --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block bg-purple-100 text-purple-700 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Notre equipe</span>
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                Notre <span class="text-primary-800">Equipe Complete</span>
            </h2>
            <p class="text-gray-600 font-body max-w-2xl mx-auto">
                Des professionnels passionnes et devoues qui forment le coeur de notre ecole. Chaque membre contribue au bien-etre et a la reussite de vos enfants.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 animate-on-scroll">
            {{-- Staff 1: Directrice --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-24 h-24 bg-pink-200 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-2xl font-heading font-bold text-primary-800">AD</span>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-1">Aminata Diallo</h3>
                <span class="inline-block text-primary-800 font-body text-sm font-semibold mb-3">Directrice</span>
                <p class="text-gray-600 font-body text-sm">Fondatrice de l'ecole, elle porte le projet educatif depuis plus de 15 ans avec passion, devouement et une vision claire pour l'avenir de chaque enfant.</p>
            </div>

            {{-- Staff 2: Directrice adjointe --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-24 h-24 bg-sky-200 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-2xl font-heading font-bold text-sky-700">FN</span>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-1">Fatou Ndiaye</h3>
                <span class="inline-block text-sky-600 font-body text-sm font-semibold mb-3">Directrice adjointe</span>
                <p class="text-gray-600 font-body text-sm">Coordinatrice pedagogique experimentee, elle veille a la coherence des programmes et a la qualite de l'enseignement dans toutes les classes.</p>
            </div>

            {{-- Staff 3: Enseignante prescolaire --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-24 h-24 bg-yellow-200 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-2xl font-heading font-bold text-yellow-700">KF</span>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-1">Khady Fall</h3>
                <span class="inline-block text-yellow-600 font-body text-sm font-semibold mb-3">Educatrice Prescolaire</span>
                <p class="text-gray-600 font-body text-sm">Specialiste de la petite enfance, elle accompagne avec douceur les tout-petits dans leurs premieres decouvertes et apprentissages.</p>
            </div>

            {{-- Staff 4: Enseignante prescolaire --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-24 h-24 bg-green-200 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-2xl font-heading font-bold text-green-700">MS</span>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-1">Mariama Sow</h3>
                <span class="inline-block text-green-600 font-body text-sm font-semibold mb-3">Educatrice Prescolaire</span>
                <p class="text-gray-600 font-body text-sm">Passionnee par l'eveil des jeunes enfants, elle utilise des methodes creatives et ludiques pour stimuler la curiosite naturelle de chaque eleve.</p>
            </div>

            {{-- Staff 5: Enseignant elementaire --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-24 h-24 bg-orange-200 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-2xl font-heading font-bold text-orange-700">IB</span>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-1">Ibrahima Ba</h3>
                <span class="inline-block text-orange-600 font-body text-sm font-semibold mb-3">Enseignant Elementaire</span>
                <p class="text-gray-600 font-body text-sm">Pedagogue rigoureux et bienveillant, il assure un enseignement de qualite en francais et en mathematiques au cycle elementaire.</p>
            </div>

            {{-- Staff 6: Enseignante elementaire --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-24 h-24 bg-purple-200 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-2xl font-heading font-bold text-purple-700">ND</span>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-1">Ndeye Diagne</h3>
                <span class="inline-block text-purple-600 font-body text-sm font-semibold mb-3">Enseignante Elementaire</span>
                <p class="text-gray-600 font-body text-sm">Enseignante devouee, elle prepare avec methode et enthousiasme les eleves du CM aux examens de fin de cycle et a l'entree au college.</p>
            </div>

            {{-- Staff 7: Surveillant --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-24 h-24 bg-teal-200 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-2xl font-heading font-bold text-teal-700">OG</span>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-1">Ousmane Gueye</h3>
                <span class="inline-block text-teal-600 font-body text-sm font-semibold mb-3">Surveillant General</span>
                <p class="text-gray-600 font-body text-sm">Garant de la discipline et de la securite, il veille au bon deroulement de la vie scolaire et au respect des regles de vie en communaute.</p>
            </div>

            {{-- Staff 8: Responsable cantine --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                <div class="w-24 h-24 bg-rose-200 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-2xl font-heading font-bold text-rose-700">AS</span>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-1">Awa Seck</h3>
                <span class="inline-block text-rose-600 font-body text-sm font-semibold mb-3">Responsable Cantine</span>
                <p class="text-gray-600 font-body text-sm">Elle prepare chaque jour des repas equilibres et savoureux, adaptes aux besoins nutritionnels des enfants, avec des ingredients frais et locaux.</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 6. NOS INFRASTRUCTURES --}}
{{-- ============================================================== --}}
<section class="py-20 bg-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="inline-block bg-orange-100 text-orange-700 font-heading font-semibold text-sm px-4 py-2 rounded-full mb-4">Nos installations</span>
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                Nos <span class="text-primary-800">Infrastructures</span>
            </h2>
            <p class="text-gray-600 font-body max-w-2xl mx-auto">
                Des espaces modernes et adaptes pour offrir a vos enfants les meilleures conditions d'apprentissage et d'epanouissement.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 animate-on-scroll">
            {{-- Facility 1: Salles de classe climatisees --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-sky-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-heading font-bold text-gray-900 mb-2">Salles de classe climatisees</h3>
                        <p class="text-gray-600 font-body text-sm">Des salles spacieuses, lumineuses et climatisees, equipees de mobilier adapte a chaque tranche d'age pour un confort optimal.</p>
                    </div>
                </div>
            </div>

            {{-- Facility 2: Cour de recreation --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-heading font-bold text-gray-900 mb-2">Cour de recreation</h3>
                        <p class="text-gray-600 font-body text-sm">Un large espace exterieur securise avec jeux et equipements adaptes, pour que les enfants se depensent et socialisent en toute securite.</p>
                    </div>
                </div>
            </div>

            {{-- Facility 3: Cantine scolaire --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-heading font-bold text-gray-900 mb-2">Cantine scolaire</h3>
                        <p class="text-gray-600 font-body text-sm">Des repas equilibres et savoureux prepares sur place chaque jour, avec des menus varies adaptes aux besoins nutritionnels des enfants.</p>
                    </div>
                </div>
            </div>

            {{-- Facility 4: Bibliotheque --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-heading font-bold text-gray-900 mb-2">Bibliotheque</h3>
                        <p class="text-gray-600 font-body text-sm">Un espace de lecture accueillant avec une collection variee de livres en francais et en arabe, pour cultiver le gout de la lecture des le plus jeune age.</p>
                    </div>
                </div>
            </div>

            {{-- Facility 5: Salle informatique --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-pink-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-heading font-bold text-gray-900 mb-2">Salle informatique</h3>
                        <p class="text-gray-600 font-body text-sm">Des ordinateurs mis a disposition des eleves pour une initiation au numerique et aux outils informatiques des le cycle elementaire.</p>
                    </div>
                </div>
            </div>

            {{-- Facility 6: Transport scolaire --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8m-8 4h4m-2 6h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-heading font-bold text-gray-900 mb-2">Transport scolaire</h3>
                        <p class="text-gray-600 font-body text-sm">Un service de transport scolaire couvrant plusieurs zones de Guediawaye et environs, pour faciliter les trajets quotidiens des familles.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 7. CTA --}}
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
            Venez nous rendre visite
        </h2>
        <p class="text-white/80 font-body max-w-2xl mx-auto mb-8 text-lg">
            Nous serions ravis de vous accueillir et de vous faire decouvrir notre ecole. Prenez rendez-vous pour une visite guidee et rencontrez notre equipe pedagogique.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-white text-primary-800 font-heading font-bold px-10 py-4 rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Nous contacter
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="https://wa.me/221771486502" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 border-2 border-white text-white font-heading font-bold px-10 py-4 rounded-full hover:bg-white hover:text-primary-800 transition-all duration-300">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection
