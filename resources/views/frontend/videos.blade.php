@extends('frontend.layout')

@section('title', 'Helpful Videos & Admission Guidance — Vardhan Foundation')
@section('meta_description', 'Watch helpful videos, student guidance tutorials, DRCC credit card application walkthroughs, campus tours, and success stories by Vardhan Foundation.')

@section('content')
<!-- Page Banner -->
<div class="page-banner">
  <div class="container">
    <h1>Helpful Videos &amp; Guidance</h1>
    <div class="breadcrumb">
      <a href="{{ route('frontend.index') }}">Home</a>
      <span>/</span>
      <span>Helpful Videos</span>
    </div>
  </div>
</div>

<!-- Videos Main Section -->
<section class="section section-light">
  <div class="container">

    <!-- Featured Spotlight Video Card -->
    <div class="featured-video-section fade-in">
      <div class="featured-video-grid">
        <!-- Video Preview -->
        <div class="featured-video-thumb-box" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1', 'How to Apply for Bihar Student Credit Card (DRCC) & Get up to ₹4 Lakhs Sanctioned')">
          <img src="{{ asset('news slide (3).png') }}" alt="Featured Video Thumbnail" onerror="this.src='{{ asset('images/hero_education.jpg') }}'">
          <div class="play-btn-large">
            <i class="fas fa-play"></i>
          </div>
          <span class="video-duration" style="font-size:12px; padding:4px 10px; bottom:16px; right:16px;">
            <i class="fas fa-clock" style="margin-right:4px;"></i> 12:45
          </span>
          <span class="video-category-badge" style="background:#F59E0B; color:#000; top:16px; left:16px;">
            <i class="fas fa-star" style="margin-right:4px;"></i> Featured Guide
          </span>
        </div>

        <!-- Video Info -->
        <div class="featured-video-info">
          <span class="hero-badge-pill" style="margin-bottom:12px; background:rgba(255,255,255,0.12); color:#FDE68A; border-color:rgba(255,255,255,0.25);">
            <i class="fas fa-graduation-cap"></i> Complete Admission Walkthrough
          </span>
          <h2 style="font-size:26px; font-weight:800; color:#ffffff; line-height:1.3; margin-bottom:14px;">
            How to Apply for Bihar Student Credit Card (DRCC) &amp; Get up to ₹4 Lakhs Sanctioned
          </h2>
          <p style="font-size:14px; color:rgba(255,255,255,0.85); line-height:1.6; margin-bottom:20px;">
            Watch this complete guide explaining how students from Bihar can access government loan support under MNSSBY with zero advance fee. Learn the exact documents needed and how our team assists you from college allotment to DRCC approval.
          </p>

          <div style="display:flex; align-items:center; gap:18px; margin-bottom:24px; font-size:13px; color:rgba(255,255,255,0.75);">
            <span><i class="fas fa-eye" style="color:#F59E0B; margin-right:5px;"></i> 45K+ Views</span>
            <span><i class="fas fa-calendar-check" style="color:#F59E0B; margin-right:5px;"></i> Updated 2024-25</span>
            <span><i class="fas fa-check-circle" style="color:#10B981; margin-right:5px;"></i> 100% Free Service</span>
          </div>

          <div style="display:flex; gap:12px; flex-wrap:wrap;">
            <button type="button" class="btn-amber-glow" style="cursor:pointer; border:none; padding:12px 24px; font-size:14px;" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1', 'How to Apply for Bihar Student Credit Card (DRCC) & Get up to ₹4 Lakhs Sanctioned')">
              <i class="fas fa-play"></i> Watch Video Now
            </button>
            <a href="{{ route('frontend.apply') }}" class="btn-glass-light" style="padding:12px 22px; font-size:14px;">
              <i class="fas fa-file-pen"></i> Apply for Counselling
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Category Filter Bar -->
    <div class="video-filter-bar fade-in">
      <button type="button" class="video-filter-btn active" data-category="all">All Videos</button>
      <button type="button" class="video-filter-btn" data-category="admission">Admission Guidance</button>
      <button type="button" class="video-filter-btn" data-category="drcc">DRCC &amp; Credit Card</button>
      <button type="button" class="video-filter-btn" data-category="courses">Course &amp; Career Guides</button>
      <button type="button" class="video-filter-btn" data-category="stories">Student Success Stories</button>
    </div>

    <!-- Video Grid -->
    <div class="video-grid">

      <!-- Video 1: Online Application Walkthrough -->
      <div class="video-card fade-in" data-category="admission">
        <div class="video-thumb" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1', 'How to Apply for Free Admission Counselling Online')">
          <img src="{{ asset('news slide (1).png') }}" alt="How to Apply for Free Admission Counselling Online" onerror="this.src='{{ asset('images/hero_education.jpg') }}'">
          <div class="play-btn"><i class="fas fa-play"></i></div>
          <span class="video-category-badge">Admission Guide</span>
          <span class="video-duration">06:30</span>
        </div>
        <div class="video-body">
          <h3>How to Apply for Free Admission Counselling Online</h3>
          <p>A quick 6-minute walkthrough on filling the online application form and downloading your allotment letter instantly.</p>
          <div class="video-meta-bar">
            <span><i class="fas fa-eye"></i> 24K views</span>
            <span><i class="fas fa-clock"></i> 2 weeks ago</span>
          </div>
        </div>
      </div>

      <!-- Video 2: DRCC Checklist -->
      <div class="video-card fade-in" data-category="drcc">
        <div class="video-thumb" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1', 'DRCC Bihar Student Credit Card: Essential Documents Checklist')">
          <img src="{{ asset('news slide (2).png') }}" alt="DRCC Documents Checklist" onerror="this.src='{{ asset('images/hero_skills.jpg') }}'">
          <div class="play-btn"><i class="fas fa-play"></i></div>
          <span class="video-category-badge">DRCC Scheme</span>
          <span class="video-duration">09:15</span>
        </div>
        <div class="video-body">
          <h3>DRCC Student Credit Card: Essential Documents Checklist</h3>
          <p>Everything you need: 10th/12th marksheet, resident certificate, income affidavit, and college allotment letter explained.</p>
          <div class="video-meta-bar">
            <span><i class="fas fa-eye"></i> 38K views</span>
            <span><i class="fas fa-clock"></i> 1 month ago</span>
          </div>
        </div>
      </div>

      <!-- Video 3: Success Story -->
      <div class="video-card fade-in" data-category="stories">
        <div class="video-thumb" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1', 'From Rural Bihar to Top Tech Company — Priya Kumari Success Story')">
          <img src="{{ asset('news slide (4).png') }}" alt="Priya Kumari Success Story" onerror="this.src='{{ asset('images/hero_community.jpg') }}'">
          <div class="play-btn"><i class="fas fa-play"></i></div>
          <span class="video-category-badge">Success Story</span>
          <span class="video-duration">11:20</span>
        </div>
        <div class="video-body">
          <h3>From Rural Bihar to Tech Engineer: Priya's Journey</h3>
          <p>Hear how Vardhan Foundation helped Priya secure a full Bihar Student Credit Card loan for her B.Tech degree.</p>
          <div class="video-meta-bar">
            <span><i class="fas fa-eye"></i> 52K views</span>
            <span><i class="fas fa-clock"></i> 3 weeks ago</span>
          </div>
        </div>
      </div>

      <!-- Video 4: Engineering & B.Tech Guide -->
      <div class="video-card fade-in" data-category="courses">
        <div class="video-thumb" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1', 'B.Tech Engineering Admission: Top Branches & Placements 2024-25')">
          <img src="{{ asset('news slide (5).png') }}" alt="B.Tech Guide" onerror="this.src='{{ asset('images/hero1.png') }}'">
          <div class="play-btn"><i class="fas fa-play"></i></div>
          <span class="video-category-badge">Course Guide</span>
          <span class="video-duration">14:05</span>
        </div>
        <div class="video-body">
          <h3>B.Tech Engineering: Top Branches, Fees &amp; Placement</h3>
          <p>Detailed comparison of CSE, AI &amp; ML, Mechanical, and Civil Engineering with future career outlook and salary packages.</p>
          <div class="video-meta-bar">
            <span><i class="fas fa-eye"></i> 19K views</span>
            <span><i class="fas fa-clock"></i> 2 weeks ago</span>
          </div>
        </div>
      </div>

      <!-- Video 5: B.Sc Nursing & GNM Guide -->
      <div class="video-card fade-in" data-category="courses">
        <div class="video-thumb" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1', 'B.Sc Nursing & GNM Admission: Eligibility, Hospital Training & Career Scope')">
          <img src="{{ asset('news slide (6).png') }}" alt="Nursing Admission Guide" onerror="this.src='{{ asset('images/hero2.png') }}'">
          <div class="play-btn"><i class="fas fa-play"></i></div>
          <span class="video-category-badge">Healthcare</span>
          <span class="video-duration">08:45</span>
        </div>
        <div class="video-body">
          <h3>B.Sc Nursing &amp; GNM Admission &amp; Hospital Training Guide</h3>
          <p>Important guidelines on Indian Nursing Council (INC) approvals, clinical rotations, and 0% interest loan for female students.</p>
          <div class="video-meta-bar">
            <span><i class="fas fa-eye"></i> 31K views</span>
            <span><i class="fas fa-clock"></i> 1 month ago</span>
          </div>
        </div>
      </div>

      <!-- Video 6: Pharmacy Career Guide -->
      <div class="video-card fade-in" data-category="courses">
        <div class="video-thumb" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1', 'B.Pharm & D.Pharm Admission: Scope, Approvals & Government Opportunities')">
          <img src="{{ asset('news slide (7).png') }}" alt="Pharmacy Guide" onerror="this.src='{{ asset('images/hero3.png') }}'">
          <div class="play-btn"><i class="fas fa-play"></i></div>
          <span class="video-category-badge">Pharmacy</span>
          <span class="video-duration">10:10</span>
        </div>
        <div class="video-body">
          <h3>B.Pharm &amp; D.Pharm: Scope, Approvals &amp; Government Jobs</h3>
          <p>How to become a licensed pharmacist or drug inspector. Complete breakdown of PCI college recognition and DRCC fee support.</p>
          <div class="video-meta-bar">
            <span><i class="fas fa-eye"></i> 16K views</span>
            <span><i class="fas fa-clock"></i> 3 weeks ago</span>
          </div>
        </div>
      </div>

      <!-- Video 7: DRCC Office Verification Steps -->
      <div class="video-card fade-in" data-category="drcc">
        <div class="video-thumb" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1', 'DRCC Office Verification: What to Expect on Your Appointment Day')">
          <img src="{{ asset('news slide (8).png') }}" alt="DRCC Office Verification" onerror="this.src='{{ asset('images/about_mission.jpg') }}'">
          <div class="play-btn"><i class="fas fa-play"></i></div>
          <span class="video-category-badge">DRCC Scheme</span>
          <span class="video-duration">07:50</span>
        </div>
        <div class="video-body">
          <h3>DRCC Office Verification: What to Expect on Appointment Day</h3>
          <p>Step-by-step insight into the biometric verification, document counters, and Third Party Verification (TPV) process.</p>
          <div class="video-meta-bar">
            <span><i class="fas fa-eye"></i> 42K views</span>
            <span><i class="fas fa-clock"></i> 1 month ago</span>
          </div>
        </div>
      </div>

      <!-- Video 8: BCA & IT Roadmap -->
      <div class="video-card fade-in" data-category="courses">
        <div class="video-thumb" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1', 'BCA & IT Career Roadmap: Software, Cloud & Web Development')">
          <img src="{{ asset('news slide (9).png') }}" alt="BCA & IT Roadmap" onerror="this.src='{{ asset('images/icon_skills.jpg') }}'">
          <div class="play-btn"><i class="fas fa-play"></i></div>
          <span class="video-category-badge">Computer &amp; IT</span>
          <span class="video-duration">13:20</span>
        </div>
        <div class="video-body">
          <h3>BCA &amp; IT Career Roadmap: Software, Cloud &amp; Web Development</h3>
          <p>Discover how students from arts, science, and commerce streams can build high-paying IT careers without paying heavy upfront fees.</p>
          <div class="video-meta-bar">
            <span><i class="fas fa-eye"></i> 22K views</span>
            <span><i class="fas fa-clock"></i> 2 weeks ago</span>
          </div>
        </div>
      </div>

      <!-- Video 9: Parent Testimonial & Zero-Fee Verification -->
      <div class="video-card fade-in" data-category="stories">
        <div class="video-thumb" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1', 'Zero-Fee Admission Verification: Parents & Students Speak')">
          <img src="{{ asset('news slide (6).png') }}" alt="Parent Testimonials" onerror="this.src='{{ asset('images/icon_education.jpg') }}'">
          <div class="play-btn"><i class="fas fa-play"></i></div>
          <span class="video-category-badge">Testimonials</span>
          <span class="video-duration">08:15</span>
        </div>
        <div class="video-body">
          <h3>Zero-Fee Admission Verification: Parents &amp; Students Speak</h3>
          <p>Authentic feedback from parents across Bihar who admitted their children to top engineering and nursing colleges via Vardhan Foundation.</p>
          <div class="video-meta-bar">
            <span><i class="fas fa-eye"></i> 29K views</span>
            <span><i class="fas fa-clock"></i> 1 month ago</span>
          </div>
        </div>
      </div>

    </div>

    <!-- YouTube CTA Banner -->
    <div class="drcc-banner-box fade-in" style="margin-top:50px; padding:36px; background:linear-gradient(135deg, #0A2240 0%, #155E9C 100%);">
      <div style="display:flex; align-items:center; justify-content:space-between; gap:24px; flex-wrap:wrap;">
        <div style="display:flex; align-items:center; gap:20px;">
          <div style="width:64px; height:64px; border-radius:50%; background:#FF0000; color:#fff; display:flex; align-items:center; justify-content:center; font-size:30px; flex-shrink:0; box-shadow:0 8px 25px rgba(255,0,0,0.4);">
            <i class="fab fa-youtube"></i>
          </div>
          <div>
            <h3 style="color:#ffffff; font-size:22px; font-weight:800; margin:0 0 4px;">Subscribe to Vardhan Foundation on YouTube</h3>
            <p style="color:rgba(255,255,255,0.85); font-size:14px; margin:0;">
              Get instant updates on admission cut-offs, scholarship notices, counselling dates, and campus life videos.
            </p>
          </div>
        </div>
        <div style="display:flex; gap:12px; flex-wrap:wrap;">
          <a href="https://www.youtube.com" target="_blank" class="btn btn-white" style="font-size:14px; padding:12px 26px;">
            <i class="fab fa-youtube" style="color:#FF0000;"></i> Subscribe Now
          </a>
          <a href="https://api.whatsapp.com/send?phone=916206850133&text=Hello%20Vardhan%20Foundation!%20I%20want%20to%20watch%20admission%20guidance%20videos." target="_blank" class="btn btn-outline" style="font-size:14px; padding:12px 22px; border-color:rgba(255,255,255,0.4);">
            <i class="fab fa-whatsapp" style="color:#25D366;"></i> WhatsApp Helpdesk
          </a>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Video Playback Modal Popup -->
<div id="videoModalOverlay" class="video-modal-overlay" onclick="handleModalBackdropClick(event)">
  <div class="video-modal-content">
    <div class="video-modal-header">
      <h4 id="videoModalTitle">Video Player</h4>
      <button type="button" class="video-modal-close" onclick="closeVideoModal()" aria-label="Close modal">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="video-modal-body">
      <iframe id="videoModalIframe" src="" title="Video Player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // ---------- Video Modal Logic ----------
  const videoOverlay = document.getElementById('videoModalOverlay');
  const videoIframe = document.getElementById('videoModalIframe');
  const videoTitle = document.getElementById('videoModalTitle');

  function openVideoModal(videoSrc, title) {
    if (videoOverlay && videoIframe) {
      videoTitle.textContent = title || 'Helpful Admission Video';
      videoIframe.src = videoSrc;
      videoOverlay.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeVideoModal() {
    if (videoOverlay && videoIframe) {
      videoOverlay.classList.remove('active');
      videoIframe.src = '';
      document.body.style.overflow = '';
    }
  }

  function handleModalBackdropClick(e) {
    if (e.target === videoOverlay) {
      closeVideoModal();
    }
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && videoOverlay && videoOverlay.classList.contains('active')) {
      closeVideoModal();
    }
  });

  // ---------- Category Filter Logic ----------
  const filterButtons = document.querySelectorAll('.video-filter-btn');
  const videoCards = document.querySelectorAll('.video-card');

  filterButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      filterButtons.forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const selectedCat = this.getAttribute('data-category');

      videoCards.forEach(card => {
        const cardCat = card.getAttribute('data-category');
        if (selectedCat === 'all' || cardCat === selectedCat) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
</script>
@endpush
