@extends('frontend.layout')

@section('title', 'Helpful Videos — Udaan Foundation')

@section('content')
<div class="mobile-nav">
  <div class="mobile-nav-header"><img src="logo.png" alt="Udaan Foundation"><button class="mobile-nav-close"><i class="fas fa-times"></i></button></div>
  <ul>
    <li><a href="{{ route('frontend.index') }}">Home</a></li>
    <li><a href="{{ route('frontend.courses') }}">Available Courses</a></li>
    <li class="has-sub"><a href="#">Process</a><ul class="sub-menu"><li><a href="{{ route('frontend.process') }}">How It Works</a></li><li><a href="{{ route('frontend.enrollment') }}">Enrollment Process</a></li></ul></li>
    <li><a href="{{ route('frontend.confirmation') }}">Counselling Letter</a></li>
    <li><a href="{{ route('frontend.news') }}">News &amp; Media</a></li>
    <li><a href="{{ route('frontend.videos') }}">Helpful Videos</a></li>
    <li><a href="{{ route('frontend.partners') }}">Approvals</a></li>
    <li><a href="{{ route('frontend.contact') }}">Contact</a></li>
    <li><a href="{{ route('frontend.services') }}">Services</a></li>
    <li><a href="{{ route('frontend.apply') }}" style="color:#FFA500;font-weight:700;">Apply Now</a></li>
  </ul>
</div>

        <div class="video-body">
          <h3>How to Apply for Udaan Foundation Programs</h3>
          <p>Step-by-step video guide on the application process</p>
        </div>
      </div>
      <!-- Video 2 -->
      <div class="video-card fade-in">
        <div class="video-thumb" style="background:linear-gradient(135deg,#D62828,#e85d5d);">
          
          <div class="play-btn"><i class="fas fa-play"></i></div>
        </div>
        <div class="video-body">
          <h3>Success Story: Priya's Journey from Village to Engineer</h3>
          <p>Inspiring story of a scholarship beneficiary</p>
        </div>
      </div>
      <!-- Video 3 -->
      <div class="video-card fade-in">
        <div class="video-thumb" style="background:linear-gradient(135deg,#F77F00,#f9a84d);">
          
          <div class="play-btn"><i class="fas fa-play"></i></div>
        </div>
        <div class="video-body">
          <h3>Women Empowerment Workshop Highlights</h3>
          <p>Highlights from our 3-day workshop in rural Bihar</p>
        </div>
      </div>
      <!-- Video 4 -->
      <div class="video-card fade-in">
        <div class="video-thumb" style="background:linear-gradient(135deg,#FCBF49,#fdd98b);">
          
          <div class="play-btn"><i class="fas fa-play"></i></div>
        </div>
        <div class="video-body">
          <h3>Computer Skills Training — Batch 2024</h3>
          <p>See what our students learn in the digital literacy program</p>
        </div>
      </div>
      <!-- Video 5 -->
      <div class="video-card fade-in">
        <div class="video-thumb" style="background:linear-gradient(135deg,#014655,#D62828);">
          
          <div class="play-btn"><i class="fas fa-play"></i></div>
        </div>
        <div class="video-body">
          <h3>Health Camp Documentary — Patna 2024</h3>
          <p>Coverage of our free health camp serving 1,200+ residents</p>
        </div>
      </div>
      <!-- Video 6 -->
      <div class="video-card fade-in">
        <div class="video-thumb" style="background:linear-gradient(135deg,#F77F00,#014655);">
          
          <div class="play-btn"><i class="fas fa-play"></i></div>
        </div>
        <div class="video-body">
          <h3>Green India Campaign — 50,000 Trees Milestone</h3>
          <p>Celebrating our environmental impact across 5 states</p>
        </div>
      </div>
      <!-- Video 7 -->
      <div class="video-card fade-in">
        <div class="video-thumb" style="background:linear-gradient(135deg,#D62828,#FCBF49);">
          
          <div class="play-btn"><i class="fas fa-play"></i></div>
        </div>
        <div class="video-body">
          <h3>Scholarship Application Tips &amp; Tricks</h3>
          <p>Expert advice on how to write a winning scholarship application</p>
        </div>
      </div>
      <!-- Video 8 -->
      <div class="video-card fade-in">
        <div class="video-thumb" style="background:linear-gradient(135deg,#014655,#FCBF49);">
          
          <div class="play-btn"><i class="fas fa-play"></i></div>
        </div>
        <div class="video-body">
          <h3>Annual Report 2024 — Impact Highlights</h3>
          <p>A visual summary of our impact and achievements this year</p>
        </div>
      </div>
      <!-- Video 9 -->
      <div class="video-card fade-in">
        <div class="video-thumb" style="background:linear-gradient(135deg,#F77F00,#D62828);">
          
          <div class="play-btn"><i class="fas fa-play"></i></div>
        </div>
        <div class="video-body">
          <h3>Volunteer Testimonials — Why We Serve</h3>
          <p>Hear from our dedicated volunteers across India</p>
        </div>
      </div>
    </div>

    <!-- YouTube CTA -->
    <div class="text-center mt-30 fade-in">
      <p style="font-size:16px;color:#555;margin-bottom:16px;">Subscribe to our YouTube channel for more videos and updates!</p>
      <a href="#" class="btn btn-primary" target="_blank"><i class="fab fa-youtube"></i> Subscribe on YouTube</a>
    </div>
  </div>
</section>
@endsection
