$files = Get-ChildItem -Path 'd:\udaan f' -Filter '*.html'

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw

    # Define the new header
    $newHeader = '<header class="header">
  <div class="header-top container">
    <a href="index.html" class="header-logo"><img src="logo.png" alt="Udaan Foundation Logo" style="height:60px;"></a>
    <button class="mobile-toggle" aria-label="Menu"><i class="fas fa-bars"></i></button>
  </div>
  <div class="header-nav-bar">
    <div class="container">
      <nav class="main-nav">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="available_courses.html">Available Courses</a></li>
          <li class="apply-now-li"><a href="apply.html">Apply Now</a></li>
          <li><a href="#">Process <i class="fas fa-chevron-down" style="font-size:11px;margin-left:4px;"></i></a>
            <ul class="dropdown-menu-custom">
              <li><a href="process.html">How It Works</a></li>
              <li><a href="enrollment.html">Enrollment Process</a></li>
            </ul>
          </li>
          <li><a href="confirmation.html">Counselling Letter</a></li>
          <li><a href="news.html">News &amp; Media</a></li>
          <li><a href="videos.html">Helpful Videos</a></li>
          <li><a href="partners.html">Approvals</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </nav>
    </div>
  </div>
</header>'

    # Replace the old header block with regex
    $content = $content -replace '(?s)<header class="header">.*?</header>', $newHeader
    
    # Also update mobile nav if needed (Optional, but let's keep it consistent)
    $mobileNavReplacement = '<ul><li><a href="index.html">Home</a></li><li><a href="available_courses.html">Available Courses</a></li><li class="apply-now-li"><a href="apply.html" style="color:#FFA500;font-weight:700;">Apply Now</a></li><li class="has-sub"><a href="#">Process</a><ul class="sub-menu"><li><a href="process.html">How It Works</a></li><li><a href="enrollment.html">Enrollment Process</a></li></ul></li><li><a href="confirmation.html">Counselling Letter</a></li><li><a href="news.html">News &amp; Media</a></li><li><a href="videos.html">Helpful Videos</a></li><li><a href="partners.html">Approvals</a></li><li><a href="contact.html">Contact</a></li></ul>'
    $content = $content -replace '(?s)<ul><li><a href="index.html">Home</a></li>.*?</ul></div>', ($mobileNavReplacement + '</div>')

    Set-Content $file.FullName $content
}
