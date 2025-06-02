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
        Schema::create('games_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->nullable()->default(null)->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->nullable()->default(null)->onDelete('cascade');
            $table->string('game_title')->nullable()->default(null);
            $table->date('played_date')->nullable()->default(null);
            $table->string('played_status')->default('Pendiente');
            $table->double('played_time')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games_users');
    }
};
