<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']) && !isset($_POST['add_category'])) {
	$title = $_POST['title'];
	$desc = $_POST['description'];
	$price = $_POST['price'];
	$category_id = $_POST['category_id'];

	$target_dir = dirname(__DIR__) . "/products/";
	if (!file_exists($target_dir)) {
		mkdir($target_dir, 0777, true);
	}

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

$products_result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<div id="products" class="tab-content active">
	<header class="header">
		<h2>Products</h2>
		<button class="btn-add" onclick="openProductModal()"><i class="fas fa-plus"></i> Add Product</button>
	</header>
	<div class="table-container">
		<table>
			<thead>
				<tr>
					<th>Image</th>
					<th>Title</th>
					<th>Description</th>
					<th>Price</th>
					<th>Category</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $products_result->fetch_assoc()): ?>
					<tr>
						<td><img src="/products/<?= $row['image'] ?>" class="prod-img"></td>
						<td><b><?= htmlspecialchars($row['title']) ?></b></td>
						<td><?= htmlspecialchars($row['description']) ?></td>
						<td>$<?= number_format($row['price'], 2) ?></td>
						<td>
							<?php
							$cat_stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
							$cat_stmt->bind_param("i", $row['category_id']);
							$cat_stmt->execute();
							$cat_result = $cat_stmt->get_result();
							$cat = $cat_result->fetch_assoc();
							echo htmlspecialchars($cat['name'] ?? 'No Category');
							?>
						</td>
						<td>
							<div class="action-btns">
								<button class="btn-edit" onclick="openEditProductModal(<?= $row['id'] ?>, '<?= htmlspecialchars(addslashes($row['title'])) ?>', '<?= htmlspecialchars(addslashes($row['description'])) ?>', '<?= $row['price'] ?>', <?= $row['category_id'] ?>)">Edit</button>
								<a class="btn-delete" href="?tab=products&delete_product=<?= $row['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
							</div>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>
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
<script>
	function openProductModal() {
		document.getElementById('pModal').style.display = 'flex';
	}

	function closeProductModal() {
		document.getElementById('pModal').style.display = 'none';
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
	window.onclick = (e) => {
		if (e.target == document.getElementById('pModal')) closeProductModal();
		if (e.target == document.getElementById('editProductModal')) closeEditProductModal();
	}
</script>