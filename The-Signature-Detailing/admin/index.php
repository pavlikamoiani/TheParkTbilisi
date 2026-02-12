<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit;
}

require_once __DIR__ . '/../db/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
	$title = $_POST['title'];
	$desc = $_POST['description'];
	$price = $_POST['price'];

	$target_dir = dirname(__DIR__) . "/products/";

	if (!file_exists($target_dir)) {
		mkdir($target_dir, 0777, true);
	}

	$file_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
	$file_name = time() . "_" . uniqid() . "." . $file_ext;
	$target_file = $target_dir . $file_name;

	if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		$stmt = $conn->prepare("INSERT INTO products (title, description, price, image) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("ssds", $title, $desc, $price, $file_name);

		if ($stmt->execute()) {
			header("Location: " . $_SERVER['PHP_SELF']);
			exit;
		} else {
			die("Ошибка базы данных: " . $stmt->error);
		}
	} else {
		die("Ошибка при загрузке файла. Проверьте права папки products.");
	}
}

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
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
		.form-group textarea {
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
	</style>
</head>

<body>

	<aside class="sidebar">
		<div class="sidebar-brand">ADMIN</div>
		<nav class="menu"><a href="#"><i class="fas fa-box"></i><span>Products</span></a></nav>
	</aside>

	<main class="main">
		<header class="header">
			<h2>Products</h2>
			<button class="btn-add" onclick="openModal()"><i class="fas fa-plus"></i> Add Product</button>
		</header>

		<div class="table-container">
			<table>
				<thead>
					<tr>
						<th>Image</th>
						<th>Title</th>
						<th>Description</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($row = $result->fetch_assoc()): ?>
						<tr>
							<td><img src="/products/<?= $row['image'] ?>" class="prod-img"></td>
							<td><b><?= htmlspecialchars($row['title']) ?></b></td>
							<td><?= htmlspecialchars($row['description']) ?></td>
							<td>$<?= number_format($row['price'], 2) ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</main>

	<div class="modal" id="pModal">
		<div class="modal-content">
			<h3>New Product</h3><br>
			<form method="POST" enctype="multipart/form-data">
				<div class="form-group"><label>Title</label><input type="text" name="title" required></div>
				<div class="form-group"><label>Description</label><textarea name="description"></textarea></div>
				<div class="form-group"><label>Price</label><input type="number" name="price" step="0.01" required></div>
				<div class="form-group"><label>Photo</label><input type="file" name="image" accept="image/*" required></div>
				<div class="modal-btns">
					<button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
					<button type="submit" class="btn-add" style="flex: 2;">Upload</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		const m = document.getElementById('pModal');

		function openModal() {
			m.style.display = 'flex';
		}

		function closeModal() {
			m.style.display = 'none';
		}
		window.onclick = (e) => {
			if (e.target == m) closeModal();
		}
	</script>

</body>

</html>