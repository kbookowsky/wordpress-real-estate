/* eslint-disable no-undef */
function initProperty() {
  const thumbs = new Swiper('.property__slider__thumbs', {
    slidesPerView: 6,
    spaceBetween: 10,
    freeMode: true,
    watchSlidesProgress: true,
  });

  const slider = new Swiper('.property__slider', {
    slidesPerView: 1,
    centeredSlides: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    thumbs: {
      swiper: thumbs,
    },
  });

  const lightbox = GLightbox({
    selector: '.property__slider img',
  });

  // eslint-disable-next-line no-unused-vars
  lightbox.on('slide_before_change', ({ prev, current }) => {
    slider.slideTo(current.slideIndex);
  });
}

initProperty();
