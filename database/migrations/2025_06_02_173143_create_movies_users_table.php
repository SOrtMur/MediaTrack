<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Movie;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies_users', function (Blueprint $table) {
            $table->id();
            $table->integer('movie_id')->nullable()->default(-1);
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade');
            $table->string('watched_status')->default('Pendiente');
            $table->integer('watched_time')->default(0);
            $table->date('added_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies_users');
    }
};
