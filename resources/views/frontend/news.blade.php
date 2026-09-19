@extends('frontend.layout')

@section('title', 'News & Media — Udaan Foundation')

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

        <!-- News 1 -->
        <div class="news-card fade-in" style="margin-bottom:30px;">
          <div class="news-card-img"><img src="news slide (1).png" alt="Digital literacy program" /></div>
          <div class="news-card-body">
            <div class="news-card-date"><i class="far fa-calendar-alt"></i> September 10, 2024 &nbsp;|&nbsp; <i class="fas fa-tag"></i> Education</div>
            <h3>Udaan Foundation Launches Digital Literacy Program in Rural Bihar</h3>
            <p>In a landmark initiative, Udaan Foundation has launched a comprehensive Digital Literacy Program targeting over 5,000 students in rural Bihar and Jharkhand. The program aims to bridge the digital divide by providing free computer training, internet access, and digital skills education. Supported by local government bodies and corporate partners, the program will run across 25 centers for a duration of 6 months.</p>
            <p style="margin-top:10px;font-size:14px;color:#555;">"Digital literacy is no longer a luxury — it's a necessity. Every child deserves access to the digital world," said the Foundation's Director.</p>
          </div>
        </div>

        <!-- News 2 -->
        <div class="news-card fade-in" style="margin-bottom:30px;">
          <div class="news-card-img"><img src="news slide (2).png" alt="Annual scholarship drive" /></div>
          <div class="news-card-body">
            <div class="news-card-date"><i class="far fa-calendar-alt"></i> August 22, 2024 &nbsp;|&nbsp; <i class="fas fa-tag"></i> Scholarships</div>
            <h3>Annual Scholarship Drive Benefits 500 Meritorious Students</h3>
            <p>Udaan Foundation's flagship Annual Scholarship Drive 2024 has successfully supported 500 meritorious students from economically weaker sections. The scholarships, ranging from ₹10,000 to ₹50,000, cover tuition fees, study materials, and exam preparation costs. This year's drive saw over 3,000 applications from 8 states.</p>
          </div>
        </div>

        <!-- News 3 -->
        <div class="news-card fade-in" style="margin-bottom:30px;">
          <div class="news-card-img"><img src="news slide (3).png" alt="Women entrepreneurs workshop" /></div>
          <div class="news-card-body">
            <div class="news-card-date"><i class="far fa-calendar-alt"></i> July 15, 2024 &nbsp;|&nbsp; <i class="fas fa-tag"></i> Women Empowerment</div>
            <h3>Women Entrepreneurs Workshop Empowers 200 Rural Women</h3>
            <p>Over 200 women from rural villages in Bihar attended Udaan Foundation's 3-day intensive workshop on micro-enterprise development and financial independence. Participants learned about business planning, marketing, micro-loan access, and digital payments. 35 women have since started their own small businesses.</p>
          </div>
        </div>

        <!-- News 4 -->
        <div class="news-card fade-in" style="margin-bottom:30px;">
          <div class="news-card-img"><img src="news slide (4).png" alt="Green India campaign" /></div>
          <div class="news-card-body">
            <div class="news-card-date"><i class="far fa-calendar-alt"></i> June 5, 2024 &nbsp;|&nbsp; <i class="fas fa-tag"></i> Environment</div>
            <h3>50,000 Trees Planted: Udaan's Green India Campaign Milestone</h3>
            <p>On World Environment Day, Udaan Foundation celebrated a significant milestone — 50,000 trees planted across 5 states since the inception of its Green India Campaign. Volunteers, students, and community members participated in the plantation drive across 100+ locations.</p>
          </div>
        </div>

        <!-- News 5 -->
        <div class="news-card fade-in" style="margin-bottom:30px;">
          <div class="news-card-img"><img src="news slide (5).png" alt="Health camp" /></div>
          <div class="news-card-body">
            <div class="news-card-date"><i class="far fa-calendar-alt"></i> May 12, 2024 &nbsp;|&nbsp; <i class="fas fa-tag"></i> Health</div>
            <h3>Free Health Camp in Patna Benefits 1,200 Residents</h3>
            <p>Udaan Foundation organized a free health camp in collaboration with local hospitals, providing check-ups, medicine, and health awareness sessions to over 1,200 residents. Services included eye tests, blood pressure screening, diabetes testing, and dental check-ups.</p>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="news-sidebar">
        <div class="widget">
          <h4>Categories</h4>
          <ul class="footer-links">
            <li><a href="#">Education (12)</a></li>
            <li><a href="#">Skill Development (8)</a></li>
            <li><a href="#">Women Empowerment (6)</a></li>
            <li><a href="#">Community Development (9)</a></li>
            <li><a href="#">Health (5)</a></li>
            <li><a href="#">Environment (4)</a></li>
          </ul>
        </div>

        <div class="widget">
          <h4>Recent Posts</h4>
          <div class="recent-post">
            <div class="rp-thumb" style="background:linear-gradient(135deg,#014655,#026d7e);"><i class="fas fa-laptop" style="color:#fff;"></i></div>
            <div><h5>Digital Literacy Program Launch</h5><span>Sept 10, 2024</span></div>
          </div>
          <div class="recent-post">
            <div class="rp-thumb" style="background:linear-gradient(135deg,#D62828,#e85d5d);"><i class="fas fa-award" style="color:#fff;"></i></div>
            <div><h5>Scholarship Drive 2024</h5><span>Aug 22, 2024</span></div>
          </div>
          <div class="recent-post">
            <div class="rp-thumb" style="background:linear-gradient(135deg,#F77F00,#f9a84d);"><i class="fas fa-female" style="color:#fff;"></i></div>
            <div><h5>Women Entrepreneurs Workshop</h5><span>Jul 15, 2024</span></div>
          </div>
          <div class="recent-post">
            <div class="rp-thumb" style="background:linear-gradient(135deg,#014655,#FCBF49);"><i class="fas fa-tree" style="color:#fff;"></i></div>
            <div><h5>Green India Campaign</h5><span>Jun 5, 2024</span></div>
          </div>
        </div>

        <div class="widget">
          <h4>Newsletter</h4>
          <p style="font-size:14px;color:#555;margin-bottom:12px;">Subscribe to our newsletter for the latest updates and impact stories.</p>
          <input type="email" placeholder="Your email address" style="width:100%;padding:10px 14px;border:2px solid #e9ecef;border-radius:8px;margin-bottom:10px;font-size:14px;">
          <button class="btn btn-primary" style="width:100;">Subscribe</button>
        </div>

        <div class="widget">
          <h4>Photo Gallery</h4>
          <div class="mini-gallery">
            <img src="news slide (6).png" alt="News gallery image six" />
            <img src="news slide (7).png" alt="News gallery image seven" />
            <img src="news slide (8).png" alt="News gallery image eight" />
            <img src="news slide (9).png" alt="News gallery image nine" />
          </div>
        </div>

        <div class="widget">
          <h4>Follow Us</h4>
          <div class="footer-social" style="justify-content:flex-start;">
            <a href="#" style="background:rgba(1,70,85,0.1);color:#014655;"><i class="fab fa-facebook-f"></i></a>
            <a href="#" style="background:rgba(1,70,85,0.1);color:#014655;"><i class="fab fa-instagram"></i></a>
            <a href="#" style="background:rgba(1,70,85,0.1);color:#014655;"><i class="fab fa-youtube"></i></a>
            <a href="#" style="background:rgba(1,70,85,0.1);color:#014655;"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
