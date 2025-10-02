    console.log('Checkout Js Loaded');
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
                    if(data.status == 'success') {
                        let shipping_cost = document.querySelector(".order-shipping strong:nth-child(2)");
                        shipping_cost.innerHTML = `${data.message}`;
                    }
                }else {
                    console.log('failed');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });