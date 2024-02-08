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
        Schema::create('user_email', function (Blueprint $table) {
            $table->id('ue_id');
            $table->foreignUuid('ue_fk_user_id')->constrained('user', 'u_id')->cascadeOnDelete();
            $table->string('ue_email');
            $table->boolean('ue_primary')->default(false);
            $table->timestamp('ue_created_at')->useCurrent();
            $table->timestamp('ue_updated_at')->useCurrent();
            $table->string('ue_status', 15)->default('PENDING');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_email');
    }
};
