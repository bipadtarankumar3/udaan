@extends('layouts.app')

@section('title', 'News & Blog Posts')

@section('content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600">
                    <i class="fa-solid fa-newspaper text-sm"></i>
                </span>
                <h1 class="text-xl font-bold font-heading text-slate-900">News & Articles</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">Manage public news, announcements, media updates, and educational stories.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                <i class="fa-solid fa-folder-tree"></i>
                <span>Categories</span>
            </a>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:opacity-95 text-white shadow-md shadow-red-500/20 transition">
                <i class="fa-solid fa-plus"></i>
                <span>Add New Post</span>
            </a>
        </div>
    </div>

    <!-- Status Tabs & Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-3">
            <!-- Filter Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto text-xs">
                <a href="{{ route('admin.posts.index') }}" class="px-3 py-1.5 rounded-lg font-medium transition {{ !request('status') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    All <span class="ml-1 px-1.5 py-0.5 rounded-full text-[10px] {{ !request('status') ? 'bg-slate-800 text-slate-200' : 'bg-slate-100 text-slate-600' }}">{{ $stats['all'] }}</span>
                </a>
                <a href="{{ route('admin.posts.index', ['status' => 'published']) }}" class="px-3 py-1.5 rounded-lg font-medium transition {{ request('status') === 'published' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Published <span class="ml-1 px-1.5 py-0.5 rounded-full text-[10px] {{ request('status') === 'published' ? 'bg-emerald-700 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $stats['published'] }}</span>
                </a>
                <a href="{{ route('admin.posts.index', ['status' => 'draft']) }}" class="px-3 py-1.5 rounded-lg font-medium transition {{ request('status') === 'draft' ? 'bg-amber-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Drafts <span class="ml-1 px-1.5 py-0.5 rounded-full text-[10px] {{ request('status') === 'draft' ? 'bg-amber-700 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $stats['draft'] }}</span>
                </a>
                <a href="{{ route('admin.posts.index', ['status' => 'featured']) }}" class="px-3 py-1.5 rounded-lg font-medium transition {{ request('status') === 'featured' ? 'bg-red-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-star text-[10px] mr-0.5"></i> Spotlight <span class="ml-1 px-1.5 py-0.5 rounded-full text-[10px] {{ request('status') === 'featured' ? 'bg-red-700 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $stats['featured'] }}</span>
                </a>
            </div>

            <!-- View live link -->
            <a href="{{ route('frontend.news') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 hover:text-red-700">
                <span>View News on Website</span>
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
        </div>

        <!-- Search and Category Filters Form -->
        <form method="GET" action="{{ route('admin.posts.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <div class="sm:col-span-6 relative">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by title, excerpt or content..." 
                    class="w-full pl-9 pr-4 py-2 rounded-xl text-xs border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"
                >
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            </div>

            <div class="sm:col-span-4">
                <select 
                    name="category_id" 
                    class="w-full px-3 py-2 rounded-xl text-xs border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 bg-white"
                >
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2 px-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'category_id', 'status']))
                    <a href="{{ route('admin.posts.index') }}" class="p-2 text-slate-500 hover:text-slate-700 rounded-xl hover:bg-slate-100 transition" title="Clear filters">
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4 w-16">Image</th>
                        <th class="py-3 px-4">Title</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Author</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Spotlight</th>
                        <th class="py-3 px-4">Date / Views</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($posts as $post)
                        <tr class="hover:bg-slate-50/70 transition group">
                            <!-- Image Thumbnail -->
                            <td class="py-3 px-4">
                                <img 
                                    src="{{ $post->image_url }}" 
                                    alt="{{ $post->title }}" 
                                    class="w-12 h-10 object-cover rounded-lg border border-slate-200 shadow-2xs"
                                    onerror="this.src='{{ asset('news slide (1).png') }}'"
                                >
                            </td>

                            <!-- Title & Slug -->
                            <td class="py-3 px-4 max-w-sm">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="font-semibold text-slate-900 hover:text-red-600 transition block line-clamp-1">
                                    {{ $post->title }}
                                </a>
                                <span class="text-[11px] text-slate-400 font-mono">/news/{{ $post->slug }}</span>
                            </td>

                            <!-- Category -->
                            <td class="py-3 px-4 whitespace-nowrap">
                                @if($post->category)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-100 text-slate-700">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $post->category->color ?? '#014655' }}"></span>
                                        {{ $post->category->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400 text-[11px] italic">Uncategorized</span>
                                @endif
                            </td>

                            <!-- Author -->
                            <td class="py-3 px-4 whitespace-nowrap text-slate-600">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-bold">
                                        {{ strtoupper(substr($post->author->name ?? 'Admin', 0, 1)) }}
                                    </div>
                                    <span>{{ $post->author->name ?? 'Admin' }}</span>
                                </div>
                            </td>

                            <!-- Status Toggle -->
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <form action="{{ route('admin.posts.toggle-status', $post->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-semibold transition cursor-pointer {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200' }}"
                                        title="Click to toggle status"
                                    >
                                        <i class="fa-solid {{ $post->status === 'published' ? 'fa-check' : 'fa-pen-to-square' }} text-[9px]"></i>
                                        {{ ucfirst($post->status) }}
                                    </button>
                                </form>
                            </td>

                            <!-- Spotlight Toggle -->
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <form action="{{ route('admin.posts.toggle-featured', $post->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="p-1.5 rounded-lg transition {{ $post->is_featured ? 'text-amber-500 hover:text-amber-600 bg-amber-50' : 'text-slate-300 hover:text-slate-500 hover:bg-slate-100' }}"
                                        title="{{ $post->is_featured ? 'Spotlight Active on Hero (Click to disable)' : 'Click to feature on Hero Spotlight' }}"
                                    >
                                        <i class="fa-solid fa-star {{ $post->is_featured ? 'text-amber-500' : '' }}"></i>
                                    </button>
                                </form>
                            </td>

                            <!-- Date / Views -->
                            <td class="py-3 px-4 whitespace-nowrap text-slate-500 text-[11px]">
                                <div><i class="fa-regular fa-calendar text-[10px] mr-1 text-slate-400"></i>{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Unpublished' }}</div>
                                <div class="text-[10px] text-slate-400 mt-0.5"><i class="fa-regular fa-eye text-[9px] mr-1"></i>{{ number_format($post->views_count) }} views</div>
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a 
                                        href="{{ route('frontend.news.show', $post->slug) }}" 
                                        target="_blank"
                                        class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition"
                                        title="View Live Post"
                                    >
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a 
                                        href="{{ route('admin.posts.edit', $post->id) }}" 
                                        class="p-1.5 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition"
                                        title="Edit Post"
                                    >
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition cursor-pointer"
                                            title="Delete Post"
                                        >
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <i class="fa-regular fa-newspaper text-3xl text-slate-300"></i>
                                    <p class="text-xs font-medium text-slate-600">No posts found</p>
                                    <p class="text-[11px] text-slate-400">Try adjusting your filters or create your first post.</p>
                                    <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold bg-red-600 text-white rounded-lg shadow-sm hover:bg-red-700 transition">
                                        <i class="fa-solid fa-plus text-[10px]"></i> Create Post
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
