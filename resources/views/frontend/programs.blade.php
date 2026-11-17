@extends('frontend.layout')

@section('title', 'Our Programs & Services — Vardhan Foundation')
@section('meta_description', 'Explore comprehensive education support, Bihar Student Credit Card (DRCC) counselling, career guidance, and skill development programs by Vardhan Foundation.')

@section('content')
<!-- Page Banner -->
<div class="page-banner">
  <div class="container">
    <h1>Our Programs &amp; Initiatives</h1>
    <div class="breadcrumb">
      <a href="{{ route('frontend.index') }}">Home</a>
      <span>/</span>
      <span>Our Programs</span>
    </div>
  </div>
</div>

<!-- Programs Grid Section -->
<section class="section section-light">
  <div class="container">
    <div class="section-title fade-in">
      <h2>Comprehensive Higher Education Programs</h2>
      <p>Transforming lives through free career counselling, financial empowerment, and verified college admissions across India</p>
    </div>

    <div class="programs-grid">
      <!-- Program 1 -->
      <div class="program-card fade-in">
        <div class="program-card-icon edu"></div>
        <div class="program-card-body">
          <h3>Higher Education Admission Guidance</h3>
          <p>Free counselling, college comparison, scholarship assistance, and direct admissions for engineering, nursing, pharmacy, IT, and management courses.</p>
          <a href="{{ route('frontend.courses') }}" class="btn-link">Explore Courses <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- Program 2 -->
      <div class="program-card fade-in">
        <div class="program-card-icon skill"></div>
        <div class="program-card-body">
          <h3>Bihar Student Credit Card (DRCC) Support</h3>
          <p>End-to-end documentation, affidavit support, and approval facilitation to help students get up to ₹4,00,000 government education loan sanctioned under MNSSBY.</p>
          <a href="{{ route('frontend.process') }}" class="btn-link">View Process <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- Program 3 -->
      <div class="program-card fade-in">
        <div class="program-card-icon women"></div>
        <div class="program-card-body">
          <h3>Career Mapping &amp; Mentorship</h3>
          <p>One-on-one sessions with senior counselors to help students choose the right stream, prepare for interviews, and understand industry hiring trends.</p>
          <a href="{{ route('frontend.apply') }}" class="btn-link">Book Free Session <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- Program 4 -->
      <div class="program-card fade-in">
        <div class="program-card-icon community"></div>
        <div class="program-card-body">
          <h3>Skill Development &amp; Placement Support</h3>
          <p>Vocational workshops in digital literacy, spoken English, technical skills, and placement assistance through our 120+ partner colleges.</p>
          <a href="{{ route('frontend.partners') }}" class="btn-link">Partner Colleges <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
  <div class="container" style="position:relative;z-index:1;">
    <h2>Ready to Join a Program?</h2>
    <p>Take the first step towards a better future. Apply now and our senior admission counselor will guide you through the entire process.</p>
    <a href="{{ route('frontend.apply') }}" class="btn btn-white" style="margin-right:12px;">Apply Now <i class="fas fa-arrow-right"></i></a>
    <a href="https://api.whatsapp.com/send?phone=916206850133&text=Hello%20Vardhan%20Foundation!%20I%20want%20to%20learn%20more%20about%20your%20programs." target="_blank" class="btn btn-outline">
      <i class="fab fa-whatsapp"></i> Chat on WhatsApp
    </a>
  </div>
</section>
@endsection
