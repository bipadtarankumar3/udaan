@extends('frontend.layout')

@section('title', 'Our Services — Udaan Foundation')

@section('content')
<section class="section section-light">
  <div class="container">
    <div class="section-title fade-in">
      <h2>Our Core Services</h2>
      <p>Comprehensive support tailored to help you navigate your academic journey.</p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
      
      <!-- Service 1 -->
      <div class="service-card fade-in">
        <div class="service-icon"><i class="fas fa-compass"></i></div>
        <h3>1. Career Counselling</h3>
        <p>Get personalized career guidance based on your academic background, interests, skills, career goals, and future opportunities. Our counsellors help students choose suitable courses, colleges, and career pathways.</p>
      </div>

      <!-- Service 2 -->
      <div class="service-card fade-in">
        <div class="service-icon"><i class="fas fa-university"></i></div>
        <h3>2. University &amp; College Selection</h3>
        <p>Choosing the right institution is an important step toward a successful career. We assist students in comparing universities, courses, eligibility, recognition, admission criteria, fees, and career prospects.</p>
      </div>

      <!-- Service 3 -->
      <div class="service-card fade-in">
        <div class="service-icon"><i class="fas fa-file-signature"></i></div>
        <h3>3. Admission Guidance</h3>
        <p>We provide step-by-step assistance throughout the admission process, including course selection, eligibility checking, application forms, document requirements, admission procedures, and important deadlines.</p>
      </div>

      <!-- Service 4 -->
      <div class="service-card fade-in">
        <div class="service-icon"><i class="fas fa-pen-alt"></i></div>
        <h3>4. Entrance Exam Guidance</h3>
        <p>Get guidance for major entrance exams and admission processes, including eligibility, application procedures, and choice filling. <em>Bihar's official BCECEB portal is currently publishing 2026 counselling updates for UGMAC, UGEAC and PGEAC.</em></p>
      </div>

      <!-- Service 5 -->
      <div class="service-card fade-in">
        <div class="service-icon"><i class="fas fa-laptop-house"></i></div>
        <h3>5. Virtual Counselling</h3>
        <p>Connect with our education counsellors from anywhere through online counselling sessions. Get guidance regarding courses, universities, admissions, entrance examinations, and career planning without needing to visit our office.</p>
      </div>

      <!-- Service 6 -->
      <div class="service-card fade-in">
        <div class="service-icon"><i class="fas fa-id-card"></i></div>
        <h3>6. BSCC Guidance</h3>
        <p>We assist eligible students with information related to the Bihar Student Credit Card Scheme, including eligibility, applications, institution selection, documentation, and the DRCC process. <a href="https://www.7nishchay-yuvaupmission.bihar.gov.in" target="_blank" style="color:#014655;font-weight:600;">Check official portal</a>.</p>
      </div>

      <!-- Service 7 -->
      <div class="service-card fade-in">
        <div class="service-icon"><i class="fas fa-chair"></i></div>
        <h3>7. Counselling &amp; Seat Selection</h3>
        <p>Get assistance with course and college preference, merit-based selection, choice filling, counselling rounds, and seat allocation. We help students understand official counselling notifications and make informed choices.</p>
      </div>

      <!-- Service 8 -->
      <div class="service-card fade-in">
        <div class="service-icon"><i class="fas fa-globe"></i></div>
        <h3>8. Distance &amp; Online Education</h3>
        <p>Explore recognized distance and online education opportunities for UG, PG, diploma and other programmes. We help students understand course options, university selection, eligibility, and study modes.</p>
      </div>

    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="section">
  <div class="container">
    <div class="section-title fade-in">
      <h2>Why Choose Us?</h2>
      <p>Dedicated to providing authentic, reliable, and up-to-date guidance.</p>
    </div>
    
    <div class="why-choose-grid fade-in">
      <div class="why-choose-item"><i class="fas fa-check-circle"></i> <span>Expert Career Guidance</span></div>
      <div class="why-choose-item"><i class="fas fa-check-circle"></i> <span>University &amp; College Selection Support</span></div>
      <div class="why-choose-item"><i class="fas fa-check-circle"></i> <span>Admission &amp; Counselling Assistance</span></div>
      <div class="why-choose-item"><i class="fas fa-check-circle"></i> <span>Entrance Exam Guidance</span></div>
      <div class="why-choose-item"><i class="fas fa-check-circle"></i> <span>Bihar Student Credit Card Support</span></div>
      <div class="why-choose-item"><i class="fas fa-check-circle"></i> <span>Online &amp; Offline Counselling</span></div>
      <div class="why-choose-item"><i class="fas fa-check-circle"></i> <span>Distance &amp; Online Education Guidance</span></div>
      <div class="why-choose-item"><i class="fas fa-check-circle"></i> <span>Updated Info Based on Official Notifications</span></div>
    </div>
  </div>
</section>

<!-- Important Disclaimer -->
<section class="section" style="padding-top: 0;">
  <div class="container fade-in">
    <div style="background: rgba(214, 40, 40, 0.05); border: 1px solid #D62828; border-left: 5px solid #D62828; padding: 25px; border-radius: 8px;">
      <h3 style="color: #D62828; margin-bottom: 12px; display: flex; align-items: center; gap: 10px;"><i class="fas fa-exclamation-triangle"></i> Important Notice</h3>
      <p style="margin-bottom: 15px; color: #444; line-height: 1.6;">Government schemes, eligibility criteria, admission dates, counselling schedules and institutional recognition can change. Students should verify the latest notification on the relevant official government/authority portal before submitting an application.</p>
      <p style="margin-bottom: 0; color: #444; line-height: 1.6;">For example, Bihar's OFSS portal is currently publishing 2026–28 admission and selection-list updates. <a href="https://www.ofssbihar.net/Higher-Education/initiatives.aspx" target="_blank" style="color: #014655; font-weight: 600; text-decoration: underline;">Visit OFSS Bihar Portal</a></p>
    </div>
  </div>
</section>

<!-- Footer -->
@endsection
