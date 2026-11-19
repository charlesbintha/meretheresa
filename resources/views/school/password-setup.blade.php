<!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="referrer" content="no-referrer"><title>Définir mon mot de passe · Mère Thérèsa</title><style>
*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:24px;font:16px Arial,sans-serif;background:#eef3fb;color:#243149}.card{width:100%;max-width:460px;background:white;padding:32px;border-radius:22px;box-shadow:0 16px 60px #20305018}header{text-align:center}img{width:72px;height:72px;border-radius:12px}h1{font-size:24px}small,p{color:#64748b;line-height:1.6}label{display:block;margin:18px 0 8px;font-weight:bold}input{width:100%;padding:14px;border:1px solid #cdd6e5;border-radius:9px;font-size:16px}button{margin-top:24px;width:100%;padding:15px;background:#2864f6;color:white;border:0;border-radius:10px;font-size:16px;font-weight:bold;cursor:pointer}.error{padding:12px;background:#fff1f1;color:#a32b2b;border-radius:8px}a{color:#2864f6}
</style></head><body><main class="card"><header><img src="{{ asset('template/assets/school-logo.jpg') }}" alt="Logo de l’école"><h1>Mère Thérèsa</h1><small>GROUPE SCOLAIRE</small></header>
@if($valid)
<h2>Définir mon mot de passe</h2><p>Choisissez un mot de passe personnel pour accéder à votre compte. Ce lien ne peut être utilisé qu’une seule fois.</p>
@if($errors->any())<div role="alert" class="error">{{ $errors->first() }}</div>@endif
<form method="post" action="{{ route('school.password.store') }}">@csrf
<input type="hidden" name="token" value="{{ $token }}"><input type="hidden" name="email" value="{{ $email }}">
<label for="password">Nouveau mot de passe</label><input id="password" name="password" type="password" minlength="12" maxlength="72" autocomplete="new-password" required aria-describedby="password-help"><small id="password-help">12 caractères minimum. Une phrase longue est facile à retenir.</small>
<label for="confirmation">Confirmer le mot de passe</label><input id="confirmation" name="password_confirmation" type="password" minlength="12" maxlength="72" autocomplete="new-password" required>
<button type="submit">Enregistrer mon mot de passe</button></form>
@else
<h2>Ce lien n’est plus disponible</h2><p>Il est expiré, a déjà été utilisé ou votre compte n’est plus actif. Demandez à l’administration de vous renvoyer l’email de bienvenue si vous n’avez pas encore défini votre mot de passe.</p><a href="{{ route('login') }}">Revenir à la connexion</a>
@endif
</main></body></html>
