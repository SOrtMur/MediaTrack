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
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('description')->nullable();
            $table->date('release_date');
            $table->integer('episodes')->default(1);
            $table->string('status')->default('Proximamente');
            $table->decimal('avg_score', 3, 1)->nullable();
            $table->string('img_path')->nullable()->default('https://4ddig.tenorshare.com/images/photo-recovery/images-not-found.jpg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
