$(document).ready(function() {

  $(function() {
    var header = $('.wrap-header'),
		scrollPrev = 100;

    $(window).scroll(function() {
      var scrolled = $(window).scrollTop();
    
      if ( scrolled > 100 && scrolled > scrollPrev ) {
        header.addClass('wrap-header--fixed');
        $("body").addClass("header-fixed");
      } else {
        header.removeClass('wrap-header--fixed');
        $("body").removeClass("header-fixed");
      }
      scrollPrev = scrolled;
    });
  });

  $('.main-slider').slick({
    dots: true,
    appendDots: $('.main-slider-dots'),
    arrows: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow: $('.main-slider-arrows__btn--prev'),
    nextArrow: $('.main-slider-arrows__btn--next'),
    mobileFirst: true,
  });

  $('.brands-slider').slick({
    dots: false,
    arrows: false,
    slidesToShow: 2,
    slidesToScroll: 1,
    mobileFirst: true,
        responsive: [
            {
              breakpoint: 601,
              settings: {
                slidesToShow: 3,
                arrows: true,
                infinite: false,
                prevArrow:'<button type="button" class="slick-prev"><i class="icon-arrow1"></i></button>',
                nextArrow:'<button type="button" class="slick-next"><i class="icon-arrow1"></i></button>',
              }
            },
            {
              breakpoint: 1025,
              settings: {
                slidesToShow: 5,
                arrows: true,
                infinite: false,
                prevArrow:'<button type="button" class="slick-prev"><i class="icon-arrow1"></i></button>',
                nextArrow:'<button type="button" class="slick-next"><i class="icon-arrow1"></i></button>',
              }
            },
          ]
  });

  $('.collapse-actions__btn-open').click(function() {
    $(this).parents('.text-block__content').find('.collapse-content--hidden').toggleClass('collapse-content--open').slideToggle(500);
    $(this).toggleClass('collapse-actions__btn-open--opened');
    $(this).text(function(i, text){
      return text === "Показать больше" ? "Скрыть" : "Показать больше";
    });
  });
  $('.actions__item--menu').click(function() {
    $(this).parents('.wrap-header').toggleClass('wrap-header--opened').find('.wrap-menu-mobile').slideToggle(500);
    $(this).toggleClass('actions__item--opened');
    $('body').toggleClass('modal-expanded');
    $('.overflow-bg, .header__logo, .header-func, .actions__item:not(.actions__item--menu), .close-btn, .mm-btn--close').click(function () { 
      $('.wrap-header').removeClass('wrap-header--opened');
      $('body').removeClass('modal-expanded');
      $('.wrap-menu-mobile').slideUp(500);
    });
  });
  $('.footer-menu-btn--menu').click(function() {
    $(this).parents('.wrap-footer').toggleClass('wrap-footer--opened').find('.footer-menu').slideToggle(500);
    $(this).toggleClass('footer-menu-btn--opened');
    $('body').toggleClass('modal-expanded');
    $('.overflow-bg, .close-btn, .mm-btn--close').click(function () { 
      $('.wrap-footer').removeClass('wrap-footer--opened');
      $('.footer-menu-btn').removeClass('footer-menu-btn--opened');
      $('body').removeClass('modal-expanded');
      $('.footer-menu').slideUp(500);
    });
  });
  $('.filter-btn').click(function() {
    $(this).parents('.wrap-filters').toggleClass('wrap-filters--opened').find('.w-filters').slideToggle(500);
    $(this).toggleClass('filter-btn--opened');
    $('body').toggleClass('modal-expanded');
    $('.overflow-bg, .header__logo, .header-func, .actions__item, .close-btn, .mm-btn--close').click(function () { 
      $('.wrap-filters').removeClass('wrap-filters--opened');
      $('body').removeClass('modal-expanded');
      $('.w-filters').slideUp(500);
    });
  });
  $('.filter-btn-second').click(function() {
    $(this).parents('.wrap-filters').toggleClass('wrap-filters--opened').find('.filters').slideToggle(500);
    $(this).toggleClass('filter-btn-second--opened');
    $('body').toggleClass('modal-expanded');
    $('.overflow-bg, .header__logo, .header-func, .actions__item, .close-btn, .mm-btn--close').click(function () { 
      $('.wrap-filters').removeClass('wrap-filters--opened');
      $('body').removeClass('modal-expanded');
      $('.filters').slideUp(500);
    });
  });
  $('.props-btn').click(function() {
    $(this).parents('.wrapper').toggleClass('wrapper--opened').find('.widget--props').fadeIn(300);
    $(this).toggleClass('props-btn--opened');
    $('body').toggleClass('modal-expanded');
    $('.overflow-bg, .header__logo, .header-func, .actions__item, .close-btn, .mm-btn--close').click(function () { 
      $('.wrapper').removeClass('wrapper--opened');
      $('body').removeClass('modal-expanded');
      $('.widget--props').fadeOut(300);
    });
  });

  $(function () {
    $(".hidden-info").hide();
    $(".faq-info").click(function ()
    {
      var sibling = $(this).next('.hidden-info');
      
       $(".hidden-info").each(function() {
          var answer = $(this);
          if (!answer.is(sibling)) {
              $(this).slideUp(300);
              $(this).parent().removeClass('is-open');
          }
       })
       $(this).siblings(".hidden-info").slideToggle(300).parent().toggleClass('is-open');
    });
});

  $(document).on("click", function(event){
    var $info = $(".faq-info");
    if($info !== event.target && !$info.has(event.target).length){
      $(".faq-actions__item").removeClass('is-open');
      $(".hidden-info").slideUp(500);
    }
  });

  jQuery(function(i) {
    var o, n;
    i(".q-a__title").on("click", function() {
      o = i(this).parents(".q-a__item"), n = o.find(".q-a__content"),
        o.hasClass("q-a__item--active") ? (o.removeClass("q-a__item--active"),
          n.slideUp()) : (o.addClass("q-a__item--active"), n.stop(!0, !0).slideDown(),
          o.siblings(".q-a__item--active").removeClass("q-a__item--active").children(
            ".q-a__content").stop(!0, !0).slideUp())
    })
  });

  if ($(window).width() <= 1300) {
    new Mmenu( "#catalog-menu", {
      "pageScroll": true,
      extensions: [
        'pagedim-black',
        'position-front'
      ],
      "offCanvas": {
        "position": "bottom"
      },
      navbar: {
      title: 'Каталог'
      },
      "navbars": [{
        content : ["prev","title", "close"]
      }],
      classNames: {
        selected: 'active'
      },
    });
  } else {
    $('.header__catalog-btn').click(function() {
      $(this).parents('.wrapper').toggleClass('wrapper--opened').find('.wrap-catalog-menu').slideToggle(500);
      $(this).toggleClass('header__catalog-btn--opened');
      $('body').toggleClass('modal-expanded');
      $('.overflow-bg, .close-btn, .mm-btn--close').click(function () { 
        $('.wrapper').removeClass('wrapper--opened');
        $('body').removeClass('modal-expanded');
        $('.wrap-catalog-menu').slideUp(500);
      });
    });
    $(document).on('keydown', function(e) {
      if (e.keyCode == 27)
        $('.wrapper').removeClass('wrapper--opened').find('.wrap-catalog-menu').slideUp(500);
        $('body').removeClass('modal-expanded');
    });
  }

  $('[data-fancybox]').fancybox({
    touch: false,
    backFocus : true,
    afterLoad: function(){
      $('.custom-scroll').jScrollPane('setPosition');
    },
  });

  $(function()
  {
    $('.custom-scroll').jScrollPane({
      contentWidth: '0px',
      verticalDragMaxHeight: 200,
      autoReinitialise: true,
    });
  });

  $( function() {
    $("#slider-range").slider({
      min: 0,
      max: 500000,
      step: 1,
      values: [0, 500000],
      slide: function(event, ui) {
          for (var i = 0; i < ui.values.length; ++i) {
              $("input.slider-value[data-index=" + i + "]").val(ui.values[i]);
          }
      }
    });
    $("input.slider-value").change(function() {
      var $this = $(this);
      $("#slider-range").slider("values", $this.data("index"), $this.val());
    });
  });
  $( function() {
    $("#slider-range-mass").slider({
      min: 0,
      max: 1000,
      step: 1,
      values: [0, 500000],
      slide: function(event, ui) {
          for (var i = 0; i < ui.values.length; ++i) {
              $("input.slider-value[data-index=" + i + "]").val(ui.values[i]);
          }
      }
    });
    $("input.slider-value").change(function() {
      var $this = $(this);
      $("#slider-range-mass").slider("values", $this.data("index"), $this.val());
    });
  });

  $( function() {
    $( ".filters > .filters__item" ).accordion({
      collapsible: true,
      heightStyle: "content",
      header: ".filters__title",
      active: false
    });
  } );
  $( function() {
    $( ".filters > .filters__item--prices" ).accordion({
      collapsible: true,
      heightStyle: "content",
      header: ".filters__title",
      active: 0
    });
  } );

  $('.goods-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    asNavFor: '.thumbs-slider',
    dots: false,
    prevArrow:"<button type='button' class='slick-prev'><i class='icon-arrow1'></i></button>",
    nextArrow:"<button type='button' class='slick-next'><i class='icon-arrow1'></i></button>",
    mobileFirst: true,
});
$('.thumbs-slider').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    vertical:true,
    asNavFor: '.goods-slider',
    dots: false,
    prevArrow:"<button type='button' class='slick-prev'><i class='icon-arrow1'></i></button>",
    nextArrow:"<button type='button' class='slick-next'><i class='icon-arrow1'></i></button>",
    focusOnSelect: true,
    verticalSwiping:true,
    mobileFirst: true,
    responsive: [
    {
      breakpoint: 0,
        settings: 'unslick'
    },
    {
        breakpoint: 1025,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
          vertical:true,
          asNavFor: '.goods-slider',
          dots: false,
          prevArrow:"<button type='button' class='slick-prev'><i class='icon-arrow1'></i></button>",
          nextArrow:"<button type='button' class='slick-next'><i class='icon-arrow1'></i></button>",
          focusOnSelect: true,
          verticalSwiping:true,
        }
    },
    ]
});

$('.compare-list').slick({
  dots: false,
  arrows: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  infinite: false,
  prevArrow:'<button type="button" class="slick-prev"><i class="icon-arrow1"></i></button>',
  nextArrow:'<button type="button" class="slick-next"><i class="icon-arrow1"></i></button>',
  mobileFirst: true,
  responsive: [
    {
      breakpoint: 601,
      settings: {
        slidesToShow: 2,
        arrows: true,
        infinite: false,
        prevArrow:'<button type="button" class="slick-prev"><i class="icon-arrow1"></i></button>',
        nextArrow:'<button type="button" class="slick-next"><i class="icon-arrow1"></i></button>',
      }
    },
    {
      breakpoint: 1025,
      settings: {
        slidesToShow: 4,
        arrows: true,
        infinite: false,
        prevArrow:'<button type="button" class="slick-prev"><i class="icon-arrow1"></i></button>',
        nextArrow:'<button type="button" class="slick-next"><i class="icon-arrow1"></i></button>',
      }
    },
  ]
});
$('.tabs-menu__link').on('click', function (e) {
  $(".compare-list").slick('reinit');
  });

$( function() {
  $( ".tabs" ).tabs({
    afterLoad: function(){
      $('.compare-list').slick('setPosition', 0);
    },
  });
  $('.good-actions__btn-all').click(function () {             
    $('.tabs').tabs("option", "active", $(this).data("tab-index"));
  });
} );

  $( function() {
    $(".good-info a[href*='#']").on("click", function(e){
      var anchor = $(this);
      $('html, body').stop().animate({
        scrollTop: $(anchor.attr('href')).offset().top - 200
      }, 777);
    });
  });

$( ".msg-city__btn, .wrap-msg-city" ).click(function() {
  $( ".wrap-msg-city" ).fadeOut(300);
});

if($(window).width() > 1024){
$('.w-page-product, .good-info').theiaStickySidebar({
  // Settings
  additionalMarginTop: 90,
  additionalMarginBottom: 60,
});
}

$('.filter-category__btn-more').click(function() {
  $(this).parents('.wrap-category-list').toggleClass('is-open');
  $(this).toggleClass('filter-category__btn-more--opened');
  $(this).text(function(i, text){
    return text === "Показать все" ? "Скрыть" : "Показать все";
  });
});

$('.basket-sum__btn--open-all').click(function() {
  $(this).parents('.right-sidebar').toggleClass('is-open').find('.widget--order, .widget--basket .basket-sum').slideToggle(500);
  // $(this).toggleClass('header__catalog-btn--opened');
  // $('body').toggleClass('modal-expanded');
  // $('.overflow-bg, .close-btn, .mm-btn--close').click(function () { 
  //   $('.wrapper').removeClass('wrapper--opened');
  //   $('body').removeClass('modal-expanded');
  //   $('.wrap-catalog-menu').slideUp(500);
  // });
});

});