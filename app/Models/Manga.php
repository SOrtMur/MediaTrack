<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Manga extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'release_date',
        'avg_score',
        'img_path',
        'chapters',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'mangas_users')->withPivot('read_status', 'last_chapter_read', 'added_at', 'last_read_at');
    }
}
