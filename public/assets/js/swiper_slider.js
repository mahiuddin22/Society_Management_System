// Swiper Slider
const swiper = new Swiper(".swiper", {
  effect: "fade", //Add more effects like "slide", "cube", "coverflow", etc.
  loop: true, // Enable looping of slides
  fadeEffect: {
    crossFade: true, // optional, for smoother fade blending
  },
  speed: 2000, // ⏱ transition duration in milliseconds (default is 300)
  autoplay: {
    delay: 5000, // 🕒 time each slide stays before changing
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});