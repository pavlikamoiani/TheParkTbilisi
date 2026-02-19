document.addEventListener('DOMContentLoaded', function () {
	const cartIcon = document.getElementById('cartIcon');
	const cartSidebar = document.getElementById('cartSidebar');
	const closeCartBtn = document.getElementById('closeCartBtn');
	const cartCount = document.getElementById('cartCount');
	const cartItems = document.getElementById('cartItems');
	const cartTotal = document.getElementById('cartTotal');

	cartIcon.addEventListener('click', function (e) {
		e.preventDefault();
		renderCart();
		cartSidebar.classList.add('open');
	});

	closeCartBtn.addEventListener('click', function () {
		cartSidebar.classList.remove('open');
	});

	document.addEventListener('click', function (e) {
		if (cartSidebar.classList.contains('open')) {
			if (!cartSidebar.contains(e.target) && !cartIcon.contains(e.target)) {
				cartSidebar.classList.remove('open');
			}
		}
	});

	function updateCartCount() {
		let cart = JSON.parse(localStorage.getItem('cart') || '[]');
		if (cart.length > 0) {
			cartCount.textContent = cart.reduce((sum, item) => sum + item.qty, 0);
			cartCount.style.display = '';
		} else {
			cartCount.textContent = '0';
			cartCount.style.display = 'none';
		}
	}

	function renderCart() {
		let cart = JSON.parse(localStorage.getItem('cart') || '[]');
		cartItems.innerHTML = '';
		let total = 0;
		if (cart.length === 0) {
			cartItems.innerHTML = '<p style="text-align:center;color:#888;">Cart is empty</p>';
		} else {
			cart.forEach(item => {
				total += item.price * item.qty;
				cartItems.innerHTML += `
					<div class="cart-item" style="display:flex;align-items:center;margin-bottom:18px;gap:12px;">
						<img src="${item.img}" alt="${item.title}" style="width:54px;height:54px;object-fit:cover;border-radius:6px;border:1px solid #eee;">
						<div style="flex:1;">
							<div style="font-weight:600;">${item.title}</div>
							<div style="font-size:14px;color:#555;">${item.price} GEL x ${item.qty}</div>
						</div>
						<button class="cart-remove-btn" data-id="${item.id}" style="background:none;border:none;color:#e74c3c;font-size:20px;cursor:pointer;">&times;</button>
					</div>
				`;
			});
		}
		cartTotal.textContent = total;
		cartItems.querySelectorAll('.cart-remove-btn').forEach(btn => {
			btn.addEventListener('click', function () {
				let id = btn.getAttribute('data-id');
				let cart = JSON.parse(localStorage.getItem('cart') || '[]');
				cart = cart.filter(item => item.id != id);
				localStorage.setItem('cart', JSON.stringify(cart));
				updateCartCount();
				renderCart();
			});
		});
	}


	document.querySelectorAll('.btn-add').forEach(function (btn) {
		btn.replaceWith(btn.cloneNode(true));
	});
	document.querySelectorAll('.btn-add').forEach(function (btn) {
		btn.addEventListener('click', function (e) {
			e.preventDefault();
			const id = btn.getAttribute('data-id');
			const title = btn.getAttribute('data-title');
			const price = parseInt(btn.getAttribute('data-price'));
			const img = btn.getAttribute('data-img');
			if (!id) return;
			let cart = JSON.parse(localStorage.getItem('cart') || '[]');
			let found = cart.find(item => item.id == id);
			if (found) {
				found.qty += 1;
			} else {
				cart.push({ id, title, price, img, qty: 1 });
			}
			localStorage.setItem('cart', JSON.stringify(cart));
			if (window.updateCartCount) window.updateCartCount();
		});
	});

	updateCartCount();
	window.updateCartCount = updateCartCount;
	window.renderCart = renderCart;
});
