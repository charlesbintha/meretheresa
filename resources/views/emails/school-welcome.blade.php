<!doctype html>
<html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Bienvenue à Mère Thérèsa</title></head>
<body style="margin:0;padding:0;background:#f2f5fa;color:#253247;font-family:Arial,Helvetica,sans-serif;">
<div style="display:none;max-height:0;overflow:hidden;">Votre compte est prêt. Retrouvez votre espace de gestion scolaire Mère Thérèsa.</div>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f2f5fa;"><tr><td align="center" style="padding:32px 16px;">
<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;background:white;border-radius:18px;overflow:hidden;">
<tr><td align="center" style="padding:32px 24px;border-top:5px solid #2864f6;">
<img src="{{ $message->embed(public_path('template/assets/school-logo.jpg')) }}" width="72" height="72" alt="Logo de l’école" style="display:block;border-radius:12px;margin-bottom:14px;">
<div style="font-size:25px;font-weight:bold;color:#192b49;">Mère Thérèsa</div><div style="font-size:11px;letter-spacing:3px;color:#71809a;margin-top:7px;">GROUPE SCOLAIRE</div>
</td></tr>
<tr><td style="padding:0 32px 32px;">
<h1 style="font-size:25px;line-height:1.3;color:#192b49;margin:8px 0 20px;">Bienvenue dans votre espace</h1>
<p style="font-size:16px;line-height:1.7;">Bonjour {{ $displayName }},</p>
<p style="font-size:15px;line-height:1.7;color:#52617a;">L’administration de Mère Thérèsa vient de créer votre compte. Vous pouvez désormais accéder aux fonctionnalités de gestion scolaire correspondant à votre rôle.</p>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f3f6fd;border-radius:12px;"><tr><td style="padding:20px;">
<div style="font-size:12px;color:#71809a;margin-bottom:7px;">VOTRE IDENTIFIANT</div><div style="font-size:15px;font-weight:bold;word-break:break-all;">{{ $loginEmail }}</div>
<div style="font-size:12px;color:#71809a;margin-top:18px;margin-bottom:7px;">VOTRE RÔLE</div><div style="font-size:15px;font-weight:bold;">{{ $roleName }}</div>
</td></tr></table>
<table role="presentation" cellpadding="0" cellspacing="0" style="margin:28px 0;"><tr><td bgcolor="#2864f6" style="border-radius:9px;"><a href="{{ $loginUrl }}" style="display:inline-block;padding:16px 24px;font-size:15px;font-weight:bold;color:#ffffff;text-decoration:none;">Accéder à mon espace</a></td></tr></table>
<p style="font-size:14px;line-height:1.7;color:#52617a;">Votre mot de passe vous est communiqué séparément par l’administration. Après votre première connexion, vous pouvez le modifier depuis <strong>Mon profil</strong>.</p>
<p style="font-size:13px;line-height:1.7;color:#71809a;">Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :<br><a href="{{ $loginUrl }}" style="color:#2864f6;word-break:break-all;">{{ $loginUrl }}</a></p>
<p style="font-size:14px;line-height:1.7;color:#52617a;">Besoin d’aide ou compte créé par erreur ? Contactez l’administration de l’école.</p>
<p style="font-size:15px;margin-top:25px;">L’équipe administrative<br><strong>Mère Thérèsa</strong></p>
</td></tr></table>
<p style="font-size:12px;color:#7d89a0;line-height:1.6;">Grandir, apprendre, réussir.<br>Groupe scolaire Mère Thérèsa</p>
</td></tr></table></body></html>
