<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Udaan Foundation — Empowering Lives, Inspiring Change')</title>
  <meta name="description" content="@yield('meta_description', 'Udaan Foundation empowers communities through education, skill development, women empowerment, and community development programs across India.')">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  @stack('styles')
</head>
<body>

<!-- Preloader -->
<div id="preloader"><div class="loader"></div></div>

<!-- Top Bar -->
<div class="top-bar">
  <div class="container">
    <div class="top-bar-left">
      <a href="tel:+916206850133"><i class="fas fa-phone-alt"></i> +91 6206850133</a>
      <a href="mailto:info@udaanfoundation.org"><i class="fas fa-envelope"></i> info@udaanfoundation.org</a>
    </div>
    <div class="top-bar-right">
      <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
      <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
      <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
      <a href="https://api.whatsapp.com/send?phone=916206850133&text=Hello Udaan Foundation!" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
      @auth
        @if(auth()->user()->hasRole(['Super Admin', 'Admin']))
          <a href="{{ route('admin.dashboard') }}" class="staff-portal-btn" style="background:#FFA500 !important; color:#000 !important; font-weight:700;"><i class="fas fa-gauge-high"></i> Dashboard</a>
        @else
          <a href="{{ route('telecaller.dashboard') }}" class="staff-portal-btn" style="background:#FFA500 !important; color:#000 !important; font-weight:700;"><i class="fas fa-headset"></i> Dashboard</a>
        @endif
      @else
        <a href="{{ route('login') }}" class="staff-portal-btn" title="Staff Portal Login"><i class="fas fa-lock" style="font-size:11px;"></i> Staff Login</a>
      @endauth
    </div>
  </div>
</div>

<!-- Header -->
<header class="header">
  <div class="header-top container">
    <a href="{{ route('frontend.index') }}" class="header-logo">
      <img src="{{ asset('logo.png') }}" alt="Udaan Foundation Logo">
    </a>
    <button class="mobile-toggle" aria-label="Menu"><i class="fas fa-bars"></i></button>
  </div>
  <div class="header-nav-bar">
    <div class="container">
      <nav class="main-nav">
        <ul>
          <li class="{{ request()->routeIs('frontend.index') ? 'active' : '' }}"><a href="{{ route('frontend.index') }}">Home</a></li>
          <li class="{{ request()->routeIs('frontend.courses') ? 'active' : '' }}"><a href="{{ route('frontend.courses') }}">Available Courses</a></li>
          <li class="{{ request()->routeIs('frontend.process') || request()->routeIs('frontend.enrollment') ? 'active' : '' }}">
            <a href="#">Process <i class="fas fa-caret-down" style="font-size:12px;margin-left:3px;"></i></a>
            <ul class="dropdown-menu-custom">
              <li><a href="{{ route('frontend.process') }}">How It Works</a></li>
              <li><a href="{{ route('frontend.enrollment') }}">Enrollment Process</a></li>
            </ul>
          </li>
          <li class="{{ request()->routeIs('frontend.confirmation') ? 'active' : '' }}"><a href="{{ route('frontend.confirmation') }}">Counselling Letter</a></li>
          <li class="{{ request()->routeIs('frontend.news') ? 'active' : '' }}"><a href="{{ route('frontend.news') }}">News &amp; Media</a></li>
          <li class="{{ request()->routeIs('frontend.videos') ? 'active' : '' }}"><a href="{{ route('frontend.videos') }}">Helpful Videos</a></li>
          <li class="{{ request()->routeIs('frontend.partners') ? 'active' : '' }}"><a href="{{ route('frontend.partners') }}">Approvals</a></li>
          <li class="{{ request()->routeIs('frontend.contact') ? 'active' : '' }}"><a href="{{ route('frontend.contact') }}">Contact</a></li>
          <li class="{{ request()->routeIs('frontend.services') ? 'active' : '' }}"><a href="{{ route('frontend.services') }}">Services</a></li>
        </ul>
      </nav>
      <div class="nav-apply-btn"><a href="{{ route('frontend.apply') }}">Apply Now</a></div>
    </div>
  </div>
</header>

<div class="mobile-nav-overlay"></div>
<div class="mobile-nav">
  <div class="mobile-nav-header">
    <img src="{{ asset('logo.png') }}" alt="Udaan Foundation" style="max-height: 45px;">
    <button class="mobile-nav-close"><i class="fas fa-times"></i></button>
  </div>
  <ul>
    <li><a href="{{ route('frontend.index') }}">Home</a></li>
    <li><a href="{{ route('frontend.courses') }}">Available Courses</a></li>
    <li class="has-sub">
      <a href="#">Process</a>
      <ul class="sub-menu">
        <li><a href="{{ route('frontend.process') }}">How It Works</a></li>
        <li><a href="{{ route('frontend.enrollment') }}">Enrollment Process</a></li>
      </ul>
    </li>
    <li><a href="{{ route('frontend.confirmation') }}">Counselling Letter</a></li>
    <li><a href="{{ route('frontend.news') }}">News &amp; Media</a></li>
    <li><a href="{{ route('frontend.videos') }}">Helpful Videos</a></li>
    <li><a href="{{ route('frontend.partners') }}">Approvals</a></li>
    <li><a href="{{ route('frontend.contact') }}">Contact</a></li>
    <li><a href="{{ route('frontend.services') }}">Services</a></li>
    <li><a href="{{ route('frontend.apply') }}" style="color:#FFA500;font-weight:700;">Apply Now</a></li>
    @auth
      @if(auth()->user()->hasRole(['Super Admin', 'Admin']))
        <li><a href="{{ route('admin.dashboard') }}" style="color:#FFA500;font-weight:700;"><i class="fas fa-gauge-high"></i> Admin Dashboard</a></li>
      @else
        <li><a href="{{ route('telecaller.dashboard') }}" style="color:#FFA500;font-weight:700;"><i class="fas fa-headset"></i> My Dashboard</a></li>
      @endif
    @else
      <li><a href="{{ route('login') }}" style="color:#E51E25;font-weight:700;"><i class="fas fa-lock"></i> Staff Login</a></li>
    @endauth
  </ul>
</div>

<!-- Main Page Content -->
@yield('content')

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <img src="{{ asset('footer logo.png') }}" alt="Edu. Uddan Foundation" style="max-width:200px; height:auto; margin-bottom:15px;" onerror="this.src='{{ asset('logo.png') }}'">
        <p><strong>UDDAN IS AN UNIT OF EDU. UDDAN FOUNDATION</strong><br>We are dedicated to empowering lives and inspiring change through education, skill development, women empowerment, and community development programs across India.</p>
        <div class="footer-social">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <div>
        <h4>Quick Links</h4>
        <ul class="footer-links">
          <li><a href="{{ route('frontend.index') }}">Home</a></li>
          <li><a href="{{ route('frontend.programs') }}">Our Programs</a></li>
          <li><a href="{{ route('frontend.services') }}">Our Services</a></li>
          <li><a href="{{ route('frontend.news') }}">News &amp; Media</a></li>
          <li><a href="{{ route('frontend.contact') }}">Contact Us</a></li>
          <li><a href="{{ route('login') }}">Staff Portal</a></li>
        </ul>
      </div>
      <div>
        <h4>Programs</h4>
        <ul class="footer-links">
          <li><a href="{{ route('frontend.programs') }}">Education Support</a></li>
          <li><a href="{{ route('frontend.courses') }}">Career Guidance</a></li>
          <li><a href="{{ route('frontend.process') }}">BSCC Counseling</a></li>
          <li><a href="{{ route('frontend.enrollment') }}">Admission Assistance</a></li>
          <li><a href="{{ route('frontend.apply') }}">Apply Now</a></li>
        </ul>
      </div>
      <div>
        <h4>Contact Us</h4>
        <ul class="footer-contact">
          <li><i class="fas fa-map-marker-alt"></i><span style="font-size:12px;"><strong>Head Office:</strong> Near Care Hospital Naya Tola, Rajendra Nagar to Kumhara Man Road, opposite Yamaha Service Center, Kumhrar, PIN - 800027</span></li>
          <li><i class="fas fa-map-marker-alt"></i><span style="font-size:12px;"><strong>Bhagalpur Branch:</strong> Near Aadampur Chowk Biased Bharat Gas Godam, 812001</span></li>
          <li><i class="fas fa-map-marker-alt"></i><span style="font-size:12px;"><strong>Muzaffarpur Branch:</strong> Near Ram Bhajan Bazar Gola Road, MIMS Campus ka andar (Near Vanijya Inter College), PIN- 842001</span></li>
          <li><i class="fas fa-map-marker-alt"></i><span style="font-size:12px;"><strong>Chapra Branch:</strong> RNP School Campus Mirchya Tola Daulatganj, PIN 841301</span></li>
          <li><i class="fas fa-map-marker-alt"></i><span style="font-size:12px;"><strong>Siwan Branch:</strong> Bindu Davi ITI Campus (moli ka Bathan) near dr. P Davi more, PIN 841227</span></li>
          <li><i class="fas fa-phone-alt"></i><span>+91 6206850133</span></li>
          <li><i class="fas fa-envelope"></i><span>info@udaanfoundation.org</span></li>
          <li><i class="fas fa-clock"></i><span>Mon - Sat: 9:00 AM - 6:00 PM</span></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <p>&copy; {{ date('Y') }} Udaan Foundation. All Rights Reserved. | Designed for Higher Education Support |
        <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
      </p>
    </div>
  </div>
</footer>

<!-- WhatsApp Float -->
<a href="https://api.whatsapp.com/send?phone=916206850133&text=Hello Udaan Foundation!" target="_blank" class="whatsapp-float" title="Chat on WhatsApp">
  <i class="fab fa-whatsapp"></i>
</a>

<!-- Scroll to Top -->
<button class="scroll-top" aria-label="Scroll to top"><i class="fas fa-arrow-up"></i></button>

<script src="{{ asset('js/main.js') }}"></script>
@stack('scripts')
</body>
</html>
