<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void {
  Schema::create('school_suppliers',function(Blueprint $t){$t->id();$t->string('name');$t->string('phone')->nullable();$t->string('email')->nullable();$t->string('address')->nullable();$t->timestamps();});
  Schema::create('school_expenses',function(Blueprint $t){$t->id();$t->foreignId('supplier_id')->constrained('school_suppliers');$t->foreignId('year_id')->constrained('accounting_years');$t->foreignId('entry_id')->nullable()->unique()->constrained('accounting_entries');$t->date('date');$t->date('due_date')->nullable();$t->string('reference');$t->string('memo');$t->string('account',20);$t->unsignedBigInteger('amount');$t->timestamps();$t->unique(['supplier_id','reference']);});
  Schema::create('school_expense_payments',function(Blueprint $t){$t->id();$t->foreignId('expense_id')->constrained('school_expenses');$t->foreignId('treasury_id')->constrained('school_treasury_accounts');$t->foreignId('entry_id')->unique()->constrained('accounting_entries');$t->date('date');$t->string('reference');$t->unsignedBigInteger('amount');$t->timestamps();});
  Schema::create('school_expense_documents',function(Blueprint $t){$t->id();$t->foreignId('expense_id')->constrained('school_expenses');$t->string('name');$t->string('path');$t->foreignId('uploaded_by')->constrained('users');$t->timestamps();});
 }
 public function down():void {foreach(['school_expense_documents','school_expense_payments','school_expenses','school_suppliers'] as $table)Schema::dropIfExists($table);}
};
