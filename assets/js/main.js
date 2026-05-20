(function () {
  const show = (element) => {
    if (!element) return;
    element.hidden = false;
    element.classList.add('is-open');
  };

  const hide = (element) => {
    if (!element) return;
    element.classList.remove('is-open');
    if (element.matches('[data-jb-mobile-menu]')) {
      element.hidden = true;
    }
  };

  const syncFilterTop = (filterBox) => {
    if (!filterBox) return;

    const header = document.querySelector('[data-jb-header]');
    const headerBottom = header ? Math.max(0, Math.round(header.getBoundingClientRect().bottom)) : 0;
    filterBox.style.setProperty('--jb-filter-top', `${headerBottom}px`);
  };

  const updateCatalogFilterCounts = (form, payload) => {
    const counts = payload?.counts || {};

    form.querySelectorAll('[data-jb-filter-option]').forEach((option) => {
      const param = option.getAttribute('data-jb-filter-param');
      const slug = option.getAttribute('data-jb-filter-slug');
      const item = param && slug && counts[param] ? counts[param][slug] : null;

      if (!item) return;

      const count = Number(item.count || 0);
      const input = option.querySelector('input');
      const countNode = option.querySelector('[data-jb-filter-count]');

      if (countNode) {
        countNode.textContent = String(count);
      }

      if (input) {
        const disabled = count <= 0 && !input.checked;
        input.disabled = disabled;
        option.classList.toggle('is-disabled', disabled);
      }
    });
  };

  const refreshCatalogFilterCounts = (() => {
    let controller = null;
    let timer = null;

    return (form) => {
      if (!form) return;

      window.clearTimeout(timer);
      timer = window.setTimeout(() => {
        if (controller) {
          controller.abort();
        }

        controller = new AbortController();
        const requestController = controller;
        const body = new FormData(form);
        body.set('action', 'jullybride_catalog_filter_counts');
        body.set('category_id', form.getAttribute('data-jb-catalog-category') || '0');
        form.classList.add('is-refreshing');

        fetch(window.jullybrideTheme?.ajaxUrl || '/wp-admin/admin-ajax.php', {
          method: 'POST',
          body,
          credentials: 'same-origin',
          signal: requestController.signal
        })
          .then((response) => (response.ok ? response.json() : Promise.reject(response)))
          .then((response) => {
            if (response?.success) {
              updateCatalogFilterCounts(form, response.data);
            }
          })
          .catch((error) => {
            if (error?.name !== 'AbortError') {
              console.warn('Не удалось обновить счетчики фильтра.', error);
            }
          })
          .finally(() => {
            if (!requestController.signal.aborted && controller === requestController) {
              form.classList.remove('is-refreshing');
            }
          });
      }, 120);
    };
  })();

  document.addEventListener('click', (event) => {
    const openMobile = event.target.closest('[data-jb-mobile-open]');
    const closeMobile = event.target.closest('[data-jb-mobile-close]');
    const mobileMenu = document.querySelector('[data-jb-mobile-menu]');
    const filterBox = document.querySelector('.filter-box');

    if (openMobile) {
      show(mobileMenu);
    }

    if (closeMobile || event.target === mobileMenu) {
      hide(mobileMenu);
    }

    if (event.target.closest('.left-filter-btn')) {
      event.preventDefault();
      syncFilterTop(filterBox);
      show(filterBox);
      document.body.classList.add('jb-filter-open');
    }

    if (event.target.closest('.w-filter-list-closer') || event.target === filterBox) {
      hide(filterBox);
      document.body.classList.remove('jb-filter-open');
    }

    const filterToggle = event.target.closest('[data-jb-filter-toggle]');
    if (filterToggle) {
      event.preventDefault();
      filterToggle.closest('.jb-filter')?.classList.toggle('is-open');
    }

    if (event.target.closest('[data-jb-filters-open]')) {
      show(document.querySelector('[data-jb-filters]'));
    }

    if (event.target.closest('[data-jb-filters-close]')) {
      hide(document.querySelector('[data-jb-filters]'));
    }
  });

  document.addEventListener('change', (event) => {
    const checkbox = event.target.closest('[data-jb-filter-term]');
    const form = event.target.closest('[data-jb-filters]');

    if (checkbox) {
      const fieldName = checkbox.getAttribute('data-jb-filter-term');
      const hidden = form ? form.querySelector(`input[type="hidden"][name="${fieldName}"]`) : null;

      if (hidden && form) {
        const checked = Array.from(form.querySelectorAll(`[data-jb-filter-term="${fieldName}"]:checked`)).map((item) => item.value);
        hidden.value = checked.join(',');
      }
    }

    if (form && (checkbox || event.target.matches('input[name="jb_in_stock"]'))) {
      refreshCatalogFilterCounts(form);
    }
  });

  document.addEventListener('submit', (event) => {
    const form = event.target.closest('[data-jb-filters], .jb-catalog-sort-form');
    if (!form) return;

    const disabled = [];
    form.querySelectorAll('input[type="hidden"]').forEach((input) => {
      if (input.value !== '') return;
      input.disabled = true;
      disabled.push(input);
    });

    if (disabled.length) {
      window.setTimeout(() => {
        disabled.forEach((input) => {
          input.disabled = false;
        });
      }, 0);
    }
  });

  const setupStickyHeader = () => {
    const header = document.querySelector('[data-jb-header]');
    if (!header) return;

    const updateHeader = () => {
      header.classList.toggle('is-compact', window.scrollY > 24);
      const updateOffset = () => {
        const bottom = Math.max(0, Math.round(header.getBoundingClientRect().bottom));
        document.documentElement.style.setProperty('--jb-sticky-header-bottom', `${bottom}px`);
        document.querySelector('.filter-box.is-open')?.style.setProperty('--jb-filter-top', `${bottom}px`);
      };
      updateOffset();
      window.requestAnimationFrame(updateOffset);
    };

    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });
    window.addEventListener('resize', updateHeader, { passive: true });
    document.addEventListener('scroll', updateHeader, { passive: true, capture: true });
    window.setInterval(updateHeader, 250);
  };

  const setupMegaMenu = () => {
    document.querySelectorAll('.jb-main-menu__item.has-dropdown').forEach((item) => {
      item.addEventListener('pointerenter', () => item.classList.add('is-mega-open'));
      item.addEventListener('pointerleave', () => item.classList.remove('is-mega-open'));
      item.addEventListener('focusin', () => item.classList.add('is-mega-open'));
      item.addEventListener('focusout', (event) => {
        if (!item.contains(event.relatedTarget)) {
          item.classList.remove('is-mega-open');
        }
      });
    });
  };

  const setupCatalogLoadMore = () => {
    if (!window.jQuery) return;
    const $ = window.jQuery;
    let isLoading = false;

    const updateLoadMoreVisibility = () => {
      const nextLink = document.getElementById('load-more-link');
      const loadMoreBlock = document.querySelector('.products-list_more');

      if (loadMoreBlock && (!nextLink || !nextLink.href || nextLink.href.includes('#'))) {
        loadMoreBlock.style.display = 'none';
      }
    };

    const initProductCards = ($items) => {
      if (!$.fn.owlCarousel) return;

      $items.find('.products-list-carusel').each(function () {
        const $carousel = $(this);
        if ($carousel.hasClass('owl-loaded')) return;

        $carousel.owlCarousel({
          loop: false,
          nav: false,
          dots: false,
          margin: 0,
          smartSpeed: 450,
          mouseDrag: true,
          touchDrag: true,
          items: 1
        });
      });
    };

    const bindProductCardNav = ($scope) => {
      $scope.find('.products-nav-prev').off('click.jullybride').on('click.jullybride', function () {
        $(this).closest('.product-carousel-wrapper').find('.products-list-carusel').trigger('prev.owl.carousel');
      });

      $scope.find('.products-nav-next').off('click.jullybride').on('click.jullybride', function () {
        $(this).closest('.product-carousel-wrapper').find('.products-list-carusel').trigger('next.owl.carousel');
      });
    };

    updateLoadMoreVisibility();

    $(document).off('click.jullybrideLoadMore').on('click.jullybrideLoadMore', '.load-more-products', function (event) {
      event.preventDefault();
      if (isLoading) return;

      const nextLink = document.getElementById('load-more-link');
      const nextPageUrl = nextLink ? nextLink.href : '';

      if (!nextPageUrl || nextPageUrl.includes('#')) {
        $('.products-list_more').fadeOut();
        return;
      }

      isLoading = true;
      $('.load-more-products').text('Загрузка...');

      $.get(nextPageUrl)
        .done((data) => {
          const $newHtml = $(data);
          const $newItems = $newHtml.find('#products-row .products-list-item');

          if ($newItems.length) {
            $('#products-row').append($newItems);
            initProductCards($newItems);
            bindProductCardNav($newItems);
          }

          const $newPagination = $newHtml.find('.box-pagination');
          if ($newPagination.length) {
            $('.box-pagination').replaceWith($newPagination);
          } else {
            $('.products-list_more').fadeOut();
          }

          updateLoadMoreVisibility();
          $('.load-more-products').text('Показать больше');
        })
        .fail(() => {
          $('.load-more-products').text('Ошибка загрузки');
          $('.products-list_more').fadeOut();
        })
        .always(() => {
          isLoading = false;
        });
    });
  };

  const setupAtmosphereCarousel = () => {
    document.querySelectorAll('img[data-src]').forEach((image) => {
      const source = image.getAttribute('data-src');
      if (source && !image.getAttribute('src')) {
        image.setAttribute('src', source);
      }
    });

    document.querySelectorAll('#carousel-pint video[data-src]').forEach((video) => {
      const source = video.getAttribute('data-src');
      if (source && !video.getAttribute('src')) {
        video.setAttribute('src', source);
      }
    });
  };

  const setupCampCountdown = () => {
    document.querySelectorAll('[data-camp-countdown]').forEach((counter) => {
      const targetDate = new Date(counter.getAttribute('data-camp-countdown')).getTime();
      if (!targetDate) return;

      const updateCounter = () => {
        const diff = targetDate - Date.now();

        if (diff <= 0) {
          counter.innerHTML = '<span class="counter-unit">00:<small>дней</small></span><span class="counter-unit">00:<small>часов</small></span><span class="counter-unit">00:<small>минут</small></span><span class="counter-unit">00<small>секунд</small></span>';
          return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        counter.innerHTML = [
          `<span class="counter-unit">${String(days).padStart(2, '0')}:<small>дней</small></span>`,
          `<span class="counter-unit">${String(hours).padStart(2, '0')}:<small>часов</small></span>`,
          `<span class="counter-unit">${String(minutes).padStart(2, '0')}:<small>минут</small></span>`,
          `<span class="counter-unit">${String(seconds).padStart(2, '0')}<small>секунд</small></span>`
        ].join('');
      };

      updateCounter();
      window.setInterval(updateCounter, 1000);
    });
  };

  const setupCampPriceLinks = () => {
    document.addEventListener('click', (event) => {
      const link = event.target.closest('.want_link');
      const priceBlock = document.getElementById('box_price');
      if (!link || !priceBlock) return;

      event.preventDefault();
      event.stopPropagation();

      const headerHeight = document.querySelector('[data-jb-header]')?.getBoundingClientRect().height || 0;
      const top = priceBlock.getBoundingClientRect().top + window.scrollY - headerHeight - 20;
      window.scrollTo({ top, behavior: 'smooth' });
    }, true);
  };

  const setupFranchiseFeedbackModal = () => {
    const modal = document.querySelector('[data-jb-franchise-modal]');
    if (!modal) return;

    const openModal = () => {
      modal.hidden = false;
      document.body.classList.add('franchise-feedback-open');
      modal.querySelector('[data-jb-franchise-close]')?.focus({ preventScroll: true });
    };

    const closeModal = () => {
      modal.hidden = true;
      document.body.classList.remove('franchise-feedback-open');
    };

    document.addEventListener('click', (event) => {
      const trigger = event.target.closest('[data-jb-franchise-feedback]');
      const close = event.target.closest('[data-jb-franchise-close]');

      if (trigger) {
        event.preventDefault();
        openModal();
        return;
      }

      if (close) {
        event.preventDefault();
        closeModal();
      }
    });

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && !modal.hidden) {
        closeModal();
      }
    });
  };

  const setupFranchiseVideoModal = () => {
    const modal = document.querySelector('[data-jb-franchise-video-modal]');
    const player = modal?.querySelector('[data-jb-franchise-video-player]');
    if (!modal || !player) return;

    const openVideo = (src) => {
      if (!src) return;

      player.pause();
      player.src = src;
      player.currentTime = 0;
      modal.hidden = false;
      document.body.classList.add('franchise-video-open');
      player.focus({ preventScroll: true });
      player.play().catch(() => {});
    };

    const closeVideo = () => {
      player.pause();
      player.removeAttribute('src');
      player.load();
      modal.hidden = true;
      document.body.classList.remove('franchise-video-open');
    };

    document.addEventListener('click', (event) => {
      const trigger = event.target.closest('[data-jb-franchise-video]');
      const close = event.target.closest('[data-jb-franchise-video-close]');

      if (trigger) {
        event.preventDefault();
        openVideo(trigger.dataset.jbFranchiseVideo);
        return;
      }

      if (close) {
        event.preventDefault();
        closeVideo();
      }
    });

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && !modal.hidden) {
        closeVideo();
      }
    });
  };

  const setupFranchiseImageCarousel = () => {
    const viewport = document.querySelector('[data-jb-franchise-carousel]');
    if (!viewport) return;

    const scrollCarousel = (direction) => {
      const slide = viewport.querySelector('.franchise-image-carousel__slide');
      const track = viewport.querySelector('.franchise-image-carousel__track');
      const gap = track ? parseFloat(window.getComputedStyle(track).columnGap) || 0 : 0;
      const step = slide ? slide.getBoundingClientRect().width + gap : viewport.clientWidth * 0.8;
      viewport.scrollBy({ left: direction * step, behavior: 'smooth' });
    };

    document.querySelector('[data-jb-franchise-carousel-prev]')?.addEventListener('click', () => scrollCarousel(-1));
    document.querySelector('[data-jb-franchise-carousel-next]')?.addEventListener('click', () => scrollCarousel(1));
  };

  const setupFranchiseMerchCarousel = () => {
    const viewport = document.querySelector('[data-jb-merch-carousel]');
    if (!viewport) return;

    const scrollCarousel = (direction) => {
      const slide = viewport.querySelector('.franchise-merch-polaroid');
      const track = viewport.querySelector('.franchise-merch-carousel__track');
      const gap = track ? parseFloat(window.getComputedStyle(track).columnGap) || 0 : 0;
      const step = slide ? slide.getBoundingClientRect().width + gap : viewport.clientWidth * 0.8;
      viewport.scrollBy({ left: direction * step, behavior: 'smooth' });
    };

    document.querySelector('[data-jb-merch-prev]')?.addEventListener('click', () => scrollCarousel(-1));
    document.querySelector('[data-jb-merch-next]')?.addEventListener('click', () => scrollCarousel(1));
  };

  const setupRelatedPostsCarousel = () => {
    document.querySelectorAll('[data-jb-related-carousel]').forEach((carousel) => {
      const track = carousel.querySelector('[data-jb-related-track]');
      const prev = carousel.querySelector('[data-jb-related-prev]');
      const next = carousel.querySelector('[data-jb-related-next]');

      if (!track || !prev || !next) return;

      const scrollCarousel = (direction) => {
        const slide = track.querySelector('.jb-related-card');
        const gap = parseFloat(window.getComputedStyle(track).columnGap) || 0;
        const step = slide ? slide.getBoundingClientRect().width + gap : track.clientWidth;
        track.scrollBy({ left: direction * step, behavior: 'smooth' });
      };

      prev.addEventListener('click', () => scrollCarousel(-1));
      next.addEventListener('click', () => scrollCarousel(1));
    });
  };

  const setupAboutGallery = () => {
    const viewport = document.querySelector('[data-jb-about-gallery]');
    if (!viewport) return;

    const scrollGallery = (direction) => {
      const slide = viewport.querySelector('.jb-about-gallery__slide');
      const track = viewport.querySelector('.jb-about-gallery__track');
      const gap = track ? parseFloat(window.getComputedStyle(track).columnGap) || 0 : 0;
      const step = slide ? slide.getBoundingClientRect().width + gap : viewport.clientWidth;
      viewport.scrollBy({ left: direction * step, behavior: 'smooth' });
    };

    document.querySelector('[data-jb-about-gallery-prev]')?.addEventListener('click', () => scrollGallery(-1));
    document.querySelector('[data-jb-about-gallery-next]')?.addEventListener('click', () => scrollGallery(1));
  };

  const setupContactTabs = () => {
    document.querySelectorAll('[data-jb-contact-tabs]').forEach((tabs) => {
      const radios = tabs.querySelectorAll('.jb-contact-tabs__radio');
      const labels = tabs.querySelectorAll('.jb-contact-tabs__label');
      const panels = tabs.querySelectorAll('[data-jb-contact-panel]');

      const updateActiveCity = () => {
        const activeRadio = [...radios].find((radio) => radio.checked);
        if (!activeRadio) return;

        const activeSlug = activeRadio.id.replace('jb-contact-city-', '');

        labels.forEach((label) => {
          const isActive = label.getAttribute('for') === activeRadio.id;
          label.classList.toggle('is-active', isActive);
          label.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        panels.forEach((panel) => {
          panel.hidden = panel.dataset.jbContactPanel !== activeSlug;
        });
      };

      radios.forEach((radio) => radio.addEventListener('change', updateActiveCity));
      updateActiveCity();
    });
  };

  const setupContactAccordion = () => {
    document.querySelectorAll('[data-jb-contact-accordion]').forEach((accordion) => {
      accordion.querySelectorAll('details').forEach((details) => {
        details.addEventListener('toggle', () => {
          if (!details.open) return;

          accordion.querySelectorAll('details[open]').forEach((other) => {
            if (other !== details) {
              other.open = false;
            }
          });
        });
      });
    });
  };

  const setupContactGalleries = () => {
    document.querySelectorAll('[data-jb-contact-gallery]').forEach((gallery) => {
      const track = gallery.querySelector('[data-jb-contact-gallery-track]');
      const prev = gallery.querySelector('[data-jb-contact-gallery-prev]');
      const next = gallery.querySelector('[data-jb-contact-gallery-next]');
      if (!track) return;

      const scrollGallery = (direction) => {
        const slide = track.querySelector('.jb-contact-gallery__item');
        const gap = parseFloat(window.getComputedStyle(track).columnGap) || 0;
        const step = slide ? slide.getBoundingClientRect().width + gap : track.clientWidth;
        track.scrollBy({ left: direction * step, behavior: 'smooth' });
      };

      prev?.addEventListener('click', () => scrollGallery(-1));
      next?.addEventListener('click', () => scrollGallery(1));
    });
  };

  const setupStockPromoCarousel = () => {
    if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.owlCarousel) return;

    window.jQuery('[data-jb-stock-promos]').each(function () {
      const $carousel = window.jQuery(this);
      if ($carousel.hasClass('owl-loaded')) return;

      $carousel.owlCarousel({
        loop: true,
        center: true,
        items: 3,
        margin: 64,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5200,
        autoplayHoverPause: true,
        navText: ['‹', '›'],
        responsive: {
          0: {
            items: 1,
            center: false,
            margin: 20
          },
          760: {
            items: 2,
            center: false,
            margin: 32
          },
          1100: {
            items: 3,
            center: true,
            margin: 64
          }
        }
      });
    });
  };

  const setupPromoCountdowns = () => {
    document.querySelectorAll('[data-jb-countdown]').forEach((counter) => {
      const target = new Date(counter.dataset.jbCountdown).getTime();
      if (!target) return;

      const updateCounter = () => {
        const diff = Math.max(0, target - Date.now());
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

        counter.innerHTML = [
          `<span><b>${String(days).padStart(2, '0')}</b><small>дней</small></span>`,
          `<span><b>${String(hours).padStart(2, '0')}</b><small>часов</small></span>`,
          `<span><b>${String(minutes).padStart(2, '0')}</b><small>минут</small></span>`
        ].join('');
      };

      updateCounter();
      window.setInterval(updateCounter, 30000);
    });
  };

  const setupPromoVideoCarousel = () => {
    document.querySelectorAll('[data-jb-promo-video-carousel]').forEach((carousel) => {
      const track = carousel.querySelector('[data-jb-promo-video-track]');
      const next = carousel.querySelector('[data-jb-promo-video-next]');
      if (!track || !next) return;

      next.addEventListener('click', () => {
        const slide = track.querySelector('.jb-promo-video-card');
        const gap = parseFloat(window.getComputedStyle(track).columnGap) || 0;
        const step = slide ? slide.getBoundingClientRect().width + gap : track.clientWidth;
        track.scrollBy({ left: step, behavior: 'smooth' });
      });
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      setupStickyHeader();
      setupMegaMenu();
      setupCatalogLoadMore();
      setupAtmosphereCarousel();
      setupCampCountdown();
      setupCampPriceLinks();
      setupFranchiseFeedbackModal();
      setupFranchiseVideoModal();
      setupFranchiseImageCarousel();
      setupFranchiseMerchCarousel();
      setupRelatedPostsCarousel();
      setupAboutGallery();
      setupContactTabs();
      setupContactAccordion();
      setupContactGalleries();
      setupStockPromoCarousel();
      setupPromoCountdowns();
      setupPromoVideoCarousel();
    });
  } else {
    setupStickyHeader();
    setupMegaMenu();
    setupCatalogLoadMore();
    setupAtmosphereCarousel();
    setupCampCountdown();
    setupCampPriceLinks();
    setupFranchiseFeedbackModal();
    setupFranchiseVideoModal();
    setupFranchiseImageCarousel();
    setupFranchiseMerchCarousel();
    setupRelatedPostsCarousel();
    setupAboutGallery();
    setupContactTabs();
    setupContactAccordion();
    setupContactGalleries();
    setupStockPromoCarousel();
    setupPromoCountdowns();
    setupPromoVideoCarousel();
  }
})();
