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
        Schema::create('movies_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies')->nullable()->default(null)->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->nullable()->default(null)->onDelete('cascade');
            $table->string('movie_title')->nullable()->default(null);
            $table->date('watched_date')->nullable()->default(null);
            $table->string('watched_status')->default('Pendiente');
            $table->double('watched_time')->default(0);
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
