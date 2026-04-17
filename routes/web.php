<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/programmes', [PageController::class, 'programmes'])->name('programmes');
Route::get('/programmes/{slug}', [PageController::class, 'programmeDetail'])->name('programmes.detail');
Route::get('/admissions', [PageController::class, 'admissions'])->name('admissions');
Route::get('/galerie', [PageController::class, 'gallery'])->name('gallery');
Route::get('/actualites', [PageController::class, 'news'])->name('news');
Route::get('/actualites/{slug}', [PageController::class, 'newsDetail'])->name('news.detail');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactSubmit'])->name('contact.submit');
Route::post('/newsletter', [PageController::class, 'newsletterSubscribe'])->name('newsletter.subscribe');

Route::get('/sitemap.xml', function () {
    $today = now()->toDateString();
    $urls = [
        ['loc' => route('home'),        'priority' => '1.0', 'changefreq' => 'weekly',  'lastmod' => $today],
        ['loc' => route('about'),       'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => $today],
        ['loc' => route('programmes'),  'priority' => '0.9', 'changefreq' => 'monthly', 'lastmod' => $today],
        ['loc' => route('admissions'),  'priority' => '0.9', 'changefreq' => 'monthly', 'lastmod' => $today],
        ['loc' => route('gallery'),     'priority' => '0.6', 'changefreq' => 'monthly', 'lastmod' => $today],
        ['loc' => route('news'),        'priority' => '0.7', 'changefreq' => 'weekly',  'lastmod' => $today],
        ['loc' => route('contact'),     'priority' => '0.8', 'changefreq' => 'yearly',  'lastmod' => $today],
    ];

    return response()
        ->view('sitemap', compact('urls'))
        ->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');
