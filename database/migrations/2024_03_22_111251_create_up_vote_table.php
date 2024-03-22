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
        Schema::create('up_vote', function (Blueprint $table) {
            $table->id("uv_id");
            $table->foreignUuid('uv_fk_user_id')->constrained('user', 'u_id')->cascadeOnDelete();
            $table->foreignUuid('uv_fk_cron_id')->constrained('cron', 'c_id')->cascadeOnDelete();
            $table->timestamp('uv_created_at')->useCurrent();
            $table->timestamp('uv_updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('up_vote');
    }
};
