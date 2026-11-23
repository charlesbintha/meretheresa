<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('school_receipt_deletion_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipt_id');
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('users');
            $table->foreignId('decided_by')->nullable()->constrained('users');
            $table->string('reason', 500);
            $table->string('status')->default('pending');
            $table->json('receipt_snapshot');
            $table->timestamp('decided_at')->nullable();
            $table->timestamps();
            $table->index(['academic_year_id', 'status']);
            $table->index(['receipt_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_receipt_deletion_requests');
    }
};
