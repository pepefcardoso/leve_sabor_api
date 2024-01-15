<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPostImage extends Model
{
    protected $fillable = [
        'name',
        'path',
        'blog_post_id',
    ];

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }
}
