let cart = [];

// Exibe ou oculta o modal do carrinho
function toggleCart() {
    const modal = document.getElementById('cart-modal');
    modal.classList.toggle('translate-x-full');
}

// Adiciona um produto ao carrinho
function addToCart(productId, name, price) {
    const product = cart.find(item => item.id === productId);
    if (product) {
        product.quantity += 1;
    } else {
        cart.push({ id: productId, name: name, price: price, quantity: 1 });
    }
    updateCart();
}

// Atualiza o carrinho e o modal
function updateCart() {
    const cartItems = document.getElementById('cart-items');
    const cartCount = document.getElementById('cart-count');
    const cartTotal = document.getElementById('cart-total');

    cartItems.innerHTML = '';
    let total = 0;

    cart.forEach(item => {
        total += item.price * item.quantity;
        cartItems.innerHTML += `
            <div class="flex justify-between items-center border-b pb-2">
                <div>
                    <h3 class="font-medium">${item.name}</h3>
                    <p class="text-sm text-gray-600">R$ ${item.price.toFixed(2).replace('.', ',')} x ${item.quantity}</p>
                </div>
                <button onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700">Remover</button>
            </div>
        `;
    });

    cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartTotal.textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
}

// Remove um item do carrinho
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCart();
}

// Finaliza o pedido
function finalizeOrder() {
    alert('Pedido finalizado!');
    cart = [];
    updateCart();
    toggleCart();
}
