<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    public function blogPosts()
    {
        return $this->belongsToMany(BlogPost::class, 'rl_blog_post_categories', 'blog_post_category_id', 'blog_post_id');
    }
}
