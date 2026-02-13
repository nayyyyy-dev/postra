import './bootstrap';

// AlpineJS (WAJIB untuk Breeze dropdown & hamburger)
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// jQuery
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

$(function () {
  // animasi ringan untuk alert
  const $alert = $('[data-alert]');
  if ($alert.length) {
    $alert.hide().fadeIn(250).delay(2500).fadeOut(350);
  }

  // efek hover card
  $('[data-card]').on('mouseenter', function () {
    $(this).addClass('scale-[1.01]');
  }).on('mouseleave', function () {
    $(this).removeClass('scale-[1.01]');
  });
});
