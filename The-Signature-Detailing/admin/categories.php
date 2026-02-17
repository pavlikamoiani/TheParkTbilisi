<?php
$categories_result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>
<div id="categories" class="tab-content active">
	<header class="header">
		<h2>Categories</h2>
		<button class="btn-add" onclick="openCategoryModal()"><i class="fas fa-plus"></i> Add Category</button>
	</header>
	<div class="table-container">
		<table>
			<thead>
				<tr>
					<th>Image</th>
					<th>Name</th>
					<th>Description</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $categories_result->fetch_assoc()): ?>
					<tr>
						<td><img src="/categories/<?= $row['image'] ?>" class="prod-img"></td>
						<td><b><?= htmlspecialchars($row['name']) ?></b></td>
						<td><?= htmlspecialchars($row['description']) ?></td>
						<td>
							<div class="action-btns">
								<button class="btn-edit" onclick="openEditCategoryModal(<?= $row['id'] ?>, '<?= htmlspecialchars(addslashes($row['name'])) ?>', '<?= htmlspecialchars(addslashes($row['description'])) ?>')">Edit</button>
								<a class="btn-delete" href="?tab=categories&delete_category=<?= $row['id'] ?>" onclick="return confirm('Delete this category?')">Delete</a>
							</div>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
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
	function openCategoryModal() {
		document.getElementById('cModal').style.display = 'flex';
	}

	function closeCategoryModal() {
		document.getElementById('cModal').style.display = 'none';
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
		if (e.target == document.getElementById('cModal')) closeCategoryModal();
		if (e.target == document.getElementById('editCategoryModal')) closeEditCategoryModal();
	}
</script>