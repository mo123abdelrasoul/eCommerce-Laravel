document.addEventListener("DOMContentLoaded", function () {
    // Home Page Best Sellers Swiper
    new Swiper(".home-best-sellers-swiper", {
        slidesPerView: 3,
        spaceBetween: 20,
        navigation: {
            nextEl: ".home-swiper-next",
            prevEl: ".home-swiper-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 1
            },
            768: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            },
        },
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById('payment-select');
    if(select) {
        const logo = document.getElementById('payment-logo');
        const logos = JSON.parse(document.getElementById('payment-methods-json').textContent);
        select.addEventListener('change', function() {
            const key = this.value;
            if (logos[key]) {
                logo.src = logos[key];
            }
        });
    }
});



// document.addEventListener("DOMContentLoaded", function () {
//     const dropdown = document.querySelector(".dropdown");
//     const btn = dropdown.querySelector(".dropdown-btn");
//     const options = dropdown.querySelectorAll(".dropdown-options li");
//     console.log("test");
//     // فتح وقفل الـ dropdown
//     btn.addEventListener("click", function () {
//         dropdown.classList.toggle("show");
//     });

//     // اختيار عنصر من القائمة
//     options.forEach(option => {
//         option.addEventListener("click", function () {
//             btn.textContent = this.textContent; // غير النص
//             dropdown.classList.remove("show"); // اقفل القائمة
//         });
//     });

//     // اقفال القائمة لو ضغطت براها
//     document.addEventListener("click", function (e) {
//         if (!dropdown.contains(e.target)) {
//             dropdown.classList.remove("show");
//         }
//     });
// });

