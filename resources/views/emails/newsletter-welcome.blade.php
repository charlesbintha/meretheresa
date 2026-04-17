@extends('emails._layout')

@section('title', 'Bienvenue dans notre newsletter')
@section('preheader', 'Merci pour votre inscription. Vous recevrez bientôt nos actualités, événements et conseils éducatifs.')

@section('content')

    {{-- Welcome header --}}
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:24px;">
        <tr>
            <td align="center">
                <div style="display:inline-block; background-color:#EFF2FB; color:#1F2A5E; font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; padding:6px 14px; border-radius:999px;">
                    ✉ Inscription confirmée
                </div>
            </td>
        </tr>
    </table>

    <h1 style="margin:0 0 12px 0; font-family:Georgia, 'Times New Roman', serif; font-size:26px; color:#1F2A5E; font-weight:700; text-align:center;">
        Bienvenue dans notre famille !
    </h1>
    <p style="margin:0 0 24px 0; font-size:15px; line-height:1.7; color:#2A2A3A; text-align:center;">
        Merci de rejoindre la newsletter du <strong style="color:#1F2A5E;">Groupe Scolaire Mère Thérèsa</strong>.
    </p>

    <p style="margin:0 0 12px 0; font-size:15px; line-height:1.7; color:#2A2A3A;">
        Vous recevrez désormais, directement dans votre boîte email :
    </p>

    {{-- Benefits list --}}
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:28px;">
        <tr>
            <td style="padding:14px 18px; background-color:#EFF2FB; border-radius:10px; margin-bottom:8px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td width="44" style="vertical-align:top;">
                            <div style="width:36px; height:36px; background-color:#1F2A5E; color:#FFFFFF; border-radius:50%; text-align:center; line-height:36px; font-size:16px; font-weight:700;">📅</div>
                        </td>
                        <td style="vertical-align:top; padding-left:4px;">
                            <p style="margin:0 0 2px 0; font-size:14px; font-weight:700; color:#1F2A5E;">Actualités & événements</p>
                            <p style="margin:0; font-size:13px; line-height:1.5; color:#4B5563;">Kermesses, portes ouvertes, remises de prix et temps forts de l'école.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td style="height:10px;"></td></tr>
        <tr>
            <td style="padding:14px 18px; background-color:#EFF2FB; border-radius:10px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td width="44" style="vertical-align:top;">
                            <div style="width:36px; height:36px; background-color:#1F2A5E; color:#FFFFFF; border-radius:50%; text-align:center; line-height:36px; font-size:16px; font-weight:700;">📖</div>
                        </td>
                        <td style="vertical-align:top; padding-left:4px;">
                            <p style="margin:0 0 2px 0; font-size:14px; font-weight:700; color:#1F2A5E;">Conseils pédagogiques</p>
                            <p style="margin:0; font-size:13px; line-height:1.5; color:#4B5563;">Des astuces pour accompagner votre enfant dans ses apprentissages.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td style="height:10px;"></td></tr>
        <tr>
            <td style="padding:14px 18px; background-color:#EFF2FB; border-radius:10px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td width="44" style="vertical-align:top;">
                            <div style="width:36px; height:36px; background-color:#1F2A5E; color:#FFFFFF; border-radius:50%; text-align:center; line-height:36px; font-size:16px; font-weight:700;">🎓</div>
                        </td>
                        <td style="vertical-align:top; padding-left:4px;">
                            <p style="margin:0 0 2px 0; font-size:14px; font-weight:700; color:#1F2A5E;">Informations d'admission</p>
                            <p style="margin:0; font-size:13px; line-height:1.5; color:#4B5563;">Dates d'inscription, places disponibles et nouveautés pour chaque niveau.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- CTA --}}
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:24px;">
        <tr>
            <td align="center" style="padding:24px; background-color:#1F2A5E; border-radius:12px;">
                <p style="margin:0 0 6px 0; color:#FFFFFF; font-size:16px; font-weight:600;">
                    Prêts à découvrir l'école ?
                </p>
                <p style="margin:0 0 16px 0; color:#BCC9EB; font-size:13px; line-height:1.5;">
                    Les inscriptions pour l'année 2025-2026 sont ouvertes.
                </p>
                <a href="{{ route('admissions') }}"
                   style="display:inline-block; background-color:#FFFFFF; color:#1F2A5E; text-decoration:none; padding:12px 28px; border-radius:999px; font-size:14px; font-weight:700; letter-spacing:0.3px;">
                    Voir les admissions
                </a>
            </td>
        </tr>
    </table>

    <p style="margin:0; font-size:13px; line-height:1.6; color:#6B7280; text-align:center;">
        Vous recevez cet email parce que vous vous êtes inscrit(e) à la newsletter<br>
        du Groupe Scolaire Mère Thérèsa depuis notre site web.
    </p>

@endsection
