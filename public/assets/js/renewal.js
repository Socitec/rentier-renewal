/**
* Template Name: renewal
* Author: Yuki Takaya
* description: Addition script when renewal 202307.
*/



window.addEventListener("DOMContentLoaded", function () {


  //Top page-mainvisual-slider 
  const topslider = new Swiper('.swiper', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
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


  /**
   * Toppage property section slider
   */

  const newswiper = new Swiper('.swiper', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 3,
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

  
  /**
   * Toppage property section slider
   */

  const detail_page_swiper = new Swiper('.detail_swiper', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: "auto",
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    },
    // ナビボタンが必要なら追加
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    }
  });

  //スパム対策-メール表示
  function setEmail() {
    var name = '&#' + (90+9) + ';&#111;&#' + (55*2) + ';&#116;&#97;&#' + (100-1) + ';&#116;'; // アカウント名
    var domain = '&#' + (100+2+10) + ';&#101;&#97;&#' + (111+4) + ';&#99;&#111;&#' + (50*2) + ';&#101;&#46;&#99;&#111;&#109;'; // ドメイン名
    document.write(name);
    document.write('&#' + (60+4) + ';'); // @マーク
    document.write(domain);
  }

});
