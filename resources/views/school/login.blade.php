<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Connexion · Mère Thérèsa</title>
    <link rel="icon" href="{{ asset('template/assets/school-logo.jpg') }}">
    <link rel="stylesheet" href="{{ asset('template/styles.css') }}">
    <style>
        body.login-page {
            min-height: 100vh;
            min-height: 100dvh;
            display: grid;
            place-items: center;
            padding: 32px 20px;
            background: #b69a68;
            isolation: isolate;
        }
        .login-background {
            position: fixed;
            inset: 0;
            z-index: -1;
            background: linear-gradient(135deg, rgba(22, 31, 42, .26), rgba(22, 31, 42, .12)), url("{{ asset('template/assets/back.jpg') }}") center / cover no-repeat;
        }
        .login-card {
            width: min(440px, 100%);
            padding: 34px 38px 28px;
            background: rgba(255, 255, 255, .82);
            border: 1px solid rgba(255, 255, 255, .65);
            border-radius: 28px;
            box-shadow: 0 24px 80px rgba(27, 32, 41, .2), inset 0 1px 0 rgba(255, 255, 255, .8);
            -webkit-backdrop-filter: blur(12px);
            backdrop-filter: blur(12px);
        }
        .login-brand { display: flex; flex-direction: column; align-items: center; text-align: center; margin-bottom: 27px; }
        .login-brand img { width: 82px; height: 82px; object-fit: contain; border-radius: 50%; padding: 7px; background: white; box-shadow: 0 5px 20px #22325310; margin-bottom: 15px; }
        .login-brand h1 { font-size: 28px; font-weight: 700; letter-spacing: -.9px; }
        .login-brand p { margin-top: 6px; color: #596474; font-size: 10px; font-weight: 600; letter-spacing: 2.6px; text-transform: uppercase; }
        .login-intro { text-align: center; }
        .login-intro h2 { font-size: 17px; letter-spacing: -.3px; }
        .login-intro p { font-size: 12px; color: #606a77; margin-top: 6px; line-height: 1.7; }
        .login-card form { margin-top: 25px; display: grid; gap: 18px; }
        .login-card .field { color: #364151; font-size: 12px; }
        .login-card .field input { min-height: 46px; background: rgba(255, 255, 255, .8); border-color: rgba(128, 143, 162, .28); border-radius: 11px; font-size: 14px; }
        .login-card .field input:focus { background: white; border-color: var(--blue); }
        .login-card .btn { width: 100%; font-size: 13px; min-height: 47px; margin-top: 4px; border-radius: 11px; justify-content: center; gap: 10px; }
        .login-foot { text-align: center; font-size: 10px; color: #606a77; margin-top: 25px; }
        @media (max-width: 480px) {
            body.login-page { padding: 24px 16px; }
            .login-card { padding: 28px 24px 24px; border-radius: 23px; }
            .login-brand img { width: 72px; height: 72px; }
            .login-brand h1 { font-size: 26px; }
            .login-card .field input { font-size: 16px; }
        }
    </style>
</head>
<body class="login-page">
    <div class="login-background" aria-hidden="true"></div>
    <section class="login-card" aria-labelledby="school-name">
        <div class="login-brand">
            <img src="{{ asset('template/assets/school-logo.jpg') }}" alt="Logo de l’établissement">
            <h1 id="school-name">Mère Thérèsa</h1>
            <p>Groupe scolaire</p>
        </div>
        <div class="login-intro">
            <h2>Heureux de vous retrouver.</h2>
            <p>Connectez-vous à votre espace de gestion scolaire.</p>
        </div>
        <form method="post" action="{{ url('/login') }}">
            @csrf
            <label class="field">Adresse e-mail
                <input name="email" type="email" value="{{ old('email') }}" required autocomplete="username" placeholder="votre@email.com">
            </label>
            <label class="field">Mot de passe
                <input name="password" type="password" required autocomplete="current-password" placeholder="Votre mot de passe">
            </label>
            @if($errors->any())
                <div class="form-error" role="alert">{{ $errors->first() }}</div>
            @endif
            <button class="btn primary" type="submit">Se connecter <span aria-hidden="true">→</span></button>
        </form>
        <p class="login-foot">Accès réservé aux membres autorisés de l’établissement.</p>
    </section>
</body>
</html>
