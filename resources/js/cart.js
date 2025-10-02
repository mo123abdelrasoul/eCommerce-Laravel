console.log('cart js loaded');

let cartBtn = document.querySelector("#proceed-to-checkout");
if(cartBtn) {
    cartBtn.addEventListener("click", function(e) {
        let valid = true;
        let data = [];
        document.querySelectorAll(".quantity-input").forEach((input) => {
            let quantity = input.value;
            if(quantity < 1) {
                valid = false;
            }
            let productId = input.dataset.productId;
            data.push({ product_id: productId, quantity: quantity});
        });
        if(!valid) {
            e.preventDefault();
            alert("Quantity must be at least 1");
            return;
        }
        fetch(updateCartQuantity, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ items: data})
        })
    });
}
