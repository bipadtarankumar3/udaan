@extends('frontend.layout')

@section('title', 'Udaan Foundation — Empowering Lives, Inspiring Change')

@section('content')
<!-- Hero Slider -->
<section class="hero-section">
  <div class="hero-slider">
    <!-- Slide 1 -->
    <div class="hero-slide hero-slide-1 active">
      <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
      </div>
      <div class="container">
        <div class="hero-content">
          <h1>Empowering Youth Through Education</h1>
          <p>We help underprivileged students access quality education, scholarships, and mentoring to build a brighter future for themselves and their communities.</p>
          <a href="{{ route('frontend.programs') }}" class="btn btn-white" style="margin-right:12px;">Our Programs</a>
          <a href="{{ route('frontend.apply') }}" class="btn btn-outline">Apply Now</a>
        </div>
      </div>
      
    </div>
    <!-- Slide 2 -->
    <div class="hero-slide hero-slide-2">
      <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
      </div>
      <div class="container">
        <div class="hero-content">
          <h1>Building Skills for Tomorrow</h1>
          <p>Our skill development programs equip young minds with industry-ready capabilities — from computer literacy to entrepreneurship training.</p>
          <a href="{{ route('frontend.programs') }}" class="btn btn-white" style="margin-right:12px;">Learn More</a>
          <a href="{{ route('frontend.apply') }}" class="btn btn-outline">Get Involved</a>
        </div>
      </div>
      
    </div>
    <!-- Slide 3 -->
    <div class="hero-slide hero-slide-3">
      <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
      </div>
      <div class="container">
        <div class="hero-content">
          <h1>Stronger Communities, Better India</h1>
          <p>From women empowerment to community health initiatives, we're creating lasting change across 12 states and counting.</p>
          <a href="{{ route('frontend.programs') }}" class="btn btn-white" style="margin-right:12px;">Explore Programs</a>
          <a href="{{ route('frontend.contact') }}" class="btn btn-outline">Donate Now</a>
        </div>
      </div>
      
    </div>
  </div>
  <button class="hero-arrow prev"><i class="fas fa-chevron-left"></i></button>
  <button class="hero-arrow next"><i class="fas fa-chevron-right"></i></button>
  <div class="hero-dots">
    <button class="dot active"></button>
    <button class="dot"></button>
    <button class="dot"></button>
  </div>
</section>

<!-- About Section -->
<section class="section">
  <div class="container">
    <div class="about-grid">
      <div class="about-image fade-in-left">
        <div class="about-image-box"><img src="{{ asset('images') }}/about_mission.jpg" alt="About Udaan Foundation"></div>
        </div>
      </div>
      <div class="about-text fade-in-right">
        <h2>About Udaan Foundation</h2>
        <p>Udaan Foundation is a non-profit organization committed to transforming lives through education, empowerment, and community development. Since 2018, we have been working tirelessly to bridge the gap between aspiration and opportunity for underprivileged communities across India.</p>
        <p>Our mission is to create a world where every individual has the tools, skills, and confidence to achieve their full potential — regardless of their socio-economic background.</p>
        <div class="about-features">
          <div class="about-feature">
            <i class="fas fa-graduation-cap"></i>
            <span>Education Support</span>
          </div>
          <div class="about-feature">
            <i class="fas fa-cogs"></i>
            <span>Skill Development</span>
          </div>
          <div class="about-feature">
            <i class="fas fa-users"></i>
            <span>Community Building</span>
          </div>
          <div class="about-feature">
            <i class="fas fa-heart-pulse"></i>
            <span>Healthcare Access</span>
          </div>
        </div>
        <a href="{{ route('frontend.programs') }}" class="btn btn-primary mt-30">Explore Our Programs <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- Programs Section -->
<section class="section section-light">
  <div class="container">
    <div class="section-title fade-in">
      <h2>Our Programs</h2>
      <p>Comprehensive programs designed to uplift communities and create lasting impact</p>
    </div>
    <div class="programs-grid">
      <!-- Education -->
      <div class="program-card fade-in">
        <div class="program-card-icon edu"></div>
        <div class="program-card-body">
          <h3>Education Support</h3>
          <p>Free coaching, scholarships, study materials, and career counselling for underprivileged students pursuing higher education.</p>
          <a href="{{ route('frontend.programs') }}" class="btn-link">Learn More <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
      <!-- Skill Development -->
      <div class="program-card fade-in">
        <div class="program-card-icon skill"></div>
        <div class="program-card-body">
          <h3>Skill Development</h3>
          <p>Vocational training in computer skills, digital marketing, spoken English, tailoring, and financial literacy.</p>
          <a href="{{ route('frontend.programs') }}" class="btn-link">Learn More <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
      <!-- Women Empowerment -->
      <div class="program-card fade-in">
        <div class="program-card-icon women"></div>
        <div class="program-card-body">
          <h3>Women Empowerment</h3>
          <p>Self-help groups, micro-enterprise training, legal awareness workshops, and leadership development for women.</p>
          <a href="{{ route('frontend.programs') }}" class="btn-link">Learn More <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
      <!-- Community -->
      <div class="program-card fade-in">
        <div class="program-card-icon community"></div>
        <div class="program-card-body">
          <h3>Community Development</h3>
          <p>Health camps, clean water initiatives, tree plantation drives, rural infrastructure support, and disaster relief.</p>
          <a href="{{ route('frontend.programs') }}" class="btn-link">Learn More <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-item fade-in">
        <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-number" data-count="15000" data-suffix="+">0</div>
        <div class="stat-label">Students Empowered</div>
      </div>
      <div class="stat-item fade-in">
        <div class="stat-icon"><i class="fas fa-project-diagram"></i></div>
        <div class="stat-number" data-count="50" data-suffix="+">0</div>
        <div class="stat-label">Programs Running</div>
      </div>
      <div class="stat-item fade-in">
        <div class="stat-icon"><i class="fas fa-map-marked-alt"></i></div>
        <div class="stat-number" data-count="12" data-suffix="">0</div>
        <div class="stat-label">States Covered</div>
      </div>
      <div class="stat-item fade-in">
        <div class="stat-icon"><i class="fas fa-hands-helping"></i></div>
        <div class="stat-number" data-count="500" data-suffix="+">0</div>
        <div class="stat-label">Active Volunteers</div>
      </div>
    </div>
  </div>
</section>

<!-- News Section -->
<section class="section">
  <div class="container">
    <div class="section-title fade-in">
      <h2>Latest News &amp; Updates</h2>
      <p>Stay updated with our recent activities and impact stories</p>
    </div>
    <div class="news-grid">
      <div class="news-card fade-in">
        <div class="news-card-img"><div class="img-1"><i class="fas fa-laptop-code"></i></div></div>
        <div class="news-card-body">
          <div class="news-card-date"><i class="far fa-calendar-alt"></i> September 10, 2024</div>
          <h3>Udaan Foundation Launches Digital Literacy Program</h3>
          <p>A new initiative to bring computer education to 5,000 students in rural areas across Bihar and Jharkhand.</p>
          <a href="{{ route('frontend.news') }}" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="news-card fade-in">
        <div class="news-card-img"><div class="img-2"><i class="fas fa-award"></i></div></div>
        <div class="news-card-body">
          <div class="news-card-date"><i class="far fa-calendar-alt"></i> August 22, 2024</div>
          <h3>Annual Scholarship Drive Benefits 500 Students</h3>
          <p>Our flagship scholarship program successfully supported 500 meritorious students from economically weaker sections.</p>
          <a href="{{ route('frontend.news') }}" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="news-card fade-in">
        <div class="news-card-img"><div class="img-3"><i class="fas fa-female"></i></div></div>
        <div class="news-card-body">
          <div class="news-card-date"><i class="far fa-calendar-alt"></i> July 15, 2024</div>
          <h3>Women Entrepreneurs Workshop in Rural Bihar</h3>
          <p>Over 200 women attended our 3-day workshop on micro-enterprise development and financial independence.</p>
          <a href="{{ route('frontend.news') }}" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<section class="section section-light">
  <div class="container">
    <div class="section-title fade-in">
      <h2>What People Say</h2>
      <p>Hear from the lives we've touched</p>
    </div>
    <div class="testimonial-slider">
      <div class="testimonial-slide active">
        <div class="testimonial-avatar">P</div>
        <div class="quote">"Udaan Foundation gave me the coaching and guidance I needed to crack my competitive exams. Today I'm pursuing my engineering degree — something my family could never have afforded without their scholarship support."</div>
        <div class="testimonial-name">Priya Kumari</div>
        <div class="testimonial-role">Scholarship Beneficiary, Bihar</div>
      </div>
      <div class="testimonial-slide">
        <div class="testimonial-avatar">R</div>
        <div class="quote">"The skill development program transformed my life. I learned computer skills and spoken English, and now I have a stable job in an IT company. I'm forever grateful to Udaan Foundation."</div>
        <div class="testimonial-name">Rahul Vishwakarma</div>
        <div class="testimonial-role">Skill Development Graduate, Jharkhand</div>
      </div>
      <div class="testimonial-slide">
        <div class="testimonial-avatar">S</div>
        <div class="quote">"Through the women empowerment program, I started my own tailoring business. Today I employ 5 other women from my village. Udaan Foundation believed in me when no one else did."</div>
        <div class="testimonial-name">Sunita Devi</div>
        <div class="testimonial-role">Women Empowerment Program, UP</div>
      </div>
    </div>
    <div class="testimonial-dots">
      <button class="dot active"></button>
      <button class="dot"></button>
      <button class="dot"></button>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
  <div class="container" style="position:relative;z-index:1;">
    <h2>Ready to Make a Difference?</h2>
    <p>Join Udaan Foundation and be part of the change. Apply for our programs or support our mission today.</p>
    <a href="{{ route('frontend.apply') }}" class="btn btn-white" style="margin-right:12px;">Apply Now</a>
    <a href="{{ route('frontend.contact') }}" class="btn btn-outline">Donate</a>
  </div>
</section>

<!-- Footer -->

@endsection
