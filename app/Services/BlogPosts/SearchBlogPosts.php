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
                    case 'status':
                        $query->whereIn('status', $value);
                        break;
                }
            }
        }


        return BlogPost::with(['categories', 'blogPostImage', 'user.userImage'])->get();
    }
}
