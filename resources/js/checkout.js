console.log('Checkout JS Loaded');

// ======================
// 🔹 Helper Functions
// ======================

function parsePrice(elementSelector) {
    const el = document.querySelector(elementSelector);
    if (!el) return 0;
    const text = el.innerText.trim();
    if (!text || text.toLowerCase().includes('not') || !text.match(/\d/)) {
        return 0;
    }
    const clean = text.replace(/[^\d.]/g, '');
    return parseFloat(clean) || 0;
}

function updateElementText(selector, value) {
    const el = document.querySelector(selector);
    if (el) el.innerText = value;
}

function calculateFinalTotal(subtotal, shipping, discount) {
    return (subtotal + shipping - discount).toFixed(2);
}

// ======================
// 🔹 Shipping Functions
// ======================

async function updateShippingRate(cityId, shippingMethodId, csrf) {
    try {
        const response = await fetch(ShippingUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ 
                city: cityId, 
                shipping_method: shippingMethodId,
                subtotal: parsePrice("#sub-total"),
                discount: parsePrice("#coupon-discount")
            })
        });

        const data = await response.json();
        if (data.status === 'success') {
            const shippingCost = parseFloat(data.total_shipping) || 0;
            updateElementText("#shipping-cost", data.formatted.total_shipping);

            const subtotal = parsePrice("#sub-total");
            const discount = parsePrice("#coupon-discount");
            const total = calculateFinalTotal(subtotal, shippingCost, discount);
            updateElementText("#final-total", data.formatted.total);
        } else {
            console.warn("Failed to fetch shipping rate:", data.message);
        }
    } catch (error) {
        console.error("Error fetching shipping rate:", error);
    }
}

// ======================
// 🔹 Coupon Functions
// ======================

async function applyCoupon(code, csrf) {
    const couponMsg = document.querySelector(".coupon-msg");

    const subtotal = parsePrice("#sub-total");
    const shipping = parsePrice("#shipping-cost");

    try {
        const response = await fetch(CouponUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({
                coupon_code: code,
                total: subtotal,
                shipping: shipping
            })
        });

        const data = await response.json();

        if (data.status === 'success') {
            updateElementText("#coupon-discount", data.formatted.discount);
            updateElementText("#final-total", data.formatted.total);
            couponMsg.className = "coupon-msg success";
            couponMsg.innerHTML = data.message;
        } else {
            updateElementText("#coupon-discount", data.formatted.discount);
            updateElementText("#final-total", data.formatted.total);
            couponMsg.className = "coupon-msg error";
            couponMsg.innerHTML = data.message;
        }

    } catch (error) {
        console.error("Error applying coupon:", error);
    }
}

// ======================
// 🔹 Event Listeners
// ======================

document.addEventListener("DOMContentLoaded", () => {
    const checkoutForm = document.querySelector("#checkout-form");
    const couponBtn = document.querySelector(".checkout-coupon-btn");

    if (checkoutForm) {
        checkoutForm.addEventListener("change", () => {
            const cityId = document.querySelector("#city").value;
            const shippingMethodId = document.querySelector("#shipping_method").value;
            const csrf = document.querySelector('input[name="_token"]').value;
            if (cityId && shippingMethodId) updateShippingRate(cityId, shippingMethodId, csrf);
        });
    }

    if (couponBtn) {
        couponBtn.addEventListener("click", () => {
            const couponCode = document.getElementById("coupon_code").value.trim();
            const csrf = document.querySelector('input[name="_token"]').value;
            if (couponCode) {
                applyCoupon(couponCode, csrf);
            } else {
                const couponMsg = document.querySelector(".coupon-msg");
                if (couponMsg) {
                    couponMsg.className = "coupon-msg error";
                    couponMsg.innerHTML = "Please enter a coupon code.";
                }
            }
        });
    }
});
