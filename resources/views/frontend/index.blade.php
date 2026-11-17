@extends('frontend.layout')

@section('title', 'Vardhan Foundation — Empowering Minds, Building Futures | Higher Education & DRCC Guidance')
@section('meta_description', 'Vardhan Foundation provides 100% free career counselling, direct college admissions, and complete Bihar Student Credit Card (DRCC/MNSSBY up to ₹4 Lakh) loan guidance across India.')

@section('content')
<!-- Admission Notice Ticker -->
<div class="admission-ticker">
  <div class="container">
    <div class="ticker-wrap">
      <span class="ticker-badge"><i class="fas fa-bell"></i> Admissions Open 2024-25</span>
      <div class="ticker-text">
        <span>Apply now for B.Tech, B.Sc Nursing, B.Pharm, BCA, BBA &amp; Polytechnic under Bihar Student Credit Card (BSCC) — 100% Free Career Guidance &amp; Zero Advance Fees!</span>
        <a href="{{ route('frontend.apply') }}">Apply Online &rarr;</a>
      </div>
    </div>
  </div>
</div>

<!-- Modern Hero Section -->
<section class="modern-hero">
  <div class="container">
    <div class="hero-grid">
      <!-- Left Column: Headline & Action -->
      <div class="hero-text-col fade-in-left">
        <div class="hero-badge-pill">
          <i class="fas fa-shield-halved"></i> Government Approved Guidance • DRCC &amp; BSCC Support
        </div>
        <h1 class="hero-main-title">
          Empowering Minds,<br>
          <span class="gradient-text-amber">Building Futures</span>
        </h1>
        <p class="hero-lead-desc">
          India's trusted higher education counselling and student support foundation. We guide students into premier UGC &amp; AICTE approved colleges with 100% transparent admission and Bihar Student Credit Card (up to ₹4 Lakhs) loan sanction support.
        </p>

        <div class="hero-action-buttons">
          <a href="{{ route('frontend.apply') }}" class="btn-amber-glow">
            <i class="fas fa-paper-plane"></i> Apply for Free Counselling
          </a>
          <a href="{{ route('frontend.courses') }}" class="btn-glass-light">
            <i class="fas fa-graduation-cap"></i> Explore 150+ Courses
          </a>
        </div>

        <div class="hero-trust-chips">
          <div class="hero-trust-chip">
            <i class="fas fa-circle-check"></i> 100% Free Guidance
          </div>
          <div class="hero-trust-chip">
            <i class="fas fa-circle-check"></i> ₹4 Lakh DRCC Credit Card
          </div>
          <div class="hero-trust-chip">
            <i class="fas fa-circle-check"></i> 120+ Partner Colleges
          </div>
        </div>
      </div>

      <!-- Right Column: Interactive Hero Glassmorphism Card -->
      <div class="hero-card-container fade-in-right">
        <!-- Floating Stat 1 -->
        <div class="floating-stat-badge pos-top-left">
          <div class="stat-icon-wrap"><i class="fas fa-user-graduate"></i></div>
          <div class="stat-meta">
            <strong>15,000+</strong>
            <span>Students Guided</span>
          </div>
        </div>

        <!-- Floating Stat 2 -->
        <div class="floating-stat-badge pos-bottom-right">
          <div class="stat-icon-wrap"><i class="fas fa-star"></i></div>
          <div class="stat-meta">
            <strong>4.9 / 5.0</strong>
            <span>Student Rating</span>
          </div>
        </div>

        <!-- Main Card -->
        <div class="hero-featured-card">
          <div class="card-head">
            <div>
              <h4 style="color:#ffffff; font-size:18px; font-weight:800; margin:0 0 3px;">Fast-Track Admission 2024-25</h4>
              <p style="color:rgba(255,255,255,0.7); font-size:12.5px; margin:0;">Direct Allotment in NAAC &amp; UGC Accredited Campuses</p>
            </div>
            <span class="badge-live">Seats Open</span>
          </div>

          <div class="hero-card-highlights">
            <div class="hero-card-highlight-item">
              <div class="item-icon"><i class="fas fa-award"></i></div>
              <div>
                <h5>100% Free Career Counselling</h5>
                <p>Personalized college and stream matching with zero consultancy charge.</p>
              </div>
            </div>

            <div class="hero-card-highlight-item">
              <div class="item-icon"><i class="fas fa-credit-card"></i></div>
              <div>
                <h5>Bihar Student Credit Card (DRCC)</h5>
                <p>End-to-end documentation assistance to get up to ₹4,00,000 loan sanctioned.</p>
              </div>
            </div>

            <div class="hero-card-highlight-item">
              <div class="item-icon"><i class="fas fa-file-circle-check"></i></div>
              <div>
                <h5>Instant Counselling Letter</h5>
                <p>Download your verified allotment letter immediately after form submission.</p>
              </div>
            </div>
          </div>

          <a href="{{ route('frontend.apply') }}" class="btn-amber-glow" style="width:100%; justify-content:center; padding:13px 20px; font-size:14.5px;">
            Register in 1-Minute <i class="fas fa-arrow-right" style="margin-left:6px;"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 4 Pillars Section (Why Choose Us) -->
<section class="pillars-section">
  <div class="container">
    <div class="pillars-grid">
      <!-- Pillar 1 -->
      <div class="pillar-card fade-in">
        <div class="pillar-icon-box icon-blue">
          <i class="fas fa-compass"></i>
        </div>
        <h3>100% Free Career Counselling</h3>
        <p>Our senior admission mentors assess your qualification, aptitude, and aspirations to suggest the best college and course.</p>
      </div>

      <!-- Pillar 2 -->
      <div class="pillar-card fade-in">
        <div class="pillar-icon-box icon-amber">
          <i class="fas fa-hand-holding-dollar"></i>
        </div>
        <h3>DRCC / BSCC Loan Support</h3>
        <p>Complete paperwork and verification support to sanction up to ₹4,00,000 for tuition, hostel, books, and laptop under MNSSBY.</p>
      </div>

      <!-- Pillar 3 -->
      <div class="pillar-card fade-in">
        <div class="pillar-icon-box icon-green">
          <i class="fas fa-building-columns"></i>
        </div>
        <h3>120+ Top NAAC &amp; UGC Colleges</h3>
        <p>Direct admission tie-ups with verified institutions recognized by UGC, AICTE, INC, PCI, and NCTE across India.</p>
      </div>

      <!-- Pillar 4 -->
      <div class="pillar-card fade-in">
        <div class="pillar-icon-box icon-purple">
          <i class="fas fa-shield-halved"></i>
        </div>
        <h3>Zero Hidden Fees &amp; Genuine Care</h3>
        <p>No middlemen or extra charges. We stand beside each student from counselling and admission to degree completion.</p>
      </div>
    </div>
  </div>
</section>

<!-- Popular Courses Showcase -->
<section class="courses-showcase">
  <div class="container">
    <div class="section-title fade-in">
      <h2>Trending Degree &amp; Professional Programs</h2>
      <p>Explore high-demand courses eligible for Bihar Student Credit Card (BSCC) with excellent campus placements</p>
    </div>

    <div class="courses-grid-cards">
      <!-- Course 1: B.Tech -->
      <div class="course-card-modern fade-in">
        <div class="course-card-header">
          <span class="course-stream-badge badge-tech">Engineering &amp; Technology</span>
          <h3>B.Tech (CSE, AI &amp; ML, Civil, ME)</h3>
          <div class="course-meta-tags">
            <span><i class="fas fa-clock"></i> 4 Years</span>
            <span><i class="fas fa-building-columns"></i> AICTE / UGC</span>
          </div>
        </div>
        <div class="course-card-body">
          <p>Cutting-edge engineering curricula in Computer Science, AI, Mechanical, and Civil Engineering with modern labs &amp; tech internships.</p>
          <div class="course-bscc-tag">
            <i class="fas fa-check-circle"></i> BSCC Approved: Up to ₹4 Lakhs Covered
          </div>
        </div>
        <div class="course-card-footer">
          <span class="course-eligibility">Eligibility: 10+2 (PCM)</span>
          <a href="{{ route('frontend.apply') }}" class="btn-apply-sm">Apply Now <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- Course 2: B.Sc Nursing -->
      <div class="course-card-modern fade-in">
        <div class="course-card-header">
          <span class="course-stream-badge badge-medical">Healthcare &amp; Nursing</span>
          <h3>B.Sc Nursing &amp; GNM</h3>
          <div class="course-meta-tags">
            <span><i class="fas fa-clock"></i> 4 / 3 Years</span>
            <span><i class="fas fa-hospital"></i> INC Approved</span>
          </div>
        </div>
        <div class="course-card-body">
          <p>Premier nursing institutions offering multi-speciality hospital training, clinical exposure, and 100% placement support worldwide.</p>
          <div class="course-bscc-tag">
            <i class="fas fa-check-circle"></i> BSCC Approved: 0% Interest for Girls
          </div>
        </div>
        <div class="course-card-footer">
          <span class="course-eligibility">Eligibility: 10+2 (PCB)</span>
          <a href="{{ route('frontend.apply') }}" class="btn-apply-sm">Apply Now <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- Course 3: Pharmacy -->
      <div class="course-card-modern fade-in">
        <div class="course-card-header">
          <span class="course-stream-badge badge-pharmacy">Pharmaceutical Sciences</span>
          <h3>B.Pharm &amp; D.Pharm</h3>
          <div class="course-meta-tags">
            <span><i class="fas fa-clock"></i> 4 / 2 Years</span>
            <span><i class="fas fa-flask"></i> PCI Approved</span>
          </div>
        </div>
        <div class="course-card-body">
          <p>Gain in-depth pharmaceutical knowledge, medicine formulation, and clinical research skills for lucrative healthcare &amp; pharma careers.</p>
          <div class="course-bscc-tag">
            <i class="fas fa-check-circle"></i> BSCC Approved: Tuition &amp; Hostel Covered
          </div>
        </div>
        <div class="course-card-footer">
          <span class="course-eligibility">Eligibility: 10+2 (PCM/PCB)</span>
          <a href="{{ route('frontend.apply') }}" class="btn-apply-sm">Apply Now <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- Course 4: BCA -->
      <div class="course-card-modern fade-in">
        <div class="course-card-header">
          <span class="course-stream-badge badge-comp">Computer &amp; Software</span>
          <h3>BCA (Bachelor of Computer Applications)</h3>
          <div class="course-meta-tags">
            <span><i class="fas fa-clock"></i> 3 Years</span>
            <span><i class="fas fa-laptop-code"></i> UGC Recognized</span>
          </div>
        </div>
        <div class="course-card-body">
          <p>Master full-stack web development, Python, mobile apps, database architecture, and cloud computing for top IT industry jobs.</p>
          <div class="course-bscc-tag">
            <i class="fas fa-check-circle"></i> BSCC Approved: Zero Advance Fees
          </div>
        </div>
        <div class="course-card-footer">
          <span class="course-eligibility">Eligibility: 10+2 (Any Stream)</span>
          <a href="{{ route('frontend.apply') }}" class="btn-apply-sm">Apply Now <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- Course 5: BBA / MBA -->
      <div class="course-card-modern fade-in">
        <div class="course-card-header">
          <span class="course-stream-badge badge-mgmt">Management &amp; Business</span>
          <h3>BBA &amp; MBA Programs</h3>
          <div class="course-meta-tags">
            <span><i class="fas fa-clock"></i> 3 / 2 Years</span>
            <span><i class="fas fa-briefcase"></i> AICTE / UGC</span>
          </div>
        </div>
        <div class="course-card-body">
          <p>Industry-aligned business education with specializations in Finance, Digital Marketing, Human Resources, and International Business.</p>
          <div class="course-bscc-tag">
            <i class="fas fa-check-circle"></i> BSCC Approved: Loan Sanction Help
          </div>
        </div>
        <div class="course-card-footer">
          <span class="course-eligibility">Eligibility: 10+2 / Graduation</span>
          <a href="{{ route('frontend.apply') }}" class="btn-apply-sm">Apply Now <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- Course 6: Polytechnic Diploma -->
      <div class="course-card-modern fade-in">
        <div class="course-card-header">
          <span class="course-stream-badge badge-poly">Technical Diploma</span>
          <h3>Polytechnic Engineering Diploma</h3>
          <div class="course-meta-tags">
            <span><i class="fas fa-clock"></i> 3 Years</span>
            <span><i class="fas fa-gears"></i> State Board / AICTE</span>
          </div>
        </div>
        <div class="course-card-body">
          <p>Practical engineering diploma for early career start in Electrical, Mechanical, Civil, and Electronics with lateral entry to B.Tech 2nd year.</p>
          <div class="course-bscc-tag">
            <i class="fas fa-check-circle"></i> BSCC Approved: Complete Fee Support
          </div>
        </div>
        <div class="course-card-footer">
          <span class="course-eligibility">Eligibility: 10th / 12th Pass</span>
          <a href="{{ route('frontend.apply') }}" class="btn-apply-sm">Apply Now <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>

    <div class="text-center mt-30">
      <a href="{{ route('frontend.courses') }}" class="btn btn-primary" style="padding:14px 36px;">
        View All 150+ Available Courses <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- DRCC / Bihar Student Credit Card Feature Spotlight -->
<section class="section" style="padding: 40px 0 80px;">
  <div class="container">
    <div class="drcc-banner-box fade-in">
      <div class="drcc-grid">
        <div class="drcc-content">
          <span class="hero-badge-pill" style="margin-bottom:14px; background:rgba(255,165,0,0.2); color:#FCD34D; border-color:rgba(255,165,0,0.35);">
            <i class="fas fa-landmark"></i> Government of Bihar (MNSSBY)
          </span>
          <h2>Study Without Financial Burden with Bihar Student Credit Card</h2>
          <p>
            Vardhan Foundation provides end-to-end assistance to eligible students from Bihar to avail up to <strong>₹4,00,000</strong> education loan from the DRCC under the Bihar Student Credit Card Scheme. No mortgage, no advance fee, and stress-free repayment!
          </p>

          <div class="drcc-perks-list">
            <div class="drcc-perk-item">
              <i class="fas fa-check-circle"></i> Up to ₹4 Lakhs Sanction
            </div>
            <div class="drcc-perk-item">
              <i class="fas fa-check-circle"></i> 0% Interest for Girls &amp; Divyang
            </div>
            <div class="drcc-perk-item">
              <i class="fas fa-check-circle"></i> 1% Simple Interest for Boys
            </div>
            <div class="drcc-perk-item">
              <i class="fas fa-check-circle"></i> Covers Tuition, Hostel &amp; Books
            </div>
          </div>

          <a href="{{ route('frontend.apply') }}" class="btn-amber-glow">
            Check Your Eligibility Now &rarr;
          </a>
        </div>

        <div class="drcc-stats-col">
          <div class="drcc-stats-box">
            <div class="big-amount">₹4,00,000</div>
            <div class="amount-label">Maximum Loan Limit</div>
            <div class="interest-note">
              Repayment starts only <strong>1 year after course completion</strong> or after securing employment!
            </div>
            <a href="https://api.whatsapp.com/send?phone=916206850133&text=Hello%20Vardhan%20Foundation!%20I%20want%20to%20know%20about%20Bihar%20Student%20Credit%20Card." target="_blank" class="btn btn-outline" style="width:100%; justify-content:center; border-radius:50px; font-size:13.5px; border-color:rgba(255,255,255,0.4);">
              <i class="fab fa-whatsapp"></i> Chat on WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 4-Step Admission Journey -->
<section class="section section-light" style="padding-top:20px;">
  <div class="container">
    <div class="section-title fade-in">
      <h2>How It Works — Simple 4-Step Admission</h2>
      <p>Your hassle-free journey from application to campus admission with Vardhan Foundation</p>
    </div>

    <div class="journey-steps-grid">
      <div class="journey-step-card fade-in">
        <span class="step-num">01</span>
        <div class="step-icon"><i class="fas fa-file-pen"></i></div>
        <h4>Online Application</h4>
        <p>Fill out our simple 1-minute form with basic academic and contact information.</p>
      </div>

      <div class="journey-step-card fade-in">
        <span class="step-num">02</span>
        <div class="step-icon"><i class="fas fa-comments"></i></div>
        <h4>Expert Counselling</h4>
        <p>Our senior counselor calls you for course mapping, college comparison, and fee details.</p>
      </div>

      <div class="journey-step-card fade-in">
        <span class="step-num">03</span>
        <div class="step-icon"><i class="fas fa-file-invoice"></i></div>
        <h4>Allotment &amp; DRCC</h4>
        <p>Receive your official Counselling Letter and complete documentation for Student Credit Card.</p>
      </div>

      <div class="journey-step-card fade-in">
        <span class="step-num">04</span>
        <div class="step-icon"><i class="fas fa-graduation-cap"></i></div>
        <h4>College Joining</h4>
        <p>Join your chosen college campus with verified approval and zero financial stress!</p>
      </div>
    </div>
  </div>
</section>

<!-- About Vardhan Foundation Section -->
<section class="section">
  <div class="container">
    <div class="about-grid">
      <div class="about-image fade-in-left">
        <div class="about-image-box">
          <img src="{{ asset('images/about_mission.jpg') }}" alt="About Vardhan Foundation">
        </div>
      </div>
      <div class="about-text fade-in-right">
        <h2>About Vardhan Foundation</h2>
        <p><strong>Vardhan Foundation</strong> is dedicated to transforming lives through educational guidance, career mentorship, and government scholarship facilitation across India.</p>
        <p>Our mission is to ensure that no aspiring student is deprived of quality higher education due to financial hardship. Through the Bihar Student Credit Card (DRCC/MNSSBY) scheme and our direct tie-ups with 120+ premier colleges, we help thousands of students build rewarding professional careers.</p>
        <div class="about-features">
          <div class="about-feature">
            <i class="fas fa-graduation-cap"></i>
            <span>Higher Education</span>
          </div>
          <div class="about-feature">
            <i class="fas fa-credit-card"></i>
            <span>BSCC / DRCC Loan</span>
          </div>
          <div class="about-feature">
            <i class="fas fa-handshake"></i>
            <span>College Allotment</span>
          </div>
          <div class="about-feature">
            <i class="fas fa-user-check"></i>
            <span>Career Mentoring</span>
          </div>
        </div>
        <a href="{{ route('frontend.programs') }}" class="btn btn-primary mt-30">
          Explore Our Programs <i class="fas fa-arrow-right"></i>
        </a>
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
        <div class="stat-label">Students Counselled</div>
      </div>
      <div class="stat-item fade-in">
        <div class="stat-icon"><i class="fas fa-building-columns"></i></div>
        <div class="stat-number" data-count="120" data-suffix="+">0</div>
        <div class="stat-label">Recognized Colleges</div>
      </div>
      <div class="stat-item fade-in">
        <div class="stat-icon"><i class="fas fa-award"></i></div>
        <div class="stat-number" data-count="50" data-suffix="+ Cr">0</div>
        <div class="stat-label">Educational Credit Approved</div>
      </div>
      <div class="stat-item fade-in">
        <div class="stat-icon"><i class="fas fa-map-location-dot"></i></div>
        <div class="stat-number" data-count="5" data-suffix=" Branches">0</div>
        <div class="stat-label">Regional Centers in Bihar</div>
      </div>
    </div>
  </div>
</section>

<!-- Student Testimonials Section -->
<section class="section section-light">
  <div class="container">
    <div class="section-title fade-in">
      <h2>What Our Students &amp; Parents Say</h2>
      <p>Inspiring stories of students who achieved their dreams with Vardhan Foundation</p>
    </div>
    <div class="testimonial-slider">
      <!-- Testimonial 1 -->
      <div class="testimonial-slide active">
        <div class="testimonial-avatar">P</div>
        <div style="color:#F59E0B; margin-bottom:12px; font-size:16px;">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <div class="quote">"Vardhan Foundation made my dream of pursuing B.Sc Nursing a reality. Coming from a modest background, my family couldn't afford private college fees. The team helped me secure the Bihar Student Credit Card without any hassle or advance charges."</div>
        <div class="testimonial-name">Priya Kumari</div>
        <div class="testimonial-role">B.Sc Nursing Student • Patna, Bihar</div>
      </div>

      <!-- Testimonial 2 -->
      <div class="testimonial-slide">
        <div class="testimonial-avatar">R</div>
        <div style="color:#F59E0B; margin-bottom:12px; font-size:16px;">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <div class="quote">"I was confused about which engineering college to choose after 12th. The counselors at Vardhan Foundation explained all options patiently, helped with college allotment, and guided me through DRCC loan sanction. Truly 100% genuine support!"</div>
        <div class="testimonial-name">Rahul Kumar Sharma</div>
        <div class="testimonial-role">B.Tech Computer Science • Muzaffarpur, Bihar</div>
      </div>

      <!-- Testimonial 3 -->
      <div class="testimonial-slide">
        <div class="testimonial-avatar">A</div>
        <div style="color:#F59E0B; margin-bottom:12px; font-size:16px;">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <div class="quote">"Thanks to Vardhan Foundation, I secured admission in a PCI approved B.Pharm college with 100% Student Credit Card assistance. Their staff is extremely supportive and responsive on WhatsApp whenever you need them."</div>
        <div class="testimonial-name">Anjali Singh</div>
        <div class="testimonial-role">B.Pharm Student • Bhagalpur, Bihar</div>
      </div>
    </div>
    <div class="testimonial-dots">
      <button class="dot active"></button>
      <button class="dot"></button>
      <button class="dot"></button>
    </div>
  </div>
</section>

<!-- Regional Branch Centers -->
<section class="branches-section">
  <div class="container">
    <div class="section-title fade-in" style="margin-bottom:35px;">
      <h2>Visit Our Branch Centers</h2>
      <p>Meet our expert career counselors at any of our regional offices in Bihar</p>
    </div>

    <div class="branches-grid">
      <!-- Patna -->
      <div class="branch-card fade-in">
        <div class="city-icon"><i class="fas fa-building"></i></div>
        <h4>Patna (Head Office)</h4>
        <p>Near Care Hospital Naya Tola, Kumhrar</p>
        <span class="badge-office">PIN 800027</span>
      </div>

      <!-- Bhagalpur -->
      <div class="branch-card fade-in">
        <div class="city-icon"><i class="fas fa-location-dot"></i></div>
        <h4>Bhagalpur</h4>
        <p>Near Aadampur Chowk, Bharat Gas Godam</p>
        <span class="badge-office">PIN 812001</span>
      </div>

      <!-- Muzaffarpur -->
      <div class="branch-card fade-in">
        <div class="city-icon"><i class="fas fa-location-dot"></i></div>
        <h4>Muzaffarpur</h4>
        <p>Gola Road, MIMS Campus ka andar</p>
        <span class="badge-office">PIN 842001</span>
      </div>

      <!-- Chapra -->
      <div class="branch-card fade-in">
        <div class="city-icon"><i class="fas fa-location-dot"></i></div>
        <h4>Chapra</h4>
        <p>RNP School Campus, Daulatganj</p>
        <span class="badge-office">PIN 841301</span>
      </div>

      <!-- Siwan -->
      <div class="branch-card fade-in">
        <div class="city-icon"><i class="fas fa-location-dot"></i></div>
        <h4>Siwan</h4>
        <p>Bindu Davi ITI Campus, P Davi More</p>
        <span class="badge-office">PIN 841227</span>
      </div>
    </div>
  </div>
</section>

<!-- High-Converting Bottom CTA -->
<section class="cta-section">
  <div class="container" style="position:relative;z-index:1;">
    <h2>Ready to Take the Next Step Toward Your Dream Career?</h2>
    <p>Join thousands of successful students who transformed their future with Vardhan Foundation. Apply for free counselling or chat directly with our admission team today.</p>
    <a href="{{ route('frontend.apply') }}" class="btn btn-white" style="margin-right:12px;">Apply Online Now</a>
    <a href="https://api.whatsapp.com/send?phone=916206850133&text=Hello%20Vardhan%20Foundation!%20I%20want%20to%20inquire%20about%20admissions." target="_blank" class="btn btn-outline">
      <i class="fab fa-whatsapp"></i> Chat on WhatsApp
    </a>
  </div>
</section>
@endsection
