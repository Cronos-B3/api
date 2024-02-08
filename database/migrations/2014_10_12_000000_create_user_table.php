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
        Schema::create('user', function (Blueprint $table) {
            $table->uuid('u_id')->primary()->unique();
            $table->uuid('u_private_key');
            $table->string('u_role', 31)->default('ROLE_USER');
            $table->string('u_firstname', 63)->nullable();
            $table->string('u_lastname', 63)->nullable();
            $table->date('u_birthdate')->nullable();
            $table->string('u_password')->nullable();
            $table->uuid('u_salt')->nullable();
            $table->timestamp('u_created_at')->useCurrent();
            $table->timestamp('u_updated_at')->useCurrent();
            $table->string('u_status', 15)->default('PENDING');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
