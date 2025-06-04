document.addEventListener("DOMContentLoaded", function () {
    // Mobile menu toggle
    const menuBtn = document.querySelector(".menu-btn");
    const nav = document.querySelector("nav");

    if (menuBtn && nav) {
        menuBtn.addEventListener("click", function () {
            nav.classList.toggle("show"); 
        });
    }

    // Slideshow logic
     const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");
    let current = 0;
    const duration = 5000; // normal duration
    const firstDelay = 2000; // shorter first delay (e.g. 2s)

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle("active", i === index);
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle("active", i === index);
        });
    }

    function nextSlide() {
        current = (current + 1) % slides.length;
        showSlide(current);
    }

    showSlide(current);

    // First delay is shorter
    setTimeout(() => {
        nextSlide();
        // Then continue at regular intervals
        setInterval(nextSlide, duration);
    }, firstDelay);
});