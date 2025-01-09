<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'image',
        'status',
        'views',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
