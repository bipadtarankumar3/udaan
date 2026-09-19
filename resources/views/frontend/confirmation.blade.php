@extends('frontend.layout')

@section('title', 'Counselling Letter & Admission Confirmation — Udaan Foundation')

@push('styles')
<style>
  @media print {
    .top-bar, .header, .mobile-nav, .mobile-nav-overlay, .page-banner, .no-print, .footer, .whatsapp-float, .scroll-top {
      display: none !important;
    }
    .letter-box {
      border: none !important;
      box-shadow: none !important;
      margin: 0 !important;
      padding: 15px !important;
      max-width: 100% !important;
    }
    body { background: #fff !important; }
  }

  .letter-box {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 35px rgba(0,0,0,0.09);
    padding: 40px;
    border: 1px solid #e2e8f0;
    max-width: 850px;
    margin: 0 auto;
    position: relative;
  }
  .letter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #014655;
    padding-bottom: 20px;
    margin-bottom: 25px;
  }
  .letter-header img { max-height: 55px; }
  .letter-title {
    text-align: center;
    margin-bottom: 25px;
  }
  .letter-title h2 {
    font-size: 22px;
    color: #014655;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0 0 5px;
    font-weight: 800;
  }
  .detail-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
  }
  .detail-table th, .detail-table td {
    border: 1px solid #cbd5e1;
    padding: 11px 16px;
    font-size: 13.5px;
    text-align: left;
  }
  .detail-table th {
    background: #f8fafc;
    color: #334155;
    width: 35%;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 12.5px;
    letter-spacing: 0.3px;
  }
  .detail-table td {
    color: #0f172a;
    font-weight: 600;
  }
</style>
@endpush

@section('content')

<!-- Page Banner -->
<section class="page-banner no-print" style="background: linear-gradient(135deg, rgba(1,70,85,0.95), rgba(1,42,51,0.9)), url('{{ asset('images/admission-bg.jpg') }}') center/cover no-repeat; padding: 50px 0; text-align: center; color: #fff;">
  <div class="container">
    <h1 style="font-size: 30px; font-weight: 800; margin: 0 0 8px;">Counselling Letter &amp; Allotment Verification</h1>
    <p style="color: rgba(255,255,255,0.85); margin: 0; font-size: 14px;">Bihar Students Counselling Center Awareness Program 2025</p>
  </div>
</section>

<section class="section" style="background: #f4f6f8; padding: 40px 0;">
  <div class="container">

    <!-- Search / Lookup Bar (No Print) -->
    <div class="no-print" style="max-width: 850px; margin: 0 auto 25px; background: #fff; border-radius: 14px; padding: 18px 24px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
      <div>
        <h4 style="margin: 0 0 3px; font-size: 15px; color: #014655; font-weight: 700;"><i class="fas fa-search"></i> Verify / Search Letter</h4>
        <p style="margin: 0; font-size: 12.5px; color: #64748b;">Enter candidate registered mobile number or ref no</p>
      </div>
      <form action="{{ route('frontend.confirmation') }}" method="GET" style="display: flex; gap: 8px; flex: 1; max-width: 400px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter 10-digit mobile number..." style="flex: 1; padding: 9px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13.5px; outline: none;">
        <button type="submit" style="background: #014655; color: #fff; border: none; padding: 9px 18px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 13px;">Search</button>
      </form>
    </div>

    <!-- Success Message if just submitted -->
    @if(session('success'))
      <div class="no-print" style="max-width: 850px; margin: 0 auto 25px; background: #ecfdf5; border: 1.5px solid #10b981; color: #065f46; padding: 20px; border-radius: 16px; text-align: center; box-shadow: 0 4px 15px rgba(16,185,129,0.15);">
        <i class="fas fa-check-circle" style="font-size: 32px; color: #10b981; margin-bottom: 8px;"></i>
        <h3 style="font-size: 20px; font-weight: 800; margin: 0 0 5px;">Application Submitted Successfully!</h3>
        <p style="margin: 0; font-size: 14px;">{{ session('success') }}</p>
        <p style="margin-top: 8px; font-size: 13px; font-weight: 700; color: #047857;">Application Reference Number: <span style="background: #fff; padding: 4px 10px; border-radius: 6px; border: 1px solid #10b981;">{{ $refNo }}</span></p>
      </div>
    @endif

    @if(!$student && request('search'))
      <div class="no-print" style="max-width: 850px; margin: 0 auto 25px; background: #fff1f2; border: 1px solid #fecdd3; color: #9f1239; padding: 16px; border-radius: 12px; text-align: center; font-size: 14px;">
        <i class="fas fa-exclamation-circle" style="margin-right: 6px;"></i> No registration record found matching <strong>"{{ request('search') }}"</strong>. Please verify the mobile number or <a href="{{ route('frontend.apply') }}" style="color: #be123c; font-weight: 700; text-decoration: underline;">apply now</a>.
      </div>
    @endif

    <!-- Dynamic Letter Box -->
    <div class="letter-box">
      <div class="letter-header">
        <div>
          <img src="{{ asset('logo.png') }}" alt="Udaan Foundation">
          <p style="font-size: 11px; color: #64748b; margin: 4px 0 0;">An Unit of Edu. Uddan Foundation</p>
        </div>
        <div style="text-align: right; font-size: 12.5px; color: #475569;">
          <p style="margin: 0;"><strong>Helpline:</strong> +91 6206850133</p>
          <p style="margin: 2px 0;"><strong>Email:</strong> info@udaanfoundation.org</p>
          <p style="margin: 2px 0;"><strong>Date:</strong> {{ date('d M, Y') }}</p>
        </div>
      </div>

      <div class="letter-title">
        <h2>COUNSELLING &amp; ADMISSION ALLOTMENT LETTER</h2>
        <span style="display: inline-block; padding: 4px 12px; background: #e0f2fe; color: #0369a1; border-radius: 20px; font-size: 12px; font-weight: 700;">
          Awareness Program 2025 • Student Credit Card Scheme (DRCC)
        </span>
      </div>

      <table class="detail-table">
        <tr>
          <th>Application Ref No:</th>
          <td><strong style="color: #014655;">{{ $refNo }}</strong></td>
        </tr>
        <tr>
          <th>Candidate's Name:</th>
          <td>{{ $student->name ?? 'Candidate Name' }}</td>
        </tr>
        <tr>
          <th>Father's Name:</th>
          <td>{{ $student->father_name ?? 'Father / Guardian Name' }}</td>
        </tr>
        <tr>
          <th>Date of Birth:</th>
          <td>{{ !empty($student->dob) ? \Carbon\Carbon::parse($student->dob)->format('d/m/Y') : 'As per 10th Certificate' }}</td>
        </tr>
        <tr>
          <th>Contact Mobile:</th>
          <td>{{ $student->phone ?? '+91-XXXXXXXXXX' }}</td>
        </tr>
        <tr>
          <th>WhatsApp Number:</th>
          <td>{{ $student->whatsapp_no ?? ($student->phone ?? '+91-XXXXXXXXXX') }}</td>
        </tr>
        <tr>
          <th>Qualification:</th>
          <td>{{ $student->qualification ?? '12th Pass' }}</td>
        </tr>
        <tr>
          <th>Gender:</th>
          <td>{{ $student->gender ?? 'Male' }}</td>
        </tr>
        <tr>
          <th>Address / Location:</th>
          <td>{{ $student->address ?? ($student->city ?? 'Bihar, India') }}</td>
        </tr>
        <tr>
          <th>Counselling Status:</th>
          <td><span style="color:#059669; font-weight: 700;"><i class="fas fa-check-circle"></i> Allotment Verified / Active Registration</span></td>
        </tr>
      </table>

      <div style="margin: 25px 0; font-size: 13.5px; color: #334155; line-height: 1.6;">
        <p>This is to certify that candidate <strong>{{ $student->name ?? 'the candidate' }}</strong> is officially registered for the <strong>Bihar Students Counselling Center Awareness Program 2025</strong> under <strong>Uddan Educational Foundation</strong>. The candidate is eligible for career guidance, college admission assistance, and Bihar Student Credit Card (DRCC) loan facilitation.</p>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 40px; padding-top: 20px; border-top: 1px dashed #cbd5e1;">
        <div style="font-size: 12px; color: #64748b;">
          <p style="margin: 0;"><strong>Verified By:</strong></p>
          <p style="margin: 2px 0;">Admission Counseling Board</p>
          <p style="margin: 0;">Uddan Educational Foundation</p>
        </div>
        <div style="text-align: right; font-size: 12px; color: #64748b;">
          <div style="display: inline-block; border-bottom: 1.5px solid #334155; width: 140px; margin-bottom: 6px;"></div>
          <p style="margin: 0; font-weight: 700; color: #0f172a;">Authorized Signatory</p>
          <p style="margin: 0;">(Official Stamp &amp; Seal)</p>
        </div>
      </div>
    </div>

    <!-- Actions (No Print) -->
    <div class="no-print" style="text-align: center; margin-top: 30px;">
      <button onclick="window.print()" style="padding: 12px 24px; background: #014655; color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; margin-right: 12px; font-size: 14px; box-shadow: 0 4px 15px rgba(1,70,85,0.2);">
        <i class="fas fa-print"></i> Print Letter
      </button>
      <a href="{{ route('frontend.apply') }}" style="padding: 12px 24px; background: #F37021; color: #fff; border-radius: 10px; font-weight: 700; text-decoration: none; display: inline-block; font-size: 14px; box-shadow: 0 4px 15px rgba(243,112,33,0.2);">
        <i class="fas fa-plus"></i> Submit Another Application
      </a>
    </div>

  </div>
</section>

@endsection
