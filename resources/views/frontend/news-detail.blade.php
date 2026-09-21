@extends('frontend.layout')

@section('title', $post->title . ' — Udaan Foundation')
@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))

@push('styles')
<style>
  /* Single Article Styles */
  .article-header-section {
    background: linear-gradient(135deg, #012b35 0%, #014655 70%, #026d7e 100%);
    padding: 50px 0 40px;
    color: #fff;
  }
  .article-breadcrumb {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 20px;
  }
  .article-breadcrumb a {
    color: rgba(255, 255, 255, 0.85);
    text-decoration: none;
    transition: color 0.2s;
  }
  .article-breadcrumb a:hover {
    color: #FFA500;
  }
  .article-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #E51E25;
    color: #fff;
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 16px;
  }
  .article-main-title {
    font-size: 32px;
    font-weight: 800;
    line-height: 1.3;
    color: #ffffff;
    margin-bottom: 20px;
  }
  @media (min-width: 768px) {
    .article-main-title {
      font-size: 38px;
    }
  }
  .article-meta-bar {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 18px;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.85);
    padding-top: 15px;
    border-top: 1px solid rgba(255, 255, 255, 0.15);
  }
  .article-meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
  }
  
  /* Article Content Card */
  .article-content-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #eef2f6;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    padding: 35px 30px;
    margin-bottom: 40px;
  }
  @media (max-width: 600px) {
    .article-content-card {
      padding: 22px 16px;
    }
  }
  .article-featured-img {
    width: 100%;
    max-height: 480px;
    object-fit: cover;
    border-radius: 14px;
    margin-bottom: 30px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
  }

  /* Typography / Prose */
  .article-body {
    font-size: 16px;
    line-height: 1.8;
    color: #334155;
  }
  .article-body h2 {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    margin: 30px 0 15px;
    line-height: 1.35;
  }
  .article-body h3 {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin: 25px 0 12px;
    line-height: 1.4;
  }
  .article-body p {
    margin-bottom: 20px;
  }
  .article-body blockquote {
    margin: 25px 0;
    padding: 20px 25px;
    background: #fff8f8;
    border-left: 4px solid #E51E25;
    border-radius: 0 12px 12px 0;
    font-style: italic;
    color: #1e293b;
    font-size: 17px;
    line-height: 1.7;
  }
  .article-body ul {
    list-style-type: disc;
    padding-left: 25px;
    margin-bottom: 20px;
  }
  .article-body ol {
    list-style-type: decimal;
    padding-left: 25px;
    margin-bottom: 20px;
  }
  .article-body li {
    margin-bottom: 8px;
  }
  .article-body strong {
    color: #0f172a;
    font-weight: 700;
  }
  .article-body img {
    max-width: 100%;
    border-radius: 12px;
    margin: 20px 0;
  }

  /* Social Share Bar */
  .share-bar {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 15px;
    padding: 20px 0;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    margin: 35px 0 25px;
  }
  .share-buttons {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }
  .share-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    transition: transform 0.2s, opacity 0.2s;
  }
  .share-btn:hover {
    transform: translateY(-2px);
    opacity: 0.95;
    color: #fff;
  }
  .share-wa { background: #25D366; }
  .share-fb { background: #1877F2; }
  .share-tw { background: #1DA1F2; }
  .share-li { background: #0A66C2; }
  .share-copy { background: #475569; cursor: pointer; }

  /* Author Bio Box */
  .author-card {
    background: #f8fafc;
    border-radius: 14px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 18px;
    border: 1px solid #e2e8f0;
  }
  .author-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #014655, #E51E25);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 700;
    flex-shrink: 0;
  }

  /* Related Articles Section */
  .related-section {
    margin-top: 40px;
  }
  .related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
    margin-top: 20px;
  }

  /* Sidebar widgets styles match news index */
  .modern-widget {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px;
    border: 1px solid #eef2f6;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    margin-bottom: 25px;
  }
  .widget-heading {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    padding-bottom: 12px;
    margin-bottom: 18px;
    border-bottom: 2px solid #f1f5f9;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .widget-heading::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 40px;
    height: 2px;
    background: #E51E25;
  }
  .widget-cat-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 9px 0;
    border-bottom: 1px dashed #f1f5f9;
    font-size: 13px;
    color: #334155;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .widget-cat-item:hover {
    color: #E51E25;
    padding-left: 5px;
  }
  .widget-cat-badge {
    background: #f1f5f9;
    color: #64748b;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
  }
  .widget-recent-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
    text-decoration: none;
  }
  .widget-recent-thumb {
    width: 65px;
    height: 60px;
    border-radius: 10px;
    object-fit: cover;
    flex-shrink: 0;
  }
  .widget-recent-title {
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.35;
    transition: color 0.2s;
  }
  .widget-recent-item:hover .widget-recent-title {
    color: #E51E25;
  }
  .widget-recent-date {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 3px;
  }
</style>
@endpush

@section('content')
<!-- Header & Breadcrumb -->
<section class="article-header-section">
  <div class="container">
    <div style="max-width: 850px;">
      <!-- Breadcrumb -->
      <nav class="article-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('frontend.index') }}"><i class="fas fa-home"></i> Home</a>
        <span><i class="fas fa-chevron-right" style="font-size:10px;"></i></span>
        <a href="{{ route('frontend.news') }}">News &amp; Media</a>
        @if($post->category)
          <span><i class="fas fa-chevron-right" style="font-size:10px;"></i></span>
          <a href="{{ route('frontend.news', ['category' => $post->category->slug]) }}">{{ $post->category->name }}</a>
        @endif
        <span><i class="fas fa-chevron-right" style="font-size:10px;"></i></span>
        <span style="color:#FFA500;">Story</span>
      </nav>

      <!-- Category Tag -->
      @if($post->category)
        <a href="{{ route('frontend.news', ['category' => $post->category->slug]) }}" class="article-badge" style="background-color: {{ $post->category->color ?? '#E51E25' }}; text-decoration:none;">
          <i class="fas fa-tag"></i> {{ $post->category->name }}
        </a>
      @endif

      <!-- Article Title -->
      <h1 class="article-main-title">{{ $post->title }}</h1>

      <!-- Meta Bar -->
      <div class="article-meta-bar">
        <div class="article-meta-item">
          <i class="far fa-calendar-alt" style="color:#FFA500;"></i>
          <span>{{ $post->published_at ? $post->published_at->format('F d, Y') : 'Recently Published' }}</span>
        </div>
        <div class="article-meta-item">
          <i class="far fa-user" style="color:#FFA500;"></i>
          <span>{{ $post->author->name ?? 'Udaan Foundation' }}</span>
        </div>
        <div class="article-meta-item">
          <i class="far fa-clock" style="color:#FFA500;"></i>
          <span>{{ $post->reading_time }}</span>
        </div>
        <div class="article-meta-item">
          <i class="far fa-eye" style="color:#FFA500;"></i>
          <span>{{ number_format($post->views_count) }} views</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Article Main Body -->
<section class="section" style="background:#f8fafc; padding: 50px 0;">
  <div class="container">
    <div style="display:grid; grid-template-columns: 2fr 1fr; gap: 35px; align-items: start;">
      
      <!-- Article Left Column -->
      <div>
        <div class="article-content-card">
          
          <!-- Featured Banner Image -->
          <img 
            src="{{ $post->image_url }}" 
            alt="{{ $post->title }}" 
            class="article-featured-img" 
            onerror="this.src='{{ asset('news slide (1).png') }}'"
          >

          <!-- Rich Content -->
          <div class="article-body">
            @if(!empty($post->content))
              {!! $post->content !!}
            @else
              <p>{{ $post->excerpt }}</p>
            @endif
          </div>

          <!-- Social Share Bar -->
          <div class="share-bar">
            <div style="font-size:13px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:6px;">
              <i class="fas fa-share-nodes" style="color:#E51E25;"></i> Share this story:
            </div>
            <div class="share-buttons">
              <!-- WhatsApp -->
              <a 
                href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . url()->current()) }}" 
                target="_blank" 
                class="share-btn share-wa"
                title="Share on WhatsApp"
              >
                <i class="fab fa-whatsapp"></i> WhatsApp
              </a>
              <!-- Facebook -->
              <a 
                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                target="_blank" 
                class="share-btn share-fb"
                title="Share on Facebook"
              >
                <i class="fab fa-facebook-f"></i> Facebook
              </a>
              <!-- Twitter / X -->
              <a 
                href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" 
                target="_blank" 
                class="share-btn share-tw"
                title="Share on Twitter"
              >
                <i class="fab fa-twitter"></i> Twitter
              </a>
              <!-- LinkedIn -->
              <a 
                href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                target="_blank" 
                class="share-btn share-li"
                title="Share on LinkedIn"
              >
                <i class="fab fa-linkedin-in"></i> LinkedIn
              </a>
              <!-- Copy Link -->
              <button 
                type="button" 
                class="share-btn share-copy" 
                onclick="navigator.clipboard.writeText(window.location.href); alert('Article link copied to clipboard!');"
                title="Copy Link"
              >
                <i class="fas fa-link"></i> Copy
              </button>
            </div>
          </div>

          <!-- Author Bio Box -->
          <div class="author-card">
            <div class="author-avatar">
              {{ strtoupper(substr($post->author->name ?? 'U', 0, 1)) }}
            </div>
            <div>
              <div style="font-size:11px; font-weight:700; text-transform:uppercase; color:#E51E25; letter-spacing:0.5px;">Published By</div>
              <h4 style="font-size:16px; font-weight:700; color:#0f172a; margin: 2px 0 4px;">{{ $post->author->name ?? 'Edu. Udaan Foundation' }}</h4>
              <p style="font-size:13px; color:#64748b; margin:0; line-height:1.5;">
                Committed to delivering higher educational opportunities, BSCC student credit counselling, and grassroots community empowerment across India.
              </p>
            </div>
          </div>

          <!-- Back to News Button -->
          <div style="margin-top:25px;">
            <a href="{{ route('frontend.news') }}" class="btn btn-secondary" style="display:inline-flex; align-items:center; gap:8px; font-size:13px; padding:10px 20px; border-radius:50px; text-decoration:none;">
              <i class="fas fa-arrow-left"></i>
              <span>Back to All News</span>
            </a>
          </div>

        </div>

        <!-- Related Articles Section -->
        @if($relatedPosts->count() > 0)
          <div class="related-section">
            <h3 style="font-size:20px; font-weight:700; color:#0f172a; margin-bottom:15px; display:flex; align-items:center; gap:8px;">
              <i class="fas fa-layer-group" style="color:#E51E25;"></i>
              <span>Related News &amp; Stories</span>
            </h3>

            <div class="related-grid">
              @foreach($relatedPosts as $relPost)
                <div style="background:#fff; border-radius:14px; overflow:hidden; border:1px solid #eef2f6; box-shadow:0 2px 10px rgba(0,0,0,0.03); display:flex; flex-direction:column;">
                  <img src="{{ $relPost->image_url }}" alt="{{ $relPost->title }}" style="width:100%; height:140px; object-fit:cover;" onerror="this.src='{{ asset('news slide (1).png') }}'">
                  <div style="padding:16px; display:flex; flex-direction:column; flex-grow:1;">
                    <div style="font-size:11px; color:#94a3b8; margin-bottom:6px;">
                      <i class="far fa-calendar-alt"></i> {{ $relPost->published_at ? $relPost->published_at->format('M d, Y') : '' }}
                    </div>
                    <h5 style="font-size:14px; font-weight:700; color:#1e293b; line-height:1.4; margin-bottom:10px; flex-grow:1;">
                      <a href="{{ route('frontend.news.show', $relPost->slug) }}" style="color:inherit; text-decoration:none;">
                        {{ Str::limit($relPost->title, 65) }}
                      </a>
                    </h5>
                    <a href="{{ route('frontend.news.show', $relPost->slug) }}" style="font-size:12px; font-weight:700; color:#E51E25; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                      <span>Read Story</span>
                      <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif

      </div>

      <!-- Right Column: Sidebar -->
      <div class="news-sidebar">
        
        <!-- Search Widget -->
        <div class="modern-widget">
          <div class="widget-heading">
            <span>Search News</span>
            <i class="fas fa-search" style="font-size:13px; color:#94a3b8;"></i>
          </div>
          <form action="{{ route('frontend.news') }}" method="GET" class="search-widget-form">
            <input 
              type="text" 
              name="search" 
              placeholder="Search news, topics..." 
              style="width:100%; padding:10px 14px; border-radius:8px; border:1px solid #e2e8f0; font-size:13px; outline:none;"
            >
          </form>
        </div>

        <!-- Categories Widget -->
        <div class="modern-widget">
          <div class="widget-heading">
            <span>Categories</span>
            <i class="fas fa-folder-open" style="font-size:13px; color:#94a3b8;"></i>
          </div>
          <div>
            @foreach($categories as $category)
              <a href="{{ route('frontend.news', ['category' => $category->slug]) }}" class="widget-cat-item">
                <div style="display:flex; align-items:center; gap:8px;">
                  <span style="width:7px; height:7px; border-radius:50%; background-color: {{ $category->color ?? '#014655' }};"></span>
                  <span>{{ $category->name }}</span>
                </div>
                <span class="widget-cat-badge">{{ $category->published_posts_count }}</span>
              </a>
            @endforeach
          </div>
        </div>

        <!-- Recent Posts Widget -->
        <div class="modern-widget">
          <div class="widget-heading">
            <span>Recent Updates</span>
            <i class="fas fa-bolt" style="font-size:13px; color:#F8971D;"></i>
          </div>
          <div>
            @foreach($recentPosts as $rPost)
              <a href="{{ route('frontend.news.show', $rPost->slug) }}" class="widget-recent-item">
                <img src="{{ $rPost->image_url }}" alt="{{ $rPost->title }}" class="widget-recent-thumb" onerror="this.src='{{ asset('news slide (1).png') }}'">
                <div>
                  <h5 class="widget-recent-title">{{ Str::limit($rPost->title, 55) }}</h5>
                  <div class="widget-recent-date">
                    <i class="far fa-calendar-alt"></i> {{ $rPost->published_at ? $rPost->published_at->format('M d, Y') : '' }}
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>

        <!-- Help / Apply Card -->
        <div class="modern-widget" style="background:linear-gradient(135deg,#014655,#026d7e); color:#fff; text-align:center;">
          <i class="fas fa-graduation-cap" style="font-size:32px; color:#FFA500; margin-bottom:12px;"></i>
          <h4 style="color:#fff; font-size:16px; font-weight:700; margin-bottom:8px;">Need Higher Education Support?</h4>
          <p style="font-size:12px; color:rgba(255,255,255,0.85); line-height:1.5; margin-bottom:16px;">
            Apply for free counseling and Bihar Student Credit Card (BSCC) financial assistance today.
          </p>
          <a href="{{ route('frontend.apply') }}" style="display:inline-block; padding:10px 20px; background:#FFA500; color:#000; font-weight:700; border-radius:50px; text-decoration:none; font-size:13px;">
            Apply Now
          </a>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection
