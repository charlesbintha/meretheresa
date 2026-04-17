<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Adresses email de l'école
    |--------------------------------------------------------------------------
    |
    | Destinataires internes utilisés par les formulaires du site :
    | - contact_recipient   : où partent les messages du formulaire /contact
    | - newsletter_recipient: où partent les notifications d'inscription newsletter
    |
    | Si ces variables ne sont pas définies, le système retombe sur
    | MAIL_FROM_ADDRESS.
    |
    */

    'contact_recipient' => env('MAIL_CONTACT_TO'),
    'newsletter_recipient' => env('MAIL_NEWSLETTER_TO'),

];
