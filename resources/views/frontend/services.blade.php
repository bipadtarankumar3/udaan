@extends('frontend.layout')

@section('title', 'Our Services — Vardhan Foundation | Free Career Counselling & DRCC Guidance')
@section('meta_description', 'Explore comprehensive educational services by Vardhan Foundation: 100% free career counselling, college selection, direct admissions, and Bihar Student Credit Card (DRCC/MNSSBY) assistance.')

@section('content')
<!-- Page Banner -->
<div class="page-banner">
  <div class="container">
    <h1>Our Educational Services</h1>
    <div class="breadcrumb">
      <a href="{{ route('frontend.index') }}">Home</a>
      <span>/</span>
      <span>Our Services</span>
    </div>
  </div>
</div>

<!-- Services Highlights Strip -->
<div class="admission-ticker" style="background: linear-gradient(90deg, #0A2240 0%, #0F437F 50%, #0A2240 100%); padding: 14px 0;">
  <div class="container">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; color:#ffffff; font-size:13.5px; font-weight:600;">
      <div style="display:flex; align-items:center; gap:8px;">
        <i class="fas fa-certificate" style="color:#F59E0B;"></i> 100% Free Career Guidance
      </div>
      <div style="display:flex; align-items:center; gap:8px;">
        <i class="fas fa-credit-card" style="color:#F59E0B;"></i> ₹4 Lakhs DRCC / BSCC Loan Assistance
      </div>
      <div style="display:flex; align-items:center; gap:8px;">
        <i class="fas fa-building-columns" style="color:#F59E0B;"></i> 120+ UGC &amp; AICTE Approved Colleges
      </div>
      <div style="display:flex; align-items:center; gap:8px;">
        <i class="fas fa-shield-halved" style="color:#10B981;"></i> Zero Hidden Fees or Donations
      </div>
    </div>
  </div>
</div>

<!-- Main Services Section -->
<section class="section section-light">
  <div class="container">
    <div class="section-title fade-in">
      <h2>Comprehensive Student Support &amp; Guidance</h2>
      <p>Dedicated end-to-end assistance designed to help students choose the right course, secure admissions, and fund their higher education hassle-free.</p>
    </div>

    <div class="services-modern-grid">

      <!-- Service 1: Career Counselling -->
      <div class="service-card-modern fade-in">
        <div class="service-card-header">
          <div class="service-icon-wrap service-icon-blue">
            <i class="fas fa-compass"></i>
          </div>
          <span class="service-tag">Career Planning</span>
        </div>
        <h3>1. Career Counselling &amp; Profiling</h3>
        <p>Personalized 1-on-1 counselling based on your academic background, aptitude, passions, and emerging employment opportunities across industries.</p>
        <ul class="service-perks">
          <li><i class="fas fa-check-circle"></i> Individual aptitude and interest assessment</li>
          <li><i class="fas fa-check-circle"></i> Stream selection after 10th and 12th</li>
          <li><i class="fas fa-check-circle"></i> Long-term career roadmap &amp; salary trends</li>
        </ul>
        <div class="service-card-action">
          <span style="font-size:12px; color:#10B981; font-weight:700;"><i class="fas fa-check"></i> Free Service</span>
          <a href="{{ route('frontend.apply') }}" class="btn-apply-sm">Book Session &rarr;</a>
        </div>
      </div>

      <!-- Service 2: College & University Selection -->
      <div class="service-card-modern fade-in">
        <div class="service-card-header">
          <div class="service-icon-wrap service-icon-amber">
            <i class="fas fa-building-columns"></i>
          </div>
          <span class="service-tag">Campus Matching</span>
        </div>
        <h3>2. College &amp; University Selection</h3>
        <p>Choosing the right institution defines your future. We help you compare 120+ premier colleges based on NAAC rating, faculty, labs, hostel, and placements.</p>
        <ul class="service-perks">
          <li><i class="fas fa-check-circle"></i> UGC, AICTE, INC &amp; PCI approvals check</li>
          <li><i class="fas fa-check-circle"></i> Detailed fee structure &amp; hostel comparison</li>
          <li><i class="fas fa-check-circle"></i> Verified placement track records &amp; alumni network</li>
        </ul>
        <div class="service-card-action">
          <span style="font-size:12px; color:#10B981; font-weight:700;"><i class="fas fa-check"></i> 120+ Colleges</span>
          <a href="{{ route('frontend.courses') }}" class="btn-apply-sm">Compare &rarr;</a>
        </div>
      </div>

      <!-- Service 3: Direct Admission Assistance -->
      <div class="service-card-modern fade-in">
        <div class="service-card-header">
          <div class="service-icon-wrap service-icon-green">
            <i class="fas fa-file-signature"></i>
          </div>
          <span class="service-tag">Direct Admission</span>
        </div>
        <h3>3. Direct Admission &amp; Seat Allotment</h3>
        <p>End-to-end guidance from application submission to seat confirmation. Receive your official counselling allotment letter without paying any upfront advance.</p>
        <ul class="service-perks">
          <li><i class="fas fa-check-circle"></i> Instant online counselling letter generation</li>
          <li><i class="fas fa-check-circle"></i> 100% transparent process with zero donation</li>
          <li><i class="fas fa-check-circle"></i> Direct admission in merit &amp; counselling quota</li>
        </ul>
        <div class="service-card-action">
          <span style="font-size:12px; color:#10B981; font-weight:700;"><i class="fas fa-check"></i> Zero Advance</span>
          <a href="{{ route('frontend.apply') }}" class="btn-apply-sm">Apply Now &rarr;</a>
        </div>
      </div>

      <!-- Service 4: Bihar Student Credit Card (DRCC) -->
      <div class="service-card-modern fade-in">
        <div class="service-card-header">
          <div class="service-icon-wrap service-icon-purple">
            <i class="fas fa-credit-card"></i>
          </div>
          <span class="service-tag">Govt. Loan Scheme</span>
        </div>
        <h3>4. Bihar Student Credit Card (BSCC)</h3>
        <p>Comprehensive assistance under MNSSBY to get up to ₹4,00,000 education loan sanctioned from DRCC with 0% interest for girls and 1% for boys.</p>
        <ul class="service-perks">
          <li><i class="fas fa-check-circle"></i> Documentation checklist &amp; affidavit guidance</li>
          <li><i class="fas fa-check-circle"></i> DRCC counter verification support</li>
          <li><i class="fas fa-check-circle"></i> Covers tuition, hostel, mess, books &amp; laptop</li>
        </ul>
        <div class="service-card-action">
          <span style="font-size:12px; color:#F59E0B; font-weight:800;">Up to ₹4 Lakhs</span>
          <a href="{{ route('frontend.process') }}" class="btn-apply-sm">View Process &rarr;</a>
        </div>
      </div>

      <!-- Service 5: Entrance Exam Guidance -->
      <div class="service-card-modern fade-in">
        <div class="service-card-header">
          <div class="service-icon-wrap service-icon-teal">
            <i class="fas fa-pen-to-square"></i>
          </div>
          <span class="service-tag">Exam Guidance</span>
        </div>
        <h3>5. Entrance Exam &amp; Choice Filling</h3>
        <p>Strategic guidance for state and national examinations (BCECE, UGMAC, UGEAC, JEE, NEET, CUET) including online choice filling and counselling rounds.</p>
        <ul class="service-perks">
          <li><i class="fas fa-check-circle"></i> Cutoff score analysis &amp; rank prediction</li>
          <li><i class="fas fa-check-circle"></i> Smart preference choice-filling strategy</li>
          <li><i class="fas fa-check-circle"></i> Mop-up and spot round guidance</li>
        </ul>
        <div class="service-card-action">
          <span style="font-size:12px; color:#10B981; font-weight:700;"><i class="fas fa-check"></i> Expert Tips</span>
          <a href="{{ route('frontend.contact') }}" class="btn-apply-sm">Inquire &rarr;</a>
        </div>
      </div>

      <!-- Service 6: Virtual & Tele-Counselling -->
      <div class="service-card-modern fade-in">
        <div class="service-card-header">
          <div class="service-icon-wrap service-icon-indigo">
            <i class="fas fa-laptop-file"></i>
          </div>
          <span class="service-tag">Remote Support</span>
        </div>
        <h3>6. Virtual &amp; Telephonic Counselling</h3>
        <p>Access our top counselors from the comfort of your home via video conference or phone calls. Ideal for students and parents residing in remote villages.</p>
        <ul class="service-perks">
          <li><i class="fas fa-check-circle"></i> Live one-on-one video counselling sessions</li>
          <li><i class="fas fa-check-circle"></i> Digital document verification assistance</li>
          <li><i class="fas fa-check-circle"></i> Instant WhatsApp helpdesk support</li>
        </ul>
        <div class="service-card-action">
          <span style="font-size:12px; color:#10B981; font-weight:700;"><i class="fas fa-check"></i> Free Video Call</span>
          <a href="https://api.whatsapp.com/send?phone=916206850133&text=Hello%20Vardhan%20Foundation!%20I%20want%20to%20book%20a%20virtual%20counselling%20session." target="_blank" class="btn-apply-sm">Chat on WhatsApp &rarr;</a>
        </div>
      </div>

      <!-- Service 7: Scholarship & Fee Concession -->
      <div class="service-card-modern fade-in">
        <div class="service-card-header">
          <div class="service-icon-wrap service-icon-rose">
            <i class="fas fa-hand-holding-dollar"></i>
          </div>
          <span class="service-tag">Financial Aid</span>
        </div>
        <h3>7. Scholarship &amp; Fee Concessions</h3>
        <p>Identify government and institutional scholarships to minimize your educational expenses. We assist students from SC, ST, EBC, OBC, and minority backgrounds.</p>
        <ul class="service-perks">
          <li><i class="fas fa-check-circle"></i> Bihar Post-Matric Scholarship (PMS) guidance</li>
          <li><i class="fas fa-check-circle"></i> National Scholarship Portal (NSP) support</li>
          <li><i class="fas fa-check-circle"></i> Merit-based institutional fee waivers</li>
        </ul>
        <div class="service-card-action">
          <span style="font-size:12px; color:#10B981; font-weight:700;"><i class="fas fa-check"></i> Up to 100% Aid</span>
          <a href="{{ route('frontend.apply') }}" class="btn-apply-sm">Check Aid &rarr;</a>
        </div>
      </div>

      <!-- Service 8: Distance & Online Education -->
      <div class="service-card-modern fade-in">
        <div class="service-card-header">
          <div class="service-icon-wrap service-icon-orange">
            <i class="fas fa-globe"></i>
          </div>
          <span class="service-tag">Flexible Degree</span>
        </div>
        <h3>8. Distance &amp; Online Education</h3>
        <p>Explore recognized flexible learning options for UG and PG degrees (BA, B.Com, B.Sc, MA, M.Com, MBA) approved by UGC-DEB for working professionals.</p>
        <ul class="service-perks">
          <li><i class="fas fa-check-circle"></i> UGC-DEB approved university admissions</li>
          <li><i class="fas fa-check-circle"></i> Self-paced online lectures and digital study kit</li>
          <li><i class="fas fa-check-circle"></i> Government job &amp; higher education valid</li>
        </ul>
        <div class="service-card-action">
          <span style="font-size:12px; color:#10B981; font-weight:700;"><i class="fas fa-check"></i> UGC-DEB Valid</span>
          <a href="{{ route('frontend.courses') }}" class="btn-apply-sm">Explore &rarr;</a>
        </div>
      </div>

      <!-- Service 9: Hostel & Campus Support -->
      <div class="service-card-modern fade-in">
        <div class="service-card-header">
          <div class="service-icon-wrap service-icon-blue">
            <i class="fas fa-hotel"></i>
          </div>
          <span class="service-tag">Campus Care</span>
        </div>
        <h3>9. Campus Visit &amp; Hostel Facilities</h3>
        <p>We ensure you are placed in safe, comfortable, and well-managed hostel accommodations with hygienic food, 24/7 security, and modern study facilities.</p>
        <ul class="service-perks">
          <li><i class="fas fa-check-circle"></i> Pre-admission campus visits and inspection</li>
          <li><i class="fas fa-check-circle"></i> Separate secure hostels for boys and girls</li>
          <li><i class="fas fa-check-circle"></i> Hostel fee included in Student Credit Card</li>
        </ul>
        <div class="service-card-action">
          <span style="font-size:12px; color:#10B981; font-weight:700;"><i class="fas fa-check"></i> Safe Accommodations</span>
          <a href="{{ route('frontend.contact') }}" class="btn-apply-sm">Campus Tour &rarr;</a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- 4-Step Consultation Journey -->
<section class="section">
  <div class="container">
    <div class="section-title fade-in">
      <h2>How Our Counselling Works</h2>
      <p>A structured, stress-free path to securing your dream course and university</p>
    </div>

    <div class="journey-steps-grid">
      <div class="journey-step-card fade-in">
        <span class="step-num">01</span>
        <div class="step-icon"><i class="fas fa-user-plus"></i></div>
        <h4>Online Application</h4>
        <p>Register your basic academic details and career preference in less than 60 seconds.</p>
      </div>

      <div class="journey-step-card fade-in">
        <span class="step-num">02</span>
        <div class="step-icon"><i class="fas fa-headset"></i></div>
        <h4>Personalized Counselling</h4>
        <p>Our senior admission expert contacts you to evaluate eligibility, courses, and fees.</p>
      </div>

      <div class="journey-step-card fade-in">
        <span class="step-num">03</span>
        <div class="step-icon"><i class="fas fa-file-invoice"></i></div>
        <h4>Allotment &amp; DRCC Support</h4>
        <p>Receive your counselling letter and complete paperwork for the ₹4 Lakh credit card.</p>
      </div>

      <div class="journey-step-card fade-in">
        <span class="step-num">04</span>
        <div class="step-icon"><i class="fas fa-graduation-cap"></i></div>
        <h4>Joining &amp; Success</h4>
        <p>Join your chosen college campus with verified approval and continuous mentoring.</p>
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="section section-light" style="padding-top: 40px;">
  <div class="container">
    <div class="section-title fade-in">
      <h2>Why Thousands of Students Choose Vardhan Foundation</h2>
      <p>Dedicated to delivering authentic, transparent, and student-first higher education support.</p>
    </div>
    
    <div class="why-choose-modern-grid fade-in">
      <div class="why-choose-card">
        <div class="why-choose-icon"><i class="fas fa-hand-holding-heart"></i></div>
        <div>
          <h4>100% Free Guidance</h4>
          <p>No consultation fees, processing charges, or hidden agent commissions.</p>
        </div>
      </div>

      <div class="why-choose-card">
        <div class="why-choose-icon"><i class="fas fa-credit-card"></i></div>
        <div>
          <h4>DRCC Loan Specialists</h4>
          <p>Step-by-step guidance to get up to ₹4 Lakhs sanctioned under MNSSBY.</p>
        </div>
      </div>

      <div class="why-choose-card">
        <div class="why-choose-icon"><i class="fas fa-building-columns"></i></div>
        <div>
          <h4>120+ Partner Colleges</h4>
          <p>Direct tie-ups with UGC, AICTE, INC &amp; PCI accredited universities.</p>
        </div>
      </div>

      <div class="why-choose-card">
        <div class="why-choose-icon"><i class="fas fa-file-circle-check"></i></div>
        <div>
          <h4>Instant Allotment Letter</h4>
          <p>Download verified counselling letter directly by searching your phone number.</p>
        </div>
      </div>

      <div class="why-choose-card">
        <div class="why-choose-icon"><i class="fas fa-map-location-dot"></i></div>
        <div>
          <h4>5 Regional Branches</h4>
          <p>Walk in anytime at our centers in Patna, Bhagalpur, Muzaffarpur, Chapra, and Siwan.</p>
        </div>
      </div>

      <div class="why-choose-card">
        <div class="why-choose-icon"><i class="fas fa-user-graduate"></i></div>
        <div>
          <h4>15,000+ Students Guided</h4>
          <p>Proven track record of placing students in high-paying engineering &amp; medical careers.</p>
        </div>
      </div>

      <div class="why-choose-card">
        <div class="why-choose-icon"><i class="fas fa-comments"></i></div>
        <div>
          <h4>WhatsApp &amp; Phone Desk</h4>
          <p>Instant query resolution from Monday to Saturday, 9:00 AM to 6:00 PM.</p>
        </div>
      </div>

      <div class="why-choose-card">
        <div class="why-choose-icon"><i class="fas fa-award"></i></div>
        <div>
          <h4>Full Mentorship Support</h4>
          <p>We remain your guide throughout your entire academic tenure until placement.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Official Transparency Advisory Notice -->
<section class="section" style="padding-top: 20px; padding-bottom: 70px;">
  <div class="container fade-in">
    <div style="background: linear-gradient(135deg, #EFF6FF 0%, #FFFFFF 100%); border: 1.5px solid #BFDBFE; border-left: 6px solid #0F437F; padding: 28px 32px; border-radius: 16px; box-shadow: 0 4px 20px rgba(15, 67, 127, 0.05);">
      <div style="display:flex; align-items:flex-start; gap:16px;">
        <div style="width:48px; height:48px; border-radius:12px; background:#DBEAFE; color:#0F437F; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0;">
          <i class="fas fa-shield-halved"></i>
        </div>
        <div>
          <h3 style="color: #0F437F; font-size: 18px; font-weight: 800; margin: 0 0 8px;">
            Official Transparency &amp; Advisory Notice
          </h3>
          <p style="margin-bottom: 12px; color: #334155; font-size: 14px; line-height: 1.65;">
            <strong>Vardhan Foundation provides 100% free career counselling and admission guidance.</strong> We do not charge any registration fee or advance money from students. All government loans under the Bihar Student Credit Card Scheme are sanctioned directly by the state government through the DRCC.
          </p>
          <p style="margin-bottom: 0; color: #64748B; font-size: 13px; line-height: 1.6;">
            Government schemes, eligibility rules, and admission schedules are subject to official government notifications. Students can verify the latest information directly on the official Bihar Government portal: 
            <a href="https://www.7nishchay-yuvaupmission.bihar.gov.in" target="_blank" style="color: #0284C7; font-weight: 700; text-decoration: underline; margin-left: 4px;">
              Visit MNSSBY Official Portal &rarr;
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- High-Converting Bottom CTA -->
<section class="cta-section">
  <div class="container" style="position:relative;z-index:1;">
    <h2>Ready to Secure Your College Admission?</h2>
    <p>Get in touch with our senior education counselor today for personalized advice and Bihar Student Credit Card loan guidance.</p>
    <a href="{{ route('frontend.apply') }}" class="btn btn-white" style="margin-right:12px;">Apply Online Now</a>
    <a href="https://api.whatsapp.com/send?phone=916206850133&text=Hello%20Vardhan%20Foundation!%20I%20want%20to%20inquire%20about%20your%20services." target="_blank" class="btn btn-outline">
      <i class="fab fa-whatsapp"></i> Chat on WhatsApp
    </a>
  </div>
</section>
@endsection
