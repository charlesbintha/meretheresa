@extends('layouts.app')

@section('title', 'Actualites')

@section('content')

{{-- ============================================================== --}}
{{-- HERO BANNER --}}
{{-- ============================================================== --}}
<section class="bg-primary-800 py-20 relative overflow-hidden">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute top-6 left-16 w-10 h-10 text-white/10 animate-float" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/></svg>
        <svg class="absolute bottom-10 right-20 w-14 h-14 text-white/10 animate-float" style="animation-delay: 1s;" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
        <svg class="absolute top-1/3 right-1/4 w-8 h-8 text-white/10 animate-float" style="animation-delay: 2s;" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/></svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center animate-on-scroll">
        <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-4">Actualites & Evenements</h1>
        <nav class="flex items-center justify-center gap-2 text-white/70 font-body text-sm" aria-label="Fil d'Ariane">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Accueil</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
            <span class="text-white font-semibold">Actualites</span>
        </nav>
    </div>
</section>

{{-- ============================================================== --}}
{{-- FEATURED ARTICLE --}}
{{-- ============================================================== --}}
<section class="py-12 bg-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="animate-on-scroll">
            <div class="card bg-white rounded-3xl shadow-lg overflow-hidden">
                <div class="grid lg:grid-cols-2 gap-0">
                    {{-- Image --}}
                    <div class="relative overflow-hidden h-64 lg:h-auto">
                        <img src="{{ asset('images/25620.jpg') }}" alt="Rentree scolaire 2025/2026" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="inline-block bg-primary-800 text-white text-xs font-heading font-bold px-4 py-1.5 rounded-full shadow-md">A la une</span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-8 lg:p-10 flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center gap-1.5 text-gray-500 font-body text-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                                1 Octobre 2025
                            </span>
                            <span class="inline-block bg-sky-100 text-sky-700 text-xs font-semibold px-3 py-1 rounded-full">Rentree</span>
                        </div>
                        <h2 class="section-title text-2xl md:text-3xl font-heading font-bold text-gray-900 mb-4">Rentree Scolaire 2025/2026</h2>
                        <p class="text-gray-600 font-body leading-relaxed mb-4">
                            Le Groupe Scolaire Mere Theresa est heureux d'annoncer la rentree scolaire 2025/2026. Cette nouvelle annee s'annonce riche en nouveautes avec l'ouverture de nouvelles salles de classe entierement equipees, l'introduction de programmes pedagogiques innovants et le renforcement de notre equipe enseignante.
                        </p>
                        <p class="text-gray-600 font-body leading-relaxed mb-6">
                            Nous accueillons les enfants de la garde au CM2 dans un cadre bienveillant et securise. Les inscriptions sont toujours ouvertes pour les places restantes. N'hesitez pas a nous contacter pour plus d'informations ou a venir visiter nos locaux.
                        </p>
                        <a href="#" class="btn-primary inline-flex items-center gap-2 bg-primary-800 text-white font-heading font-semibold px-6 py-3 rounded-full hover:bg-primary-900 transition-all duration-300 shadow-md hover:shadow-lg self-start">
                            Lire l'article complet
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- ARTICLES GRID --}}
{{-- ============================================================== --}}
<section class="py-16 bg-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="section-title text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">
                Dernieres <span class="text-primary-800">Actualites</span>
            </h2>
            <p class="text-gray-600 font-body max-w-2xl mx-auto">Suivez les evenements marquants et la vie quotidienne au sein de notre etablissement.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 animate-on-scroll">

            {{-- Article 1 --}}
            <article class="card bg-white rounded-3xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="relative overflow-hidden h-52">
                    <img src="{{ asset('images/8845.jpg') }}" alt="Journee portes ouvertes" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute top-4 left-4 bg-white rounded-xl px-3 py-1.5 shadow-sm">
                        <span class="text-sm font-heading font-bold text-primary-800">15 Nov 2025</span>
                    </div>
                </div>
                <div class="p-6">
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">Evenement</span>
                    <h3 class="text-lg font-heading font-bold text-gray-900 mb-2 group-hover:text-primary-800 transition-colors">Journee Portes Ouvertes</h3>
                    <p class="text-gray-600 font-body text-sm mb-4">Venez decouvrir notre ecole lors de notre journee portes ouvertes. Visitez nos locaux, rencontrez les enseignants et decouvrez nos programmes pedagogiques.</p>
                    <a href="#" class="inline-flex items-center text-primary-800 font-heading font-semibold text-sm hover:text-primary-900 transition-colors">
                        Lire la suite
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            {{-- Article 2 --}}
            <article class="card bg-white rounded-3xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="relative overflow-hidden h-52">
                    <img src="{{ asset('images/10211.jpg') }}" alt="Resultats examens" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute top-4 left-4 bg-white rounded-xl px-3 py-1.5 shadow-sm">
                        <span class="text-sm font-heading font-bold text-primary-800">20 Dec 2025</span>
                    </div>
                </div>
                <div class="p-6">
                    <span class="inline-block bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">Pedagogie</span>
                    <h3 class="text-lg font-heading font-bold text-gray-900 mb-2 group-hover:text-primary-800 transition-colors">Resultats des Examens du 1er Trimestre</h3>
                    <p class="text-gray-600 font-body text-sm mb-4">Felicitations a tous nos eleves pour leurs excellents resultats. Un taux de reussite remarquable qui temoigne de l'engagement de nos equipes.</p>
                    <a href="#" class="inline-flex items-center text-primary-800 font-heading font-semibold text-sm hover:text-primary-900 transition-colors">
                        Lire la suite
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            {{-- Article 3 --}}
            <article class="card bg-white rounded-3xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="relative overflow-hidden h-52">
                    <img src="{{ asset('images/72276.jpg') }}" alt="Sortie pedagogique" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute top-4 left-4 bg-white rounded-xl px-3 py-1.5 shadow-sm">
                        <span class="text-sm font-heading font-bold text-primary-800">10 Jan 2025</span>
                    </div>
                </div>
                <div class="p-6">
                    <span class="inline-block bg-sky-100 text-sky-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">Vie scolaire</span>
                    <h3 class="text-lg font-heading font-bold text-gray-900 mb-2 group-hover:text-primary-800 transition-colors">Sortie Pedagogique au Parc de Hann</h3>
                    <p class="text-gray-600 font-body text-sm mb-4">Nos eleves de CE1 et CE2 ont decouvert la faune et la flore senegalaise lors d'une sortie enrichissante au Parc zoologique de Hann.</p>
                    <a href="#" class="inline-flex items-center text-primary-800 font-heading font-semibold text-sm hover:text-primary-900 transition-colors">
                        Lire la suite
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            {{-- Article 4 --}}
            <article class="card bg-white rounded-3xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="relative overflow-hidden h-52">
                    <img src="{{ asset('images/275099.jpg') }}" alt="Fete culturelle" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute top-4 left-4 bg-white rounded-xl px-3 py-1.5 shadow-sm">
                        <span class="text-sm font-heading font-bold text-primary-800">14 Feb 2025</span>
                    </div>
                </div>
                <div class="p-6">
                    <span class="inline-block bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">Communaute</span>
                    <h3 class="text-lg font-heading font-bold text-gray-900 mb-2 group-hover:text-primary-800 transition-colors">Fete Culturelle et Artistique</h3>
                    <p class="text-gray-600 font-body text-sm mb-4">Une journee riche en couleurs ou nos eleves ont presente des danses traditionnelles, des chants et des oeuvres d'art realisees en classe.</p>
                    <a href="#" class="inline-flex items-center text-primary-800 font-heading font-semibold text-sm hover:text-primary-900 transition-colors">
                        Lire la suite
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            {{-- Article 5 --}}
            <article class="card bg-white rounded-3xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="relative overflow-hidden h-52">
                    <img src="{{ asset('images/7.jpg') }}" alt="Atelier parents-enseignants" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute top-4 left-4 bg-white rounded-xl px-3 py-1.5 shadow-sm">
                        <span class="text-sm font-heading font-bold text-primary-800">5 Mar 2025</span>
                    </div>
                </div>
                <div class="p-6">
                    <span class="inline-block bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">Pedagogie</span>
                    <h3 class="text-lg font-heading font-bold text-gray-900 mb-2 group-hover:text-primary-800 transition-colors">Atelier Parents-Enseignants</h3>
                    <p class="text-gray-600 font-body text-sm mb-4">Un moment d'echange privilegie entre les parents et notre equipe pedagogique pour discuter du suivi scolaire et du bien-etre des enfants.</p>
                    <a href="#" class="inline-flex items-center text-primary-800 font-heading font-semibold text-sm hover:text-primary-900 transition-colors">
                        Lire la suite
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            {{-- Article 6 --}}
            <article class="card bg-white rounded-3xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="relative overflow-hidden h-52">
                    <img src="{{ asset('images/81569.jpg') }}" alt="Competition sportive" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute top-4 left-4 bg-white rounded-xl px-3 py-1.5 shadow-sm">
                        <span class="text-sm font-heading font-bold text-primary-800">22 Avr 2025</span>
                    </div>
                </div>
                <div class="p-6">
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">Evenement</span>
                    <h3 class="text-lg font-heading font-bold text-gray-900 mb-2 group-hover:text-primary-800 transition-colors">Competition Sportive Inter-ecoles</h3>
                    <p class="text-gray-600 font-body text-sm mb-4">Nos eleves ont brillamment represente l'ecole lors de la competition sportive inter-ecoles de Guediawaye. Bravo a tous les participants !</p>
                    <a href="#" class="inline-flex items-center text-primary-800 font-heading font-semibold text-sm hover:text-primary-900 transition-colors">
                        Lire la suite
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- PAGINATION --}}
{{-- ============================================================== --}}
<section class="py-8 bg-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-center gap-4 animate-on-scroll">
            <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 rounded-full font-heading font-semibold text-sm text-gray-500 hover:text-primary-800 hover:border-primary-800 transition-all duration-300 shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                Precedent
            </a>
            <span class="text-sm font-body text-gray-500">Page 1 sur 3</span>
            <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-800 text-white rounded-full font-heading font-semibold text-sm hover:bg-primary-900 transition-all duration-300 shadow-md">
                Suivant
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- NEWSLETTER CTA --}}
{{-- ============================================================== --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center animate-on-scroll">
            <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-primary-800" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                </svg>
            </div>
            <h2 class="section-title text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-4">Restez informes</h2>
            <p class="text-gray-600 font-body mb-8">Inscrivez-vous a notre newsletter pour recevoir les dernieres actualites de l'ecole, les evenements a venir et les informations importantes directement dans votre boite mail.</p>

            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                @csrf
                <label for="newsletter-email-news" class="sr-only">Adresse email</label>
                <input
                    type="email"
                    id="newsletter-email-news"
                    name="email"
                    required
                    placeholder="Votre adresse email"
                    class="flex-1 px-5 py-3.5 rounded-full border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none shadow-sm"
                >
                <button type="submit" class="btn-primary bg-primary-800 text-white font-heading font-bold px-8 py-3.5 rounded-full hover:bg-primary-900 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/></svg>
                    S'inscrire
                </button>
            </form>
        </div>
    </div>
</section>

@endsection
