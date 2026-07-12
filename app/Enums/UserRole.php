<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case User = 'user';
    case ContentCreator = 'content_creator';
    case Finance = 'finance';
}