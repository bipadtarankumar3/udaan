/* ============================================
   UDAAN FOUNDATION — Main JavaScript
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

  // ---------- Preloader ----------
  const preloader = document.getElementById('preloader');
  if (preloader) {
    window.addEventListener('load', function () {
      setTimeout(() => { preloader.classList.add('hidden'); }, 400);
    });
    // Fallback: hide after 3s
    setTimeout(() => { preloader.classList.add('hidden'); }, 3000);
  }

  // ---------- Hero Slider ----------
  const slides = document.querySelectorAll('.hero-slide');
  const heroDots = document.querySelectorAll('.hero-dots .dot');
  let currentSlide = 0;
  let slideInterval;

  function showSlide(index) {
    slides.forEach(s => s.classList.remove('active'));
    heroDots.forEach(d => d.classList.remove('active'));
    currentSlide = (index + slides.length) % slides.length;
    if (slides[currentSlide]) slides[currentSlide].classList.add('active');
    if (heroDots[currentSlide]) heroDots[currentSlide].classList.add('active');
  }

  function nextSlide() { showSlide(currentSlide + 1); }
  function prevSlide() { showSlide(currentSlide - 1); }

  if (slides.length > 0) {
    slideInterval = setInterval(nextSlide, 5000);
    heroDots.forEach((dot, i) => {
      dot.addEventListener('click', () => {
        clearInterval(slideInterval);
        showSlide(i);
        slideInterval = setInterval(nextSlide, 5000);
      });
    });
    const prevBtn = document.querySelector('.hero-arrow.prev');
    const nextBtn = document.querySelector('.hero-arrow.next');
    if (prevBtn) prevBtn.addEventListener('click', () => {
      clearInterval(slideInterval);
      prevSlide();
      slideInterval = setInterval(nextSlide, 5000);
    });
    if (nextBtn) nextBtn.addEventListener('click', () => {
      clearInterval(slideInterval);
      nextSlide();
      slideInterval = setInterval(nextSlide, 5000);
    });
  }

  // ---------- Mobile Nav ----------
  const mobileToggle = document.querySelector('.mobile-toggle');
  const mobileNav = document.querySelector('.mobile-nav');
  const mobileOverlay = document.querySelector('.mobile-nav-overlay');
  const mobileClose = document.querySelector('.mobile-nav-close');

  function openMobileNav() {
    mobileNav && mobileNav.classList.add('active');
    mobileOverlay && mobileOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
  function closeMobileNav() {
    mobileNav && mobileNav.classList.remove('active');
    mobileOverlay && mobileOverlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  if (mobileToggle) mobileToggle.addEventListener('click', openMobileNav);
  if (mobileClose) mobileClose.addEventListener('click', closeMobileNav);
  if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileNav);

  // Mobile sub-menus
  document.querySelectorAll('.mobile-nav .has-sub > a').forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      this.parentElement.classList.toggle('open');
    });
  });

  // ---------- Scroll to Top ----------
  const scrollTopBtn = document.querySelector('.scroll-top');
  if (scrollTopBtn) {
    window.addEventListener('scroll', () => {
      scrollTopBtn.classList.toggle('visible', window.scrollY > 400);
    });
    scrollTopBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // ---------- Stats Counter Animation ----------
  const counters = document.querySelectorAll('.stat-number');
  let countersAnimated = false;

  function animateCounters() {
    if (countersAnimated) return;
    counters.forEach(counter => {
      const target = parseInt(counter.getAttribute('data-count'), 10);
      const suffix = counter.getAttribute('data-suffix') || '';
      const duration = 2000;
      const step = target / (duration / 16);
      let current = 0;

      const update = () => {
        current += step;
        if (current >= target) {
          counter.textContent = target.toLocaleString() + suffix;
          return;
        }
        counter.textContent = Math.floor(current).toLocaleString() + suffix;
        requestAnimationFrame(update);
      };
      requestAnimationFrame(update);
    });
    countersAnimated = true;
  }

  // ---------- Scroll Animations ----------
  const fadeElements = document.querySelectorAll('.fade-in, .fade-in-left, .fade-in-right');

  function handleScrollAnimations() {
    fadeElements.forEach(el => {
      const rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight - 80) {
        el.classList.add('visible');
      }
    });

    // Trigger counters when stats section is visible
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
      const rect = statsSection.getBoundingClientRect();
      if (rect.top < window.innerHeight - 100) {
        animateCounters();
      }
    }
  }

  window.addEventListener('scroll', handleScrollAnimations);
  handleScrollAnimations(); // Initial check

  // ---------- Testimonial Slider ----------
  const testimonialSlides = document.querySelectorAll('.testimonial-slide');
  const testimonialDots = document.querySelectorAll('.testimonial-dots .dot');
  let currentTestimonial = 0;
  let testimonialInterval;

  function showTestimonial(index) {
    testimonialSlides.forEach(s => s.classList.remove('active'));
    testimonialDots.forEach(d => d.classList.remove('active'));
    currentTestimonial = (index + testimonialSlides.length) % testimonialSlides.length;
    if (testimonialSlides[currentTestimonial]) testimonialSlides[currentTestimonial].classList.add('active');
    if (testimonialDots[currentTestimonial]) testimonialDots[currentTestimonial].classList.add('active');
  }

  if (testimonialSlides.length > 0) {
    testimonialInterval = setInterval(() => showTestimonial(currentTestimonial + 1), 4000);
    testimonialDots.forEach((dot, i) => {
      dot.addEventListener('click', () => {
        clearInterval(testimonialInterval);
        showTestimonial(i);
        testimonialInterval = setInterval(() => showTestimonial(currentTestimonial + 1), 4000);
      });
    });
  }

  // ---------- FAQ Accordion ----------
  document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', function () {
      const answer = this.nextElementSibling;
      const isOpen = this.classList.contains('active');

      // Close all
      document.querySelectorAll('.faq-question').forEach(q => q.classList.remove('active'));
      document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('open'));

      if (!isOpen) {
        this.classList.add('active');
        answer.classList.add('open');
      }
    });
  });

  // ---------- Contact Form Validation ----------
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      let valid = true;

      // Clear previous errors
      this.querySelectorAll('.form-group').forEach(g => g.classList.remove('error'));

      // Validate required fields
      this.querySelectorAll('[required]').forEach(field => {
        if (!field.value.trim()) {
          field.closest('.form-group').classList.add('error');
          valid = false;
        }
      });

      // Email validation
      const email = this.querySelector('[type="email"]');
      if (email && email.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        email.closest('.form-group').classList.add('error');
        valid = false;
      }

      if (valid) {
        showToast('Thank you! Your message has been sent successfully.', 'success');
        this.reset();
      } else {
        showToast('Please fill in all required fields correctly.', 'error');
      }
    });
  }

  // ---------- Apply Form Validation ----------
  const applyForm = document.getElementById('applyForm');
  if (applyForm) {
    applyForm.addEventListener('submit', function (e) {
      e.preventDefault();
      let valid = true;

      this.querySelectorAll('.form-group').forEach(g => g.classList.remove('error'));

      this.querySelectorAll('[required]').forEach(field => {
        if (!field.value.trim()) {
          field.closest('.form-group').classList.add('error');
          valid = false;
        }
      });

      const email = this.querySelector('[type="email"]');
      if (email && email.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        email.closest('.form-group').classList.add('error');
        valid = false;
      }

      const terms = this.querySelector('#terms');
      if (terms && !terms.checked) {
        showToast('Please accept the Terms & Conditions.', 'error');
        valid = false;
      }

      if (valid) {
        showToast('Application submitted successfully! We will contact you soon.', 'success');
        this.reset();
      } else if (valid === false && (!terms || terms.checked)) {
        showToast('Please fill in all required fields correctly.', 'error');
      }
    });
  }

  // ---------- Toast Notification ----------
  function showToast(message, type) {
    // Remove existing
    const existing = document.querySelector('.toast-msg');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = `toast-msg ${type}`;
    toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}`;
    document.body.appendChild(toast);

    setTimeout(() => toast.classList.add('show'), 50);
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 400);
    }, 4000);
  }

  // ---------- News Ticker ----------
  const ticker = document.querySelector('.news-ticker-content');
  if (ticker) {
    // Clone for seamless loop
    ticker.innerHTML += ticker.innerHTML;
  }

  // ---------- Sticky header shadow on scroll ----------
  const header = document.querySelector('.header');
  if (header) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 10) {
        header.style.boxShadow = '0 4px 30px rgba(0,0,0,0.1)';
      } else {
        header.style.boxShadow = '0 4px 24px rgba(0,0,0,0.08)';
      }
    });
  }

  // ---------- Active Nav Link ----------
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.main-nav a, .mobile-nav a').forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPage) {
      link.closest('li').classList.add('active');
    }
  });

});
