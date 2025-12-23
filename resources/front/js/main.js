import { createPopper } from '@popperjs/core';
import 'bootstrap';

// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Cart Badge Update (Mockup or Hook)
    // If there's an event 'cart-updated', listen to it.
    window.addEventListener('cart-updated', (event) => {
        const count = event.detail.count;
        const badge = document.getElementById('cart-badge');
        if (badge) {
            badge.innerText = count;
            badge.classList.remove('hidden');
        }
    });

    // Price Range Slider
    const priceRange = document.getElementById('price-range');
    const priceValue = document.getElementById('price-value');
    if (priceRange && priceValue) {
        priceRange.addEventListener('input', (e) => {
            priceValue.innerText = e.target.value;
        });
        priceRange.addEventListener('change', (e) => {
            // Trigger filter update
            const form = document.getElementById('shop-filter-form');
            if (form) form.submit();
        });
    }
});
