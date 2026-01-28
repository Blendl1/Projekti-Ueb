let slideIndex = 1;
let slideTimer; 

showSlides(slideIndex);
startAutoSlide(); 


function changeSlide(n) {
    showSlides(slideIndex += n);
    
    
    clearInterval(slideTimer); 
    startAutoSlide();
}

function showSlides(n) {
    let slides = document.getElementsByClassName("slide-fade");
    if (slides.length === 0) return;

    if (n > slides.length) { slideIndex = 1; }
    if (n < 1) { slideIndex = slides.length; }

    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slides[slideIndex - 1].style.display = "block";
}

function startAutoSlide() {
    slideTimer = setInterval(() => {
        changeSlide(1);
    }, 5000); 
}