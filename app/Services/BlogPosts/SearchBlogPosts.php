<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;

class SearchBlogPosts
{
    public function search(array $filters)
    {
        $query = BlogPost::query();

        foreach ($filters as $key => $value) {
            if ($value !== null) {
                switch ($key) {
                    case 'title':
                        $query->where('title', 'like', '%' . $value . '%');
                        break;
                    case 'status':
                        $query->whereIn('status', $value);
                        break;
                }
            }
        }

        return $query->with(['categories', 'blogPostImage', 'user'])->get();
    }
}
