@extends('emails._layout')

@section('title', 'Nouveau message depuis le site')
@section('preheader', 'Message reçu via le formulaire de contact du site web.')

@section('content')

    <h1 style="margin:0 0 8px 0; font-family:Georgia, 'Times New Roman', serif; font-size:24px; color:#1F2A5E; font-weight:700;">
        Nouveau message reçu
    </h1>
    <p style="margin:0 0 24px 0; color:#6B7280; font-size:14px; line-height:1.6;">
        Un visiteur vient d'envoyer un message via le formulaire de contact du site.
    </p>

    {{-- Sender card --}}
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#EFF2FB; border-radius:12px; margin-bottom:20px;">
        <tr>
            <td style="padding:20px;">
                <p style="margin:0 0 4px 0; font-size:11px; color:#354588; text-transform:uppercase; letter-spacing:1px; font-weight:600;">
                    Expéditeur
                </p>
                <p style="margin:0 0 12px 0; font-size:18px; color:#1F2A5E; font-weight:700;">
                    {{ $data['name'] }}
                </p>
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="font-size:14px; color:#2A2A3A;">
                    <tr>
                        <td style="padding:2px 12px 2px 0; color:#6B7280; vertical-align:top;">Email :</td>
                        <td style="padding:2px 0;">
                            <a href="mailto:{{ $data['email'] }}" style="color:#1F2A5E; text-decoration:none; font-weight:600;">{{ $data['email'] }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:2px 12px 2px 0; color:#6B7280; vertical-align:top;">Téléphone :</td>
                        <td style="padding:2px 0;">
                            <a href="tel:{{ $data['phone'] }}" style="color:#1F2A5E; text-decoration:none; font-weight:600;">{{ $data['phone'] }}</a>
                        </td>
                    </tr>
                    @if(!empty($data['child_age']))
                    <tr>
                        <td style="padding:2px 12px 2px 0; color:#6B7280; vertical-align:top;">Âge enfant :</td>
                        <td style="padding:2px 0;">{{ $data['child_age'] }}</td>
                    </tr>
                    @endif
                    @if(!empty($data['level']))
                    <tr>
                        <td style="padding:2px 12px 2px 0; color:#6B7280; vertical-align:top;">Niveau :</td>
                        <td style="padding:2px 0;">{{ $data['level'] }}</td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>

    {{-- Message --}}
    <p style="margin:0 0 8px 0; font-size:11px; color:#354588; text-transform:uppercase; letter-spacing:1px; font-weight:600;">
        Message
    </p>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#FFFFFF; border:1px solid #DCE3F5; border-left:4px solid #1F2A5E; border-radius:8px;">
        <tr>
            <td style="padding:18px 20px; font-size:15px; line-height:1.7; color:#2A2A3A; white-space:pre-wrap;">{{ $data['message'] }}</td>
        </tr>
    </table>

    {{-- Reply CTA --}}
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top:28px;">
        <tr>
            <td align="center">
                <a href="mailto:{{ $data['email'] }}?subject=Re%3A%20Votre%20message%20au%20Groupe%20Scolaire%20M%C3%A8re%20Th%C3%A9r%C3%A9sa"
                   style="display:inline-block; background-color:#1F2A5E; color:#FFFFFF; text-decoration:none; padding:14px 32px; border-radius:999px; font-size:14px; font-weight:600; letter-spacing:0.3px;">
                    Répondre à {{ \Illuminate\Support\Str::before($data['name'], ' ') }}
                </a>
            </td>
        </tr>
    </table>

    <p style="margin:24px 0 0 0; font-size:12px; color:#6B7280; text-align:center; line-height:1.5;">
        Reçu le {{ \Carbon\Carbon::now()->locale('fr')->translatedFormat('l j F Y à H:i') }}.
    </p>

@endsection
