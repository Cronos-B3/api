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
        Schema::create('cron', function (Blueprint $table) {
            $table->uuid('c_id')->primary();
            $table->foreignUuid('c_fk_user_id')->default(null)->constrained('user', 'u_id');
            $table->foreignUuid('c_fk_cron_id')->nullable()->default(null)->constrained('cron', 'c_id');
            $table->string('c_text', 255)->nullable();
            $table->string('c_chanel', 255)->default('GENERAL');
            $table->string('c_status', 15)->default('ACTIVE');
            $table->timestamp('c_created_at')->useCurrent();
            $table->timestamp('c_updated_at')->useCurrent();
            $table->dateTime('c_end_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cron');
    }
};
