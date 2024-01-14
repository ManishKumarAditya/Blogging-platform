<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'post_id', 'commenter_name', 'content'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
