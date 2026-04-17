@extends('layouts.app')

@section('title', 'Admissions')

@section('content')

{{-- ============================================================== --}}
{{-- 1. HERO BANNER --}}
{{-- ============================================================== --}}
<section class="relative bg-primary-800 py-20 overflow-hidden">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <svg class="absolute top-10 left-10 w-16 h-16 text-white/10 animate-float" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/>
        </svg>
        <svg class="absolute bottom-10 right-16 w-20 h-12 text-white/5 animate-float" style="animation-delay: 1.5s;" viewBox="0 0 64 32" fill="currentColor">
            <path d="M56 20a8 8 0 00-8-8 10 10 0 00-18-4 12 12 0 00-22 6 8 8 0 000 16h44a8 8 0 008-10z"/>
        </svg>
        <svg class="absolute top-1/2 right-1/4 w-8 h-8 text-white/10 animate-float" style="animation-delay: 2s;" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="12" cy="12" r="10"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="mb-6 animate-on-scroll" aria-label="Fil d'Ariane">
            <ol class="flex items-center gap-2 text-sm text-white/70">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Accueil</a>
                </li>
                <li>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </li>
                <li class="text-white font-semibold" aria-current="page">Admissions</li>
            </ol>
        </nav>

        <div class="text-center animate-on-scroll">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-heading font-bold text-white leading-tight mb-4">
                Admissions & Inscriptions
            </h1>
            <p class="text-xl md:text-2xl text-white/80 font-body">
                Annee Scolaire 2025/2026
            </p>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 2. PROCESSUS D'INSCRIPTION --}}
{{-- ============================================================== --}}
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="section-title font-heading font-bold text-3xl md:text-4xl text-gray-900 mb-4">
                Processus d'inscription
            </h2>
            <p class="text-lg text-gray-600 font-body max-w-2xl mx-auto">
                Suivez ces etapes simples pour inscrire votre enfant au Groupe Scolaire Mere Theresa.
            </p>
        </div>

        {{-- Steps Timeline --}}
        <div class="relative">
            {{-- Horizontal line (desktop) --}}
            <div class="hidden lg:block absolute top-16 left-0 right-0 h-0.5 bg-primary-200" aria-hidden="true"></div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-6">
                {{-- Step 1 --}}
                <div class="relative animate-on-scroll">
                    {{-- Vertical line (mobile) --}}
                    <div class="lg:hidden absolute left-6 top-12 bottom-0 w-0.5 bg-primary-200" aria-hidden="true"></div>

                    <div class="flex flex-col items-center text-center">
                        <div class="relative z-10 w-12 h-12 rounded-full bg-primary-800 text-white flex items-center justify-center font-heading font-bold text-lg shadow-lg mb-4">
                            1
                        </div>
                        <h3 class="font-heading font-semibold text-lg text-gray-900 mb-2">Prise de contact</h3>
                        <p class="text-sm text-gray-600 font-body leading-relaxed">
                            Rendez-nous visite a l'ecole ou appelez-nous pour decouvrir notre etablissement et poser vos questions.
                        </p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="relative animate-on-scroll">
                    <div class="lg:hidden absolute left-6 top-12 bottom-0 w-0.5 bg-primary-200" aria-hidden="true"></div>

                    <div class="flex flex-col items-center text-center">
                        <div class="relative z-10 w-12 h-12 rounded-full bg-primary-800 text-white flex items-center justify-center font-heading font-bold text-lg shadow-lg mb-4">
                            2
                        </div>
                        <h3 class="font-heading font-semibold text-lg text-gray-900 mb-2">Constitution du dossier</h3>
                        <p class="text-sm text-gray-600 font-body leading-relaxed">
                            Rassemblez les pieces requises pour completer le dossier d'inscription de votre enfant.
                        </p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="relative animate-on-scroll">
                    <div class="lg:hidden absolute left-6 top-12 bottom-0 w-0.5 bg-primary-200" aria-hidden="true"></div>

                    <div class="flex flex-col items-center text-center">
                        <div class="relative z-10 w-12 h-12 rounded-full bg-primary-800 text-white flex items-center justify-center font-heading font-bold text-lg shadow-lg mb-4">
                            3
                        </div>
                        <h3 class="font-heading font-semibold text-lg text-gray-900 mb-2">Test d'admissibilite</h3>
                        <p class="text-sm text-gray-600 font-body leading-relaxed">
                            Obligatoire pour les nouveaux eleves de l'elementaire. Le test a lieu apres les cours de vacances.
                        </p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="relative animate-on-scroll">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative z-10 w-12 h-12 rounded-full bg-primary-800 text-white flex items-center justify-center font-heading font-bold text-lg shadow-lg mb-4">
                            4
                        </div>
                        <h3 class="font-heading font-semibold text-lg text-gray-900 mb-2">Confirmation d'inscription</h3>
                        <p class="text-sm text-gray-600 font-body leading-relaxed">
                            Finalisez l'inscription en reglant les frais et en deposant le dossier complet au secretariat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 3. CALENDRIER D'INSCRIPTION --}}
{{-- ============================================================== --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="section-title font-heading font-bold text-3xl md:text-4xl text-gray-900 mb-4">
                Calendrier d'inscription
            </h2>
            <p class="text-lg text-gray-600 font-body max-w-2xl mx-auto">
                Les dates importantes a retenir pour l'annee scolaire 2025/2026.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">
            {{-- Card: Reinscriptions anciens --}}
            <div class="card bg-white rounded-2xl shadow-md p-6 border-l-4 border-primary-800 animate-on-scroll">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 w-10 h-10 rounded-full bg-primary-100 text-primary-800 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-gray-900 mb-1">Reinscriptions anciens eleves</h3>
                        <p class="text-sm text-gray-600 font-body">
                            <span class="font-semibold text-primary-800">18 juin - 31 juillet 2025</span><br>
                            puis <span class="font-semibold text-primary-800">25 aout - 30 septembre 2025</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Card: Cours de vacances --}}
            <div class="card bg-white rounded-2xl shadow-md p-6 border-l-4 border-secondary-500 animate-on-scroll">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 w-10 h-10 rounded-full bg-secondary-100 text-secondary-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-gray-900 mb-1">Cours de vacances</h3>
                        <p class="text-sm text-gray-600 font-body">
                            <span class="font-semibold">Obligatoires pour les nouveaux de l'elementaire</span><br>
                            <span class="font-semibold text-primary-800">25 aout - 19 septembre 2025</span><br>
                            Frais : <span class="font-semibold">10 000 FCFA</span><br>
                            Cloture inscription : <span class="font-semibold">29 aout 2025</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Card: Fermeture ecole --}}
            <div class="card bg-white rounded-2xl shadow-md p-6 border-l-4 border-red-400 animate-on-scroll">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-gray-900 mb-1">Fermeture de l'ecole</h3>
                        <p class="text-sm text-gray-600 font-body">
                            <span class="font-semibold text-red-600">01 - 25 aout 2025</span><br>
                            Pas de permanence durant cette periode.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Card: Date limite cantine/transport --}}
            <div class="card bg-white rounded-2xl shadow-md p-6 border-l-4 border-amber-400 animate-on-scroll">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 w-10 h-10 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-gray-900 mb-1">Date limite cantine / transport</h3>
                        <p class="text-sm text-gray-600 font-body">
                            <span class="font-semibold text-primary-800">14 novembre 2025</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Warning notices --}}
        <div class="max-w-5xl mx-auto mt-8 space-y-4 animate-on-scroll">
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-6 h-6 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
                <p class="text-sm text-amber-800 font-body font-semibold">
                    Passe le delai, aucune place ne sera consideree comme reservee.
                </p>
            </div>
            <div class="bg-primary-50 border border-primary-200 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-6 h-6 text-primary-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <p class="text-sm text-primary-900 font-body">
                    L'inscription effective d'un nouveau a l'elementaire n'est possible qu'apres les cours de vacances avec le test d'admissibilite.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 4. PIECES A FOURNIR --}}
{{-- ============================================================== --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="section-title font-heading font-bold text-3xl md:text-4xl text-gray-900 mb-4">
                Pieces a fournir
            </h2>
            <p class="text-lg text-gray-600 font-body max-w-2xl mx-auto">
                Documents necessaires selon le statut de l'eleve.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            {{-- Nouveaux eleves --}}
            <div class="card bg-white rounded-2xl shadow-md overflow-hidden animate-on-scroll">
                <div class="bg-primary-800 px-6 py-4">
                    <h3 class="font-heading font-bold text-xl text-white flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                        Nouveaux eleves
                    </h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-sm text-gray-700 font-body">
                            <svg class="w-5 h-5 text-primary-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            01 copie du carnet de vaccination mis a jour
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-700 font-body">
                            <svg class="w-5 h-5 text-primary-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            02 extraits de naissance ou bulletins de naissance (moins de 3 mois)
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-700 font-body">
                            <svg class="w-5 h-5 text-primary-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            04 photos d'identite
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-700 font-body">
                            <svg class="w-5 h-5 text-primary-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            01 certificat de scolarite
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-700 font-body">
                            <svg class="w-5 h-5 text-primary-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Le carnet de notes 2024-2025 (du CP au CM1)
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-700 font-body">
                            <svg class="w-5 h-5 text-primary-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Dispense d'age pour les enfants de moins de 6 ans sans prescolaire
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Anciens eleves --}}
            <div class="card bg-white rounded-2xl shadow-md overflow-hidden animate-on-scroll">
                <div class="bg-gray-800 px-6 py-4">
                    <h3 class="font-heading font-bold text-xl text-white flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Anciens eleves
                    </h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-sm text-gray-700 font-body">
                            <svg class="w-5 h-5 text-gray-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Etre en regle avec la comptabilite
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-700 font-body">
                            <svg class="w-5 h-5 text-gray-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            01 copie du carnet de vaccination mis a jour
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-700 font-body">
                            <svg class="w-5 h-5 text-gray-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            01 extrait de naissance (moins de 3 mois)
                        </li>
                    </ul>

                    {{-- Visual spacer to balance columns --}}
                    <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm text-gray-500 font-body flex items-center gap-2">
                            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                            Le dossier complet est a deposer au secretariat de l'ecole.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 5. FRAIS DE SCOLARITE --}}
{{-- ============================================================== --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="section-title font-heading font-bold text-3xl md:text-4xl text-gray-900 mb-4">
                Tarifs 2025/2026
            </h2>
        </div>

        {{-- Notes --}}
        <div class="max-w-4xl mx-auto mb-10 space-y-3 animate-on-scroll">
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-primary-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <p class="text-sm text-gray-700 font-body">
                    Les frais de scolarite sont annuels. Ils sont dus en entier quelle que soit la date d'inscription.
                </p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-primary-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <p class="text-sm text-gray-700 font-body">
                    Les frais de reinscription et d'inscription prennent en compte les frais generaux, les tenues et le mois d'octobre 2025. <span class="font-semibold text-red-600">Non remboursables.</span>
                </p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-primary-800 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <p class="text-sm text-gray-700 font-body">
                    Etudes dirigees obligatoires a partir de novembre a l'elementaire : <span class="font-semibold text-primary-800">2 500 FCFA/mois</span>.
                </p>
            </div>
        </div>

        {{-- Tuition Table --}}
        <div class="max-w-4xl mx-auto animate-on-scroll">
            <div class="overflow-x-auto rounded-2xl shadow-md">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-primary-800 text-white">
                            <th class="px-6 py-4 font-heading font-semibold text-sm uppercase tracking-wider">Classe</th>
                            <th class="px-6 py-4 font-heading font-semibold text-sm uppercase tracking-wider text-center">Inscription</th>
                            <th class="px-6 py-4 font-heading font-semibold text-sm uppercase tracking-wider text-center">Mensualite</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <tr class="hover:bg-primary-50/30 transition-colors">
                            <td class="px-6 py-4 font-body font-semibold text-gray-900">Garde</td>
                            <td class="px-6 py-4 font-body text-gray-700 text-center">39 000 FCFA</td>
                            <td class="px-6 py-4 font-body text-gray-700 text-center">13 000 FCFA</td>
                        </tr>
                        <tr class="hover:bg-primary-50/30 transition-colors bg-gray-50/50">
                            <td class="px-6 py-4 font-body font-semibold text-gray-900">PS & MS</td>
                            <td class="px-6 py-4 font-body text-gray-700 text-center">42 000 FCFA</td>
                            <td class="px-6 py-4 font-body text-gray-700 text-center">12 000 FCFA</td>
                        </tr>
                        <tr class="hover:bg-primary-50/30 transition-colors">
                            <td class="px-6 py-4 font-body font-semibold text-gray-900">GS</td>
                            <td class="px-6 py-4 font-body text-gray-700 text-center">57 000 FCFA</td>
                            <td class="px-6 py-4 font-body text-gray-700 text-center">13 000 FCFA</td>
                        </tr>
                        <tr class="hover:bg-primary-50/30 transition-colors bg-gray-50/50">
                            <td class="px-6 py-4 font-body font-semibold text-gray-900">CI au CM1</td>
                            <td class="px-6 py-4 font-body text-gray-700 text-center">59 000 FCFA</td>
                            <td class="px-6 py-4 font-body text-gray-700 text-center">17 500 FCFA</td>
                        </tr>
                        <tr class="hover:bg-primary-50/30 transition-colors">
                            <td class="px-6 py-4 font-body font-semibold text-gray-900">CM2</td>
                            <td class="px-6 py-4 font-body text-gray-700 text-center">65 000 FCFA</td>
                            <td class="px-6 py-4 font-body text-gray-700 text-center">18 500 FCFA</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 6. CANTINE ET TRANSPORT --}}
{{-- ============================================================== --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="section-title font-heading font-bold text-3xl md:text-4xl text-gray-900 mb-4">
                Cantine & Transport
            </h2>
            <p class="text-lg text-gray-600 font-body max-w-2xl mx-auto">
                Les frais de cantine et de transport sont payes a l'inscription et leurs mensualites sont dues en debut de chaque mois.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
            {{-- Cantine --}}
            <div class="animate-on-scroll">
                <div class="card bg-white rounded-2xl shadow-md overflow-hidden h-full">
                    <div class="bg-amber-600 px-6 py-4 flex items-center gap-3">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-1.5.75a3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0L3 16.5m15-3.379a48.474 48.474 0 0 0-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 0 1 3 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 0 1 6 13.12" />
                        </svg>
                        <h3 class="font-heading font-bold text-xl text-white">Cantine</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-amber-50 rounded-xl p-4 text-center">
                                <p class="text-xs text-amber-700 font-body uppercase tracking-wider mb-1">Inscription</p>
                                <p class="text-2xl font-heading font-bold text-gray-900">15 000</p>
                                <p class="text-xs text-gray-500 font-body">FCFA</p>
                            </div>
                            <div class="bg-amber-50 rounded-xl p-4 text-center">
                                <p class="text-xs text-amber-700 font-body uppercase tracking-wider mb-1">Mensualite</p>
                                <p class="text-2xl font-heading font-bold text-gray-900">12 000</p>
                                <p class="text-xs text-gray-500 font-body">FCFA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Transport --}}
            <div class="animate-on-scroll">
                <div class="card bg-white rounded-2xl shadow-md overflow-hidden h-full">
                    <div class="bg-sky-700 px-6 py-4 flex items-center gap-3">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H18.75m-7.5-3.375h3.375c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125H11.25m-5.625 0H3.375A1.125 1.125 0 0 1 2.25 14.25v-1.5c0-.621.504-1.125 1.125-1.125h2.25m0 0V9.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v2.25" />
                        </svg>
                        <h3 class="font-heading font-bold text-xl text-white">Transport</h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto rounded-xl">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="bg-sky-50 text-sky-800">
                                        <th class="px-3 py-2 font-heading font-semibold text-xs uppercase">Service</th>
                                        <th class="px-3 py-2 font-heading font-semibold text-xs uppercase text-center">Inscription</th>
                                        <th class="px-3 py-2 font-heading font-semibold text-xs uppercase text-center">Mensualite</th>
                                        <th class="px-3 py-2 font-heading font-semibold text-xs uppercase text-center">1 voyage</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr class="hover:bg-sky-50/50 transition-colors">
                                        <td class="px-3 py-2 font-body font-semibold text-gray-900">Zone 1</td>
                                        <td class="px-3 py-2 font-body text-gray-700 text-center">11 000</td>
                                        <td class="px-3 py-2 font-body text-gray-700 text-center">8 500</td>
                                        <td class="px-3 py-2 font-body text-gray-700 text-center">7 000</td>
                                    </tr>
                                    <tr class="hover:bg-sky-50/50 transition-colors bg-gray-50/50">
                                        <td class="px-3 py-2 font-body font-semibold text-gray-900">Zone 2</td>
                                        <td class="px-3 py-2 font-body text-gray-700 text-center">13 500</td>
                                        <td class="px-3 py-2 font-body text-gray-700 text-center">11 000</td>
                                        <td class="px-3 py-2 font-body text-gray-700 text-center">8 500</td>
                                    </tr>
                                    <tr class="hover:bg-sky-50/50 transition-colors">
                                        <td class="px-3 py-2 font-body font-semibold text-gray-900">Zone 3</td>
                                        <td class="px-3 py-2 font-body text-gray-700 text-center">15 500</td>
                                        <td class="px-3 py-2 font-body text-gray-700 text-center">13 000</td>
                                        <td class="px-3 py-2 font-body text-gray-700 text-center">10 000</td>
                                    </tr>
                                    <tr class="hover:bg-sky-50/50 transition-colors bg-gray-50/50">
                                        <td class="px-3 py-2 font-body font-semibold text-gray-900">Hors Zone</td>
                                        <td class="px-3 py-2 font-body text-gray-700 text-center">17 500</td>
                                        <td class="px-3 py-2 font-body text-gray-700 text-center">15 000</td>
                                        <td class="px-3 py-2 font-body text-gray-500 text-center">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-xs text-gray-500 font-body mt-3 text-right">Montants en FCFA</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Horaires transport --}}
        <div class="max-w-4xl mx-auto mt-10 animate-on-scroll">
            <div class="card bg-white rounded-2xl shadow-md p-6">
                <h3 class="font-heading font-bold text-lg text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-sky-700" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Horaires de transport
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-sky-50 rounded-xl p-4 text-center">
                        <p class="font-heading font-bold text-2xl text-sky-700 mb-1">8h</p>
                        <p class="text-sm text-gray-600 font-body">Aller pour tous les eleves</p>
                    </div>
                    <div class="bg-sky-50 rounded-xl p-4 text-center">
                        <p class="font-heading font-bold text-2xl text-sky-700 mb-1">13h</p>
                        <p class="text-sm text-gray-600 font-body">Prescolaire + elementaire le mercredi</p>
                    </div>
                    <div class="bg-sky-50 rounded-xl p-4 text-center">
                        <p class="font-heading font-bold text-2xl text-sky-700 mb-1">17h</p>
                        <p class="text-sm text-gray-600 font-body">Retour elementaire + prescolaire inscrits cantine</p>
                    </div>
                </div>
                <div class="mt-4 bg-amber-50 border border-amber-200 rounded-xl p-3 flex items-start gap-2">
                    <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <p class="text-sm text-amber-800 font-body">
                        Les eleves du prescolaire inscrits a la cantine et au transport prennent le car de 17h.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 7. FAQ --}}
{{-- ============================================================== --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="section-title font-heading font-bold text-3xl md:text-4xl text-gray-900 mb-4">
                Questions frequentes
            </h2>
            <p class="text-lg text-gray-600 font-body max-w-2xl mx-auto">
                Retrouvez les reponses aux questions les plus posees par les parents.
            </p>
        </div>

        <div class="max-w-3xl mx-auto space-y-4 animate-on-scroll">
            {{-- FAQ 1 --}}
            <details class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <summary class="flex items-center justify-between px-6 py-5 cursor-pointer font-heading font-semibold text-gray-900 hover:text-primary-800 transition-colors list-none">
                    <span>A partir de quel age puis-je inscrire mon enfant ?</span>
                    <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform duration-300 shrink-0 ml-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </summary>
                <div class="px-6 pb-5 text-sm text-gray-600 font-body leading-relaxed">
                    La garde accueille les enfants a partir de 6 mois. Le prescolaire (Petite Section) accueille les enfants a partir de 3 ans. Pour l'elementaire, les enfants de moins de 6 ans sans prescolaire doivent fournir une dispense d'age.
                </div>
            </details>

            {{-- FAQ 2 --}}
            <details class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <summary class="flex items-center justify-between px-6 py-5 cursor-pointer font-heading font-semibold text-gray-900 hover:text-primary-800 transition-colors list-none">
                    <span>Le test d'admissibilite est-il obligatoire pour tous les nouveaux eleves ?</span>
                    <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform duration-300 shrink-0 ml-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </summary>
                <div class="px-6 pb-5 text-sm text-gray-600 font-body leading-relaxed">
                    Le test d'admissibilite est obligatoire uniquement pour les nouveaux eleves de l'elementaire. Il a lieu apres les cours de vacances (25 aout - 19 septembre 2025). Les inscriptions a la garde et au prescolaire ne necessitent pas de test.
                </div>
            </details>

            {{-- FAQ 3 --}}
            <details class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <summary class="flex items-center justify-between px-6 py-5 cursor-pointer font-heading font-semibold text-gray-900 hover:text-primary-800 transition-colors list-none">
                    <span>Les frais d'inscription sont-ils remboursables ?</span>
                    <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform duration-300 shrink-0 ml-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </summary>
                <div class="px-6 pb-5 text-sm text-gray-600 font-body leading-relaxed">
                    Non, les frais de reinscription et d'inscription ne sont pas remboursables. Ils prennent en compte les frais generaux, les tenues et le mois d'octobre 2025. Les frais de scolarite sont annuels et dus en entier quelle que soit la date d'inscription.
                </div>
            </details>

            {{-- FAQ 4 --}}
            <details class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <summary class="flex items-center justify-between px-6 py-5 cursor-pointer font-heading font-semibold text-gray-900 hover:text-primary-800 transition-colors list-none">
                    <span>Les cours de vacances sont-ils obligatoires ?</span>
                    <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform duration-300 shrink-0 ml-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </summary>
                <div class="px-6 pb-5 text-sm text-gray-600 font-body leading-relaxed">
                    Oui, les cours de vacances sont obligatoires pour les nouveaux eleves de l'elementaire. Ils se deroulent du 25 aout au 19 septembre 2025. Les frais s'elevent a 10 000 FCFA et la cloture des inscriptions est fixee au 29 aout 2025.
                </div>
            </details>

            {{-- FAQ 5 --}}
            <details class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <summary class="flex items-center justify-between px-6 py-5 cursor-pointer font-heading font-semibold text-gray-900 hover:text-primary-800 transition-colors list-none">
                    <span>Comment fonctionne le service de transport scolaire ?</span>
                    <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform duration-300 shrink-0 ml-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </summary>
                <div class="px-6 pb-5 text-sm text-gray-600 font-body leading-relaxed">
                    Le transport est organise en 3 zones avec une option hors zone. Le car de 8h assure l'aller pour tous les eleves. Le car de 13h est pour le prescolaire et l'elementaire le mercredi. Le car de 17h assure le retour de l'elementaire et des prescolaires inscrits a la cantine. L'inscription au service de transport doit etre faite avant le 14 novembre 2025.
                </div>
            </details>

            {{-- FAQ 6 --}}
            <details class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <summary class="flex items-center justify-between px-6 py-5 cursor-pointer font-heading font-semibold text-gray-900 hover:text-primary-800 transition-colors list-none">
                    <span>Que se passe-t-il si je depasse la date limite d'inscription ?</span>
                    <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform duration-300 shrink-0 ml-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </summary>
                <div class="px-6 pb-5 text-sm text-gray-600 font-body leading-relaxed">
                    Passe le delai, aucune place ne sera consideree comme reservee. Nous vous encourageons a respecter les dates limites pour garantir une place a votre enfant. Contactez-nous au plus vite si vous avez un empechement.
                </div>
            </details>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- 8. CTA --}}
{{-- ============================================================== --}}
<section class="py-16 bg-primary-800 relative overflow-hidden">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <svg class="absolute -top-6 -left-6 w-24 h-24 text-white/5 animate-float" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="12" cy="12" r="10"/>
        </svg>
        <svg class="absolute bottom-4 right-10 w-12 h-12 text-white/10 animate-float" style="animation-delay: 1s;" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/>
        </svg>
        <svg class="absolute top-1/2 left-1/3 w-8 h-8 text-white/5 animate-float" style="animation-delay: 2s;" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="12" cy="12" r="10"/>
        </svg>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 animate-on-scroll">
        <h2 class="font-heading font-bold text-3xl md:text-4xl text-white mb-4">
            Des questions ? Contactez-nous !
        </h2>
        <p class="text-lg text-white/80 font-body mb-6 max-w-2xl mx-auto">
            Notre equipe est a votre disposition pour vous accompagner dans le processus d'inscription de votre enfant.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="tel:+221338778162"
               class="inline-flex items-center gap-2 text-white/90 hover:text-white font-body text-lg transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>
                33 877 81 62 / 77 148 65 02
            </a>
            <a href="{{ route('contact') }}"
               class="btn-primary inline-flex items-center gap-2 bg-white text-primary-800 font-heading font-semibold px-8 py-4 rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Nous contacter
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@endsection
