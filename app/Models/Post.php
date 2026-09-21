<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'is_featured',
        'published_at',
        'views_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $slug = Str::slug($post->title);
                $originalSlug = $slug;
                $count = 2;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-" . $count++;
                }
                $post->slug = $slug;
            }

            if (empty($post->published_at) && $post->status === 'published') {
                $post->published_at = now();
            }
        });
    }

    /**
     * Relationship with Category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship with User / Author.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope for published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Scope for featured posts.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get image URL attribute (supports both uploaded files in storage and public/ assets).
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->featured_image)) {
            return asset('news slide (1).png');
        }

        if (str_starts_with($this->featured_image, 'http://') || str_starts_with($this->featured_image, 'https://')) {
            return $this->featured_image;
        }

        if (str_starts_with($this->featured_image, 'posts/')) {
            return asset('storage/' . $this->featured_image);
        }

        return asset($this->featured_image);
    }

    /**
     * Approximate reading time calculation.
     */
    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content ?? $this->excerpt ?? ''));
        $minutes = ceil($words / 200);
        return max(1, $minutes) . ' min read';
    }
}
