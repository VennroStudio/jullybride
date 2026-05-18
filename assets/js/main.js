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

  document.addEventListener('click', (event) => {
    const openMobile = event.target.closest('[data-jb-mobile-open]');
    const closeMobile = event.target.closest('[data-jb-mobile-close]');
    const mobileMenu = document.querySelector('[data-jb-mobile-menu]');

    if (openMobile) {
      show(mobileMenu);
    }

    if (closeMobile || event.target === mobileMenu) {
      hide(mobileMenu);
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
    if (!checkbox) return;

    const fieldName = checkbox.getAttribute('data-jb-filter-term');
    const form = checkbox.closest('form');
    const hidden = form ? form.querySelector(`input[type="hidden"][name="${fieldName}"]`) : null;
    if (!hidden || !form) return;

    const checked = Array.from(form.querySelectorAll(`[data-jb-filter-term="${fieldName}"]:checked`)).map((item) => item.value);
    hidden.value = checked.join(',');
  });

  const setupStickyHeader = () => {
    const header = document.querySelector('[data-jb-header]');
    if (!header) return;

    const updateHeader = () => {
      header.classList.toggle('is-compact', window.scrollY > 24);
    };

    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });
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

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      setupStickyHeader();
      setupMegaMenu();
      setupCatalogLoadMore();
      setupCampCountdown();
      setupCampPriceLinks();
    });
  } else {
    setupStickyHeader();
    setupMegaMenu();
    setupCatalogLoadMore();
    setupCampCountdown();
    setupCampPriceLinks();
  }
})();
