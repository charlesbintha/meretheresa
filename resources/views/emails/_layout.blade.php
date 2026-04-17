<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Groupe Scolaire Mère Thérèsa')</title>
</head>
<body style="margin:0; padding:0; background-color:#EFF2FB; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#2A2A3A;">

{{-- Preheader (hidden preview text in inbox) --}}
<div style="display:none; font-size:1px; color:#EFF2FB; line-height:1px; max-height:0; max-width:0; opacity:0; overflow:hidden;">
    @yield('preheader')
</div>

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#EFF2FB; padding:24px 12px;">
    <tr>
        <td align="center">

            <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="max-width:600px; width:100%; background-color:#FFFDF8; border-radius:16px; overflow:hidden; box-shadow:0 4px 18px rgba(15,22,49,0.08);">

                {{-- ==================== HEADER ==================== --}}
                <tr>
                    <td style="background-color:#1F2A5E; padding:32px 24px; text-align:center;">
                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="Groupe Scolaire Mère Thérèsa"
                            width="100"
                            height="100"
                            style="display:inline-block; width:100px; height:100px; border-radius:50%; background-color:#FFFFFF; padding:6px; border:0;">
                        <p style="margin:14px 0 0 0; font-family:Georgia, 'Times New Roman', serif; color:#FFFFFF; font-size:18px; font-weight:600; letter-spacing:0.5px;">
                            Groupe Scolaire Mère Thérèsa
                        </p>
                        <p style="margin:4px 0 0 0; color:#BCC9EB; font-size:12px; letter-spacing:1px; text-transform:uppercase;">
                            École Les Bambinos · Guédiawaye
                        </p>
                    </td>
                </tr>

                {{-- ==================== BODY ==================== --}}
                <tr>
                    <td style="padding:40px 32px 32px 32px;">
                        @yield('content')
                    </td>
                </tr>

                {{-- ==================== CONTACT STRIP ==================== --}}
                <tr>
                    <td style="background-color:#EFF2FB; padding:20px 32px; border-top:1px solid #DCE3F5;">
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td style="font-size:13px; color:#354588; line-height:1.6;">
                                    <strong style="color:#1F2A5E;">Nous contacter</strong><br>
                                    <a href="tel:+221338778162" style="color:#354588; text-decoration:none;">33 877 81 62</a>
                                    &nbsp;·&nbsp;
                                    <a href="tel:+221771486502" style="color:#354588; text-decoration:none;">77 148 65 02</a><br>
                                    <a href="mailto:gardebambinos@gmail.com" style="color:#354588; text-decoration:none;">gardebambinos@gmail.com</a><br>
                                    SHS N° 60 Golf Nord, Guédiawaye, Sénégal<br>
                                    Lun–Ven : 7h30–17h30
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- ==================== FOOTER ==================== --}}
                <tr>
                    <td style="background-color:#0d132a; padding:20px 32px; text-align:center;">
                        <p style="margin:0; color:#92A5DA; font-size:11px; line-height:1.5;">
                            &copy; {{ date('Y') }} Groupe Scolaire Mère Thérèsa — École privée Les Bambinos.<br>
                            Tous droits réservés.
                        </p>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
