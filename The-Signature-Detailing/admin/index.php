<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit;
}
require_once __DIR__ . '/../db/db.php';
$tab = $_GET['tab'] ?? 'products';

if ($tab === 'categories') {
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
		$name = $_POST['category_name'];
		$desc = $_POST['category_description'];
		$target_dir = dirname(__DIR__) . "/categories/";
		if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
		$file_ext = pathinfo($_FILES["category_image"]["name"], PATHINFO_EXTENSION);
		$file_name = time() . "_" . uniqid() . "." . $file_ext;
		$target_file = $target_dir . $file_name;
		if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file)) {
			$stmt = $conn->prepare("INSERT INTO categories (name, description, image) VALUES (?, ?, ?)");
			$stmt->bind_param("sss", $name, $desc, $file_name);
			$stmt->execute();
			header("Location: ?tab=categories");
			exit;
		}
	}
	if (isset($_GET['delete_category'])) {
		$id = (int)$_GET['delete_category'];
		$stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		header("Location: ?tab=categories");
		exit;
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_category'])) {
		$id = (int)$_POST['category_id'];
		$name = $_POST['category_name'];
		$desc = $_POST['category_description'];
		if (!empty($_FILES['category_image']['name'])) {
			$target_dir = dirname(__DIR__) . "/categories/";
			$file_ext = pathinfo($_FILES["category_image"]["name"], PATHINFO_EXTENSION);
			$file_name = time() . "_" . uniqid() . "." . $file_ext;
			$target_file = $target_dir . $file_name;
			move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file);
			$stmt = $conn->prepare("UPDATE categories SET name=?, description=?, image=? WHERE id=?");
			$stmt->bind_param("sssi", $name, $desc, $file_name, $id);
		} else {
			$stmt = $conn->prepare("UPDATE categories SET name=?, description=? WHERE id=?");
			$stmt->bind_param("ssi", $name, $desc, $id);
		}
		$stmt->execute();
		header("Location: ?tab=categories");
		exit;
	}
}
if ($tab === 'products') {
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']) && !isset($_POST['add_category'])) {
		$title = $_POST['title'];
		$desc = $_POST['description'];
		$price = $_POST['price'];
		$category_id = $_POST['category_id'];
		$target_dir = dirname(__DIR__) . "/products/";
		if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
		$file_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
		$file_name = time() . "_" . uniqid() . "." . $file_ext;
		$target_file = $target_dir . $file_name;
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
			$stmt = $conn->prepare("INSERT INTO products (title, description, price, image, category_id) VALUES (?, ?, ?, ?, ?)");
			$stmt->bind_param("ssdsi", $title, $desc, $price, $file_name, $category_id);
			$stmt->execute();
			header("Location: ?tab=products");
			exit;
		}
	}
	if (isset($_GET['delete_product'])) {
		$id = (int)$_GET['delete_product'];
		$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		header("Location: ?tab=products");
		exit;
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_product'])) {
		$id = (int)$_POST['product_id'];
		$title = $_POST['title'];
		$desc = $_POST['description'];
		$price = $_POST['price'];
		$category_id = $_POST['category_id'];
		if (!empty($_FILES['image']['name'])) {
			$target_dir = dirname(__DIR__) . "/products/";
			$file_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
			$file_name = time() . "_" . uniqid() . "." . $file_ext;
			$target_file = $target_dir . $file_name;
			move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
			$stmt = $conn->prepare("UPDATE products SET title=?, description=?, price=?, image=?, category_id=? WHERE id=?");
			$stmt->bind_param("ssdsii", $title, $desc, $price, $file_name, $category_id, $id);
		} else {
			$stmt = $conn->prepare("UPDATE products SET title=?, description=?, price=?, category_id=? WHERE id=?");
			$stmt->bind_param("ssdii", $title, $desc, $price, $category_id, $id);
		}
		$stmt->execute();
		header("Location: ?tab=products");
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<title>Admin</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
	<style>
		:root {
			--bg: #050505;
			--sidebar: #0d0d0d;
			--card: #121212;
			--accent: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
			--text: #fff;
			--text-dim: #94a3b8;
			--border: 1px solid rgba(255, 255, 255, 0.08);
		}

		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: 'Plus Jakarta Sans', sans-serif;
		}

		body {
			background: var(--bg);
			color: var(--text);
			display: flex;
			min-height: 100vh;
		}

		.sidebar {
			width: 260px;
			background: var(--sidebar);
			padding: 40px 20px;
			border-right: var(--border);
		}

		.sidebar-brand {
			font-size: 20px;
			font-weight: 700;
			margin-bottom: 40px;
			background: var(--accent);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			text-align: center;
		}

		.menu {
			display: flex;
			flex-direction: column;
			gap: 10px;
		}

		.menu a {
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 14px 18px;
			text-decoration: none;
			color: #fff;
			background: var(--accent);
			border-radius: 12px;
		}

		.menu a.active {
			background: #4f46e5;
		}

		.main {
			flex: 1;
			padding: 40px;
		}

		.header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 30px;
		}

		.btn-add {
			padding: 12px 24px;
			background: var(--accent);
			border: none;
			color: #fff;
			border-radius: 10px;
			cursor: pointer;
			font-weight: 600;
		}

		.table-container {
			background: var(--card);
			border: var(--border);
			border-radius: 20px;
			overflow: hidden;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		th {
			padding: 18px 24px;
			background: rgba(255, 255, 255, 0.03);
			color: var(--text-dim);
			font-size: 13px;
			text-align: left;
			text-transform: uppercase;
		}

		td {
			padding: 18px 24px;
			border-top: var(--border);
			color: #e2e8f0;
		}

		.prod-img {
			width: 45px;
			height: 45px;
			border-radius: 8px;
			object-fit: cover;
		}

		.modal {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.85);
			backdrop-filter: blur(5px);
			justify-content: center;
			align-items: center;
			z-index: 100;
		}

		.modal-content {
			background: var(--card);
			border: var(--border);
			width: 450px;
			padding: 40px;
			border-radius: 24px;
		}

		.form-group {
			margin-bottom: 15px;
		}

		.form-group label {
			display: block;
			margin-bottom: 8px;
			color: var(--text-dim);
			font-size: 14px;
		}

		.form-group input,
		.form-group textarea,
		.form-group select {
			width: 100%;
			padding: 12px;
			background: #1a1a1a;
			border: var(--border);
			border-radius: 8px;
			color: #fff;
			outline: none;
		}

		.modal-btns {
			margin-top: 25px;
			display: flex;
			gap: 10px;
		}

		.btn-cancel {
			flex: 1;
			padding: 12px;
			background: #222;
			border: none;
			color: #fff;
			border-radius: 10px;
			cursor: pointer;
		}

		.tab-content {
			display: none;
		}

		.tab-content.active {
			display: block;
		}

		.action-btns {
			display: flex;
			gap: 8px;
		}

		.btn-edit,
		.btn-delete {
			padding: 6px 14px;
			border-radius: 7px;
			border: none;
			cursor: pointer;
			font-size: 13px;
			font-weight: 600;
			transition: 0.2s;
			text-decoration: none;
		}

		.btn-edit {
			background: #6366f1;
			color: #fff;
		}

		.btn-edit:hover {
			background: #4338ca;
		}

		.btn-delete {
			background: #ef4444;
			color: #fff;
		}

		.btn-delete:hover {
			background: #b91c1c;
		}
	</style>
</head>

<body>

	<aside class="sidebar">
		<div class="sidebar-brand">ADMIN</div>
		<nav class="menu">
			<a href="?tab=categories" class="<?= $tab === 'categories' ? 'active' : '' ?>"><i class="fas fa-tags"></i><span>Categories</span></a>
			<a href="?tab=products" class="<?= $tab === 'products' ? 'active' : '' ?>"><i class="fas fa-box"></i><span>Products</span></a>
			<a href="?tab=images" class="<?= $tab === 'images' ? 'active' : '' ?>"><i class="fas fa-image"></i><span>Images</span></a>
		</nav>
	</aside>

	<main class="main">
		<?php
		if ($tab === 'categories') {
			include __DIR__ . '/categories.php';
		} elseif ($tab === 'products') {
			include __DIR__ . '/products.php';
		} elseif ($tab === 'images') {
			include __DIR__ . '/images.php';
		}
		?>
	</main>

	<!-- Product Add Modal -->
	<div class="modal" id="pModal">
		<div class="modal-content">
			<h3>New Product</h3><br>
			<form method="POST" enctype="multipart/form-data">
				<div class="form-group"><label>Title</label><input type="text" name="title" required></div>
				<div class="form-group"><label>Description</label><textarea name="description"></textarea></div>
				<div class="form-group"><label>Price</label><input type="number" name="price" step="0.01" required></div>
				<div class="form-group">
					<label>Category</label>
					<select name="category_id" required>
						<option value="">Select Category</option>
						<?php
						$cat_result = $conn->query("SELECT id, name FROM categories");
						while ($cat = $cat_result->fetch_assoc()) {
							echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
						}
						?>
					</select>
				</div>
				<div class="form-group"><label>Photo</label><input type="file" name="image" accept="image/*" required></div>
				<div class="modal-btns">
					<button type="button" class="btn-cancel" onclick="closeProductModal()">Cancel</button>
					<button type="submit" class="btn-add" style="flex: 2;">Upload</button>
				</div>
			</form>
		</div>
	</div>

	<!-- Product Edit Modal -->
	<div class="modal" id="editProductModal">
		<div class="modal-content">
			<h3>Edit Product</h3><br>
			<form method="POST" enctype="multipart/form-data">
				<input type="hidden" name="edit_product" value="1">
				<input type="hidden" name="product_id" id="editProductId">
				<div class="form-group"><label>Title</label><input type="text" name="title" id="editProductTitle" required></div>
				<div class="form-group"><label>Description</label><textarea name="description" id="editProductDesc"></textarea></div>
				<div class="form-group"><label>Price</label><input type="number" name="price" id="editProductPrice" step="0.01" required></div>
				<div class="form-group">
					<label>Category</label>
					<select name="category_id" id="editProductCategory" required>
						<option value="">Select Category</option>
						<?php
						$cat_result = $conn->query("SELECT id, name FROM categories");
						while ($cat = $cat_result->fetch_assoc()) {
							echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
						}
						?>
					</select>
				</div>
				<div class="form-group"><label>Photo (leave empty to keep current)</label><input type="file" name="image" accept="image/*"></div>
				<div class="modal-btns">
					<button type="button" class="btn-cancel" onclick="closeEditProductModal()">Cancel</button>
					<button type="submit" class="btn-add" style="flex: 2;">Save</button>
				</div>
			</form>
		</div>
	</div>

	<!-- Category Add Modal -->
	<div class="modal" id="cModal">
		<div class="modal-content">
			<h3>New Category</h3><br>
			<form method="POST" enctype="multipart/form-data">
				<input type="hidden" name="add_category" value="1">
				<div class="form-group"><label>Name</label><input type="text" name="category_name" required></div>
				<div class="form-group"><label>Description</label><textarea name="category_description"></textarea></div>
				<div class="form-group"><label>Photo</label><input type="file" name="category_image" accept="image/*" required></div>
				<div class="modal-btns">
					<button type="button" class="btn-cancel" onclick="closeCategoryModal()">Cancel</button>
					<button type="submit" class="btn-add" style="flex: 2;">Upload</button>
				</div>
			</form>
		</div>
	</div>

	<!-- Category Edit Modal -->
	<div class="modal" id="editCategoryModal">
		<div class="modal-content">
			<h3>Edit Category</h3><br>
			<form method="POST" enctype="multipart/form-data">
				<input type="hidden" name="edit_category" value="1">
				<input type="hidden" name="category_id" id="editCategoryId">
				<div class="form-group"><label>Name</label><input type="text" name="category_name" id="editCategoryName" required></div>
				<div class="form-group"><label>Description</label><textarea name="category_description" id="editCategoryDesc"></textarea></div>
				<div class="form-group"><label>Photo (leave empty to keep current)</label><input type="file" name="category_image" accept="image/*"></div>
				<div class="modal-btns">
					<button type="button" class="btn-cancel" onclick="closeEditCategoryModal()">Cancel</button>
					<button type="submit" class="btn-add" style="flex: 2;">Save</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		const pModal = document.getElementById('pModal');
		const cModal = document.getElementById('cModal');

		function showTab(tab) {
			document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
			document.querySelectorAll('.menu a').forEach(a => a.classList.remove('active'));
			document.getElementById(tab).classList.add('active');
			event.target.classList.add('active');
		}

		function openProductModal() {
			pModal.style.display = 'flex';
		}

		function closeProductModal() {
			pModal.style.display = 'none';
		}

		function openCategoryModal() {
			cModal.style.display = 'flex';
		}

		function closeCategoryModal() {
			cModal.style.display = 'none';
		}

		function openEditProductModal(id, title, desc, price, category_id) {
			document.getElementById('editProductId').value = id;
			document.getElementById('editProductTitle').value = title.replace(/\\'/g, "'");
			document.getElementById('editProductDesc').value = desc.replace(/\\'/g, "'");
			document.getElementById('editProductPrice').value = price;
			document.getElementById('editProductCategory').value = category_id;
			document.getElementById('editProductModal').style.display = 'flex';
		}

		function closeEditProductModal() {
			document.getElementById('editProductModal').style.display = 'none';
		}

		function openEditCategoryModal(id, name, desc) {
			document.getElementById('editCategoryId').value = id;
			document.getElementById('editCategoryName').value = name.replace(/\\'/g, "'");
			document.getElementById('editCategoryDesc').value = desc.replace(/\\'/g, "'");
			document.getElementById('editCategoryModal').style.display = 'flex';
		}

		function closeEditCategoryModal() {
			document.getElementById('editCategoryModal').style.display = 'none';
		}

		window.onclick = (e) => {
			if (e.target == pModal) closeProductModal();
			if (e.target == cModal) closeCategoryModal();
			if (e.target == document.getElementById('editProductModal')) closeEditProductModal();
			if (e.target == document.getElementById('editCategoryModal')) closeEditCategoryModal();
		}
	</script>

</body>

</html>