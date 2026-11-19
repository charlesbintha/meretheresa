MÈRE THÉRÈSA — GROUPE SCOLAIRE

Bonjour {{ $displayName }},

@if($isPreview)Ceci est un aperçu de test. Aucun compte supplémentaire n’a été créé.@else Bienvenue ! L’administration a créé votre compte de gestion scolaire.@endif

Identifiant : {{ $loginEmail }}
Rôle : {{ $roleName }}
@if($setupUrl)Définir mon mot de passe : {{ $setupUrl }}
Lien valable {{ config('auth.passwords.users.expire', 60) }} minutes, utilisable une seule fois. Un nouvel envoi remplace le lien précédent.
@else Connexion : {{ $loginUrl }}
@endif

Si votre lien a expiré, demandez à l’administration de renvoyer votre invitation. Si votre mot de passe est déjà défini, utilisez-le pour vous connecter.

Pour toute question ou si ce compte a été créé par erreur, contactez l’administration de l’école.

L’équipe administrative de Mère Thérèsa
Grandir, apprendre, réussir.
