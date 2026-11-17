<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void {Schema::table('school_staff_receipts',fn(Blueprint $t)=>$t->string('method',40)->nullable());}
 public function down():void {Schema::table('school_staff_receipts',fn(Blueprint $t)=>$t->dropColumn('method'));}
};
