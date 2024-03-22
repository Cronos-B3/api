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
        Schema::create('cron_like', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('cl_fk_user_id')->constrained('user')->cascadeOnDelete();
            $table->foreignUuid('cl_fk_cron_id')->constrained('cron')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cron_like');
    }
};
