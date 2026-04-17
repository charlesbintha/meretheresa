<?php

namespace App\Http\Controllers;

use App\Mail\ContactConfirmation;
use App\Mail\ContactMessage;
use App\Mail\NewsletterWelcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function programmes()
    {
        return view('pages.programmes');
    }

    public function programmeDetail($slug)
    {
        return view('pages.programme-detail', compact('slug'));
    }

    public function admissions()
    {
        return view('pages.admissions');
    }

    public function gallery()
    {
        return view('pages.gallery');
    }

    public function news()
    {
        return view('pages.news');
    }

    public function newsDetail($slug)
    {
        return view('pages.news-detail', compact('slug'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'child_age' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:100',
            'message' => 'required|string|max:5000',
        ]);

        $adminRecipient = config('school.contact_recipient')
            ?? config('mail.from.address');

        try {
            Mail::to($adminRecipient)->send(new ContactMessage($validated));
            Mail::to($validated['email'])->send(new ContactConfirmation($validated));
        } catch (\Throwable $e) {
            Log::error('Contact form email failed', [
                'error' => $e->getMessage(),
                'email' => $validated['email'],
            ]);

            return redirect()
                ->route('contact')
                ->withInput()
                ->with('error', "Une erreur est survenue lors de l'envoi de votre message. Merci de nous contacter directement par téléphone.");
        }

        return redirect()
            ->route('contact')
            ->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
    }

    public function newsletterSubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $adminRecipient = config('school.newsletter_recipient')
            ?? config('school.contact_recipient')
            ?? config('mail.from.address');

        try {
            Mail::to($validated['email'])->send(new NewsletterWelcome($validated['email']));

            // Notify the school so they can add the address to their list manually
            if ($adminRecipient) {
                Mail::raw(
                    "Nouvelle inscription à la newsletter : {$validated['email']}",
                    fn ($m) => $m->to($adminRecipient)
                        ->subject('Nouvelle inscription newsletter — ' . $validated['email'])
                );
            }
        } catch (\Throwable $e) {
            Log::error('Newsletter subscription email failed', [
                'error' => $e->getMessage(),
                'email' => $validated['email'],
            ]);

            return back()->with('newsletter_error', "Une erreur est survenue. Merci de réessayer plus tard.");
        }

        return back()->with('newsletter_success', 'Merci ! Vous êtes inscrit à notre newsletter.');
    }
}
