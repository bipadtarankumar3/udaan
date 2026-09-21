@extends('frontend.layout')

@section('title', ($selectedCategory ? $selectedCategory->name . ' — ' : '') . 'News & Media — Udaan Foundation')
@section('meta_description', 'Stay updated with the latest news, scholarship announcements, skill development programs, and community welfare initiatives by Udaan Foundation.')

@push('styles')
<style>
  /* Modern News Styles */
  .news-hero-section {
    background: linear-gradient(135deg, #012b35 0%, #014655 60%, #026d7e 100%);
    position: relative;
    padding: 60px 0 45px;
    color: #fff;
    overflow: hidden;
  }
  .news-hero-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(243, 112, 33, 0.15) 0%, rgba(229, 30, 37, 0) 70%);
    border-radius: 50%;
    pointer-events: none;
  }
  .news-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    color: #F8971D;
    margin-bottom: 15px;
  }
  .news-hero-title {
    font-size: 36px;
    font-weight: 800;
    line-height: 1.25;
    margin-bottom: 12px;
    color: #ffffff;
  }
  .news-hero-sub {
    font-size: 15px;
    color: rgba(255, 255, 255, 0.85);
    max-width: 650px;
    line-height: 1.6;
  }
  
  /* Category Pills Navigation */
  .category-nav-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    overflow-x: auto;
    padding: 10px 0 5px;
    scrollbar-width: none;
  }
  .category-nav-wrap::-webkit-scrollbar {
    display: none;
  }
  .category-nav-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 18px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.15);
    transition: all 0.25s ease;
    text-decoration: none;
  }
  .category-nav-pill:hover,
  .category-nav-pill.active {
    background: #E51E25;
    color: #fff;
    border-color: #E51E25;
    box-shadow: 0 4px 15px rgba(229, 30, 37, 0.35);
    transform: translateY(-1px);
  }
  .category-nav-pill .pill-count {
    background: rgba(255, 255, 255, 0.25);
    padding: 2px 7px;
    border-radius: 20px;
    font-size: 11px;
  }

  /* Spotlight Hero Card */
  .spotlight-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
    border: 1px solid #eef2f6;
    margin-bottom: 40px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: grid;
    grid-template-columns: 1.1fr 1fr;
  }
  @media (max-width: 900px) {
    .spotlight-card {
      grid-template-columns: 1fr;
    }
  }
  .spotlight-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
  }
  .spotlight-img-wrap {
    position: relative;
    overflow: hidden;
    min-height: 280px;
  }
  .spotlight-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  .spotlight-card:hover .spotlight-img {
    transform: scale(1.04);
  }
  .spotlight-badge {
    position: absolute;
    top: 18px;
    left: 18px;
    background: linear-gradient(135deg, #E51E25, #F37021);
    color: #fff;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 10px rgba(229, 30, 37, 0.4);
  }
  .spotlight-content {
    padding: 35px 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .spotlight-meta {
    display: flex;
    align-items: center;
    gap: 15px;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 12px;
  }
  .spotlight-title {
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.35;
    margin-bottom: 14px;
    transition: color 0.2s ease;
  }
  .spotlight-title:hover {
    color: #E51E25;
  }
  .spotlight-excerpt {
    font-size: 14px;
    color: #475569;
    line-height: 1.65;
    margin-bottom: 20px;
  }
  .spotlight-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #014655;
    color: #fff;
    padding: 10px 22px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    align-self: flex-start;
  }
  .spotlight-btn:hover {
    background: #E51E25;
    color: #fff;
    transform: translateX(3px);
  }

  /* Modern News Card */
  .modern-news-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #eef2f6;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
  }
  .modern-news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.09);
    border-color: #ffd6d6;
  }
  .card-thumb-wrap {
    position: relative;
    height: 200px;
    overflow: hidden;
  }
  .card-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  .modern-news-card:hover .card-thumb {
    transform: scale(1.06);
  }
  .card-cat-badge {
    position: absolute;
    bottom: 12px;
    left: 14px;
    background: rgba(1, 70, 85, 0.9);
    backdrop-filter: blur(6px);
    color: #fff;
    padding: 4px 12px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 600;
  }
  .card-body-wrap {
    padding: 22px 20px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
  }
  .card-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 12px;
    color: #94a3b8;
    margin-bottom: 10px;
  }
  .card-title {
    font-size: 16px;
    font-weight: 700;
    line-height: 1.4;
    color: #1e293b;
    margin-bottom: 10px;
    transition: color 0.2s;
  }
  .card-title a {
    color: inherit;
    text-decoration: none;
  }
  .card-title a:hover {
    color: #E51E25;
  }
  .card-excerpt {
    font-size: 13px;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 18px;
    flex-grow: 1;
  }
  .card-footer-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 14px;
    border-top: 1px solid #f1f5f9;
    font-size: 12px;
  }
  .card-read-link {
    font-weight: 700;
    color: #E51E25;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: gap 0.2s ease;
  }
  .card-read-link:hover {
    gap: 8px;
    color: #cc1219;
  }

  /* News Sidebar Widgets */
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
  .widget-cat-item:hover .widget-cat-badge {
    background: #FFF1F1;
    color: #E51E25;
  }
  
  /* Widget Recent Post Item */
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

  /* Search Box */
  .search-widget-form {
    position: relative;
  }
  .search-widget-input {
    width: 100%;
    padding: 12px 42px 12px 16px;
    border-radius: 50px;
    border: 1px solid #e2e8f0;
    font-size: 13px;
    outline: none;
    transition: border-color 0.2s;
  }
  .search-widget-input:focus {
    border-color: #E51E25;
    box-shadow: 0 0 0 3px rgba(229, 30, 37, 0.1);
  }
  .search-widget-btn {
    position: absolute;
    right: 5px;
    top: 5px;
    bottom: 5px;
    width: 34px;
    background: #E51E25;
    color: #fff;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    transition: background 0.2s;
  }
  .search-widget-btn:hover {
    background: #cc1219;
  }
  
  /* Pagination Styling */
  .news-pagination-wrap {
    margin-top: 35px;
    display: flex;
    justify-content: center;
  }
</style>
@endpush

@section('content')
<!-- Hero / Header Section -->
<section class="news-hero-section">
  <div class="container">
    <div style="max-width:800px;">
      <div class="news-hero-badge">
        <i class="fas fa-bullhorn"></i> Official Announcements & Updates
      </div>
      <h1 class="news-hero-title">
        @if($selectedCategory)
          News in <span style="color:#FFA500;">{{ $selectedCategory->name }}</span>
        @elseif($searchQuery)
          Search Results for "<span style="color:#FFA500;">{{ $searchQuery }}</span>"
        @else
          News, Media &amp; Community Impact
        @endif
      </h1>
      <p class="news-hero-sub">
        Discover how Udaan Foundation is creating meaningful educational transformation, empowering women, and delivering student support across India.
      </p>
    </div>

    <!-- Category Filter Pills Bar -->
    <div style="margin-top:30px; border-top: 1px solid rgba(255,255,255,0.15); padding-top:15px;">
      <div class="category-nav-wrap">
        <a href="{{ route('frontend.news') }}" class="category-nav-pill {{ !$selectedCategory ? 'active' : '' }}">
          <i class="fas fa-layer-group"></i> All Topics
        </a>
        @foreach($categories as $cat)
          <a href="{{ route('frontend.news', ['category' => $cat->slug]) }}" class="category-nav-pill {{ ($selectedCategory && $selectedCategory->id === $cat->id) ? 'active' : '' }}">
            <span style="display:inline-block;width:7px;height:7px;border-radius:50%;background-color:{{ $cat->color ?? '#F8971D' }};"></span>
            {{ $cat->name }}
            <span class="pill-count">{{ $cat->published_posts_count }}</span>
          </a>
        @endforeach
      </div>
    </div>
  </div>
</section>

<!-- Main News Content Section -->
<section class="section" style="background:#f8fafc; padding: 50px 0;">
  <div class="container">
    <div class="news-layout" style="display:grid; grid-template-columns: 2fr 1fr; gap: 35px; align-items: start;">
      
      <!-- Left Column: Articles Stream -->
      <div>
        
        <!-- Spotlight / Featured Article (if available on home stream) -->
        @if($featuredPost)
          <div class="spotlight-card">
            <div class="spotlight-img-wrap">
              <img src="{{ $featuredPost->image_url }}" alt="{{ $featuredPost->title }}" class="spotlight-img" onerror="this.src='{{ asset('news slide (1).png') }}'">
              <span class="spotlight-badge"><i class="fas fa-star"></i> Featured Story</span>
            </div>
            <div class="spotlight-content">
              <div class="spotlight-meta">
                @if($featuredPost->category)
                  <span style="color:#E51E25;font-weight:700;"><i class="fas fa-folder-open"></i> {{ $featuredPost->category->name }}</span>
                @endif
                <span><i class="far fa-calendar-alt"></i> {{ $featuredPost->published_at ? $featuredPost->published_at->format('M d, Y') : '' }}</span>
                <span><i class="far fa-clock"></i> {{ $featuredPost->reading_time }}</span>
              </div>
              <h2 class="spotlight-title">
                <a href="{{ route('frontend.news.show', $featuredPost->slug) }}" style="color:inherit;text-decoration:none;">
                  {{ $featuredPost->title }}
                </a>
              </h2>
              <p class="spotlight-excerpt">
                {{ $featuredPost->excerpt }}
              </p>
              <a href="{{ route('frontend.news.show', $featuredPost->slug) }}" class="spotlight-btn">
                <span>Read Full Story</span>
                <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        @endif

        <!-- Active Filter Indicator & Count -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
          <h3 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">
            @if($selectedCategory)
              Category: {{ $selectedCategory->name }}
            @elseif($searchQuery)
              Search: "{{ $searchQuery }}"
            @else
              Latest Articles &amp; Updates
            @endif
          </h3>
          <span style="font-size:13px; color:#64748b; font-weight:500;">
            Showing {{ $posts->total() }} {{ Str::plural('article', $posts->total()) }}
          </span>
        </div>

        <!-- News Cards Grid -->
        @if($posts->count() > 0)
          <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px;">
            @foreach($posts as $post)
              <div class="modern-news-card">
                <div class="card-thumb-wrap">
                  <a href="{{ route('frontend.news.show', $post->slug) }}">
                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="card-thumb" onerror="this.src='{{ asset('news slide (1).png') }}'">
                  </a>
                  @if($post->category)
                    <span class="card-cat-badge">
                      <i class="fas fa-tag" style="font-size:9px;"></i> {{ $post->category->name }}
                    </span>
                  @endif
                </div>

                <div class="card-body-wrap">
                  <div class="card-meta">
                    <span><i class="far fa-calendar-alt"></i> {{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}</span>
                    <span>•</span>
                    <span><i class="far fa-clock"></i> {{ $post->reading_time }}</span>
                  </div>

                  <h4 class="card-title">
                    <a href="{{ route('frontend.news.show', $post->slug) }}">
                      {{ $post->title }}
                    </a>
                  </h4>

                  <p class="card-excerpt">
                    {{ Str::limit($post->excerpt ?? strip_tags($post->content), 120) }}
                  </p>

                  <div class="card-footer-wrap">
                    <div style="display:flex; align-items:center; gap:6px; color:#64748b; font-weight:500;">
                      <i class="far fa-user" style="color:#014655;"></i>
                      <span>{{ $post->author->name ?? 'Udaan Team' }}</span>
                    </div>
                    <a href="{{ route('frontend.news.show', $post->slug) }}" class="card-read-link">
                      <span>Read More</span>
                      <i class="fas fa-arrow-right" style="font-size:11px;"></i>
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <!-- Pagination -->
          <div class="news-pagination-wrap">
            {{ $posts->links() }}
          </div>

        @else
          <!-- Empty State -->
          <div style="background:#fff; border-radius:16px; padding: 50px 20px; text-align:center; border: 1px dashed #cbd5e1;">
            <div style="width:60px; height:60px; background:#fff1f1; border-radius:50%; display:flex; align-items:center; justify-content:center; margin: 0 auto 15px; color:#E51E25; font-size:24px;">
              <i class="far fa-newspaper"></i>
            </div>
            <h4 style="font-size:18px; font-weight:700; color:#0f172a; margin-bottom:8px;">No news articles found</h4>
            <p style="font-size:14px; color:#64748b; max-width:400px; margin: 0 auto 20px;">
              @if($searchQuery)
                We couldn't find any articles matching "<strong>{{ $searchQuery }}</strong>". Try searching for different keywords.
              @elseif($selectedCategory)
                There are currently no published articles under <strong>{{ $selectedCategory->name }}</strong>.
              @else
                No articles are available at the moment. Please check back soon.
              @endif
            </p>
            <a href="{{ route('frontend.news') }}" class="btn btn-primary" style="padding: 10px 24px; border-radius:50px; font-size:13px;">
              <i class="fas fa-rotate-left"></i> View All News
            </a>
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
            @if(request('category'))
              <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input 
              type="text" 
              name="search" 
              value="{{ request('search') }}" 
              placeholder="Search news, topics..." 
              class="search-widget-input"
            >
            <button type="submit" class="search-widget-btn" aria-label="Search">
              <i class="fas fa-arrow-right"></i>
            </button>
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

        <!-- Newsletter Subscription Widget -->
        <div class="modern-widget" style="background: linear-gradient(135deg, #014655 0%, #012b35 100%); color:#fff;">
          <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
            <div style="width:36px; height:36px; border-radius:8px; background:rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; color:#FFA500;">
              <i class="far fa-envelope-open"></i>
            </div>
            <h4 style="font-size:16px; font-weight:700; color:#fff; margin:0;">Stay Informed</h4>
          </div>
          <p style="font-size:13px; color:rgba(255,255,255,0.8); line-height:1.5; margin-bottom:16px;">
            Subscribe to receive direct notifications regarding admission dates, scholarships &amp; welfare drives.
          </p>
          <form onsubmit="event.preventDefault(); alert('Thank you for subscribing to Udaan Foundation updates!'); this.reset();">
            <input 
              type="email" 
              placeholder="Enter your email address" 
              required 
              style="width:100%; padding:10px 14px; border-radius:8px; border:none; margin-bottom:10px; font-size:13px; outline:none;"
            >
            <button type="submit" style="width:100%; padding:10px; background:#E51E25; color:#fff; border:none; border-radius:8px; font-weight:700; font-size:13px; cursor:pointer; transition:opacity 0.2s;">
              Subscribe Now
            </button>
          </form>
        </div>

        <!-- Photo Gallery Widget -->
        <div class="modern-widget">
          <div class="widget-heading">
            <span>Media Gallery</span>
            <i class="far fa-images" style="font-size:13px; color:#94a3b8;"></i>
          </div>
          <div class="mini-gallery" style="display:grid; grid-template-columns: repeat(3, 1fr); gap:8px;">
            <img src="{{ asset('news slide (6).png') }}" alt="Gallery photo 1" style="width:100%; height:70px; object-fit:cover; border-radius:8px;">
            <img src="{{ asset('news slide (7).png') }}" alt="Gallery photo 2" style="width:100%; height:70px; object-fit:cover; border-radius:8px;">
            <img src="{{ asset('news slide (8).png') }}" alt="Gallery photo 3" style="width:100%; height:70px; object-fit:cover; border-radius:8px;">
            <img src="{{ asset('news slide (9).png') }}" alt="Gallery photo 4" style="width:100%; height:70px; object-fit:cover; border-radius:8px;">
            <img src="{{ asset('news slide (1).png') }}" alt="Gallery photo 5" style="width:100%; height:70px; object-fit:cover; border-radius:8px;">
            <img src="{{ asset('news slide (2).png') }}" alt="Gallery photo 6" style="width:100%; height:70px; object-fit:cover; border-radius:8px;">
          </div>
        </div>

        <!-- Social Channels -->
        <div class="modern-widget">
          <div class="widget-heading">
            <span>Connect With Us</span>
            <i class="fas fa-share-nodes" style="font-size:13px; color:#94a3b8;"></i>
          </div>
          <div style="display:flex; gap:10px;">
            <a href="#" style="width:38px; height:38px; border-radius:50%; background:#f1f5f9; color:#1877f2; display:flex; align-items:center; justify-content:center; text-decoration:none; font-size:14px; transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-facebook-f"></i></a>
            <a href="#" style="width:38px; height:38px; border-radius:50%; background:#f1f5f9; color:#e4405f; display:flex; align-items:center; justify-content:center; text-decoration:none; font-size:14px; transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-instagram"></i></a>
            <a href="#" style="width:38px; height:38px; border-radius:50%; background:#f1f5f9; color:#ff0000; display:flex; align-items:center; justify-content:center; text-decoration:none; font-size:14px; transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-youtube"></i></a>
            <a href="https://api.whatsapp.com/send?phone=916206850133&text=Hello Udaan Foundation!" target="_blank" style="width:38px; height:38px; border-radius:50%; background:#f1f5f9; color:#25d366; display:flex; align-items:center; justify-content:center; text-decoration:none; font-size:14px; transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection
