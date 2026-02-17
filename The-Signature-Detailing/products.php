<?php
require_once __DIR__ . '/db/db.php';

$category_id = $_GET['category_id'] ?? null;
if (!$category_id) {
	header("Location: index.php");
	exit;
}

$category_stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
$category_stmt->bind_param("i", $category_id);
$category_stmt->execute();
$category_result = $category_stmt->get_result();
$category = $category_result->fetch_assoc();

if (!$category) {
	header("Location: index.php");
	exit;
}

$pageTitle = 'Products - ' . htmlspecialchars($category['name']) . ' | The Park Detailing';
include 'header.php';

$products_stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY id DESC");
$products_stmt->bind_param("i", $category_id);
$products_stmt->execute();
$products_result = $products_stmt->get_result();
?>

<section class="products-section" style="margin-bottom: 10%;">
	<div class="container">
		<div class="products-grid">
			<?php if ($products_result->num_rows > 0): ?>
				<?php $delay = 0;
				while ($row = $products_result->fetch_assoc()): ?>
					<div class="product-card" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
						<div class="image-wrapper">
							<a href="product-details.php?id=<?= $row['id'] ?>">
								<img src="/products/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" />
							</a>
						</div>
						<div class="product-info">
							<div class="title"><?= htmlspecialchars($row['title']) ?></div>
							<div class="description"><?= htmlspecialchars($row['description']) ?></div>
							<div class="price-section">
								<div class="price"><?= number_format($row['price'], 0, '.', ' ') ?> GEL</div>
								<a href="product-details.php?id=<?= $row['id'] ?>" class="btn-add">
									<i class="fas fa-plus"></i>
								</a>
							</div>
						</div>
					</div>
				<?php $delay += 100;
				endwhile; ?>
			<?php else: ?>
				<p style="color: white; text-align: center; width: 100%;">No products in this category.</p>
			<?php endif; ?>
		</div>
		<!-- <div style="text-align: center; margin-top: 24px;">
			<a href="index.php" class="book-now">Back to Categories</a>
		</div> -->
	</div>
</section>

<?php include 'footer.php'; ?>