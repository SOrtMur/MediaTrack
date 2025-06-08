<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Manga;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mangas_users', function (Blueprint $table) {
            $table->id();
            $table->integer('manga_id')->constrained('games')->nullable()->default(null)->onDelete('cascade');
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade');
            $table->date('last_read_at')->nullable()->default(null);
            $table->string('read_status')->default('Pendiente');
            $table->integer('last_chapter_read')->default(0);
            $table->date('added_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mangas_users');
    }
};
