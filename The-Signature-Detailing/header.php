<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo isset($pageTitle) ? $pageTitle : 'The Park Detailing'; ?></title>

	<link rel="stylesheet" href="style.css" />
	<link rel="shortcut icon" href="./Images/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
	<link rel="stylesheet" href="./css/cart.css">
	<link rel="stylesheet" href="./css/checkout-modal.css">
</head>

<body>
	<nav id="nav" data-aos="fade-down">
		<input type="checkbox" id="check" />
		<label for="check" class="checkbtn" aria-label="Open Menu">
			<i class="fas fa-bars"></i>
		</label>

		<a href="./index.php"><img class="logoo" data-aos="fade-down" src="./Images/logo.png" alt="The Signature Detailing Logo" /></a>

		<ul id="navLinks">

			<li><a href="index.php#home" id="nav-home">Home</a></li>
			<li><a href="index.php#our-services" id="nav-services">Services</a></li>
			<li><a href="index.php#our-work" id="nav-work">Our Work</a></li>
			<li><a href="index.php#footer" id="nav-contact">Contact</a></li>
			<li><a href="index.php#products" id="nav-products">Products</a></li>
			<li>
				<a href="#" id="cartIcon" aria-label="Cart" style="position:relative;">
					<i class="fas fa-shopping-cart"></i>
					<span id="cartCount">0</span>
				</a>
			</li>
			<li>
				<a href="#" class="lang" id="lang-en" data-lang="en">EN</a>
				<a href="#" class="lang" id="lang-ge" data-lang="ge">GE</a>
				<a href="#" class="lang" id="lang-ru" data-lang="ru">RU</a>
			</li>
		</ul>
	</nav>

	<!-- Cart Sidebar -->
	<div id="cartSidebar" class="cart-sidebar">
		<div class="cart-header">
			<span>Cart</span>
			<button id="closeCartBtn" aria-label="Close Cart">&times;</button>
		</div>
		<div class="cart-items" id="cartItems"></div>
		<div class="cart-footer">
			<div class="cart-total">Total: <span id="cartTotal">0</span> GEL</div>
			<button class="book-now" id="checkoutBtn">Checkout</button>
		</div>
	</div>

	<script src="./js/cart.js"></script>

	<!-- Checkout Modal Include -->
	<?php include_once __DIR__ . '/checkout-modal.php'; ?>

</body>