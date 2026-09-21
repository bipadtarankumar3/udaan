<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index(Request $request)
    {
        $query = Post::with(['category', 'author'])->latest();

        // Status Filter
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('status', 'published');
            } elseif ($request->status === 'draft') {
                $query->where('status', 'draft');
            } elseif ($request->status === 'featured') {
                $query->where('is_featured', true);
            }
        }

        // Category Filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search Query
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(15)->withQueryString();

        // Quick statistics
        $stats = [
            'all' => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'draft' => Post::where('status', 'draft')->count(),
            'featured' => Post::where('is_featured', true)->count(),
        ];

        $categories = Category::orderBy('name')->get();

        return view('admin.posts.index', compact('posts', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new post (WordPress-style).
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'category_id' => 'nullable|exists:categories,id',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:1000',
            'status' => 'required|in:published,draft',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        if (empty($validated['slug'])) {
            $slug = Str::slug($validated['title']);
            $originalSlug = $slug;
            $count = 2;
            while (Post::where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-" . $count++;
            }
            $validated['slug'] = $slug;
        }

        if (empty($validated['excerpt']) && !empty($validated['content'])) {
            $validated['excerpt'] = Str::limit(strip_tags($validated['content']), 220);
        }

        $validated['user_id'] = auth()->id();
        $validated['is_featured'] = $request->has('is_featured');
        $validated['published_at'] = $request->filled('published_at') 
            ? $request->published_at 
            : ($validated['status'] === 'published' ? now() : null);

        // Handle Image Upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        }

        $post = Post::create($validated);

        return redirect()->route('admin.posts.edit', $post->id)
            ->with('success', 'Post created successfully! You can continue editing or view it live.');
    }

    /**
     * Show the form for editing the specified post (WordPress-style).
     */
    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'category_id' => 'nullable|exists:categories,id',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:1000',
            'status' => 'required|in:published,draft',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'remove_image' => 'nullable|boolean',
        ]);

        if (empty($validated['excerpt']) && !empty($validated['content'])) {
            $validated['excerpt'] = Str::limit(strip_tags($validated['content']), 220);
        }

        $validated['is_featured'] = $request->has('is_featured');

        if ($request->filled('published_at')) {
            $validated['published_at'] = $request->published_at;
        } elseif ($validated['status'] === 'published' && empty($post->published_at)) {
            $validated['published_at'] = now();
        }

        // Handle image removal
        if ($request->boolean('remove_image')) {
            if ($post->featured_image && str_starts_with($post->featured_image, 'posts/')) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('featured_image')) {
            if ($post->featured_image && str_starts_with($post->featured_image, 'posts/')) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        }

        $post->update($validated);

        return redirect()->route('admin.posts.edit', $post->id)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Toggle featured status quickly.
     */
    public function toggleFeatured(Post $post)
    {
        $post->update(['is_featured' => !$post->is_featured]);
        return back()->with('success', 'Post spotlight status updated.');
    }

    /**
     * Toggle published / draft status quickly.
     */
    public function toggleStatus(Post $post)
    {
        $newStatus = $post->status === 'published' ? 'draft' : 'published';
        $post->update([
            'status' => $newStatus,
            'published_at' => $newStatus === 'published' && empty($post->published_at) ? now() : $post->published_at,
        ]);
        return back()->with('success', "Post status updated to {$newStatus}.");
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post moved to trash successfully!');
    }
}
