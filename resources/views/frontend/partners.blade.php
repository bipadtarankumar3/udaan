@extends('frontend.layout')

@section('title', 'Approvals & Partners — Udaan Foundation')

@section('content')
<section class="section" style="padding: 0;">
  <div style="width: 100%;">
    <img src="{{ asset('images') }}/approvals.png" alt="Our Colleges Are Approved By" style="width: 100%; height: auto; display: block;">
  </div>
</section>

<!-- Certifications -->
<section class="section section-light">
  <div class="container">
    <div class="section-title fade-in">
      <h2>Certifications &amp; Recognitions</h2>
      <p>Trusted, verified, and recognized by national and international bodies</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:30px;">
      <div class="info-card fade-in text-center">
        <div style="font-size:48px;color:#D62828;margin-bottom:15px;"><i class="fas fa-certificate"></i></div>
        <h3 style="font-size:18px;">NGO Darpan Registered</h3>
        <p style="font-size:14px;color:#555;">Registered with NITI Aayog's NGO Darpan portal. Unique ID: BR/2018/XXXXXX</p>
      </div>
      <div class="info-card fade-in text-center">
        <div style="font-size:48px;color:#F77F00;margin-bottom:15px;"><i class="fas fa-shield-alt"></i></div>
        <h3 style="font-size:18px;">12A &amp; 80G Certified</h3>
        <p style="font-size:14px;color:#555;">Income Tax exemption under Section 12A and 80G. Donations are tax-deductible.</p>
      </div>
      <div class="info-card fade-in text-center">
        <div style="font-size:48px;color:#014655;margin-bottom:15px;"><i class="fas fa-award"></i></div>
        <h3 style="font-size:18px;">ISO 9001:2015</h3>
        <p style="font-size:14px;color:#555;">Quality Management System certified for organizational excellence.</p>
      </div>
      <div class="info-card fade-in text-center">
        <div style="font-size:48px;color:#FCBF49;margin-bottom:15px;"><i class="fas fa-check-double"></i></div>
        <h3 style="font-size:18px;">FCRA Registered</h3>
        <p style="font-size:14px;color:#555;">Foreign Contribution Regulation Act registration for international funding.</p>
      </div>
      <div class="info-card fade-in text-center">
        <div style="font-size:48px;color:#D62828;margin-bottom:15px;"><i class="fas fa-trophy"></i></div>
        <h3 style="font-size:18px;">National CSR Award 2023</h3>
        <p style="font-size:14px;color:#555;">Recognized for outstanding contribution to community development.</p>
      </div>
      <div class="info-card fade-in text-center">
        <div style="font-size:48px;color:#F77F00;margin-bottom:15px;"><i class="fas fa-handshake"></i></div>
        <h3 style="font-size:18px;">GuideStar India Platinum</h3>
        <p style="font-size:14px;color:#555;">Highest level of transparency certification from GuideStar India.</p>
      </div>
    </div>
  </div>
</section>

<!-- Become a Partner CTA -->
<section class="cta-section">
  <div class="container" style="position:relative;z-index:1;">
    <h2>Become a Partner</h2>
    <p>Join hands with Udaan Foundation to create lasting social impact. We welcome partnerships with corporates, NGOs, and government bodies.</p>
    <a href="{{ route('frontend.contact') }}" class="btn btn-white">Partner With Us <i class="fas fa-arrow-right"></i></a>
  </div>
</section>
@endsection
