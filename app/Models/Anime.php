<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Anime extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'release_date',
        'avg_score',
        'img_path',
        'episodes',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'animes_users');
    }
}
