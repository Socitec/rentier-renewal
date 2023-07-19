/**
* Template Name: renewal
* Author: Yuki Takaya
* description: Addition script when renewal 202307.
*/

window.addEventListener("DOMContentLoaded", function () {


  /**
   * Toppage property section slider
   */

  const newswiper = new Swiper('.js-swiper', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 20
      },

      1200: {
        slidesPerView: 2,
        spaceBetween: 20
      }
    },
    // ナビボタンが必要なら追加
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    }
  });



});
