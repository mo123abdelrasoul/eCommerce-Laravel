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

let addCartBtn = document.querySelectorAll(".add-cart-btn");
addCartBtn.forEach((btn) => {
    btn.addEventListener("click", function() {
        let productId = this.dataset.productId;
        let csrf = document.querySelector('input[name="_token"]').value;
        fetch(addToCartUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            credentials: 'include',
            body: JSON.stringify({ product_id: productId, quantity: 1})
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success'){
                let cartCount = document.querySelector(".cart-count");
                if(cartCount) {
                    cartCount.textContent = data.cartCount;
                }
                openCart();
                let cartContent = document.querySelector('#cartSidebar .cart-content');
                cartContent.innerHTML = '';
                let cartTotal = 0;
                data.products.forEach(product => {
                    let itemDiv = document.createElement('div');
                    itemDiv.classList.add('cart-item');
                    itemDiv.innerHTML = `
                        <img src="storage/${product.image}" alt="${product.name}">
                        <div class="cart-item-details">
                            <h4 class="cart-item-title">${product.name}</h4>
                            <p class="cart-item-qty">Quantity: ${data.cart[product.id]}</p>
                            <p class="cart-item-price">$${product.price}</p>
                        </div>
                    `;
                    cartContent.appendChild(itemDiv);
                    cartTotal += product.price * data.cart[product.id];
                });
                let cartTotalDiv = document.getElementById('cartTotalPrice');
                cartTotalDiv.textContent = `${cartTotal}`;
            }
        })
    });
});

function openCart() {
    document.getElementById('cartSidebar').classList.add('active');
    document.getElementById('cartOverlay').classList.add('active');
}

function closeCart() {
    document.getElementById('cartSidebar').classList.remove('active');
    document.getElementById('cartOverlay').classList.remove('active');
}
window.openCart = openCart;
window.closeCart = closeCart;


let removeCartBtn = document.querySelectorAll(".remove-cart-item");
removeCartBtn.forEach(btn => {
    btn.addEventListener("click", function() {
        let productId = this.dataset.productId;
        let csrf = document.querySelector('input[name="_token"]').value;
        fetch(removeCartUrl + '/' + productId, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf 
            },
            body: JSON.stringify({product_id: productId})
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success'){
                let row = this.closest("tr");
                if(row) {
                    row.remove();
                }
                let cartCount = document.querySelector(".cart-count");
                if(cartCount) {
                    cartCount.textContent = data.cartCount;
                }
                let cartTotal = document.querySelector(".cartTotal h3");
                if(cartTotal && data.cartTotal !== undefined) {
                    cartTotal.textContent = `Grand Total: ${data.cartTotal.toFixed(2)}`;
                }
                let tbody = document.querySelector("table tbody");
                if(tbody && tbody.children.length === 0) {
                    const container = document.querySelector('.cart-container');
                    container.innerHTML = `
                        <p>Your cart is empty.</p>  
                        <a href="/" class="btn btn-primary">Continue Shopping</a>
                    `;
                }
            }
        })
    });
});