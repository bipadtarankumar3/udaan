@extends('layouts.app')

@section('title', 'Edit Post: ' . $post->title)

@push('styles')
<style>
    .wp-title-input {
        font-family: 'Outfit', 'Inter', sans-serif;
        font-size: 1.75rem;
        font-weight: 700;
        line-height: 1.3;
    }
    .wp-title-input::placeholder {
        color: #94A3B8;
        font-weight: 600;
    }
    .wp-editor-content {
        min-height: 380px;
        line-height: 1.7;
        font-size: 0.95rem;
    }
    .wp-editor-content:focus {
        outline: none;
    }
    .wp-editor-content h2 { font-size: 1.4rem; font-weight: 700; margin: 1.2rem 0 0.6rem; color: #0F172A; }
    .wp-editor-content h3 { font-size: 1.2rem; font-weight: 600; margin: 1rem 0 0.5rem; color: #1E293B; }
    .wp-editor-content p { margin-bottom: 1rem; color: #334155; }
    .wp-editor-content blockquote { border-left: 4px solid #E51E25; padding-left: 1rem; margin: 1rem 0; font-style: italic; color: #475569; background: #FFF1F1; padding-top: 0.5rem; padding-bottom: 0.5rem; border-radius: 0 8px 8px 0; }
    .wp-editor-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
    .wp-editor-content ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
</style>
@endpush

@section('content')
<form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="postForm" x-data="wpPostEditor()">
    @csrf
    @method('PUT')

    <div class="space-y-5">
        <!-- Top WordPress-style Control Bar -->
        <div class="bg-white px-5 py-3.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sticky top-0 z-30 backdrop-blur-md bg-white/95">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.posts.index') }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition" title="Back to Posts">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $post->status === 'published' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Edit Post</span>
                        <span class="text-slate-300">|</span>
                        <span class="text-xs text-slate-500" x-text="status === 'published' ? 'Published' : 'Draft'"></span>
                    </div>
                </div>
            </div>

            <!-- Header Action Buttons -->
            <div class="flex items-center gap-2">
                <a 
                    href="{{ route('frontend.news.show', $post->slug) }}" 
                    target="_blank" 
                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition flex items-center gap-1.5"
                >
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    <span>View Post</span>
                </a>
                <button 
                    type="submit" 
                    @click="status = 'draft'"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition"
                >
                    Save as Draft
                </button>
                <button 
                    type="submit" 
                    class="px-5 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:opacity-95 text-white shadow-md shadow-red-500/20 transition flex items-center gap-1.5"
                >
                    <i class="fa-solid fa-check text-[11px]"></i>
                    <span>Update Post</span>
                </button>
            </div>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs space-y-1">
                <div class="font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>Please correct the errors below:</span>
                </div>
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main 2-Column WordPress Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Main Column (Content & Excerpt) -->
            <div class="lg:col-span-8 space-y-5">
                
                <!-- Main Post Content Card -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                    
                    <!-- Post Title Input -->
                    <div>
                        <input 
                            type="text" 
                            name="title" 
                            id="postTitle"
                            x-model="title"
                            placeholder="Add title" 
                            class="w-full wp-title-input text-slate-900 border-0 border-b border-slate-200 pb-3 focus:outline-none focus:border-red-500 transition px-0"
                            required
                        >
                    </div>

                    <!-- Permalink Slug Preview & Edit -->
                    <div class="flex flex-wrap items-center gap-1.5 text-xs text-slate-500 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                        <span class="font-medium text-slate-600"><i class="fa-solid fa-link text-[11px] mr-1 text-slate-400"></i> Permalink:</span>
                        <span class="text-slate-400">{{ url('/news') }}/</span>
                        <div class="flex items-center gap-1">
                            <input 
                                type="text" 
                                name="slug" 
                                id="postSlug"
                                x-model="slug"
                                class="px-2 py-0.5 rounded text-xs font-mono bg-white border border-slate-200 text-slate-800 focus:outline-none focus:border-red-500"
                            >
                            <a href="{{ route('frontend.news.show', $post->slug) }}" target="_blank" class="text-red-600 hover:text-red-700 ml-1" title="Open Link">
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- WordPress Rich Text Toolbar -->
                    <div class="border border-slate-200 rounded-xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-50 border-b border-slate-200 px-3 py-2 flex flex-wrap items-center justify-between gap-2">
                            <!-- Formatting Tools -->
                            <div class="flex flex-wrap items-center gap-1">
                                <button type="button" @click="formatDoc('bold')" class="p-1.5 w-8 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition font-bold" title="Bold (Ctrl+B)"><b>B</b></button>
                                <button type="button" @click="formatDoc('italic')" class="p-1.5 w-8 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition italic" title="Italic (Ctrl+I)"><i>I</i></button>
                                <button type="button" @click="formatDoc('underline')" class="p-1.5 w-8 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition underline" title="Underline (Ctrl+U)"><u>U</u></button>
                                <button type="button" @click="formatDoc('strikeThrough')" class="p-1.5 w-8 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition line-through" title="Strikethrough"><s>S</s></button>
                                <span class="w-px h-5 bg-slate-200 mx-1"></span>
                                <button type="button" @click="formatBlock('h2')" class="px-2 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition text-xs font-bold" title="Heading 2">H2</button>
                                <button type="button" @click="formatBlock('h3')" class="px-2 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition text-xs font-bold" title="Heading 3">H3</button>
                                <button type="button" @click="formatBlock('p')" class="px-2 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition text-xs font-medium" title="Paragraph">¶</button>
                                <span class="w-px h-5 bg-slate-200 mx-1"></span>
                                <button type="button" @click="formatDoc('insertUnorderedList')" class="p-1.5 w-8 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition text-xs" title="Bullet List"><i class="fa-solid fa-list-ul"></i></button>
                                <button type="button" @click="formatDoc('insertOrderedList')" class="p-1.5 w-8 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition text-xs" title="Numbered List"><i class="fa-solid fa-list-ol"></i></button>
                                <button type="button" @click="formatBlock('blockquote')" class="p-1.5 w-8 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition text-xs" title="Quote"><i class="fa-solid fa-quote-left"></i></button>
                                <span class="w-px h-5 bg-slate-200 mx-1"></span>
                                <button type="button" @click="insertLink()" class="p-1.5 w-8 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition text-xs" title="Insert Link"><i class="fa-solid fa-link"></i></button>
                                <button type="button" @click="insertImagePrompt()" class="p-1.5 w-8 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition text-xs" title="Insert Image by URL"><i class="fa-regular fa-image"></i></button>
                                <button type="button" @click="formatDoc('removeFormat')" class="p-1.5 w-8 h-8 rounded text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition text-xs" title="Clear Formatting"><i class="fa-solid fa-eraser"></i></button>
                            </div>

                            <!-- Visual / Text HTML Tabs -->
                            <div class="flex items-center bg-slate-200/80 p-0.5 rounded-lg text-[11px] font-medium">
                                <button 
                                    type="button" 
                                    @click="switchMode('visual')" 
                                    :class="mode === 'visual' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                                    class="px-2.5 py-1 rounded transition"
                                >
                                    Visual
                                </button>
                                <button 
                                    type="button" 
                                    @click="switchMode('html')" 
                                    :class="mode === 'html' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                                    class="px-2.5 py-1 rounded transition font-mono"
                                >
                                    HTML / Code
                                </button>
                            </div>
                        </div>

                        <!-- Editable Visual Area -->
                        <div 
                            x-show="mode === 'visual'"
                            id="editorVisual" 
                            contenteditable="true" 
                            @input="syncFromVisual()"
                            class="wp-editor-content p-4 bg-white focus:outline-none"
                        >{!! $post->content !!}</div>

                        <!-- Code / HTML Area -->
                        <textarea 
                            x-show="mode === 'html'"
                            name="content" 
                            id="editorHtml" 
                            x-model="content"
                            @input="syncFromHtml()"
                            class="w-full wp-editor-content p-4 font-mono text-xs text-slate-800 bg-slate-900 text-slate-100 focus:outline-none resize-y"
                            rows="16"
                        ></textarea>
                    </div>

                    <!-- Hidden real content field for form submission if visual is used -->
                    <textarea name="content" x-model="content" class="hidden"></textarea>

                    <!-- Word & Character Count Bar -->
                    <div class="flex items-center justify-between text-[11px] text-slate-400 pt-1">
                        <span x-text="getWordCount() + ' words'"></span>
                        <span>Last updated: {{ $post->updated_at->diffForHumans() }}</span>
                    </div>
                </div>

                <!-- Excerpt / Summary Box (WordPress style) -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-align-left text-slate-400"></i>
                            <span>Excerpt / Short Summary</span>
                        </label>
                        <span class="text-[10px] text-slate-400">Optional (used in news cards and SEO)</span>
                    </div>
                    <textarea 
                        name="excerpt" 
                        rows="3" 
                        placeholder="Write a brief 1-2 sentence excerpt summarizing this article..." 
                        class="w-full p-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-slate-700"
                    >{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>
            </div>

            <!-- Right Sidebar Column (WordPress Document Settings Panel) -->
            <div class="lg:col-span-4 space-y-5">
                
                <!-- 1. Publish Box -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="bg-slate-50/80 px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-bullhorn text-red-600"></i>
                            <span>Publish Settings</span>
                        </h3>
                    </div>
                    
                    <div class="p-4 space-y-3.5 text-xs">
                        <!-- Status Selection -->
                        <div class="space-y-1.5">
                            <label class="font-semibold text-slate-700">Status:</label>
                            <select 
                                name="status" 
                                x-model="status" 
                                class="w-full px-3 py-2 rounded-xl text-xs border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 bg-white"
                            >
                                <option value="published">Published (Public)</option>
                                <option value="draft">Draft (Private)</option>
                            </select>
                        </div>

                        <!-- Publish Date -->
                        <div class="space-y-1.5">
                            <label class="font-semibold text-slate-700">Publish Date & Time:</label>
                            <input 
                                type="datetime-local" 
                                name="published_at" 
                                value="{{ $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i') }}"
                                class="w-full px-3 py-2 rounded-xl text-xs border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 bg-white"
                            >
                        </div>

                        <!-- Action Buttons inside Card -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <button 
                                type="submit" 
                                @click="status = 'draft'" 
                                class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-100 transition"
                            >
                                Switch to Draft
                            </button>
                            <button 
                                type="submit" 
                                class="px-4 py-2 rounded-xl text-xs font-semibold bg-red-600 hover:bg-red-700 text-white shadow-sm transition"
                            >
                                Update Post
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 2. Categories Box with Inline Category Creator -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden" x-data="{ showNewCat: false, newCatName: '', creatingCat: false }">
                    <div class="bg-slate-50/80 px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-folder text-amber-500"></i>
                            <span>Category</span>
                        </h3>
                    </div>

                    <div class="p-4 space-y-3">
                        <div class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar pr-1" id="categoryRadioList">
                            @foreach($categories as $category)
                                <label class="flex items-center gap-2 text-xs text-slate-700 hover:text-slate-900 cursor-pointer p-1 rounded hover:bg-slate-50">
                                    <input 
                                        type="radio" 
                                        name="category_id" 
                                        value="{{ $category->id }}"
                                        {{ $post->category_id == $category->id ? 'checked' : '' }}
                                        class="text-red-600 focus:ring-red-500 rounded-full"
                                    >
                                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $category->color ?? '#014655' }}"></span>
                                    <span>{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>

                        <!-- Inline Add New Category Toggle -->
                        <div class="pt-2 border-t border-slate-100">
                            <button 
                                type="button" 
                                @click="showNewCat = !showNewCat"
                                class="text-xs font-semibold text-red-600 hover:text-red-700 flex items-center gap-1"
                            >
                                <i class="fa-solid" :class="showNewCat ? 'fa-minus' : 'fa-plus'"></i>
                                <span>Add New Category</span>
                            </button>

                            <!-- Add category inline subform -->
                            <div x-show="showNewCat" x-cloak class="mt-2.5 p-2.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                                <input 
                                    type="text" 
                                    x-model="newCatName" 
                                    placeholder="New category name" 
                                    class="w-full px-2.5 py-1.5 rounded-lg text-xs border border-slate-200 focus:outline-none focus:border-red-500"
                                >
                                <button 
                                    type="button" 
                                    @click="createNewCategory()"
                                    :disabled="creatingCat || !newCatName.trim()"
                                    class="w-full py-1.5 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-semibold disabled:opacity-50 transition"
                                >
                                    <span x-show="!creatingCat">+ Create & Select</span>
                                    <span x-show="creatingCat">Creating...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Featured Image Box -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden" x-data="imageUploader('{{ $post->image_url }}')">
                    <div class="bg-slate-50/80 px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-image text-emerald-600"></i>
                            <span>Featured Image</span>
                        </h3>
                    </div>

                    <div class="p-4 space-y-3">
                        <input type="hidden" name="remove_image" x-model="removeImageFlag">

                        <div 
                            @click="$refs.fileInput.click()" 
                            class="border-2 border-dashed border-slate-200 hover:border-red-400 rounded-xl p-3 text-center cursor-pointer transition bg-slate-50/50 hover:bg-red-50/20 group relative overflow-hidden"
                        >
                            <template x-if="previewUrl">
                                <div class="space-y-2">
                                    <img :src="previewUrl" class="w-full h-40 object-cover rounded-lg shadow-sm border border-slate-200">
                                    <p class="text-[11px] text-red-600 font-medium group-hover:underline">Click to change image</p>
                                </div>
                            </template>

                            <template x-if="!previewUrl">
                                <div class="py-6 space-y-2">
                                    <div class="w-10 h-10 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center group-hover:bg-red-100 group-hover:text-red-600 transition">
                                        <i class="fa-regular fa-image text-lg"></i>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-700">Set featured image</p>
                                    <p class="text-[10px] text-slate-400">PNG, JPG, WEBP up to 5MB</p>
                                </div>
                            </template>
                        </div>

                        <input 
                            type="file" 
                            name="featured_image" 
                            x-ref="fileInput" 
                            @change="handleFileChange($event)" 
                            accept="image/*" 
                            class="hidden"
                        >

                        <template x-if="previewUrl">
                            <button 
                                type="button" 
                                @click="removeImage()" 
                                class="w-full py-1 text-xs text-red-600 hover:text-red-700 font-medium transition flex items-center justify-center gap-1"
                            >
                                <i class="fa-solid fa-trash text-[10px]"></i> Remove featured image
                            </button>
                        </template>
                    </div>
                </div>

                <!-- 4. Spotlight on Hero Toggle -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_featured" 
                            value="1" 
                            {{ $post->is_featured ? 'checked' : '' }}
                            class="mt-0.5 rounded text-red-600 focus:ring-red-500 w-4 h-4"
                        >
                        <div>
                            <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <i class="fa-solid fa-star text-amber-500 text-xs"></i>
                                <span>Pin as Hero Spotlight</span>
                            </span>
                            <p class="text-[11px] text-slate-500 mt-0.5">Feature this post prominently at the top of the news portal as the main headline story.</p>
                        </div>
                    </label>
                </div>

            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
function wpPostEditor() {
    return {
        title: @json($post->title),
        slug: @json($post->slug),
        content: @json($post->content ?? ''),
        status: @json($post->status),
        mode: 'visual',

        formatDoc(cmd, value = null) {
            document.execCommand(cmd, false, value);
            this.syncFromVisual();
        },

        formatBlock(tag) {
            document.execCommand('formatBlock', false, tag);
            this.syncFromVisual();
        },

        insertLink() {
            const url = prompt('Enter link URL:');
            if (url) {
                document.execCommand('createLink', false, url);
                this.syncFromVisual();
            }
        },

        insertImagePrompt() {
            const url = prompt('Enter Image URL:');
            if (url) {
                document.execCommand('insertImage', false, url);
                this.syncFromVisual();
            }
        },

        switchMode(newMode) {
            if (newMode === 'html') {
                this.content = document.getElementById('editorVisual').innerHTML;
            } else if (newMode === 'visual') {
                document.getElementById('editorVisual').innerHTML = this.content;
            }
            this.mode = newMode;
        },

        syncFromVisual() {
            this.content = document.getElementById('editorVisual').innerHTML;
        },

        syncFromHtml() {
            document.getElementById('editorVisual').innerHTML = this.content;
        },

        getWordCount() {
            const text = this.content.replace(/<[^>]*>?/gm, '').trim();
            return text ? text.split(/\s+/).length : 0;
        },

        createNewCategory() {
            if (!this.newCatName.trim()) return;
            this.creatingCat = true;

            fetch("{{ route('admin.categories.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ name: this.newCatName })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.category) {
                    const list = document.getElementById('categoryRadioList');
                    const label = document.createElement('label');
                    label.className = "flex items-center gap-2 text-xs text-slate-700 hover:text-slate-900 cursor-pointer p-1 rounded hover:bg-slate-50";
                    label.innerHTML = `
                        <input type="radio" name="category_id" value="${data.category.id}" checked class="text-red-600 focus:ring-red-500 rounded-full">
                        <span class="w-2 h-2 rounded-full" style="background-color: ${data.category.color || '#014655'}"></span>
                        <span>${data.category.name}</span>
                    `;
                    list.prepend(label);
                    this.newCatName = '';
                    this.showNewCat = false;
                }
            })
            .catch(err => {
                alert('Error creating category. Please try again.');
            })
            .finally(() => {
                this.creatingCat = false;
            });
        }
    }
}

function imageUploader(initialUrl) {
    return {
        previewUrl: initialUrl || null,
        removeImageFlag: '0',
        handleFileChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.previewUrl = URL.createObjectURL(file);
                this.removeImageFlag = '0';
            }
        },
        removeImage() {
            this.previewUrl = null;
            this.removeImageFlag = '1';
            this.$refs.fileInput.value = '';
        }
    }
}
</script>
@endpush
@endsection
