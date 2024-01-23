<?php

namespace App\Models;

use App\Services\BlogPostImages\TemporaryUrlBlogPostImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class BlogPostImage extends Model
{
    protected $appends = [
        'url',
    ];

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

    public function url(): Attribute
    {
        return Attribute::make(
            fn() => (new TemporaryUrlBlogPostImage())->temporaryUrl($this)
        );
    }
}
