var cart = null;

function addToCart(element, id)
{
    var cartElement = element.cloneNode(true);
    cartElement.onclick = function(){ removeFromCart(cartElement, id) };
    
    cart.appendChild(cartElement);
}

function removeFromCart(element, id)
{
    cart.removeChild(element);
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
