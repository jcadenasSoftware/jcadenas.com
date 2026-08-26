document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const menuButton = document.getElementById('electricista-menu-toggle');
  const mobileMenu = document.getElementById('electricista-mobile-menu');
  const menuLinks = mobileMenu ? mobileMenu.querySelectorAll('a') : [];
  const accordionBreakPoint = window.matchMedia('(max-width: 680px)');
  const serviceAccordions = Array.from(document.querySelectorAll('.electricista-service-included'));

  const closeMenu = () => {
    if (!menuButton || !mobileMenu) {
      return;
    }
    mobileMenu.classList.remove('is-open');
    mobileMenu.setAttribute('aria-hidden', 'true');
    menuButton.setAttribute('aria-expanded', 'false');
    body.classList.remove('electricista-menu-open');
  };

  const openMenu = () => {
    if (!menuButton || !mobileMenu) {
      return;
    }
    mobileMenu.classList.add('is-open');
    mobileMenu.setAttribute('aria-hidden', 'false');
    menuButton.setAttribute('aria-expanded', 'true');
    body.classList.add('electricista-menu-open');
  };

  if (menuButton && mobileMenu) {
    menuButton.addEventListener('click', () => {
      const isOpen = mobileMenu.classList.contains('is-open');
      if (isOpen) {
        closeMenu();
      } else {
        openMenu();
      }
    });

    menuLinks.forEach((link) => {
      link.addEventListener('click', () => {
        closeMenu();
      });
    });

    document.addEventListener('click', (event) => {
      if (!mobileMenu.classList.contains('is-open')) {
        return;
      }
      const target = event.target;
      if (!(target instanceof Element)) {
        return;
      }
      if (!mobileMenu.contains(target) && !menuButton.contains(target)) {
        closeMenu();
      }
    });

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        closeMenu();
      }
    });
  }

  const closeServiceAccordion = (accordion) => {
    if (!accordion) {
      return;
    }
    accordion.classList.remove('is-open');
    const toggle = accordion.querySelector('.electricista-service-included-toggle');
    if (toggle) {
      toggle.setAttribute('aria-expanded', 'false');
    }
  };

  const openServiceAccordion = (accordion) => {
    if (!accordion) {
      return;
    }
    serviceAccordions.forEach((item) => {
      if (item !== accordion) {
        closeServiceAccordion(item);
      }
    });
    accordion.classList.add('is-open');
    const toggle = accordion.querySelector('.electricista-service-included-toggle');
    if (toggle) {
      toggle.setAttribute('aria-expanded', 'true');
    }
  };

  const syncServiceAccordionMode = () => {
    const isMobile = accordionBreakPoint.matches;
    serviceAccordions.forEach((accordion) => {
      const panel = accordion.querySelector('.electricista-service-included-panel');
      const toggle = accordion.querySelector('.electricista-service-included-toggle');
      if (!panel || !toggle) {
        return;
      }

      if (isMobile) {
        accordion.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
      } else {
        accordion.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'true');
      }
    });
  };

  if (serviceAccordions.length) {
    serviceAccordions.forEach((accordion) => {
      const toggle = accordion.querySelector('.electricista-service-included-toggle');
      if (!toggle) {
        return;
      }

      toggle.addEventListener('click', () => {
        if (!accordionBreakPoint.matches) {
          return;
        }

        const isOpen = accordion.classList.contains('is-open');
        if (isOpen) {
          closeServiceAccordion(accordion);
        } else {
          openServiceAccordion(accordion);
        }
      });
    });

    syncServiceAccordionMode();
    if (typeof accordionBreakPoint.addEventListener === 'function') {
      accordionBreakPoint.addEventListener('change', syncServiceAccordionMode);
    } else if (typeof accordionBreakPoint.addListener === 'function') {
      accordionBreakPoint.addListener(syncServiceAccordionMode);
    }
  }

  document.querySelectorAll('a[href*="#"]').forEach((link) => {
    link.addEventListener('click', (event) => {
      const href = link.getAttribute('href') || '';
      const url = new URL(href, window.location.href);
      if (url.pathname !== window.location.pathname || !url.hash) {
        return;
      }
      const target = document.querySelector(url.hash);
      if (!target) {
        return;
      }
      event.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      history.replaceState(null, '', url.hash);
    });
  });

  const gatewayTrigger = document.querySelector('[data-electricista-gateway]');
  if (gatewayTrigger) {
    let clickCount = 0;
    let clickTimeout = null;

    const resetGateway = () => {
      clickCount = 0;
      if (clickTimeout) {
        window.clearTimeout(clickTimeout);
        clickTimeout = null;
      }
    };

    const advanceGateway = () => {
      clickCount += 1;

      if (clickTimeout) {
        window.clearTimeout(clickTimeout);
      }

      if (clickCount >= 3) {
        const targetUrl = gatewayTrigger.getAttribute('data-electricista-gateway');
        resetGateway();
        if (targetUrl) {
          window.location.href = targetUrl;
        }
        return;
      }

      clickTimeout = window.setTimeout(resetGateway, 1100);
    };

    if (window.PointerEvent) {
      gatewayTrigger.addEventListener('pointerup', (event) => {
        if (event.pointerType === 'mouse' && event.button !== 0) {
          return;
        }
        advanceGateway();
      });
    } else {
      let touchTriggered = false;

      gatewayTrigger.addEventListener('touchend', (event) => {
        event.preventDefault();
        touchTriggered = true;
        advanceGateway();
        window.setTimeout(() => {
          touchTriggered = false;
        }, 400);
      }, { passive: false });

      gatewayTrigger.addEventListener('click', () => {
        if (touchTriggered) {
          return;
        }
        advanceGateway();
      });
    }
  }
});
