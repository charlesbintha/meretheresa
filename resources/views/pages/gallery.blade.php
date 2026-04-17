@extends('layouts.app')

@section('title', 'Galerie')

@section('content')

{{-- ============================================================== --}}
{{-- HERO BANNER --}}
{{-- ============================================================== --}}
<section class="bg-primary-800 py-20 relative overflow-hidden">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute top-8 right-16 w-12 h-12 text-white/10 animate-float" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
        <svg class="absolute bottom-6 left-12 w-10 h-10 text-white/10 animate-float" style="animation-delay: 1.5s;" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/></svg>
        <svg class="absolute top-1/2 left-1/3 w-8 h-8 text-white/10 animate-float" style="animation-delay: 2.5s;" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center animate-on-scroll">
        <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-4">Galerie Photos</h1>
        <nav class="flex items-center justify-center gap-2 text-white/70 font-body text-sm" aria-label="Fil d'Ariane">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Accueil</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
            <span class="text-white font-semibold">Galerie</span>
        </nav>
    </div>
</section>

{{-- ============================================================== --}}
{{-- FILTER TABS --}}
{{-- ============================================================== --}}
<section class="py-8 bg-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-center gap-3 animate-on-scroll">
            <button type="button" class="gallery-filter-btn px-6 py-2.5 rounded-full font-heading font-semibold text-sm transition-all duration-300 bg-primary-800 text-white shadow-md" data-filter="all">
                Toutes
            </button>
            <button type="button" class="gallery-filter-btn px-6 py-2.5 rounded-full font-heading font-semibold text-sm transition-all duration-300 bg-white text-gray-700 hover:bg-primary-800 hover:text-white shadow-sm" data-filter="classes">
                Classes
            </button>
            <button type="button" class="gallery-filter-btn px-6 py-2.5 rounded-full font-heading font-semibold text-sm transition-all duration-300 bg-white text-gray-700 hover:bg-primary-800 hover:text-white shadow-sm" data-filter="activites">
                Activites
            </button>
            <button type="button" class="gallery-filter-btn px-6 py-2.5 rounded-full font-heading font-semibold text-sm transition-all duration-300 bg-white text-gray-700 hover:bg-primary-800 hover:text-white shadow-sm" data-filter="evenements">
                Evenements
            </button>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- GALLERY GRID --}}
{{-- ============================================================== --}}
<section class="py-12 bg-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="gallery-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 animate-on-scroll">

            {{-- Image 1 --}}
            <div class="gallery-item card rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group" data-category="classes" data-lightbox="{{ asset('images/7.jpg') }}">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/7.jpg') }}" alt="Eleve souriant en classe" class="w-full h-48 md:h-56 object-cover hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/30 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/></svg>
                    </div>
                </div>
                <div class="p-3 bg-white">
                    <p class="text-sm font-body text-gray-700 text-center">Nos eleves en classe</p>
                </div>
            </div>

            {{-- Image 2 --}}
            <div class="gallery-item card rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group" data-category="classes" data-lightbox="{{ asset('images/2148892522.jpg') }}">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/2148892522.jpg') }}" alt="Enfants en train d'etudier" class="w-full h-48 md:h-56 object-cover hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/30 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/></svg>
                    </div>
                </div>
                <div class="p-3 bg-white">
                    <p class="text-sm font-body text-gray-700 text-center">Seance d'apprentissage</p>
                </div>
            </div>

            {{-- Image 3 --}}
            <div class="gallery-item card rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group" data-category="activites" data-lightbox="{{ asset('images/1226.jpg') }}">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/1226.jpg') }}" alt="Fille avec sac a dos au tableau" class="w-full h-48 md:h-56 object-cover hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/30 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/></svg>
                    </div>
                </div>
                <div class="p-3 bg-white">
                    <p class="text-sm font-body text-gray-700 text-center">Activite au tableau</p>
                </div>
            </div>

            {{-- Image 4 --}}
            <div class="gallery-item card rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group" data-category="classes" data-lightbox="{{ asset('images/10211.jpg') }}">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/10211.jpg') }}" alt="Fille ecrivant au tableau" class="w-full h-48 md:h-56 object-cover hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/30 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/></svg>
                    </div>
                </div>
                <div class="p-3 bg-white">
                    <p class="text-sm font-body text-gray-700 text-center">Exercice d'ecriture</p>
                </div>
            </div>

            {{-- Image 5 --}}
            <div class="gallery-item card rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group" data-category="activites" data-lightbox="{{ asset('images/81569.jpg') }}">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/81569.jpg') }}" alt="Garcon avec livres" class="w-full h-48 md:h-56 object-cover hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/30 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/></svg>
                    </div>
                </div>
                <div class="p-3 bg-white">
                    <p class="text-sm font-body text-gray-700 text-center">Lecture et decouverte</p>
                </div>
            </div>

            {{-- Image 6 --}}
            <div class="gallery-item card rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group" data-category="evenements" data-lightbox="{{ asset('images/72276.jpg') }}">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/72276.jpg') }}" alt="Eleve souriante avec livres" class="w-full h-48 md:h-56 object-cover hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/30 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/></svg>
                    </div>
                </div>
                <div class="p-3 bg-white">
                    <p class="text-sm font-body text-gray-700 text-center">Journee portes ouvertes</p>
                </div>
            </div>

            {{-- Image 7 --}}
            <div class="gallery-item card rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group" data-category="evenements" data-lightbox="{{ asset('images/275099.jpg') }}">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/275099.jpg') }}" alt="Garcon en uniforme" class="w-full h-48 md:h-56 object-cover hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/30 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/></svg>
                    </div>
                </div>
                <div class="p-3 bg-white">
                    <p class="text-sm font-body text-gray-700 text-center">Ceremonie de rentree</p>
                </div>
            </div>

            {{-- Image 8 --}}
            <div class="gallery-item card rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group" data-category="activites" data-lightbox="{{ asset('images/25620.jpg') }}">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/25620.jpg') }}" alt="Enfants avec sacs a dos en classe" class="w-full h-48 md:h-56 object-cover hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/30 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/></svg>
                    </div>
                </div>
                <div class="p-3 bg-white">
                    <p class="text-sm font-body text-gray-700 text-center">Sortie pedagogique</p>
                </div>
            </div>

            {{-- Image 9 --}}
            <div class="gallery-item card rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group" data-category="evenements" data-lightbox="{{ asset('images/8845.jpg') }}">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/8845.jpg') }}" alt="Salle de classe" class="w-full h-48 md:h-56 object-cover hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-primary-800/0 group-hover:bg-primary-800/30 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/></svg>
                    </div>
                </div>
                <div class="p-3 bg-white">
                    <p class="text-sm font-body text-gray-700 text-center">Nos salles de classe</p>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Gallery filtering
        const filterBtns = document.querySelectorAll('.gallery-filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');

        filterBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const filter = this.getAttribute('data-filter');

                // Update active button styles
                filterBtns.forEach(function (b) {
                    b.classList.remove('bg-primary-800', 'text-white', 'shadow-md');
                    b.classList.add('bg-white', 'text-gray-700', 'shadow-sm');
                });
                this.classList.remove('bg-white', 'text-gray-700', 'shadow-sm');
                this.classList.add('bg-primary-800', 'text-white', 'shadow-md');

                // Filter gallery items
                galleryItems.forEach(function (item) {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = '';
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.95)';
                        setTimeout(function () {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });

        // Lightbox integration
        const galleryLightboxItems = document.querySelectorAll('[data-lightbox]');
        galleryLightboxItems.forEach(function (item, index) {
            item.style.cursor = 'pointer';
            item.addEventListener('click', function () {
                var images = [];
                var visibleItems = document.querySelectorAll('.gallery-item[data-lightbox]');
                var clickedIndex = 0;
                var count = 0;
                visibleItems.forEach(function (vi) {
                    if (vi.style.display !== 'none') {
                        var img = vi.querySelector('img');
                        var caption = vi.querySelector('.p-3 p');
                        images.push({
                            src: vi.getAttribute('data-lightbox'),
                            alt: caption ? caption.textContent : (img ? img.alt : '')
                        });
                        if (vi === item) clickedIndex = count;
                        count++;
                    }
                });
                if (window.openLightbox) {
                    window.openLightbox(
                        this.getAttribute('data-lightbox'),
                        this.querySelector('.p-3 p') ? this.querySelector('.p-3 p').textContent : '',
                        clickedIndex,
                        images
                    );
                }
            });
        });
    });
</script>
@endpush
