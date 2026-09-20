@extends('frontend.layout')

@section('title', 'Apply for Free Career Counselling & Admission Guidance — Udaan Foundation')
@section('meta_description', 'Apply online for Bihar Students Counselling Center Awareness Program 2025. Get free expert guidance for DRCC Student Credit Card and college admissions.')

@push('styles')
<style>
  /* ===== APPLY PAGE STYLES ===== */
  .apply-wrapper {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 35px;
    align-items: start;
  }
  @media (max-width: 1024px) { 
    .apply-wrapper { grid-template-columns: 1fr; } 
  }

  /* ---- Form Card ---- */
  .apply-form-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.07);
    overflow: hidden;
    border: 1px solid #e2e8f0;
  }
  .form-card-header {
    background: linear-gradient(135deg, #014655, #026d7e);
    padding: 26px 30px;
    color: #fff;
    position: relative;
  }
  .form-card-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #E51E25, #F37021, #F8971D);
  }
  .form-card-header h2 { font-size: 22px; margin: 0 0 4px; font-weight: 700; color: #ffffff; }
  .form-card-header h2 i { color: #ffffff; }
  .form-card-header p  { margin: 0; color: rgba(255, 255, 255, 0.9); font-size: 13.5px; }
  .form-card-body { padding: 32px 30px; }

  .form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px;
  }
  @media (max-width: 640px) { 
    .form-grid-2 { grid-template-columns: 1fr; gap: 16px; } 
  }

  .form-group {
    margin-bottom: 22px;
  }
  .form-group label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .form-group label .req { color: #E51E25; font-weight: 700; margin-left: 2px; }
  
  .form-group input, 
  .form-group select {
    width: 100%;
    height: 48px;
    padding: 10px 16px;
    border: 1.5px solid #d1d5db;
    border-radius: 12px;
    font-size: 14px;
    font-family: inherit;
    color: #1e293b;
    background: #fdfdfd;
    transition: all 0.2s ease;
    box-sizing: border-box;
  }
  .form-group input:focus, 
  .form-group select:focus {
    outline: none;
    border-color: #014655;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(1, 70, 85, 0.12);
  }
  .form-group input::placeholder {
    color: #94a3b8;
    font-weight: 400;
  }

  .submit-btn {
    width: 100%;
    padding: 14px 24px;
    background: linear-gradient(135deg, #014655 0%, #026d7e 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 6px 20px rgba(1, 70, 85, 0.25);
    margin-top: 15px;
  }
  .submit-btn:hover {
    background: linear-gradient(135deg, #E51E25 0%, #F37021 100%);
    box-shadow: 0 8px 25px rgba(229, 30, 37, 0.35);
    transform: translateY(-2px);
  }

  /* ---- Sidebar Cards ---- */
  .sidebar-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    overflow: hidden;
    margin-bottom: 22px;
    border: 1px solid #e2e8f0;
  }
  .sidebar-card-header {
    padding: 15px 20px;
    color: #fff;
    font-weight: 700;
    font-size: 14.5px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .sidebar-card-header.teal { background: linear-gradient(135deg, #014655, #026d7e); }
  .sidebar-card-header.orange { background: linear-gradient(135deg, #E51E25, #F37021); }
  .sidebar-card-body { padding: 20px; }

  .why-list { list-style: none; padding: 0; margin: 0; }
  .why-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 12px;
    font-size: 13px;
    color: #475569;
    line-height: 1.4;
  }
  .why-list li i { color: #026d7e; font-size: 14px; margin-top: 2px; flex-shrink: 0; }
  .why-list li:last-child { margin-bottom: 0; }

  .helpline-box {
    background: #fff8f0;
    border: 1.5px dashed #F37021;
    border-radius: 12px;
    padding: 16px;
    text-align: center;
  }
  .helpline-box h4 { margin: 0 0 4px; color: #9a3412; font-size: 14.5px; font-weight: 700; }
  .helpline-box p { margin: 0 0 10px; font-size: 12px; color: #64748b; }
  .helpline-box a {
    display: inline-block;
    padding: 7px 16px;
    background: #F37021;
    color: #fff;
    border-radius: 20px;
    font-weight: 700;
    font-size: 13px;
    text-decoration: none;
  }
</style>
@endpush

@section('content')

<!-- Page Banner -->
<section class="page-banner" style="background: linear-gradient(135deg, rgba(1,70,85,0.95), rgba(1,42,51,0.9)), url('{{ asset('images/admission-bg.jpg') }}') center/cover no-repeat; padding: 50px 0; text-align: center; color: #fff;">
  <div class="container">
    <span style="display:inline-block; padding: 5px 15px; background: rgba(255,255,255,0.15); border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; border: 1px solid rgba(255,255,255,0.25);">
      Bihar Students Counselling Center • Awareness Program 2025
    </span>
    <h1 style="font-size: 30px; font-weight: 800; margin: 0 0 8px;">Apply for Free Career Counselling</h1>
    <p style="color: rgba(255,255,255,0.85); margin: 0; font-size: 14.5px;">Your Education. Your Career. Your Future — Guided the Right Way with DRCC Support.</p>
  </div>
</section>

<!-- Apply Section -->
<section class="section" style="background: #f4f6f8; padding: 50px 0;">
  <div class="container">
    <div class="apply-wrapper">

      <!-- LEFT: Dynamic Application Form with exact 8 fields -->
      <div class="apply-form-card">
        <div class="form-card-header">
          <h2><i class="fas fa-file-alt" style="margin-right:10px;"></i>Online Application Form</h2>
          <p>Please fill all details correctly. Fields marked with <strong style="color:#FFA500;">*</strong> are required.</p>
        </div>

        <div class="form-card-body">

          <!-- Flash Validation Errors -->
          @if($errors->any())
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; font-size: 13.5px;">
              <strong style="display:block; margin-bottom: 4px;"><i class="fas fa-exclamation-triangle"></i> Please correct the following errors:</strong>
              <ul style="margin: 0; padding-left: 18px;">
                @foreach($errors->all() as $err)
                  <li>{{ $err }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('frontend.apply.submit') }}" method="POST">
            @csrf

            <!-- Row 1: NAME & FATHER NAME -->
            <div class="form-grid-2">
              <div class="form-group">
                <label for="name">NAME: <span class="req">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter student's full name" required>
              </div>

              <div class="form-group">
                <label for="father_name">FATHER NAME: <span class="req">*</span></label>
                <input type="text" id="father_name" name="father_name" value="{{ old('father_name') }}" placeholder="Enter father's name" required>
              </div>
            </div>

            <!-- Row 2: DATE OF BIRTH & MOBILE NO -->
            <div class="form-grid-2">
              <div class="form-group">
                <label for="dob">DATE OF BIRTH: <span class="req">*</span></label>
                <input type="date" id="dob" name="dob" value="{{ old('dob') }}" placeholder="dd/mm/yyyy" required>
              </div>

              <div class="form-group">
                <label for="phone">MOBILE NO: <span class="req">*</span></label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="10-digit mobile number" maxlength="15" required>
              </div>
            </div>

            <!-- Row 3: WHATSAPP NO & QUALIFICATION -->
            <div class="form-grid-2">
              <div class="form-group">
                <label for="whatsapp_no">WHATSAPP NO: <span class="req">*</span></label>
                <input type="tel" id="whatsapp_no" name="whatsapp_no" value="{{ old('whatsapp_no') }}" placeholder="WhatsApp contact number" maxlength="15" required>
              </div>

              <div class="form-group">
                <label for="qualification">QUALIFICATION: <span class="req">*</span></label>
                <select id="qualification" name="qualification" required>
                  <option value="">Select Qualification</option>
                  <option value="10th" {{ old('qualification') == '10th' ? 'selected' : '' }}>10th</option>
                  <option value="Appearing in 10th" {{ old('qualification') == 'Appearing in 10th' ? 'selected' : '' }}>Appearing in 10th</option>
                  <option value="12th" {{ old('qualification') == '12th' ? 'selected' : '' }}>12th</option>
                  <option value="Appearing in 12th" {{ old('qualification') == 'Appearing in 12th' ? 'selected' : '' }}>Appearing in 12th</option>
                  <option value="Graduation" {{ old('qualification') == 'Graduation' ? 'selected' : '' }}>Graduation</option>
                  <option value="Appearing in Graduation" {{ old('qualification') == 'Appearing in Graduation' ? 'selected' : '' }}>Appearing in Graduation</option>
                </select>
              </div>
            </div>

            <!-- Row 4: GENDER & ADDRESS -->
            <div class="form-grid-2">
              <div class="form-group">
                <label for="gender">GENDER: <span class="req">*</span></label>
                <select id="gender" name="gender" required>
                  <option value="">Select Gender</option>
                  <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                  <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                  <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
              </div>

              <div class="form-group">
                <label for="address">ADDRESS: <span class="req">*</span></label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Village/Town, Post Office, District" required>
              </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">
              <i class="fas fa-paper-plane"></i> Submit Application
            </button>

          </form>
        </div>
      </div>

      <!-- RIGHT: Sidebar Info -->
      <div class="apply-sidebar">

        <!-- Why Apply -->
        <div class="sidebar-card">
          <div class="sidebar-card-header teal">
            <i class="fas fa-star"></i> Why Apply With Us?
          </div>
          <div class="sidebar-card-body">
            <ul class="why-list">
              <li><i class="fas fa-check-circle"></i> <strong>100% Free</strong> expert career &amp; college counselling</li>
              <li><i class="fas fa-check-circle"></i> <strong>Bihar Student Credit Card (DRCC)</strong> 4 Lakh loan support</li>
              <li><i class="fas fa-check-circle"></i> NAAC 'A' &amp; UGC/AICTE approved college options</li>
              <li><i class="fas fa-check-circle"></i> College campus visits &amp; admission confirmation</li>
              <li><i class="fas fa-check-circle"></i> Dedicated counseling telecaller assigned to you</li>
              <li><i class="fas fa-check-circle"></i> Quick response within 24 hours</li>
            </ul>
          </div>
        </div>

        <!-- Helpline Card -->
        <div class="sidebar-card">
          <div class="sidebar-card-header orange">
            <i class="fas fa-headset"></i> Need Immediate Help?
          </div>
          <div class="sidebar-card-body">
            <div class="helpline-box">
              <h4>Direct Admission Desk</h4>
              <p>Speak with our senior admission counselor right now:</p>
              <a href="tel:+916206850133"><i class="fas fa-phone-alt"></i> +91 6206850133</a>
              <div style="margin-top: 10px;">
                <a href="https://api.whatsapp.com/send?phone=916206850133&text=Hello,%20I%20want%20information%20about%20college%20admissions!" target="_blank" style="background: #25D366; font-size: 12.5px;">
                  <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

@endsection
