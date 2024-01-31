<?php

namespace App\Models;

use App\Enums\BlogPostStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class BlogPost extends Model
{
    use HasFactory;

    protected $appends = [
        'favorite'
    ];

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
            'title' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:3|max:200',
            'content' => 'required|string|min:3|max:5000',
            'status' => ['required', Rule::in(BlogPostStatusEnum::cases())],
            'categories' => 'required|array',
            'categories.*' => 'required|integer|exists:blog_post_categories,id',
            ...BlogPostImage::blogPostRules(),
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(BlogPostCategory::class, 'rl_blog_post_categories', 'blog_post_id', 'blog_post_category_id');
    }

    public function blogPostImage()
    {
        return $this->hasOne(BlogPostImage::class);
    }

    public function favorite(): Attribute
    {
        return new Attribute(
            function () {
                $user = auth('api')->user();

                if (!$user) {
                    return false;
                }

                return $this->favoritedBy()->where('user_id', $user->id)->exists();
            }
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'rl_user_favorite_blog_posts', 'blog_post_id', 'user_id');
    }
}
