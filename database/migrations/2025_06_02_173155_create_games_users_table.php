<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Game;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games_users', function (Blueprint $table) {
            $table->id();
            $table->integer('game_id')->constrained('games')->nullable()->default(null)->onDelete('cascade');
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade');
            $table->date('last_played_at')->nullable()->default(null);
            $table->date('added_at');
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
