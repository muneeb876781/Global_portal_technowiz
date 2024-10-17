<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blacklisted_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number'); 
            $table->foreignId('app_id')->nullable()->constrained('applications')->onDelete('set null');
            $table->text('reason')->nullable(); 
            $table->boolean('is_blocked')->default(1); 
            $table->timestamp('blocked_at')->nullable(); 
            $table->timestamp('unblocked_at')->nullable(); 
            $table->string('blacklisted_by')->nullable(); // New column for username
            $table->string('blacklisted_by_ip')->nullable(); // New column for IP
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blacklisted_numbers');
    }
};
