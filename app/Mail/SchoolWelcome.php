<?php
namespace App\Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{Content,Envelope};
class SchoolWelcome extends Mailable {
 public function __construct(public string $displayName,public string $loginEmail,public string $roleName,public string $loginUrl,public bool $isPreview=false) {}
 public function envelope():Envelope {return new Envelope(subject:($this->isPreview?'[TEST] ':'').'Bienvenue dans votre espace Mère Thérèsa');}
 public function content():Content {return new Content(view:'emails.school-welcome',text:'emails.school-welcome-text');}
}
