<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // Drop the existing threshold column if it exists
            $table->dropColumn('threshold');
        });

        Schema::table('campaigns', function (Blueprint $table) {
            // Add the threshold column back after the source column
            $table->integer('threshold')->after('source')->nullable();
        });
    }

    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // Drop the threshold column in case of rollback
            $table->dropColumn('threshold'); 
        });
    }
};
