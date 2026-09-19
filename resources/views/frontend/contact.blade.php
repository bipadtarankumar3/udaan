@extends('frontend.layout')

@section('title', 'Contact Us — Udaan Foundation')
@section('meta_description', 'Get in touch with Udaan Educational Foundation for admission inquiries, DRCC student credit card assistance, free career guidance, or campus visits.')

@section('content')

<!-- Page Banner -->
<section class="page-banner" style="background: linear-gradient(135deg, rgba(1,70,85,0.95), rgba(1,42,51,0.9)), url('{{ asset('images/admission-bg.jpg') }}') center/cover no-repeat; padding: 60px 0; text-align: center; color: #fff;">
  <div class="container">
    <span style="display:inline-block; padding: 5px 15px; background: rgba(255,255,255,0.15); border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; border: 1px solid rgba(255,255,255,0.25);">
      Get in Touch
    </span>
    <h1 style="font-size: 32px; font-weight: 800; margin: 0 0 10px;">Contact Udaan Educational Foundation</h1>
    <p style="color: rgba(255,255,255,0.85); margin: 0; font-size: 15px;">Have questions about colleges, admission eligibility, or DRCC loan support? We are here to guide you.</p>
  </div>
</section>

<!-- Contact Section -->
<section class="section" style="padding: 60px 0; background: #f8fafc;">
  <div class="container">
    <div class="contact-grid">
      
      <!-- Left Column: Contact Form -->
      <div class="contact-form-card" style="background: #fff; border-radius: 16px; padding: 35px; box-shadow: 0 4px 25px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
        <h2 style="font-size: 22px; font-weight: 700; color: #014655; margin-bottom: 6px;">Send Us a Message</h2>
        <p style="color: #64748b; font-size: 14px; margin-bottom: 25px;">Fill out the form below and our counseling coordinator will get back to you within 24 hours.</p>

        @if(session('success'))
          <div style="background: #ecfdf5; border: 1.5px solid #10b981; color: #065f46; padding: 14px 18px; border-radius: 10px; margin-bottom: 22px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-check-circle" style="color: #10b981; font-size: 18px;"></i>
            <span>{{ session('success') }}</span>
          </div>
        @endif

        @if($errors->any())
          <div style="background: #fef2f2; border: 1.5px solid #f87171; color: #991b1b; padding: 12px 18px; border-radius: 10px; margin-bottom: 22px; font-size: 13.5px;">
            <ul style="margin:0; padding-left: 18px;">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('frontend.contact.submit') }}" method="POST">
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label for="name">Full Name <span style="color:#E51E25;">*</span></label>
              <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Rahul Kumar" required>
            </div>
            <div class="form-group">
              <label for="email">Email Address <span style="color:#94a3b8; font-weight:normal;">(Optional)</span></label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="student@example.com">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="phone">Phone / WhatsApp Number <span style="color:#E51E25;">*</span></label>
              <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="10-digit mobile number" maxlength="15" required>
            </div>
            <div class="form-group">
              <label for="subject">Inquiry Type <span style="color:#E51E25;">*</span></label>
              <select id="subject" name="subject" required>
                <option value="">Select an option</option>
                <option value="Admission Inquiry" {{ old('subject') == 'Admission Inquiry' ? 'selected' : '' }}>College Admission Inquiry</option>
                <option value="Bihar Student Credit Card (DRCC)" {{ old('subject') == 'Bihar Student Credit Card (DRCC)' ? 'selected' : '' }}>Bihar Student Credit Card (DRCC)</option>
                <option value="Course Guidance" {{ old('subject') == 'Course Guidance' ? 'selected' : '' }}>Free Career Guidance</option>
                <option value="Campus Visit" {{ old('subject') == 'Campus Visit' ? 'selected' : '' }}>Campus Visit Request</option>
                <option value="Partnership" {{ old('subject') == 'Partnership' ? 'selected' : '' }}>College Affiliation / Partner</option>
                <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other Query</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="message">Your Message / Query <span style="color:#E51E25;">*</span></label>
            <textarea id="message" name="message" placeholder="Tell us about the courses or information you are looking for..." rows="4" required>{{ old('message') }}</textarea>
          </div>

          <button type="submit" class="btn" style="background: linear-gradient(135deg, #014655, #026d7e); color: #fff; padding: 14px 28px; border-radius: 10px; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-size: 15px; box-shadow: 0 4px 15px rgba(1,70,85,0.2); transition: all 0.2s ease;">
            <i class="fas fa-paper-plane"></i> Send Message
          </button>
        </form>
      </div>

      <!-- Right Column: Contact Info Cards -->
      <div>
        <h2 style="font-size: 22px; font-weight: 700; color: #014655; margin-bottom: 6px;">Reach Us Directly</h2>
        <p style="color: #64748b; font-size: 14px; margin-bottom: 25px;">You are welcome to visit our counseling centers or contact our helpline anytime.</p>

        <div class="contact-info-card" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; margin-bottom: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
          <div class="icon" style="background: linear-gradient(135deg, #014655, #026d7e); color: #fff; flex-shrink: 0;"><i class="fas fa-map-marker-alt"></i></div>
          <div>
            <h4 style="color: #014655; font-weight: 700; margin-bottom: 6px;">Our Head Office &amp; Regional Branches</h4>
            <p style="font-size: 13px; line-height: 1.6; color: #475569; margin: 0;">
              <strong>Head Office:</strong> Near Care Hospital Naya Tola, Rajendra Nagar to Kumhara Man Road, opp. Yamaha Service Center, Kumhrar, Patna - 800027<br>
              <strong>Bhagalpur Branch:</strong> Near Aadampur Chowk, beside Bharat Gas Godam, 812001<br>
              <strong>Muzaffarpur Branch:</strong> Near Ram Bhajan Bazar Gola Road, MIMS Campus (Near Vanijya Inter College), 842001<br>
              <strong>Chapra Branch:</strong> RNP School Campus, Mirchya Tola Daulatganj, 841301<br>
              <strong>Siwan Branch:</strong> Bindu Davi ITI Campus (Moli ka Bathan), near Dr. P. Davi More, 841227
            </p>
          </div>
        </div>

        <div class="contact-info-card" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px; margin-bottom: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
          <div class="icon" style="background: linear-gradient(135deg, #E51E25, #F37021); color: #fff; flex-shrink: 0;"><i class="fas fa-phone-alt"></i></div>
          <div>
            <h4 style="color: #014655; font-weight: 700; margin-bottom: 4px;">Helpline Numbers</h4>
            <p style="font-size: 14px; color: #475569; margin: 0;">
              <a href="tel:+916206850133" style="color: #014655; font-weight: 700; text-decoration: none;">+91 6206850133</a> (Admission Counseling Desk)
            </p>
          </div>
        </div>

        <div class="contact-info-card" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px; margin-bottom: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
          <div class="icon" style="background: linear-gradient(135deg, #014655, #026d7e); color: #fff; flex-shrink: 0;"><i class="fas fa-envelope"></i></div>
          <div>
            <h4 style="color: #014655; font-weight: 700; margin-bottom: 4px;">Email Support</h4>
            <p style="font-size: 14px; color: #475569; margin: 0;">
              <a href="mailto:info@udaanfoundation.org" style="color: #014655; text-decoration: none;">info@udaanfoundation.org</a>
            </p>
          </div>
        </div>

        <div class="contact-info-card" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px; margin-bottom: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
          <div class="icon" style="background: linear-gradient(135deg, #25D366, #128C7E); color: #fff; flex-shrink: 0;"><i class="fab fa-whatsapp"></i></div>
          <div>
            <h4 style="color: #014655; font-weight: 700; margin-bottom: 4px;">Instant WhatsApp Guidance</h4>
            <p style="font-size: 13.5px; color: #475569; margin: 0;">
              Chat directly with our senior admission team:<br>
              <a href="https://api.whatsapp.com/send?phone=916206850133&text=Hello%20Udaan%20Foundation!%20I%20want%20to%20inquire%20about%20admissions." target="_blank" style="color: #25D366; font-weight: 700; text-decoration: none;">
                <i class="fab fa-whatsapp"></i> Start WhatsApp Chat &rarr;
              </a>
            </p>
          </div>
        </div>

      </div>

    </div>

    <!-- Google Map Embed -->
    <div style="margin-top: 40px; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; height: 350px;">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d115133.0101683401!2d85.07300223297126!3d25.608175570220675!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f29937c52d4f05%3A0x831a0e05f607b270!2sPatna%2C%20Bihar!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

  </div>
</section>

@endsection
