<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void {Schema::table('users',function(Blueprint $t){$t->string('welcome_email_status')->default('not_sent');$t->timestamp('welcome_email_sent_at')->nullable();});}
 public function down():void {Schema::table('users',fn(Blueprint $t)=>$t->dropColumn(['welcome_email_status','welcome_email_sent_at']));}
};
