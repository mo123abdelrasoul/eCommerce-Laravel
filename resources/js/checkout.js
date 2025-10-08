console.log('Checkout Js Loaded');
let checkoutForm = document.querySelector("#checkout-form");
if(checkoutForm){
    document.querySelector("#checkout-form").addEventListener("change",function(){
        let cityId = document.querySelector("#city").value;
        let shippingMethodId = document.querySelector("#shipping_method").value;
        if(cityId && shippingMethodId){
            let csrf = document.querySelector('input[name="_token"]').value;
            fetch(ShippingUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({
                    city: cityId,
                    shipping_method: shippingMethodId
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.status == 'success') {
                    let shipping_cost = document.querySelector("#shipping-cost");
                    shipping_cost.innerHTML = `${data.shipping_rate}`;
                }else {
                    console.log('failed');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
}

let couponBtn = document.querySelector(".checkout-coupon-btn");
if(couponBtn){
    couponBtn.addEventListener("click", function() {
        let couponCode = document.getElementById("coupon_code").value;
        let couponMsg = document.querySelector(".coupon-msg");
        if(couponCode) {
            let totalText = document.querySelector(".checkout-order-total strong:nth-child(2)").innerText;
            let total = parseFloat(totalText.replace(/[^\d.]/g, ''));
            let csrf = document.querySelector('input[name="_token"]').value;
            fetch(CouponUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({
                    coupon_code: couponCode,
                    total: total
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    if(couponMsg) {
                        couponMsg.classList.remove("error");
                        couponMsg.classList.add("success");
                        let couponNumber = document.querySelector(".checkout-order-coupon strong:nth-child(2)");
                        if(couponNumber) {
                            couponNumber.innerText = '$' + data.discount.toFixed(2);
                        }
                        couponMsg.innerHTML = data.message;
                    }
                }else {
                    if(couponMsg) {
                        couponMsg.classList.remove("success");
                        couponMsg.classList.add("error");
                        couponMsg.innerHTML = data.message;
                    }
                }
            })
        }else {
            if(couponMsg) {
                couponMsg.classList.remove("success");
                couponMsg.classList.add("error");
                couponMsg.innerHTML = 'No coupon added';
            }
        }
    });
}