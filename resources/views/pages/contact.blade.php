@extends('layouts.app')

@section('title', 'Contact')

@section('content')

{{-- ============================================================== --}}
{{-- HERO BANNER --}}
{{-- ============================================================== --}}
<section class="bg-primary-800 py-20 relative overflow-hidden">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute top-8 left-10 w-10 h-10 text-white/10 animate-float" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/></svg>
        <svg class="absolute bottom-8 right-16 w-14 h-14 text-white/10 animate-float" style="animation-delay: 1s;" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
        <svg class="absolute top-1/2 right-1/3 w-8 h-8 text-white/10 animate-float" style="animation-delay: 2s;" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.09 6.26L20.18 9l-5.09 3.74L16.18 19 12 15.27 7.82 19l1.09-6.26L3.82 9l6.09-.74z"/></svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center animate-on-scroll">
        <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-4">Contactez-nous</h1>
        <nav class="flex items-center justify-center gap-2 text-white/70 font-body text-sm" aria-label="Fil d'Ariane">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Accueil</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
            <span class="text-white font-semibold">Contact</span>
        </nav>
    </div>
</section>

{{-- ============================================================== --}}
{{-- CONTACT SECTION --}}
{{-- ============================================================== --}}
<section class="py-20 bg-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12">

            {{-- LEFT: Contact Form --}}
            <div class="animate-on-scroll">
                <div class="bg-white rounded-3xl shadow-lg p-8 md:p-10">
                    <h2 class="section-title text-2xl md:text-3xl font-heading font-bold text-gray-900 mb-2">Envoyez-nous un message</h2>
                    <p class="text-gray-600 font-body mb-8">Remplissez le formulaire ci-dessous et nous vous repondrons dans les plus brefs delais.</p>

                    {{-- Success Flash Message --}}
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 rounded-2xl p-4 flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                            </div>
                            <p class="text-green-800 font-body font-semibold text-sm">{{ session('success') }}</p>
                        </div>
                    @endif

                    {{-- Error Flash Message (mail send failure) --}}
                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                            </div>
                            <p class="text-red-800 font-body font-semibold text-sm">{{ session('error') }}</p>
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                                </div>
                                <p class="text-red-800 font-body font-semibold text-sm">Merci de corriger les erreurs ci-dessous :</p>
                            </div>
                            <ul class="list-disc list-inside text-sm text-red-700 space-y-1 ml-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Nom complet --}}
                        <div>
                            <label for="name" class="block text-sm font-heading font-semibold text-gray-700 mb-2">Nom complet</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none"
                                placeholder="Votre nom complet">
                        </div>

                        {{-- Email & Telephone --}}
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-heading font-semibold text-gray-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none"
                                    placeholder="votre@email.com">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-heading font-semibold text-gray-700 mb-2">Telephone</label>
                                <input type="tel" id="phone" name="phone"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none"
                                    placeholder="77 XXX XX XX">
                            </div>
                        </div>

                        {{-- Age de l'enfant & Niveau souhaite --}}
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label for="child_age" class="block text-sm font-heading font-semibold text-gray-700 mb-2">Age de l'enfant</label>
                                <select id="child_age" name="child_age"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none bg-white">
                                    <option value="">Selectionnez un age</option>
                                    <option value="0-3">0 - 3 ans</option>
                                    <option value="3-4">3 - 4 ans</option>
                                    <option value="4-5">4 - 5 ans</option>
                                    <option value="5-6">5 - 6 ans</option>
                                    <option value="6-9">6 - 9 ans</option>
                                    <option value="9-11">9 - 11 ans</option>
                                </select>
                            </div>
                            <div>
                                <label for="level" class="block text-sm font-heading font-semibold text-gray-700 mb-2">Niveau souhaite</label>
                                <select id="level" name="level"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none bg-white">
                                    <option value="">Selectionnez un niveau</option>
                                    <option value="garde">Garde</option>
                                    <option value="ps">Petite Section (PS)</option>
                                    <option value="ms">Moyenne Section (MS)</option>
                                    <option value="gs">Grande Section (GS)</option>
                                    <option value="ci">CI</option>
                                    <option value="cp">CP</option>
                                    <option value="ce1">CE1</option>
                                    <option value="ce2">CE2</option>
                                    <option value="cm1">CM1</option>
                                    <option value="cm2">CM2</option>
                                </select>
                            </div>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="message" class="block text-sm font-heading font-semibold text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 font-body focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 transition-all outline-none resize-none"
                                placeholder="Ecrivez votre message ici..."></textarea>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn-primary w-full bg-primary-800 text-white font-heading font-bold py-4 rounded-full hover:bg-primary-900 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/></svg>
                            Envoyer le message
                        </button>
                    </form>
                </div>
            </div>

            {{-- RIGHT: Info Cards + Map --}}
            <div class="animate-on-scroll space-y-6">

                {{-- Address Card --}}
                <div class="card bg-white rounded-2xl p-5 shadow-md flex items-start gap-4 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary-800" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-heading font-bold text-gray-900 mb-1">Adresse</h4>
                        <p class="text-gray-600 font-body text-sm">SHS N&deg; 60 Golf Nord, Guediawaye, Senegal</p>
                    </div>
                </div>

                {{-- Phone Card --}}
                <div class="card bg-white rounded-2xl p-5 shadow-md flex items-start gap-4 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-sky-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-heading font-bold text-gray-900 mb-1">Telephone</h4>
                        <p class="text-gray-600 font-body text-sm"><a href="tel:+221338778162" class="hover:text-primary-800 transition-colors">33-877-81-62</a></p>
                        <p class="text-gray-600 font-body text-sm"><a href="tel:+221771486502" class="hover:text-primary-800 transition-colors">77-148-65-02</a></p>
                    </div>
                </div>

                {{-- Email Card --}}
                <div class="card bg-white rounded-2xl p-5 shadow-md flex items-start gap-4 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-heading font-bold text-gray-900 mb-1">Email</h4>
                        <p class="text-gray-600 font-body text-sm"><a href="mailto:gardebambinos@gmail.com" class="hover:text-primary-800 transition-colors">gardebambinos@gmail.com</a></p>
                    </div>
                </div>

                {{-- Hours Card --}}
                <div class="card bg-white rounded-2xl p-5 shadow-md flex items-start gap-4 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-heading font-bold text-gray-900 mb-1">Horaires d'ouverture</h4>
                        <p class="text-gray-600 font-body text-sm">Lundi - Vendredi : 7h30 - 17h30</p>
                    </div>
                </div>

                {{-- Google Maps --}}
                <div class="bg-gray-200 rounded-2xl overflow-hidden shadow-md h-64">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3858.5!2d-17.395!3d14.775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTTCsDQ2JzMwLjAiTiAxN8KwMjMnNDIuMCJX!5e0!3m2!1sfr!2ssn!4v1"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Localisation Groupe Scolaire Mere Theresa - Guediawaye"
                        class="rounded-2xl">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================== --}}
{{-- ADDITIONAL INFO --}}
{{-- ============================================================== --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8 animate-on-scroll">

            {{-- Horaires d'accueil --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-primary-800" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>
                <h3 class="section-title text-lg font-heading font-bold text-gray-900 mb-4">Horaires d'accueil</h3>
                <ul class="text-gray-600 font-body text-sm space-y-2">
                    <li class="flex justify-between"><span>Lundi - Vendredi</span><span class="font-semibold">7h30 - 17h30</span></li>
                    <li class="flex justify-between"><span>Samedi</span><span class="font-semibold">8h00 - 12h00</span></li>
                    <li class="flex justify-between"><span>Dimanche</span><span class="font-semibold text-primary-800">Ferme</span></li>
                </ul>
            </div>

            {{-- Pour les urgences --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                    </svg>
                </div>
                <h3 class="section-title text-lg font-heading font-bold text-gray-900 mb-4">Pour les urgences</h3>
                <p class="text-gray-600 font-body text-sm mb-4">En cas d'urgence en dehors des heures d'ouverture, veuillez nous contacter par telephone ou WhatsApp.</p>
                <a href="tel:+221771486502" class="inline-flex items-center gap-2 text-primary-800 font-heading font-semibold text-sm hover:text-primary-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                    77-148-65-02
                </a>
            </div>

            {{-- Suivez-nous --}}
            <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-lg transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-sky-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-sky-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z"/>
                    </svg>
                </div>
                <h3 class="section-title text-lg font-heading font-bold text-gray-900 mb-4">Suivez-nous</h3>
                <p class="text-gray-600 font-body text-sm mb-6">Restez connectes et suivez nos actualites sur les reseaux sociaux.</p>
                <div class="flex items-center justify-center gap-4">
                    <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="w-11 h-11 flex items-center justify-center rounded-full bg-primary-800 text-white hover:bg-primary-900 transition-all duration-300 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                    <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="w-11 h-11 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-600 to-pink-500 text-white hover:from-purple-700 hover:to-pink-600 transition-all duration-300 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 0 1 1.772 1.153 4.902 4.902 0 0 1 1.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 0 1-1.153 1.772 4.902 4.902 0 0 1-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 0 1-1.772-1.153 4.902 4.902 0 0 1-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 0 1 1.153-1.772A4.902 4.902 0 0 1 5.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63ZM12 6.865a5.135 5.135 0 1 1 0 10.27 5.135 5.135 0 0 1 0-10.27Zm0 1.802a3.333 3.333 0 1 0 0 6.666 3.333 3.333 0 0 0 0-6.666Zm5.338-3.205a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4Z"/></svg>
                    </a>
                    <a href="https://wa.me/221771486502" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" class="w-11 h-11 flex items-center justify-center rounded-full bg-green-600 text-white hover:bg-green-700 transition-all duration-300 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
