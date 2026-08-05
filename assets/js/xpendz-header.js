/**
 * Xpendz Sticky Header - Mobile Menu & Scroll Detection
 * Handles mobile menu toggle and scroll-based header appearance
 */

(function() {
  'use strict';

  var header = document.getElementById('xpendz-header');
  var mobileMenuBtn = document.getElementById('xpendz-mobile-menu-btn');
  var mobileMenu = document.getElementById('xpendz-mobile-menu');
  var mobileMenuLinks = mobileMenu ? mobileMenu.querySelectorAll('.xpendz-mobile-menu-link, .xpendz-mobile-menu-cta') : [];
  var lastScrollY = window.scrollY;
  var scrollThreshold = 5;

  if (!header || !mobileMenuBtn || !mobileMenu) {
    return;
  }

  // Toggle mobile menu
  function toggleMobileMenu() {
    var isOpen = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
    
    mobileMenuBtn.setAttribute('aria-expanded', !isOpen);
    mobileMenu.classList.toggle('open', !isOpen);
    
    // Prevent body scroll when menu is open
    document.body.style.overflow = !isOpen ? 'hidden' : '';
    
    // Focus management
    if (!isOpen) {
      mobileMenuLinks[0] ? mobileMenuLinks[0].focus() : null;
    } else {
      mobileMenuBtn.focus();
    }
  }

  // Close mobile menu
  function closeMobileMenu() {
    var isOpen = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
    if (isOpen) {
      mobileMenuBtn.setAttribute('aria-expanded', 'false');
      mobileMenu.classList.remove('open');
      document.body.style.overflow = '';
      mobileMenuBtn.focus();
    }
  }

  // Handle scroll for header appearance
  function handleScroll() {
    var currentScrollY = window.scrollY;
    
    // Add/remove scrolled class based on scroll position
    if (currentScrollY > scrollThreshold) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
    
    lastScrollY = currentScrollY;
  }

  // Event listeners
  mobileMenuBtn.addEventListener('click', toggleMobileMenu);

  // Close menu when clicking on links
  mobileMenuLinks.forEach(function(link) {
    link.addEventListener('click', closeMobileMenu);
  });

  // Close menu on escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && mobileMenu.classList.contains('open')) {
      closeMobileMenu();
    }
  });

  // Scroll detection with passive listener for performance
  window.addEventListener('scroll', handleScroll, { passive: true });

  // Initial check for scroll state
  handleScroll();

})();
