@extends('frontend.layout')

@section('title', 'Our Programs — Udaan Foundation')

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
<section class="cta-section">
  <div class="container" style="position:relative;z-index:1;">
    <h2>Ready to Join a Program?</h2>
    <p>Take the first step towards a better future. Apply now and our team will guide you through the process.</p>
    <a href="{{ route('frontend.apply') }}" class="btn btn-white">Apply Now <i class="fas fa-arrow-right"></i></a>
  </div>
</section>

<!-- Footer -->
@endsection
