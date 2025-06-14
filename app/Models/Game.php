<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'release_date',
        'avg_score',
        'img_path',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'games_users')->withPivot('played_status', 'played_time', 'added_at', 'last_played_at');
    }
}
