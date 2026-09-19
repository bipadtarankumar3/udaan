$files = Get-ChildItem -Path 'd:\udaan f' -Filter '*.html'

$oldFooterContact = '(?s)<li><i class="fas fa-map-marker-alt"></i><span>123 Foundation Street,<br>New Delhi, India - 110001</span></li>\s*<li><i class="fas fa-phone-alt"></i><span>\+91-98765-43210</span></li>'

$newFooterContact = '<li><i class="fas fa-map-marker-alt"></i><span style="font-size:12px;"><strong>Head Office:</strong> Near Care Hospital Naya Tola, Rajendra Nagar to Kumhara Man Road, opposite Yamaha Service Center, Kumhrar, PIN - 800027</span></li>
          <li><i class="fas fa-map-marker-alt"></i><span style="font-size:12px;"><strong>Bhagalpur Branch:</strong> Near Aadampur Chowk Biased Bharat Gas Godam, 812001</span></li>
          <li><i class="fas fa-map-marker-alt"></i><span style="font-size:12px;"><strong>Muzaffarpur Branch:</strong> Near Ram Bhajan Bazar Gola Road, MIMS Campus ka andar (Near Vanijya Inter College), PIN- 842001</span></li>
          <li><i class="fas fa-map-marker-alt"></i><span style="font-size:12px;"><strong>Chapra Branch:</strong> RNP School Campus Mirchya Tola Daulatganj, PIN 841301</span></li>
          <li><i class="fas fa-map-marker-alt"></i><span style="font-size:12px;"><strong>Siwan Branch:</strong> Bindu Davi ITI Campus (moli ka Bathan) near dr. P Davi more, PIN 841227</span></li>
          <li><i class="fas fa-phone-alt"></i><span>+91 6206850133</span></li>'

$contactHtmlHeadOfficeOld = '(?s)<h4>Head Office</h4>\s*<p>123 Foundation Street, Connaught Place,<br>New Delhi, India - 110001</p>'
$contactHtmlHeadOfficeNew = '<h4>Our Offices</h4>
            <p style="font-size:13px; line-height:1.5;"><strong>Head Office:</strong> Near Care Hospital Naya Tola, Rajendra Nagar to Kumhara Man Road, opposite Yamaha Service Center, Kumhrar, PIN - 800027<br>
            <strong>Bhagalpur Branch:</strong> Near Aadampur Chowk Biased Bharat Gas Godam, 812001<br>
            <strong>Muzaffarpur Branch:</strong> Near Ram Bhajan Bazar Gola Road, MIMS Campus ka andar (Near Vanijya Inter College), PIN- 842001<br>
            <strong>Chapra Branch:</strong> RNP School Campus Mirchya Tola Daulatganj, PIN 841301<br>
            <strong>Siwan Branch:</strong> Bindu Davi ITI Campus (moli ka Bathan) near dr. P Davi more, PIN 841227</p>'

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw

    # Update Footer Contact Info
    $content = $content -replace $oldFooterContact, $newFooterContact

    # Update footer description & logo (ensure Edu. Uddan Foundation)
    $content = $content -replace '(?s)<img src="logo\.png" alt="Udaan Foundation">\s*<p>Udaan Foundation is dedicated', '<img src="logo.png" alt="Edu. Uddan Foundation" style="max-width:200px; height:auto; margin-bottom:15px;">
        <p><strong>UDDAN IS AN UNIT OF EDU. UDDAN FOUNDATION</strong><br>We are dedicated'

    # Update Top Bar Phone Number & WhatsApp
    $content = $content -replace '\+91-98765-43210', '+91 6206850133'
    $content = $content -replace '919876543210', '916206850133'
    
    # Update contact.html specific section
    $content = $content -replace $contactHtmlHeadOfficeOld, $contactHtmlHeadOfficeNew
    
    # Update phone in contact.html specific section
    $content = $content -replace '(?s)\+91-98765-43210 \(General\)<br>\+91-98765-43211 \(Programs\)', '+91 6206850133'

    Set-Content $file.FullName $content
}
