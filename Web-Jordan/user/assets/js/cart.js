// Ambil elemen tombol "Add to Cart"
const addToCartButtons = document.querySelectorAll('.add-to-cart');

// Tambahkan event listener untuk setiap tombol "Add to Cart"
addToCartButtons.forEach(button => {
  button.addEventListener('click', addToCart);
});

// Fungsi untuk menambahkan barang ke dalam keranjang
function addToCart(event) {
  // Ambil elemen produk yang diklik
  const product = event.target.closest('.product');

  // Ambil informasi produk
  const productName = product.querySelector('.product-name').textContent;
  const productPrice = product.querySelector('.product-price').textContent;

  // Buat elemen baru untuk ditambahkan ke dalam keranjang
  const cartItem = document.createElement('div');
  cartItem.classList.add('cart-item');
  cartItem.innerHTML = `
    <span class="cart-item-name">${productName}</span>
    <span class="cart-item-price">${productPrice}</span>
    <button class="remove-item">Remove</button>
  `;

  // Tambahkan elemen baru ke dalam keranjang
  const cartItems = document.querySelector('.cart-items');
  cartItems.appendChild(cartItem);

  // Hitung total harga
  updateTotal();
}

// Fungsi untuk menghapus barang dari keranjang
function removeItem(event) {
  const cartItem = event.target.closest('.cart-item');
  cartItem.remove();
  updateTotal();
}

// Fungsi untuk menghitung total harga
function updateTotal() {
  const cartItems = document.querySelectorAll('.cart-item');
  let total = 0;
  cartItems.forEach(item => {
    const price = parseFloat(item.querySelector('.cart-item-price').textContent.replace('Rp. ', ''));
    total += price;
  });
  const totalElement = document.querySelector('.cart-total');
  totalElement.textContent = 'Rp. ' + total;
}

// Ambil elemen tombol "Remove"
const removeButtons = document.querySelectorAll('.remove-item');

// Tambahkan event listener untuk setiap tombol "Remove"
removeButtons.forEach(button => {
  button.addEventListener('click', removeItem);
});
