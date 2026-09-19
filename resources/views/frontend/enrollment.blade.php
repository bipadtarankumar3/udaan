@extends('frontend.layout')

@section('title', 'Enrollment Process — Udaan Foundation')

@section('content')
<section class="section section-light">
  <div class="container">
    <div class="info-card fade-in">
      <h3><i class="fas fa-search"></i> Track Your Application Status</h3>
      <p>Stay updated on your application's progress using any of these methods:</p>
      <ul>
        <li><i class="fas fa-globe"></i> <strong>Online:</strong> Visit our website and enter your Application ID on the status tracker</li>
        <li><i class="fas fa-sms"></i> <strong>SMS:</strong> Send <code>APP &lt;Your Application ID&gt;</code> to <strong>56789</strong></li>
        <li><i class="fas fa-phone-alt"></i> <strong>Call:</strong> Dial our helpline <strong>+91 6206850133</strong> for instant status update</li>
        <li><i class="fas fa-envelope"></i> <strong>Email:</strong> Write to <strong>status@udaanfoundation.org</strong> with your Application ID</li>
        <li><i class="fab fa-whatsapp"></i> <strong>WhatsApp:</strong> Send your Application ID to our WhatsApp number for quick response</li>
      </ul>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section class="section">
  <div class="container">
    <div class="section-title fade-in">
      <h2>Frequently Asked Questions</h2>
      <p>Find answers to the most common questions about our enrollment process</p>
    </div>
    <div style="max-width:800px;margin:0 auto;">
      <div class="faq-item fade-in">
        <button class="faq-question">How long does the enrollment process take? <i class="fas fa-chevron-down"></i></button>
        <div class="faq-answer"><p>The entire enrollment process typically takes 14 working days from the date of application submission. This includes document verification (4-7 days), counselling (2-3 days), and seat allotment (2-3 days).</p></div>
      </div>
      <div class="faq-item fade-in">
        <button class="faq-question">Is there any fee for enrollment? <i class="fas fa-chevron-down"></i></button>
        <div class="faq-answer"><p>No, absolutely not. All Udaan Foundation programs are completely FREE of cost. We do not charge any registration fee, processing fee, or tuition fee. If anyone asks you for money on our behalf, please report it immediately.</p></div>
      </div>
      <div class="faq-item fade-in">
        <button class="faq-question">Can I apply for multiple programs simultaneously? <i class="fas fa-chevron-down"></i></button>
        <div class="faq-answer"><p>Yes, you can apply for up to 2 programs simultaneously. However, depending on the schedule and your availability, you may be allotted one program at a time. You can enroll in the second program after completing the first.</p></div>
      </div>
      <div class="faq-item fade-in">
        <button class="faq-question">What if my application is rejected? <i class="fas fa-chevron-down"></i></button>
        <div class="faq-answer"><p>If your application is rejected, you will be notified with the specific reason. You can address the concerns (such as missing documents or eligibility issues) and re-apply in the next enrollment cycle. Our team is always available to help.</p></div>
      </div>
      <div class="faq-item fade-in">
        <button class="faq-question">Do I need to visit the center in person? <i class="fas fa-chevron-down"></i></button>
        <div class="faq-answer"><p>Only for the counselling session and program orientation. The application can be submitted entirely online. For the counselling session, we also offer video call options for candidates in remote areas.</p></div>
      </div>
      <div class="faq-item fade-in">
        <button class="faq-question">Are there any age restrictions for the programs? <i class="fas fa-chevron-down"></i></button>
        <div class="faq-answer"><p>Most programs are designed for individuals aged 16–45 years. However, some community development and women empowerment programs have no upper age limit. Please check the specific program details for exact eligibility.</p></div>
      </div>
    </div>
  </div>
</section>

<section class="cta-section">
  <div class="container" style="position:relative;z-index:1;">
    <h2>Ready to Get Started?</h2>
    <p>Apply now and our team will guide you through every step of the enrollment process.</p>
    <a href="{{ route('frontend.apply') }}" class="btn btn-white">Apply Now <i class="fas fa-arrow-right"></i></a>
  </div>
</section>
@endsection
