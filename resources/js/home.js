document.addEventListener("DOMContentLoaded", function () {
    const bestSellersSwiper = document.querySelector(".home-best-sellers-swiper");
    if (!bestSellersSwiper) return;

    new Swiper(bestSellersSwiper, {
        slidesPerView: 3,
        spaceBetween: 20,
        navigation: {
            nextEl: ".home-swiper-next",
            prevEl: ".home-swiper-prev",
        },
        breakpoints: {
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById('payment-select');
    const logo = document.getElementById('payment-logo');
    const logosData = document.getElementById('payment-methods-json');

    if (!select || !logo || !logosData) return;

    const logos = JSON.parse(logosData.textContent);

    select.addEventListener('change', function() {
        const key = this.value;
        logo.src = logos[key] || '';
    });
});


