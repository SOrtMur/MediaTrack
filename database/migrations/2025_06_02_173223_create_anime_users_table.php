<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Anime;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animes_users', function (Blueprint $table) {
            $table->id();
            $table->integer('anime_id')->constrained('animes')->nullable()->default(null)->onDelete('cascade');
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade');
            $table->date('last_watched_date')->nullable()->default(null);
            $table->string('watched_status')->default('Pendiente');
            $table->integer('last_episode_watched')->default(0);
            $table->date('added_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes_users');
    }
};
