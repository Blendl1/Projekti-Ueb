let slideIndex = 0;
let slides = document.getElementsByClassName("slide-fade");
let slideTimer;

function initSlides() {
    if (slides.length === 0) return;
    showSlide(slideIndex);
    slideTimer = setInterval(nextSlide, 5000);
}

function showSlide(n) {
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[n].style.display = "block";
}

function nextSlide() {
    slideIndex++;
    if (slideIndex >= slides.length) slideIndex = 0;
    showSlide(slideIndex);
}

function changeSlide(n) {
    clearInterval(slideTimer);
    slideIndex += n;
    if (slideIndex >= slides.length) slideIndex = 0;
    if (slideIndex < 0) slideIndex = slides.length - 1;
    showSlide(slideIndex);
    slideTimer = setInterval(nextSlide, 5000);
}

document.addEventListener("DOMContentLoaded", initSlides);
