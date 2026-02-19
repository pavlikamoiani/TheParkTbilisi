document.addEventListener('DOMContentLoaded', function () {
	const checkoutBtn = document.getElementById('checkoutBtn');
	let modal, closeModalBtn, modalCartItems, checkoutForm;

	function openModal() {
		if (!modal) modal = document.getElementById('checkoutModal');
		if (!closeModalBtn) closeModalBtn = document.getElementById('closeModalBtn');
		if (!modalCartItems) modalCartItems = document.getElementById('modalCartItems');
		if (!checkoutForm) checkoutForm = document.getElementById('checkoutForm');
		renderModalCart();
		modal.classList.add('open');
	}

	function closeModal() {
		modal.classList.remove('open');
	}

	function renderModalCart() {
		let cart = JSON.parse(localStorage.getItem('cart') || '[]');
		if (!cart.length) {
			modalCartItems.innerHTML = '<div style="color:#888;text-align:center;">კალათა ცარიელია</div>';
			return;
		}
		modalCartItems.innerHTML = cart.map(item => `
      <div class="modal-cart-item">
        <img src="${item.img}" alt="${item.title}" />
        <div style="flex:1;">
          <div style="font-weight:600;">${item.title}</div>
          <div style="font-size:13px;color:#555;">${item.price} GEL x ${item.qty}</div>
        </div>
      </div>
    `).join('');
	}

	if (checkoutBtn) {
		checkoutBtn.addEventListener('click', function (e) {
			e.preventDefault();
			openModal();
		});
	}

	document.addEventListener('click', function (e) {
		if (modal && modal.classList.contains('open')) {
			if (e.target === modal || (closeModalBtn && e.target === closeModalBtn)) {
				closeModal();
			}
		}
	});

	document.addEventListener('submit', function (e) {
		if (e.target && e.target.id === 'checkoutForm') {
			e.preventDefault();
			const form = e.target;
			const name = form.customerName.value.trim();
			const phone = form.customerPhone.value.trim();
			const address = form.customerAddress.value.trim();
			let cart = JSON.parse(localStorage.getItem('cart') || '[]');
			if (!name || !phone || !address || !cart.length) {
				alert('გთხოვთ შეავსოთ ყველა ველი და კალათა არ უნდა იყოს ცარიელი');
				return;
			}
			const submitBtn = form.querySelector('.modal-submit');
			if (submitBtn) submitBtn.disabled = true;
			fetch('../components/mail-send.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: new URLSearchParams({
					customerName: name,
					customerPhone: phone,
					customerAddress: address,
					cart: JSON.stringify(cart)
				})
			})
				.then(r => r.json())
				.then(data => {
					if (data.success) {
						alert('შეკვეთა წარმატებით გაიგზავნა!');
						closeModal();
						localStorage.removeItem('cart');
						window.updateCartCount && window.updateCartCount();
					} else {
						alert(data.msg || 'შეცდომა!');
					}
				})
				.catch(() => {
					alert('სერვერის შეცდომა!');
				})
				.finally(() => {
					if (submitBtn) submitBtn.disabled = false;
				});
		}
	});
});
