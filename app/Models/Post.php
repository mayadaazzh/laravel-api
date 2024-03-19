<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'news_content',
    ];

    public function writer(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
