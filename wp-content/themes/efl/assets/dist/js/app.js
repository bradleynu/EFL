(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

(function ($) {

  $.cookie.json = true;

  var App = (function () {
    function App() {
      _classCallCheck(this, App);

      this.initMegaMenuCarousel();
      this.initProductCarousels();
      this.initSliderCarousel();
      this.initProductDetailCarousel();
      this.setOwlThumbnails();
      this.openModal();
      this.applyZoomImages();
      this.bindEvents();

      $('.product-archive .col-sm-3').matchHeight({
        byRow: true
      });

      $('#header nav.menu a[href="#"], .woocommerce .woocommerce-main-image').on('click', function (e) {
        e.preventDefault();
      });

      $( "li.menu-item .sub-menu li.menu-item" ).hover(function() {  // mouse enter
      console.log("mouse enter");  // mouse enter
          $( this ).find( " > .sub-menu" ).show(); // display immediate child

      }, function(){ // mouse leave
          if ( !$(this).hasClass("current_page_item") ) {  // check if current page
              $( this ).find( ".sub-menu" ).hide(); // hide if not current page
          }
      });

      $('.owl-carousel.catemobile').owlCarousel({
          loop:false,
          margin:10,
          nav:true,
          dots: false,
          items:1,
          navText : ["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"]
      });
      $('.owl-carousel.cate').owlCarousel({
          loop:false,
          margin:10,
          nav:true,
          dots: false,
          items:1,
          navText : ["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"]
      });

      $(window).on("scroll", function () {
        if ($(window).width() > 480) {
          if ($(this).scrollTop() > 25) {
              $("nav").addClass("scroll-down-menu");
          }
          else {
              $("nav").removeClass("scroll-down-menu");
          }
        }else {
          if ($(this).scrollTop() > 25) {
              $("nav").addClass("scroll-down-menu-white");
          }
          else {
              $("nav").removeClass("scroll-down-menu-white");
          }
        }
      });
      $(document).ready(function () {
          $(window).on("resize", function (e) {
              checkScreenSize();
          });

          checkScreenSize();

          function checkScreenSize(){
              var newWindowWidth = $(window).width();
              if (newWindowWidth < 481) {
                  jQuery( "#menu-menu-1-primary" ).append( "<span class='close-js-ham'>X</p>" );
                  jQuery( "#menu-menu-1-primary-english" ).append( "<span class='close-js-ham'>X</p>" );
              }
          }
      });



      $('.mobile-ham').on("click", function (e) {
         e.preventDefault();
          if ($('#menu-menu-1-primary').hasClass('open-menu')) {
            
             $('#menu-menu-1-primary').removeClass('open-menu');
          }
          else {
              $('#menu-menu-1-primary').addClass('open-menu');
          }
          if ($('#menu-menu-1-primary-english').hasClass('open-menu')) {
             $('#menu-menu-1-primary-english').removeClass('open-menu');
          }
          else {
              $('#menu-menu-1-primary-english').addClass('open-menu');
          }
      });

      $('body').on('click', 'span.close-js-ham', function(e) {
        e.preventDefault();
          if ($('#menu-menu-1-primary').hasClass('open-menu')) {
            $('#menu-menu-1-primary').removeClass('open-menu');
          }
          if ($('#menu-menu-1-primary-english').hasClass('open-menu')) {
            $('#menu-menu-1-primary-english').removeClass('open-menu');
          }
      });


 
    }

    App.prototype.applyZoomImages = function applyZoomImages() {
      // $('.easyzoom').easyZoom();
    };

    App.prototype.openModal = function openModal() {
      $('#cuponModal').modal('show');
    };

    App.prototype.setOwlThumbnails = function setOwlThumbnails() {
      $('.owl-thumbnails').each(function (i, e) {
        var $carousel = $(e);
        $('.owl-item', $carousel).each(function (i, e) {
          var src = $('img', e).attr('src');
          var $dot = $($('.owl-dot', $carousel)[i]);
          var $span = $('span', $dot);
          $span.css({ 'background-image': 'url(' + src + ')' });
        });
      });
    };

    App.prototype.initSliderCarousel = function initSliderCarousel() {
      $('.slider.slider-carousel').owlCarousel({
        items: 1,
        nav: false,
        dots: true
      });
    };

    App.prototype.initProductDetailCarousel = function initProductDetailCarousel() {
      $('.product-detail-carousel').owlCarousel({
        items: 1,
        nav: true,
        rewind: false,
        dots: true,
        navText: ["<span class='fa fa-chevron-left'><span>", "<span class='fa fa-chevron-right'><span>"]
      });
    };

    App.prototype.initMegaMenuCarousel = function initMegaMenuCarousel() {
      $('.mega-menu .carousel').owlCarousel({
        items: 7,
        nav: true,
        rewind: false,
        dots: false,
        navText: ["<span class='fa fa-chevron-left'><span>", "<span class='fa fa-chevron-right'><span>"],
        responsive: {
          0: {
            items: 1
          },
          768: {
            items: 5
          },
          1199: {
            items: 7
          }
        }
      });
    };

    App.prototype.initProductCarousels = function initProductCarousels() {
      $('.products .frame').each(function (i, e) {
        $(e).sly({
          horizontal: 1,
          itemNav: 'basic',
          smart: 1,
          mouseDragging: 1,
          touchDragging: 1,
          releaseSwing: 1,
          scrollBar: $('.scrollbar', $(e)),
          scrollBy: 1,
          speed: 300,
          elasticBounds: 1,
          dragHandle: 1,
          dynamicHandle: 1,
          prevPage: $('.prevPage', $(e)),
          nextPage: $('.nextPage', $(e))
        });
      });
    };

    App.prototype.bindEvents = function bindEvents() {
      $('.back-top').on('click', this.backToTop);

      $('#cuponModal').on('hide.bs.modal', function () {
        $.cookie('hide-coupon-modal', 1, { expires: 7, path: '/' });
      });

      $('.js-count-product-view').each(function () {
        var products = [];

        if ($.cookie('lanco_viewed_products')) {
          products = $.cookie('lanco_viewed_products');
        }

        if (products.indexOf($(this).data('product')) === -1) {
          products.push($(this).data('product'));
          $.cookie('lanco_viewed_products', products, { expires: 365, path: '/' });
        }
      });
    };

    App.prototype.backToTop = function backToTop() {
      $('html, body').animate({
        'scrollTop': 0
      }, 1000);

      return false;
    };

    return App;
  })();

  $(function () {
    return new App();
  });
})(window.jQuery);

},{}]},{},[1]);

