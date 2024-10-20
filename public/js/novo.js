function changeColor(colorImage, colorName) {
    document.getElementById("colorImage").src = colorImage;
    document.getElementById("selectedColor").value = colorName;
}

var quantity = document.getElementById('quantity').value; // Initial quantity value

document.getElementById('increment').addEventListener('click', function() {
    quantity++;
    updateQuantity();
});

document.getElementById('decrement').addEventListener('click', function() {
    if (quantity > 1) {
        quantity--;
        updateQuantity();
    }
});

function updateQuantity() {
    document.getElementById('quantity').value = quantity;
}