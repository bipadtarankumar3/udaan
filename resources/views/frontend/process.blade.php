@extends('frontend.layout')

@section('title', 'How It Works & Process — Udaan Foundation')

@section('content')
<section class="section section-light">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:30px;">
      <div class="info-card fade-in">
        <h3><i class="fas fa-clipboard-check"></i> Eligibility Criteria</h3>
        <ul>
          <li><i class="fas fa-check-circle"></i> Indian citizen or permanent resident</li>
          <li><i class="fas fa-check-circle"></i> Age between 16–45 years</li>
          <li><i class="fas fa-check-circle"></i> Minimum education: 8th standard pass (varies by program)</li>
          <li><i class="fas fa-check-circle"></i> Must provide valid ID proof (Aadhaar, Voter ID, etc.)</li>
          <li><i class="fas fa-check-circle"></i> Income certificate for scholarship programs</li>
          <li><i class="fas fa-check-circle"></i> Willingness to attend full program duration</li>
        </ul>
      </div>
      <div class="info-card fade-in">
        <h3><i class="fas fa-file-alt"></i> Required Documents</h3>
        <ul>
          <li><i class="fas fa-check-circle"></i> Aadhaar Card (original + photocopy)</li>
          <li><i class="fas fa-check-circle"></i> Recent passport-size photographs (4 nos)</li>
          <li><i class="fas fa-check-circle"></i> Educational certificates &amp; marksheets</li>
          <li><i class="fas fa-check-circle"></i> Income certificate (if applicable)</li>
          <li><i class="fas fa-check-circle"></i> Domicile / Residence proof</li>
          <li><i class="fas fa-check-circle"></i> Bank account details (passbook copy)</li>
          <li><i class="fas fa-check-circle"></i> Medical fitness certificate (for specific programs)</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Important Notes -->
<section class="section">
  <div class="container">
    <div class="info-card fade-in" style="border-left:4px solid #F77F00;">
      <h3><i class="fas fa-info-circle" style="color:#F77F00;"></i> Important Notes</h3>
      <ul>
        <li><i class="fas fa-angle-right"></i> All documents must be self-attested</li>
        <li><i class="fas fa-angle-right"></i> Application is completely <strong>FREE</strong> of charge</li>
        <li><i class="fas fa-angle-right"></i> Processing time is typically 7–14 working days</li>
        <li><i class="fas fa-angle-right"></i> Applicants will be notified via SMS and email</li>
        <li><i class="fas fa-angle-right"></i> For queries, contact our helpline: <strong>+91 6206850133</strong></li>
        <li><i class="fas fa-angle-right"></i> Walk-in applications accepted at all centers (Mon–Sat, 9 AM – 5 PM)</li>
      </ul>
    </div>
  </div>
</section>

<section class="cta-section">
  <div class="container" style="position:relative;z-index:1;">
    <h2>Start Your Journey Today</h2>
    <p>Don't wait — apply now and take the first step towards a brighter future with Udaan Foundation.</p>
    <a href="{{ route('frontend.apply') }}" class="btn btn-white">Apply Now <i class="fas fa-arrow-right"></i></a>
  </div>
</section>
@endsection
