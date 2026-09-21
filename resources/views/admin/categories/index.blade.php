@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 text-amber-600">
                    <i class="fa-solid fa-folder-tree text-sm"></i>
                </span>
                <h1 class="text-xl font-bold font-heading text-slate-900">Post Categories</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">Organize your news, media stories, and announcements into meaningful topics.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Posts</span>
            </a>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:opacity-95 text-white shadow-md shadow-red-500/20 transition">
                <i class="fa-solid fa-plus"></i>
                <span>Add Post</span>
            </a>
        </div>
    </div>

    <!-- 2-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Add New Category Form -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-4">
            <h2 class="text-sm font-bold font-heading text-slate-900 border-b border-slate-100 pb-3">Add New Category</h2>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div class="space-y-1.5">
                    <label class="font-semibold text-slate-700">Category Name <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        name="name" 
                        required 
                        placeholder="e.g. Higher Education" 
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"
                    >
                </div>

                <div class="space-y-1.5">
                    <label class="font-semibold text-slate-700">Slug (URL identifier)</label>
                    <input 
                        type="text" 
                        name="slug" 
                        placeholder="auto-generated-if-empty" 
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 font-mono text-slate-600"
                    >
                    <p class="text-[10px] text-slate-400">The "slug" is the URL-friendly version of the name.</p>
                </div>

                <div class="space-y-1.5">
                    <label class="font-semibold text-slate-700">Badge Color</label>
                    <div class="flex items-center gap-2">
                        <input 
                            type="color" 
                            name="color" 
                            value="#014655" 
                            class="w-9 h-9 p-0.5 rounded-lg border border-slate-200 cursor-pointer bg-white"
                        >
                        <span class="text-[11px] text-slate-500">Pick color for category pill tags</span>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="font-semibold text-slate-700">Description</label>
                    <textarea 
                        name="description" 
                        rows="3" 
                        placeholder="Brief summary of what this category covers..." 
                        class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-slate-700"
                    ></textarea>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-semibold transition"
                >
                    Add New Category
                </button>
            </form>
        </div>

        <!-- Right: Categories List Table -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden" x-data="{ editModal: false, editCat: {} }">
            <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Existing Categories</span>
                <span class="text-xs font-medium text-slate-400">{{ $categories->total() }} Total</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Slug</th>
                            <th class="py-3 px-4">Badge</th>
                            <th class="py-3 px-4 text-center">Posts</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-4 font-semibold text-slate-900">
                                    {{ $category->name }}
                                    @if($category->description)
                                        <p class="text-[11px] text-slate-400 font-normal mt-0.5 line-clamp-1">{{ $category->description }}</p>
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-mono text-[11px] text-slate-500">
                                    {{ $category->slug }}
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-100 text-slate-700">
                                        <span class="w-2 h-2 rounded-full" style="background-color: {{ $category->color ?? '#014655' }}"></span>
                                        {{ $category->name }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    <a href="{{ route('admin.posts.index', ['category_id' => $category->id]) }}" class="px-2 py-0.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-full font-bold text-[11px] transition">
                                        {{ $category->posts_count }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button 
                                            type="button" 
                                            @click="editCat = {{ json_encode($category) }}; editModal = true"
                                            class="p-1.5 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition"
                                            title="Edit Category"
                                        >
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category? Associated posts will become uncategorized.');">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition"
                                                title="Delete Category"
                                            >
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    No categories created yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $categories->links() }}
                </div>
            @endif

            <!-- Edit Category Modal -->
            <div 
                x-show="editModal" 
                x-cloak 
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs"
            >
                <div 
                    @click.away="editModal = false" 
                    class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md p-6 space-y-4"
                >
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h3 class="text-sm font-bold font-heading text-slate-900">Edit Category</h3>
                        <button @click="editModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
                    </div>

                    <form :action="'{{ url('admin/categories') }}/' + editCat.id" method="POST" class="space-y-3.5 text-xs">
                        @csrf
                        @method('PUT')

                        <div class="space-y-1.5">
                            <label class="font-semibold text-slate-700">Category Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                x-model="editCat.name" 
                                required 
                                class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-red-500"
                            >
                        </div>

                        <div class="space-y-1.5">
                            <label class="font-semibold text-slate-700">Slug</label>
                            <input 
                                type="text" 
                                name="slug" 
                                x-model="editCat.slug" 
                                required 
                                class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-red-500 font-mono text-slate-600"
                            >
                        </div>

                        <div class="space-y-1.5">
                            <label class="font-semibold text-slate-700">Badge Color</label>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="color" 
                                    name="color" 
                                    x-model="editCat.color" 
                                    class="w-9 h-9 p-0.5 rounded-lg border border-slate-200 cursor-pointer bg-white"
                                >
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="font-semibold text-slate-700">Description</label>
                            <textarea 
                                name="description" 
                                x-model="editCat.description" 
                                rows="3" 
                                class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:border-red-500 text-slate-700"
                            ></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                            <button type="button" @click="editModal = false" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">Cancel</button>
                            <button type="submit" class="px-4 py-2 rounded-xl text-xs font-semibold bg-red-600 hover:bg-red-700 text-white shadow-sm transition">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
