var cart = null;

function addToCart(element, id)
{
    var cartElement = element.cloneNode(true);
    cartElement.onclick = function(){ removeFromCart(cartElement, id) };

    ajax("/admin/create/add_to_cart/" + id,
         function(response) {
             if (response === "true")
                 cart.appendChild(cartElement);
         },
         function() {} );
}

function removeFromCart(element, id)
{
    ajax("/admin/create/remove_from_cart/" + id,
         function(response) {
             if (response === "true")
                 cart.removeChild(element);
         },
         function() {} );
}

function submitForm()
{
    console.log("submitForm()");
    location.href = "#n"; // close pop-up
}

function cancelForm()
{
    console.log("cancelForm()");
    location.href = "#n"; // close pop-up
}

function init()
{
    cart = document.getElementById("cart");
}
