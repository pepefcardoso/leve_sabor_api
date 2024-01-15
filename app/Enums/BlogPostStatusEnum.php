<?php

namespace App\Enums;
enum BlogPostStatusEnum: string
{
    case DRAFT = 'DRAFT';
    case PUBLISHED = 'PUBLISHED';

    case ARCHIVED = 'ARCHIVED';
}
