<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ==========================================================
         SEO META
         Pages définissent @section('title') et @section('description').
         Les balises OG / Twitter / canonical en dérivent automatiquement.
    ========================================================== --}}
    @php
        // Laravel's short-form @section('name', 'value') escapes the value once via e().
        // We decode so {{ }} re-escapes exactly once — avoids &amp;amp; and similar.
        $decode = fn ($v) => html_entity_decode(trim((string) $v), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $metaSiteName = 'Groupe Scolaire Mère Thérèsa';
        $metaTagline = 'École Les Bambinos · Guédiawaye';
        $metaTitlePage = $decode($__env->yieldContent('title'));
        $metaFullTitle = $metaTitlePage !== ''
            ? $metaTitlePage . ' — ' . $metaSiteName
            : $metaSiteName . ' — ' . $metaTagline;
        $metaDescription = $decode($__env->yieldContent('description'))
            ?: "École privée à Guédiawaye, Sénégal. Accueil des enfants de 2 à 11 ans : Garde, Préscolaire et Élémentaire. Inscriptions 2025-2026 ouvertes.";
        $metaImage = $decode($__env->yieldContent('og_image')) ?: asset('images/logo.png');
        $metaUrl = url()->current();
    @endphp

    <title>{{ $metaFullTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $metaUrl }}">
    <meta name="robots" content="index, follow">
    <meta name="author" content="{{ $metaSiteName }}">

    {{-- Open Graph (Facebook, WhatsApp, LinkedIn) --}}
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:site_name" content="{{ $metaSiteName }}">
    <meta property="og:url" content="{{ $metaUrl }}">
    <meta property="og:title" content="{{ $metaFullTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:image:alt" content="Logo {{ $metaSiteName }}">

    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaFullTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">

    {{-- Theme color (mobile browser chrome) --}}
    <meta name="theme-color" content="#1F2A5E">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Nunito:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" href="/images/logo.png" type="image/png">
    <link rel="apple-touch-icon" href="/images/logo.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-body text-dark bg-cream antialiased min-h-screen flex flex-col">

    {{-- ============================================================
         A. TOP BAR
    ============================================================= --}}
    <div class="bg-primary-950 text-white/90 text-sm hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-10">
                {{-- Left: Contact Info --}}
                <div class="flex items-center gap-6">
                    {{-- Phone --}}
                    <a href="tel:+221338778162" class="flex items-center gap-1.5 hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                        <span>33 877 81 62 / 77 148 65 02</span>
                    </a>
                    {{-- Email --}}
                    <a href="mailto:gardebambinos@gmail.com" class="flex items-center gap-1.5 hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <span>gardebambinos@gmail.com</span>
                    </a>
                    {{-- Hours --}}
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Lun-Ven: 7h30-17h30</span>
                    </span>
                </div>

                {{-- Right: Social Icons --}}
                <div class="flex items-center gap-3">
                    <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Suivez-nous sur Facebook" class="hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                    </a>
                    <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Suivez-nous sur Instagram" class="hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 0 1 1.772 1.153 4.902 4.902 0 0 1 1.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 0 1-1.153 1.772 4.902 4.902 0 0 1-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 0 1-1.772-1.153 4.902 4.902 0 0 1-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 0 1 1.153-1.772A4.902 4.902 0 0 1 5.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63Zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 0 0-.748-1.15 3.098 3.098 0 0 0-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058ZM12 6.865a5.135 5.135 0 1 1 0 10.27 5.135 5.135 0 0 1 0-10.27Zm0 1.802a3.333 3.333 0 1 0 0 6.666 3.333 3.333 0 0 0 0-6.666Zm5.338-3.205a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4Z"/>
                        </svg>
                    </a>
                    <a href="https://wa.me/221771486502" target="_blank" rel="noopener noreferrer" aria-label="Contactez-nous sur WhatsApp" class="hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         B. STICKY HEADER
    ============================================================= --}}
    <header id="main-header" class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm transition-shadow duration-300">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-label="Navigation principale">
            <div class="flex items-center justify-between h-16 lg:h-20">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0" aria-label="Accueil - Groupe Scolaire Mere Theresa">
                    <img
                        src="/images/logo.png"
                        alt="Logo Groupe Scolaire Mere Theresa"
                        class="h-10 lg:h-14 w-auto"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >
                    <span class="hidden items-center gap-2 font-heading font-bold text-primary-900 text-lg leading-tight" aria-hidden="true">
                        <span>Groupe Scolaire<br>Mere Theresa</span>
                    </span>
                    <span class="font-heading font-bold text-primary-900 text-sm lg:text-base leading-tight hidden sm:block">
                        Groupe Scolaire<br>Mere Theresa
                    </span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                       class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('home') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                        Accueil
                    </a>
                    <a href="{{ route('about') }}"
                       class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('about') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                        A propos
                    </a>
                    <a href="{{ route('programmes') }}"
                       class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('programmes*') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                        Programmes
                    </a>
                    <a href="{{ route('admissions') }}"
                       class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('admissions') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                        Admissions
                    </a>
                    <a href="{{ route('gallery') }}"
                       class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('gallery') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                        Galerie
                    </a>
                    <a href="{{ route('news') }}"
                       class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('news*') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                        Actualites
                    </a>
                    <a href="{{ route('contact') }}"
                       class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('contact') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                        Contact
                    </a>
                </div>

                {{-- CTA Button (Desktop) --}}
                <a href="{{ route('admissions') }}"
                   class="hidden lg:inline-flex items-center gap-2 px-5 py-2.5 bg-primary-800 hover:bg-primary-900 text-white font-heading font-semibold text-sm rounded-full shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" />
                    </svg>
                    Inscription
                </a>

                {{-- Mobile Menu Button --}}
                <button
                    type="button"
                    id="mobile-menu-button"
                    class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-primary-800 hover:bg-primary-50 transition-colors"
                    aria-expanded="false"
                    aria-controls="mobile-menu-drawer"
                    aria-label="Ouvrir le menu de navigation"
                >
                    <svg id="menu-icon-open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg id="menu-icon-close" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    {{-- ============================================================
         MOBILE MENU — MUST BE OUTSIDE <header> because the header's
         backdrop-blur-md creates a containing block that traps
         position: fixed children (menu becomes invisible/cropped).
    ============================================================= --}}

    {{-- Mobile Menu Overlay --}}
    <div
        id="mobile-menu-overlay"
        class="fixed inset-0 bg-black/50 z-[60] opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"
        aria-hidden="true"
    ></div>

    {{-- Mobile Menu Drawer --}}
    <div
        id="mobile-menu-drawer"
        class="fixed top-0 right-0 h-full w-full sm:w-96 bg-white z-[70] shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out lg:hidden overflow-y-auto"
        role="dialog"
        aria-modal="true"
        aria-label="Menu de navigation mobile"
    >
            {{-- Drawer Header --}}
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="/images/logo.png" alt="Logo" class="h-8 w-auto">
                    <span class="font-heading font-bold text-primary-900 text-sm leading-tight">Mere Theresa</span>
                </a>
                <button
                    type="button"
                    id="mobile-menu-close"
                    class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors"
                    aria-label="Fermer le menu"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Drawer Nav Links --}}
            <nav class="p-4 space-y-1" aria-label="Navigation mobile">
                <a href="{{ route('home') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold transition-colors {{ request()->routeIs('home') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                    Accueil
                </a>
                <a href="{{ route('about') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold transition-colors {{ request()->routeIs('about') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
                    A propos
                </a>
                <a href="{{ route('programmes') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold transition-colors {{ request()->routeIs('programmes*') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
                    Programmes
                </a>
                <a href="{{ route('admissions') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold transition-colors {{ request()->routeIs('admissions') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" /></svg>
                    Admissions
                </a>
                <a href="{{ route('gallery') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold transition-colors {{ request()->routeIs('gallery') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm12.75-11.25h.008v.008h-.008V6.75Z" /></svg>
                    Galerie
                </a>
                <a href="{{ route('news') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold transition-colors {{ request()->routeIs('news*') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5" /></svg>
                    Actualites
                </a>
                <a href="{{ route('contact') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold transition-colors {{ request()->routeIs('contact') ? 'text-primary-800 bg-primary-50' : 'text-dark/80 hover:text-primary-800 hover:bg-primary-50/50' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                    Contact
                </a>
            </nav>

            {{-- Drawer CTA --}}
            <div class="p-4 border-t border-gray-100">
                <a href="{{ route('admissions') }}"
                   class="flex items-center justify-center gap-2 w-full px-5 py-3 bg-primary-800 hover:bg-primary-900 text-white font-heading font-semibold rounded-xl shadow-md transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" />
                    </svg>
                    Inscription
                </a>
            </div>

            {{-- Drawer Contact Info --}}
            <div class="p-4 border-t border-gray-100 space-y-3 text-sm text-dark/70">
                <a href="tel:+221338778162" class="flex items-center gap-2 hover:text-primary-800 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                    33 877 81 62 / 77 148 65 02
                </a>
                <a href="mailto:gardebambinos@gmail.com" class="flex items-center gap-2 hover:text-primary-800 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                    gardebambinos@gmail.com
                </a>
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    Lun-Ven: 7h30-17h30
                </p>
            </div>
        </div>

    {{-- ============================================================
         E. SVG DECORATIVE ELEMENTS (reusable floating shapes)
    ============================================================= --}}
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden" aria-hidden="true">
        {{-- Cloud 1 --}}
        <svg class="absolute top-20 -left-10 w-40 h-24 text-accent-blue/10 animate-float-slow" viewBox="0 0 200 120" fill="currentColor">
            <path d="M160 70c0-22.1-17.9-40-40-40-16.5 0-30.7 10-36.7 24.3C78.6 48.1 71.6 44 64 44c-13.3 0-24 10.7-24 24-.5 0-1 0-1.5.1C25.4 69.3 16 79.5 16 92c0 13.3 10.7 24 24 24h120c13.3 0 24-10.7 24-24 0-12-8.8-21.9-20.3-23.7.2-1.5.3-3 .3-4.6V70Z"/>
        </svg>

        {{-- Cloud 2 --}}
        <svg class="absolute top-40 right-10 w-32 h-20 text-accent-pink/10 animate-float" viewBox="0 0 200 120" fill="currentColor">
            <path d="M160 70c0-22.1-17.9-40-40-40-16.5 0-30.7 10-36.7 24.3C78.6 48.1 71.6 44 64 44c-13.3 0-24 10.7-24 24-.5 0-1 0-1.5.1C25.4 69.3 16 79.5 16 92c0 13.3 10.7 24 24 24h120c13.3 0 24-10.7 24-24 0-12-8.8-21.9-20.3-23.7.2-1.5.3-3 .3-4.6V70Z"/>
        </svg>

        {{-- Star 1 --}}
        <svg class="absolute top-1/3 left-[15%] w-8 h-8 text-secondary-300/20 animate-bounce-gentle" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>

        {{-- Star 2 --}}
        <svg class="absolute top-2/3 right-[10%] w-6 h-6 text-secondary-400/15 animate-float-delay" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>

        {{-- Circle 1 --}}
        <svg class="absolute bottom-1/4 left-[5%] w-16 h-16 text-accent-lavender/15 animate-float-slow" viewBox="0 0 100 100" fill="currentColor">
            <circle cx="50" cy="50" r="50"/>
        </svg>

        {{-- Circle 2 --}}
        <svg class="absolute top-1/2 right-[20%] w-10 h-10 text-accent-mint/15 animate-float" viewBox="0 0 100 100" fill="currentColor">
            <circle cx="50" cy="50" r="50"/>
        </svg>

        {{-- Small Circle 3 --}}
        <svg class="absolute bottom-1/3 right-[35%] w-5 h-5 text-accent-peach/20 animate-bounce-gentle" viewBox="0 0 100 100" fill="currentColor">
            <circle cx="50" cy="50" r="50"/>
        </svg>
    </div>

    {{-- ============================================================
         MAIN CONTENT
    ============================================================= --}}
    <main id="main-content" class="flex-grow relative z-10">
        @yield('content')
    </main>

    {{-- ============================================================
         D. LIGHTBOX (hidden, for gallery images)
    ============================================================= --}}
    <div
        id="lightbox"
        class="fixed inset-0 z-[100] bg-black/90 backdrop-blur-sm hidden items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
        aria-label="Visionneuse d'images"
        tabindex="-1"
    >
        {{-- Close Button --}}
        <button
            type="button"
            id="lightbox-close"
            class="absolute top-4 right-4 p-2 text-white/80 hover:text-white bg-white/10 hover:bg-white/20 rounded-full transition-colors z-10"
            aria-label="Fermer la visionneuse"
        >
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Previous Button --}}
        <button
            type="button"
            id="lightbox-prev"
            class="absolute left-4 top-1/2 -translate-y-1/2 p-2 text-white/80 hover:text-white bg-white/10 hover:bg-white/20 rounded-full transition-colors z-10"
            aria-label="Image precedente"
        >
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </button>

        {{-- Next Button --}}
        <button
            type="button"
            id="lightbox-next"
            class="absolute right-4 top-1/2 -translate-y-1/2 p-2 text-white/80 hover:text-white bg-white/10 hover:bg-white/20 rounded-full transition-colors z-10"
            aria-label="Image suivante"
        >
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </button>

        {{-- Image Container --}}
        <figure class="max-w-5xl max-h-[90vh] flex flex-col items-center">
            <img
                id="lightbox-image"
                src=""
                alt=""
                class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl"
            >
            <figcaption id="lightbox-caption" class="mt-4 text-white/90 text-center text-sm font-body max-w-lg"></figcaption>
        </figure>

        {{-- Image Counter --}}
        <div id="lightbox-counter" class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white/60 text-sm font-body"></div>
    </div>

    {{-- ============================================================
         C. FOOTER
    ============================================================= --}}
    <footer class="bg-primary-950 text-white/80 relative z-10">
        {{-- Footer Main --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">

                {{-- Column 1: Logo, Description, Social --}}
                <div class="sm:col-span-2 lg:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-4">
                        <img src="/images/logo.png" alt="Logo Groupe Scolaire Mere Theresa" class="h-12 w-auto brightness-200">
                        <span class="font-heading font-bold text-white text-lg leading-tight">
                            Groupe Scolaire<br>Mere Theresa
                        </span>
                    </a>
                    <p class="text-white/60 text-sm leading-relaxed mb-6">
                        Un environnement chaleureux et stimulant ou chaque enfant s'epanouit, apprend et grandit avec confiance. Ecole privee Les Bambinos au coeur de Guediawaye.
                    </p>
                    {{-- Social Links --}}
                    <div class="flex items-center gap-3">
                        <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="w-9 h-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-primary-700 text-white/70 hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>
                        <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="w-9 h-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-primary-700 text-white/70 hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 0 1 1.772 1.153 4.902 4.902 0 0 1 1.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 0 1-1.153 1.772 4.902 4.902 0 0 1-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 0 1-1.772-1.153 4.902 4.902 0 0 1-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 0 1 1.153-1.772A4.902 4.902 0 0 1 5.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63Zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 0 0-.748-1.15 3.098 3.098 0 0 0-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058ZM12 6.865a5.135 5.135 0 1 1 0 10.27 5.135 5.135 0 0 1 0-10.27Zm0 1.802a3.333 3.333 0 1 0 0 6.666 3.333 3.333 0 0 0 0-6.666Zm5.338-3.205a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4Z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/221771486502" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" class="w-9 h-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-green-600 text-white/70 hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Column 2: Quick Links --}}
                <div>
                    <h3 class="font-heading font-semibold text-white text-lg mb-4">Liens rapides</h3>
                    <ul class="space-y-2.5">
                        <li>
                            <a href="{{ route('home') }}" class="text-sm hover:text-white hover:pl-1 transition-all duration-200">Accueil</a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="text-sm hover:text-white hover:pl-1 transition-all duration-200">A propos de nous</a>
                        </li>
                        <li>
                            <a href="{{ route('admissions') }}" class="text-sm hover:text-white hover:pl-1 transition-all duration-200">Admissions</a>
                        </li>
                        <li>
                            <a href="{{ route('gallery') }}" class="text-sm hover:text-white hover:pl-1 transition-all duration-200">Galerie photos</a>
                        </li>
                        <li>
                            <a href="{{ route('news') }}" class="text-sm hover:text-white hover:pl-1 transition-all duration-200">Actualites</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="text-sm hover:text-white hover:pl-1 transition-all duration-200">Contact</a>
                        </li>
                    </ul>
                </div>

                {{-- Column 3: Programs --}}
                <div>
                    <h3 class="font-heading font-semibold text-white text-lg mb-4">Nos programmes</h3>
                    <ul class="space-y-2.5">
                        <li>
                            <a href="{{ route('programmes') }}" class="text-sm hover:text-white hover:pl-1 transition-all duration-200 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-accent-peach shrink-0"></span>
                                Garde (2 ans - 3 ans)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('programmes') }}" class="text-sm hover:text-white hover:pl-1 transition-all duration-200 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-accent-mint shrink-0"></span>
                                Prescolaire (3 - 5 ans)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('programmes') }}" class="text-sm hover:text-white hover:pl-1 transition-all duration-200 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-accent-blue shrink-0"></span>
                                Elementaire (6 - 12 ans)
                            </a>
                        </li>
                    </ul>
                    {{-- Decorative element --}}
                    <div class="mt-6 flex gap-2">
                        <span class="w-3 h-3 rounded-full bg-accent-pink/30"></span>
                        <span class="w-3 h-3 rounded-full bg-accent-mint/30"></span>
                        <span class="w-3 h-3 rounded-full bg-accent-blue/30"></span>
                        <span class="w-3 h-3 rounded-full bg-secondary-300/30"></span>
                    </div>
                </div>

                {{-- Column 4: Contact + Newsletter --}}
                <div>
                    <h3 class="font-heading font-semibold text-white text-lg mb-4">Contact</h3>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start gap-2.5 text-sm">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-accent-peach" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <span>SHS N&deg; 60 Golf Nord,<br>Guediawaye, Senegal</span>
                        </li>
                        <li>
                            <a href="tel:+221338778162" class="flex items-start gap-2.5 text-sm hover:text-white transition-colors">
                                <svg class="w-4 h-4 mt-0.5 shrink-0 text-accent-mint" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                                <span>33 877 81 62<br>77 148 65 02</span>
                            </a>
                        </li>
                        <li>
                            <a href="mailto:gardebambinos@gmail.com" class="flex items-center gap-2.5 text-sm hover:text-white transition-colors">
                                <svg class="w-4 h-4 shrink-0 text-accent-blue" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                gardebambinos@gmail.com
                            </a>
                        </li>
                        <li class="flex items-center gap-2.5 text-sm">
                            <svg class="w-4 h-4 shrink-0 text-accent-lavender" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Lun-Ven: 7h30-17h30
                        </li>
                    </ul>

                    {{-- Newsletter Form --}}
                    <div>
                        <h4 class="font-heading font-medium text-white text-sm mb-2">Newsletter</h4>

                        @if(session('newsletter_success'))
                            <p class="mb-2 text-sm text-green-300 bg-green-900/30 border border-green-700/30 rounded-lg px-3 py-2">
                                {{ session('newsletter_success') }}
                            </p>
                        @elseif(session('newsletter_error'))
                            <p class="mb-2 text-sm text-red-200 bg-red-900/30 border border-red-700/30 rounded-lg px-3 py-2">
                                {{ session('newsletter_error') }}
                            </p>
                        @endif

                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex gap-2">
                            @csrf
                            <label for="newsletter-email" class="sr-only">Adresse email</label>
                            <input
                                type="email"
                                id="newsletter-email"
                                name="email"
                                required
                                placeholder="Votre email"
                                class="flex-1 min-w-0 px-3 py-2 bg-white/10 border border-white/20 rounded-lg text-sm text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-accent-peach/50 focus:border-transparent transition-colors"
                            >
                            <button
                                type="submit"
                                class="px-3 py-2 bg-primary-700 hover:bg-primary-600 text-white rounded-lg text-sm font-semibold transition-colors shrink-0"
                                aria-label="S'inscrire a la newsletter"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        {{-- Copyright Bar --}}
        <div class="border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <p class="text-center text-xs text-white/50">
                    &copy; 2025 Groupe Scolaire Mere Theresa - Ecole privee Les Bambinos. Tous droits reserves.
                </p>
            </div>
        </div>
    </footer>

    {{-- ============================================================
         SCRIPTS
    ============================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile Menu Toggle
            const menuButton = document.getElementById('mobile-menu-button');
            const menuClose = document.getElementById('mobile-menu-close');
            const menuOverlay = document.getElementById('mobile-menu-overlay');
            const menuDrawer = document.getElementById('mobile-menu-drawer');
            const iconOpen = document.getElementById('menu-icon-open');
            const iconClose = document.getElementById('menu-icon-close');

            function openMobileMenu() {
                menuDrawer.classList.remove('translate-x-full');
                menuOverlay.classList.remove('opacity-0', 'pointer-events-none');
                menuOverlay.classList.add('opacity-100');
                iconOpen.classList.add('hidden');
                iconClose.classList.remove('hidden');
                menuButton.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
                // Focus trap: focus the close button
                menuClose.focus();
            }

            function closeMobileMenu() {
                menuDrawer.classList.add('translate-x-full');
                menuOverlay.classList.add('opacity-0', 'pointer-events-none');
                menuOverlay.classList.remove('opacity-100');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
                menuButton.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
                menuButton.focus();
            }

            if (menuButton) menuButton.addEventListener('click', openMobileMenu);
            if (menuClose) menuClose.addEventListener('click', closeMobileMenu);
            if (menuOverlay) menuOverlay.addEventListener('click', closeMobileMenu);

            // Close on Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !menuDrawer.classList.contains('translate-x-full')) {
                    closeMobileMenu();
                }
            });

            // Header shadow on scroll
            const header = document.getElementById('main-header');
            if (header) {
                window.addEventListener('scroll', function () {
                    if (window.scrollY > 10) {
                        header.classList.add('shadow-md');
                        header.classList.remove('shadow-sm');
                    } else {
                        header.classList.remove('shadow-md');
                        header.classList.add('shadow-sm');
                    }
                }, { passive: true });
            }

            // Lightbox functionality
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightbox-image');
            const lightboxCaption = document.getElementById('lightbox-caption');
            const lightboxCounter = document.getElementById('lightbox-counter');
            const lightboxClose = document.getElementById('lightbox-close');
            const lightboxPrev = document.getElementById('lightbox-prev');
            const lightboxNext = document.getElementById('lightbox-next');

            let lightboxImages = [];
            let currentLightboxIndex = 0;

            function openLightbox(src, alt, index, images) {
                lightboxImages = images || [];
                currentLightboxIndex = index || 0;
                lightboxImage.src = src;
                lightboxImage.alt = alt || '';
                lightboxCaption.textContent = alt || '';
                updateLightboxCounter();
                lightbox.classList.remove('hidden');
                lightbox.classList.add('flex');
                document.body.style.overflow = 'hidden';
                lightbox.focus();
            }

            function closeLightbox() {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
                lightboxImage.src = '';
                document.body.style.overflow = '';
            }

            function updateLightboxCounter() {
                if (lightboxImages.length > 1) {
                    lightboxCounter.textContent = (currentLightboxIndex + 1) + ' / ' + lightboxImages.length;
                    lightboxPrev.style.display = '';
                    lightboxNext.style.display = '';
                } else {
                    lightboxCounter.textContent = '';
                    lightboxPrev.style.display = 'none';
                    lightboxNext.style.display = 'none';
                }
            }

            function showLightboxImage(index) {
                if (index < 0) index = lightboxImages.length - 1;
                if (index >= lightboxImages.length) index = 0;
                currentLightboxIndex = index;
                const img = lightboxImages[index];
                lightboxImage.src = img.src;
                lightboxImage.alt = img.alt || '';
                lightboxCaption.textContent = img.alt || '';
                updateLightboxCounter();
            }

            if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
            if (lightboxPrev) lightboxPrev.addEventListener('click', function () { showLightboxImage(currentLightboxIndex - 1); });
            if (lightboxNext) lightboxNext.addEventListener('click', function () { showLightboxImage(currentLightboxIndex + 1); });

            // Close lightbox on backdrop click
            if (lightbox) {
                lightbox.addEventListener('click', function (e) {
                    if (e.target === lightbox) closeLightbox();
                });
            }

            // Keyboard navigation for lightbox
            document.addEventListener('keydown', function (e) {
                if (lightbox && !lightbox.classList.contains('hidden')) {
                    if (e.key === 'Escape') closeLightbox();
                    if (e.key === 'ArrowLeft') showLightboxImage(currentLightboxIndex - 1);
                    if (e.key === 'ArrowRight') showLightboxImage(currentLightboxIndex + 1);
                }
            });

            // Expose openLightbox globally for use in page scripts
            window.openLightbox = openLightbox;
        });
    </script>

    @stack('scripts')
</body>
</html>
