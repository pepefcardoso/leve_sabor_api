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

    static public function rules()
    {
        return [
            'id' => 'nullable|integer|exists:blog_post_images,id',
            'file' => 'nullable',
        ];
    }

    static public function blogPostRules()
    {
        return [
            'image' => 'nullable|array',
            'image.id' => 'nullable|integer|exists:blog_post_images,id',
            'image.file' => 'nullable',
        ];
    }

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }
}
