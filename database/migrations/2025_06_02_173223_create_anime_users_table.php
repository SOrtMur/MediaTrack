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
        Schema::create('anime_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('animes')->nullable()->default(null)->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->nullable()->default(null)->onDelete('cascade');
            $table->string('anime_title')->nullable()->default(null);
            $table->date('watched_date')->nullable()->default(null);
            $table->string('watched_status')->default('Pendiente');
            $table->integer('last_episode_watched')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anime_users');
    }
};
