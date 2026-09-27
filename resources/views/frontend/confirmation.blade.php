@extends('frontend.layout')

@section('title', 'Counselling Letter & Admission Confirmation — Udaan Foundation')

@push('styles')
<style>
  @media print {
    .top-bar, .header, .mobile-nav, .mobile-nav-overlay, .page-banner, .no-print, .footer, .whatsapp-float, .scroll-top {
      display: none !important;
    }
    body, html {
      background: #fff !important;
      padding: 0 !important;
      margin: 0 !important;
    }
    .letter-wrapper {
      padding: 0 !important;
      background: #fff !important;
    }
    .counselling-letter-card {
      border: 3px solid #005697 !important;
      box-shadow: none !important;
      margin: 0 auto !important;
      padding: 20px 24px !important;
      max-width: 100% !important;
      page-break-inside: avoid;
    }
  }

  .counselling-letter-card {
    background: #ffffff;
    border: 3.5px solid #005697;
    border-radius: 14px;
    box-shadow: 0 10px 35px rgba(0, 86, 151, 0.12);
    padding: 24px 28px;
    max-width: 820px;
    margin: 0 auto;
    position: relative;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #0f172a;
  }

  .cl-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2.5px solid #005697;
    padding-bottom: 12px;
    margin-bottom: 14px;
    gap: 12px;
  }

  .cl-logo-box {
    flex: 1.1;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }

  .cl-center-info {
    flex: 1.55;
    border-left: 2px solid #005697;
    padding-left: 14px;
    padding-right: 8px;
  }

  .cl-seal-box {
    flex: 0.65;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .cl-title-banner {
    background: #005697;
    color: #ffffff;
    text-align: center;
    font-size: 20px;
    font-weight: 800;
    padding: 6px 12px;
    border-radius: 6px;
    margin-bottom: 14px;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 5px rgba(0, 86, 151, 0.25);
  }

  .cl-info-table {
    width: 100%;
    border-collapse: collapse;
    border: 1.5px solid #005697;
    margin-bottom: 12px;
  }

  .cl-info-table td {
    border: 1.5px solid #005697;
    padding: 7px 12px;
    font-size: 13px;
  }

  .cl-label {
    font-weight: 800;
    color: #005697;
  }

  .cl-val {
    font-weight: 600;
    color: #0f172a;
  }

  .cl-badge-tab {
    background: #005697;
    color: #ffffff;
    display: inline-block;
    padding: 3px 22px 3px 12px;
    font-weight: 800;
    font-size: 13.5px;
    clip-path: polygon(0 0, 100% 0, 92% 100%, 0% 100%);
    margin-bottom: 6px;
    position: relative;
  }

  .cl-badge-tab::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: #f97316;
  }

  .cl-list-item {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 11px;
    line-height: 1.4;
    color: #1e293b;
  }

  .cl-loc-table {
    width: 100%;
    border-collapse: collapse;
    border: 1.2px solid #005697;
    font-size: 11px;
  }

  .cl-loc-table td {
    border: 1.2px solid #005697;
    padding: 4px 8px;
    line-height: 1.35;
  }

  .cl-loc-city {
    font-weight: 800;
    color: #005697;
    white-space: nowrap;
    width: 18%;
  }

  .cl-loc-desc {
    color: #1e293b;
  }

  @media (max-width: 768px) {
    .cl-header {
      flex-direction: column;
      text-align: center;
      gap: 12px;
    }
    .cl-logo-box {
      align-items: center;
    }
    .cl-center-info {
      border-left: none;
      border-top: 1.5px solid #005697;
      padding: 10px 0 0;
    }
    .cl-info-table td {
      padding: 5px 8px;
      font-size: 12px;
    }
    .counselling-letter-card {
      padding: 15px;
    }
  }
</style>
@endpush

@section('content')

<!-- Page Banner (No Print) -->
<section class="page-banner no-print" style="background: linear-gradient(135deg, rgba(1,70,85,0.95), rgba(1,42,51,0.9)), url('{{ asset('images/admission-bg.jpg') }}') center/cover no-repeat; padding: 45px 0; text-align: center; color: #fff;">
  <div class="container">
    <h1 style="font-size: 28px; font-weight: 800; margin: 0 0 6px;">Counselling Letter &amp; Allotment Verification</h1>
    <p style="color: rgba(255,255,255,0.85); margin: 0; font-size: 14px;">Bihar Students Counselling Center Awareness Program 2025</p>
  </div>
</section>

<section class="letter-wrapper" style="background: #f1f5f9; padding: 35px 0 50px;">
  <div class="container">

    <!-- Search Box (No Print) -->
    <div class="no-print" style="max-width: 820px; margin: 0 auto 25px; background: #ffffff; border-radius: 14px; padding: 20px 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1.5px solid #cbd5e1;">
      <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
        <div>
          <h4 style="margin: 0 0 4px; font-size: 16px; color: #005697; font-weight: 800;">
            <i class="fas fa-search" style="color: #f97316; margin-right: 6px;"></i> Verify / Download Counselling Letter
          </h4>
          <p style="margin: 0; font-size: 13px; color: #64748b;">
            Enter your 10-digit registered mobile number to search and display your letter
          </p>
        </div>
        <form action="{{ route('frontend.confirmation') }}" method="GET" style="display: flex; gap: 8px; flex: 1; min-width: 280px; max-width: 420px;">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter 10-digit mobile number..." required style="flex: 1; padding: 10px 14px; border: 1.5px solid #94a3b8; border-radius: 8px; font-size: 14px; outline: none; font-weight: 500;">
          <button type="submit" style="background: #005697; color: #fff; border: none; padding: 10px 22px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 14px; transition: background 0.2s; white-space: nowrap;">
            <i class="fas fa-search"></i> Search
          </button>
        </form>
      </div>
    </div>

    <!-- Success Flash (No Print) -->
    @if(session('success'))
      <div class="no-print" style="max-width: 820px; margin: 0 auto 20px; background: #ecfdf5; border: 1.5px solid #10b981; color: #065f46; padding: 16px 20px; border-radius: 12px; text-align: center; box-shadow: 0 4px 15px rgba(16,185,129,0.12);">
        <i class="fas fa-check-circle" style="font-size: 28px; color: #10b981; margin-bottom: 6px;"></i>
        <h3 style="font-size: 18px; font-weight: 800; margin: 0 0 4px;">Application Submitted Successfully!</h3>
        <p style="margin: 0; font-size: 13.5px;">{{ session('success') }}</p>
        @if($refNo)
          <p style="margin-top: 6px; font-size: 12.5px; font-weight: 700; color: #047857;">
            Application Reference Number: <span style="background: #fff; padding: 3px 8px; border-radius: 6px; border: 1px solid #10b981;">{{ $refNo }}</span>
          </p>
        @endif
      </div>
    @endif

    <!-- Error if searched but not found -->
    @if(!$student && request('search'))
      <div class="no-print" style="max-width: 820px; margin: 0 auto 25px; background: #fff1f2; border: 1.5px solid #fecdd3; color: #9f1239; padding: 20px; border-radius: 12px; text-align: center; font-size: 14px;">
        <i class="fas fa-exclamation-circle" style="font-size: 24px; color: #e11d48; margin-bottom: 6px; display: block;"></i>
        No registration record found for mobile number <strong>"{{ request('search') }}"</strong>.
        <div style="margin-top: 10px;">
          <a href="{{ route('frontend.apply') }}" style="background: #e11d48; color: #fff; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 700; display: inline-block; font-size: 13px;">
            <i class="fas fa-user-plus"></i> Apply Online Now
          </a>
        </div>
      </div>
    @endif

    <!-- Default state: when no search has been performed yet and not submitted -->
    @if(!$student && !request('search') && !session('success'))
      <div class="no-print" style="max-width: 820px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 45px 30px; text-align: center; border: 1.5px dashed #94a3b8; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
        <div style="width: 70px; height: 70px; margin: 0 auto 16px; background: #e0f2fe; color: #0284c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px;">
          <i class="fas fa-id-card"></i>
        </div>
        <h3 style="color: #005697; font-size: 20px; font-weight: 800; margin: 0 0 8px;">Search Your Counselling Letter</h3>
        <p style="color: #64748b; font-size: 14px; max-width: 500px; margin: 0 auto 20px; line-height: 1.5;">
          Please enter your registered 10-digit mobile number in the search box above to view, verify, and print your official Bihar Student Counselling Center (BSCC) allotment letter.
        </p>
        <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
          <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; color: #475569; background: #f8fafc; padding: 6px 14px; border-radius: 20px; border: 1px solid #e2e8f0;">
            <i class="fas fa-check-circle" style="color: #10b981;"></i> 100% Free Counselling
          </span>
          <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; color: #475569; background: #f8fafc; padding: 6px 14px; border-radius: 20px; border: 1px solid #e2e8f0;">
            <i class="fas fa-check-circle" style="color: #10b981;"></i> DRCC Credit Card Scheme
          </span>
          <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; color: #475569; background: #f8fafc; padding: 6px 14px; border-radius: 20px; border: 1px solid #e2e8f0;">
            <i class="fas fa-check-circle" style="color: #10b981;"></i> Instant Allotment Slip
          </span>
        </div>
      </div>
    @endif

    <!-- COUNSELLING LETTER DETAILS (Shown ONLY when student is searched or found) -->
    @if($student)
      <div class="counselling-letter-card">

        <!-- Top Header -->
        <div class="cl-header">
          <!-- Left: Udaan Foundation Logo & Tagline -->
          <div class="cl-logo-box">
            <img src="{{ asset('logo.png') }}" alt="Uddan Educational Foundation" style="max-height: 54px; width: auto; object-fit: contain;">
            <div style="font-size: 7.5px; font-weight: 800; color: #334155; letter-spacing: 1.2px; margin-top: 5px; text-transform: uppercase;">
              GUIDANCE &nbsp;|&nbsp; OPPORTUNITY &nbsp;|&nbsp; BRIGHTER FUTURE
            </div>
          </div>

          <!-- Middle: Combined Counselling Board info -->
          <div class="cl-center-info">
            <div style="color: #005697; font-size: 19px; font-weight: 800; line-height: 1.15; letter-spacing: -0.3px;">
              Combined Counselling Board
            </div>
            <div style="background: #005697; color: #ffffff; font-weight: 800; font-size: 11px; padding: 2px 8px; text-transform: uppercase; margin: 3px 0 4px; display: inline-block; letter-spacing: 0.5px; border-radius: 2px;">
              BIHAR STUDENT COUNSELLING CENTER
            </div>
            <div style="font-size: 9.5px; color: #1e293b; line-height: 1.35; display: flex; align-items: flex-start; gap: 4px;">
              <i class="fas fa-map-marker-alt" style="color: #005697; font-size: 10px; margin-top: 2px;"></i>
              <div>
                <strong>BSCC</strong>, AT- Kargil Chowk (Gandhi Maidan), Beside Aawaran Vastralaya, in front of Pillar No. 7 &amp; 8 Ashok Rajpath, Patna, Bihar
              </div>
            </div>
            <div style="font-size: 9px; color: #005697; font-weight: 700; margin-top: 3px; display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
              <span><i class="fas fa-phone-alt"></i> 6202601616</span>
              <span>|</span>
              <span><i class="fas fa-globe"></i> www.bscc.net.in</span>
              <span>|</span>
              <span><i class="fas fa-envelope"></i> ccbwelfare@gmail.com</span>
            </div>
          </div>

          <!-- Right: Combined Counselling Board Circular Seal / Stamp -->
          <div class="cl-seal-box">
            <img src="{{ asset('images/stamp_top.png') }}" alt="Combined Counselling Board Seal" style="max-height: 90px; max-width: 90px; width: auto; object-fit: contain; background: transparent;">
          </div>
        </div>

        <!-- Section Title Banner -->
        <div class="cl-title-banner">
          Counselling Letter
        </div>

        <!-- 2x2 Dynamic Details Table -->
        <table class="cl-info-table">
          <tr>
            <td class="cl-label" style="width: 20%;">Counselling Date:</td>
            <td class="cl-val" style="width: 30%;">{{ $counsellingDate }}</td>
            <td class="cl-label" style="width: 16%;">Time:</td>
            <td class="cl-val" style="width: 34%;">{{ $counsellingTime }}</td>
          </tr>
          <tr>
            <td class="cl-label">Name:</td>
            <td class="cl-val" style="text-transform: capitalize;">{{ $student->name }}</td>
            <td class="cl-label">Date of Birth:</td>
            <td class="cl-val">{{ $dobFormatted }}</td>
          </tr>
        </table>

        <!-- Note: Section -->
        <div style="margin-bottom: 11px;">
          <div class="cl-badge-tab">
            Note:
          </div>
          <div style="font-size: 10.5px; color: #1e293b; line-height: 1.45; padding-left: 2px;">
            <div><strong>1.</strong> To download your counselling letter again, fill up your mobile number and date of birth.</div>
            <div><strong>2.</strong> You can select your choice at the time of the time of counselling. Our Counselling is absolutely FREE.</div>
            <div>
              <strong>3.</strong> <strong style="color: #005697;">Available Courses:</strong> 
              <span style="color: #c2410c; font-weight: 700;">B.Tech, B.Tech-CS, B.Tech/B.Sc Bio-tech, Polytechnic, B.Pharma, B.Sc. Agriculture, BCA, BBA, B.Com, BPT, GNM, Hotel Mgmt., B.Sc. (Hospital Mgmt.), BBA/B.Com, LL.B, BMLT, MBA, MCA, BPT, B.Com, Para Medical, BDS etc.</span>
            </div>
          </div>
        </div>

        <!-- BSCC Highlight Box with Graduation Cap Icon -->
        <div style="background: #edf6fd; border-radius: 8px; padding: 9px 14px; display: flex; align-items: center; gap: 14px; margin-bottom: 11px; border: 1px solid #bfdbfe;">
          <div style="background: #005697; color: #ffffff; width: 40px; height: 40px; min-width: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-graduation-cap"></i>
          </div>
          <div style="font-size: 11px; color: #0f172a; line-height: 1.45;">
            आपका काउंसलिंग <strong>BSCC</strong> द्वारा संचालित कर दिया गया है तथा सरकार द्वारा आयोजित काउंसलिंग में आपको आमंत्रित किया जाता है। स्टूडेंट क्रेडिट कार्ड बिहार सरकार की महत्वाकांक्षी योजना है, जो विद्यार्थियों को उच्च शिक्षा प्राप्त करने में <strong>4 लाख रुपये तक की ब्याज मुक्त आर्थिक सहायता</strong> प्रदान करती है।
          </div>
        </div>

        <!-- Section: काउंसलिंग से संबंधित मुख्य बातें -->
        <div style="margin-bottom: 11px;">
          <div class="cl-badge-tab">
            काउंसलिंग से संबंधित मुख्य बातें
          </div>
          <div style="display: flex; flex-direction: column; gap: 3.5px; font-size: 10.5px; color: #1e293b; line-height: 1.35; padding-left: 2px;">
            <div class="cl-list-item">
              <i class="fas fa-check-square" style="color: #10b981; font-size: 13px; margin-top: 1px;"></i>
              <span>इस योजना के अंतर्गत विद्यार्थियों को BSCC से संबंधित कॉलेजों से College Fee, Hostel Fee एवं रहने व खाने का खर्चा बिहार स्टूडेंट क्रेडिट कार्ड योजना के माध्यम से मिलता है।</span>
            </div>
            <div class="cl-list-item">
              <i class="fas fa-check-square" style="color: #10b981; font-size: 13px; margin-top: 1px;"></i>
              <span>काउंसलिंग लेटर को सुरक्षित रखें एवं काउंसलिंग के समय लेटर दिखाकर निःशुल्क काउंसलिंग अटेंड करें।</span>
            </div>
            <div class="cl-list-item">
              <i class="fas fa-check-square" style="color: #10b981; font-size: 13px; margin-top: 1px;"></i>
              <span>काउंसलिंग सेंटर के माध्यम से छात्र अवगत कराया जाता है कि आपको कौन सा कोर्स उपलब्ध है, Courses, Colleges list, Placements Hostel, Colleges location, College Govt. Approvals एवं अन्य जानकारी विस्तृत में दी जाती है।</span>
            </div>
            <div class="cl-list-item">
              <i class="fas fa-check-square" style="color: #10b981; font-size: 13px; margin-top: 1px;"></i>
              <span>स्टूडेंट क्रेडिट कार्ड योजना के लिए आवश्यक डॉक्यूमेंट्स की जानकारी दी जाती है तथा एजुकेशन इंस्टीटूयशन द्वारा विद्यार्थियों को दिए जाने वाले Documents उपलब्ध करवाया जाता है।</span>
            </div>
            <div class="cl-list-item">
              <i class="fas fa-check-square" style="color: #10b981; font-size: 13px; margin-top: 1px;"></i>
              <span>बिहार स्टूडेंट क्रेडिट कार्ड (BSCC) का लाभ केवल NAAC-A / NIRF / NBA accredited institutions एवं बिहार सरकार द्वारा मान्यता प्राप्त कॉलेजों से पढ़ाई करने पर ही मिलता है।</span>
            </div>
            <div class="cl-list-item">
              <i class="fas fa-check-square" style="color: #10b981; font-size: 13px; margin-top: 1px;"></i>
              <span>काउंसलिंग के समय विद्यार्थी अपनी पसंद अनुसार दिए गए कॉलेज लिस्ट में कॉलेज और कोर्स का चयन कर सकते हैं।</span>
            </div>
            <div class="cl-list-item">
              <i class="fas fa-check-square" style="color: #10b981; font-size: 13px; margin-top: 1px;"></i>
              <span>काउंसलिंग के बाद विद्यार्थियों अपने लिए एक Seat का Allotment Letter निःशुल्क प्राप्त कर सकते हैं।</span>
            </div>
            <div class="cl-list-item">
              <i class="fas fa-check-square" style="color: #10b981; font-size: 13px; margin-top: 1px;"></i>
              <span>काउंसलिंग के बाद admission लेना पूर्णतः विद्यार्थियों एवं उनके परिवार के निर्णय पर निर्भर है।</span>
            </div>
            <div class="cl-list-item">
              <i class="fas fa-check-square" style="color: #10b981; font-size: 13px; margin-top: 1px;"></i>
              <span>काउंसलिंग पूर्णतः निःशुल्क है अतः काउंसलिंग अवश्य अटेंड करें।</span>
            </div>
          </div>
        </div>

        <!-- Section: Counselling Location & Seal/Signature -->
        <div>
          <div class="cl-badge-tab">
            Counselling Location
          </div>
          <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px;">
            <!-- Location Table -->
            <table class="cl-loc-table" style="flex: 1;">
              <tr>
                <td class="cl-loc-city">पटना :</td>
                <td class="cl-loc-desc">कारगिल चौक (गांधी मैदान), आचार्य वस्त्रालय के बगल में, पिलर नम्बर 7 और 8 के सामने, अशोक राजपथ, पटना, बिहार</td>
              </tr>
              <tr>
                <td class="cl-loc-city">सीतामढ़ी :</td>
                <td class="cl-loc-desc">Umega Pvt ITI, श्री मधुरा हाई स्कूल के सामने, रिंग बांध, लक्ष्मणा नगर, सीतामढ़ी</td>
              </tr>
              <tr>
                <td class="cl-loc-city">सिवान :</td>
                <td class="cl-loc-desc">सिद्धि देवी ITI, मखदूम सराय फुलवरिया, शिव पब्लिक स्कूल के पास, सिवान</td>
              </tr>
              <tr>
                <td class="cl-loc-city">बेतिया :</td>
                <td class="cl-loc-desc">Abhinav I.T.I, चन्द्रिया सिनेमा रोड, होटल राज के पास, पटना, बिहार</td>
              </tr>
            </table>

            <!-- Stamp & Official Signature at Bottom Right -->
            <div style="width: 115px; min-width: 115px; text-align: center; position: relative;">
              <img src="{{ asset('images/stamp_signature.png') }}" alt="Combined Counselling Board Signature & Stamp" style="max-height: 98px; max-width: 120px; width: auto; object-fit: contain; background: transparent;">
            </div>
          </div>
        </div>

      </div>

      <!-- Action Buttons (No Print) -->
      <div class="no-print" style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()" style="padding: 12px 28px; background: #005697; color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; margin-right: 12px; font-size: 14px; box-shadow: 0 4px 15px rgba(0,86,151,0.25); transition: all 0.2s;">
          <i class="fas fa-print"></i> Print Counselling Letter
        </button>
        <a href="{{ route('frontend.apply') }}" style="padding: 12px 24px; background: #f97316; color: #fff; border-radius: 10px; font-weight: 700; text-decoration: none; display: inline-block; font-size: 14px; box-shadow: 0 4px 15px rgba(249,115,22,0.25);">
          <i class="fas fa-plus"></i> New Application
        </a>
      </div>
    @endif

  </div>
</section>

@endsection
