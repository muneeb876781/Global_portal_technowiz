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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('app_id')->nullable()->constrained('applications')->onDelete('set null');
            $table->string('source'); 
            $table->boolean('is_deleted')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->integer('status')->default(0); 
            $table->time('starts_at')->nullable();
            $table->time('pause_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
