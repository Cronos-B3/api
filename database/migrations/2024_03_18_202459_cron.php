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
            $table->foreignUuid('c_fk_user_id')->constrained('user', 'u_id');
            $table->string('c_text', 255)->nullable();
            $table->string('c_chanel', 255);
            $table->string('c_status', 15)->default('ACTIVE');
            $table->timestamp('c_end_at');
            $table->timestamp('c_created_at')->useCurrent();
            $table->timestamp('c_updated_at')->useCurrent();
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
