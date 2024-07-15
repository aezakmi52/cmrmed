//карусель

let currentIndex = 0;

function showSlide(index) {
    const slides = document.querySelectorAll('.carousel-item');
    const totalSlides = slides.length;

    if (index >= totalSlides) {
        currentIndex = 0;
    } else if (index < 0) {
        currentIndex = totalSlides - 1;
    } else {
        currentIndex = index;
    }

    const slideWidth = slides[currentIndex].clientWidth; 
    const offset = -currentIndex * slideWidth;
    document.querySelector('.carousel-images').style.transform = `translateX(${offset}px)`;
}

function nextSlide() {
    showSlide(currentIndex + 1);
}

setInterval(nextSlide, 5000); 

window.addEventListener('resize', () => showSlide(currentIndex)); 

showSlide(currentIndex);