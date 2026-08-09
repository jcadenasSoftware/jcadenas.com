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

  function setMobileMenuState(isOpen) {
    mobileMenuBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    mobileMenu.classList.toggle('open', isOpen);
    mobileMenu.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    document.body.style.overflow = isOpen ? 'hidden' : '';
  }

  // Toggle mobile menu
  function toggleMobileMenu() {
    var isOpen = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
    setMobileMenuState(!isOpen);
    
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
      setMobileMenuState(false);
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

  mobileMenu.addEventListener('click', function(e) {
    if (e.target === mobileMenu) {
      closeMobileMenu();
    }
  });

  // Close menu on escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && mobileMenu.classList.contains('open')) {
      closeMobileMenu();
    }
  });

  window.addEventListener('resize', function() {
    if (window.innerWidth >= 768) {
      setMobileMenuState(false);
    }
  });

  // Scroll detection with passive listener for performance
  window.addEventListener('scroll', handleScroll, { passive: true });

  // Initial check for scroll state
  handleScroll();

})();
