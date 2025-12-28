// ======================
// 🔹 Helper Functions
// ======================

function getPrice(elementSelector) {
    const el = document.querySelector(elementSelector);
    if (!el) return 0;
    return parseFloat(el.getAttribute('data-value')) || 0;
}

function updateElementText(selector, value, rawValue = null) {
    const el = document.querySelector(selector);
    if (el) {
        el.innerText = value;
        if (rawValue !== null) {
            el.setAttribute('data-value', rawValue);
        }
    }
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
                city: parseInt(cityId),
                shipping_method: parseInt(shippingMethodId),
                subtotal: getPrice("#sub-total"),
                discount: getPrice("#coupon-discount")
            })
        });

        const data = await response.json();
        if (data.status === 'success') {
            const shippingCost = parseFloat(data.total_shipping) || 0;
            updateElementText("#shipping-cost", data.formatted.total_shipping, shippingCost);

            const subtotal = getPrice("#sub-total");
            const discount = getPrice("#coupon-discount");
            const total = subtotal + shippingCost - discount;

            updateElementText("#final-total", data.formatted.total, total);
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

    const subtotal = getPrice("#sub-total");
    const shipping = getPrice("#shipping-cost");

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
            updateElementText("#coupon-discount", data.formatted.discount, data.discount);

            // Recalculate total
            const total = subtotal + shipping - data.discount;
            updateElementText("#final-total", data.formatted.total, total);

            couponMsg.className = "coupon-msg text-success";
            couponMsg.innerHTML = data.message;
        } else {
            updateElementText("#coupon-discount", data.formatted.discount, 0);

            // Recalculate total (revert discount)
            const total = subtotal + shipping;
            updateElementText("#final-total", data.formatted.total, total);

            couponMsg.className = "coupon-msg text-danger";
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
        checkoutForm.addEventListener("change", (e) => {
            // Only trigger if city or shipping method changed
            if (e.target.id === 'city' || e.target.id === 'shipping_method') {
                const cityId = document.querySelector("#city").value;
                const shippingMethodId = document.querySelector("#shipping_method").value;
                const csrf = document.querySelector('input[name="_token"]').value;

                if (cityId && shippingMethodId) {
                    updateShippingRate(cityId, shippingMethodId, csrf);
                }
            }
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
                    couponMsg.className = "coupon-msg text-danger";
                    couponMsg.innerHTML = "Please enter a coupon code.";
                }
            }
        });
    }
});
