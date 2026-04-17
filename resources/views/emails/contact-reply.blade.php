@extends('emails._layout')

@section('title', 'Nous avons bien reçu votre message')
@section('preheader', 'Merci pour votre message. Notre équipe vous répond dans les plus brefs délais.')

@section('content')

    <h1 style="margin:0 0 12px 0; font-family:Georgia, 'Times New Roman', serif; font-size:24px; color:#1F2A5E; font-weight:700;">
        Merci {{ \Illuminate\Support\Str::before($data['name'], ' ') }} !
    </h1>
    <p style="margin:0 0 20px 0; font-size:15px; line-height:1.7; color:#2A2A3A;">
        Nous avons bien reçu votre message et toute l'équipe du <strong style="color:#1F2A5E;">Groupe Scolaire Mère Thérèsa</strong> vous remercie de l'intérêt que vous portez à notre école.
    </p>
    <p style="margin:0 0 28px 0; font-size:15px; line-height:1.7; color:#2A2A3A;">
        Nous vous répondrons dans les <strong>plus brefs délais</strong>, généralement sous 24 à 48 heures ouvrées.
    </p>

    {{-- Recap of submitted message --}}
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#EFF2FB; border-radius:12px; margin-bottom:28px;">
        <tr>
            <td style="padding:18px 20px;">
                <p style="margin:0 0 8px 0; font-size:11px; color:#354588; text-transform:uppercase; letter-spacing:1px; font-weight:600;">
                    Récapitulatif de votre message
                </p>
                <p style="margin:0; font-size:14px; line-height:1.7; color:#2A2A3A; white-space:pre-wrap;">{{ \Illuminate\Support\Str::limit($data['message'], 400) }}</p>
            </td>
        </tr>
    </table>

    {{-- Meanwhile CTA --}}
    <p style="margin:0 0 12px 0; font-size:15px; line-height:1.7; color:#2A2A3A;">
        <strong style="color:#1F2A5E;">En attendant notre retour</strong>, vous pouvez :
    </p>
    <ul style="margin:0 0 24px 0; padding-left:20px; font-size:14px; line-height:1.8; color:#2A2A3A;">
        <li>Consulter notre <a href="{{ route('programmes') }}" style="color:#1F2A5E; font-weight:600;">offre pédagogique</a> (Garde, Préscolaire, Élémentaire)</li>
        <li>Découvrir les <a href="{{ route('admissions') }}" style="color:#1F2A5E; font-weight:600;">modalités d'admission et tarifs</a> 2025-2026</li>
        <li>Parcourir la <a href="{{ route('gallery') }}" style="color:#1F2A5E; font-weight:600;">galerie photos</a> de l'école</li>
    </ul>

    {{-- Direct contact CTA --}}
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top:16px;">
        <tr>
            <td align="center" style="padding:20px; background-color:#EFF2FB; border-radius:12px;">
                <p style="margin:0 0 10px 0; font-size:13px; color:#354588;">Besoin d'une réponse urgente ?</p>
                <a href="tel:+221338778162"
                   style="display:inline-block; background-color:#1F2A5E; color:#FFFFFF; text-decoration:none; padding:12px 28px; border-radius:999px; font-size:14px; font-weight:600;">
                    Appeler le 33 877 81 62
                </a>
            </td>
        </tr>
    </table>

    <p style="margin:28px 0 0 0; font-size:14px; line-height:1.7; color:#2A2A3A;">
        À très bientôt,<br>
        <strong style="color:#1F2A5E;">L'équipe du Groupe Scolaire Mère Thérèsa</strong>
    </p>

@endsection
