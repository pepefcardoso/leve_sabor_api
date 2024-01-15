<?php

namespace App\Models;

use App\Enums\BlogPostStatusEnum;
use App\Services\BlogPostImages\TemporaryUrlBlogPostImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'status',
        'user_id',
    ];

    static public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:1000',
            'description' => 'required|string|min:3|max:150',
            'content' => 'required|string|min:3|max:5000',
            'status' => ['required', Rule::in(BlogPostStatusEnum::cases())],
            'image' => 'required|image|max:2048|mimes:jpeg,png,jpg,svg',
            'categories' => 'required|array',
            'categories.*' => 'required|integer|exists:blog_post_categories,id',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(BlogPostCategory::class, 'rl_blog_post_categories', 'blog_post_id', 'blog_post_category_id');
    }

    public function blogPostImage()
    {
        return $this->hasOne(BlogPostImage::class);
    }

    public function temporaryUrlBlogPostImage(): Attribute
    {
        return Attribute::make(
            get: function () {
                $blogPostImage = $this->blogPostImage;

                if ($blogPostImage) {
                    $temporaryUrlBlogPostImage = app(TemporaryUrlBlogPostImage::class);

                    return $temporaryUrlBlogPostImage->temporaryUrl($blogPostImage);
                }

                return null;
            }
        );
    }
}
