<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
    ];

    /**
     * Auto-generate slug on creating if not provided.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Relationship with Posts.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Published posts count helper.
     */
    public function publishedPosts()
    {
        return $this->hasMany(Post::class)->where('status', 'published');
    }
}
