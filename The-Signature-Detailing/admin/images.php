<?php
// Handle hero video upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_hero_video'])) {
	$target_dir = dirname(__DIR__) . "/Images/";
	if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
	$file_ext = pathinfo($_FILES["hero_video"]["name"], PATHINFO_EXTENSION);
	$file_name = "hero_" . time() . "_" . uniqid() . "." . $file_ext;
	$target_file = $target_dir . $file_name;
	if (move_uploaded_file($_FILES["hero_video"]["tmp_name"], $target_file)) {
		$conn->query("DELETE FROM settings WHERE name='hero_video'");
		$stmt = $conn->prepare("INSERT INTO settings (name, value) VALUES ('hero_video', ?)");
		$stmt->bind_param("s", $file_name);
		$stmt->execute();
	}
}

// Handle gallery upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_gallery'])) {
	$type = $_POST['type'];
	$target_dir = dirname(__DIR__) . "/gallery/";
	if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
	$file_ext = pathinfo($_FILES["gallery_file"]["name"], PATHINFO_EXTENSION);
	$file_name = time() . "_" . uniqid() . "." . $file_ext;
	$target_file = $target_dir . $file_name;
	if (move_uploaded_file($_FILES["gallery_file"]["tmp_name"], $target_file)) {
		$stmt = $conn->prepare("INSERT INTO gallery (file, type) VALUES (?, ?)");
		$stmt->bind_param("ss", $file_name, $type);
		$stmt->execute();
		// Redirect to avoid resubmission and refresh gallery
		header("Location: ?tab=images");
		exit;
	}
}

// Handle gallery delete
if (isset($_GET['delete_gallery'])) {
	$id = (int)$_GET['delete_gallery'];
	$stmt = $conn->prepare("DELETE FROM gallery WHERE id=?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
}

$hero_video = '';
$res = $conn->query("SELECT value FROM settings WHERE name='hero_video' LIMIT 1");
if ($row = $res->fetch_assoc()) $hero_video = $row['value'];

$gallery = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
?>
<div id="images" class="tab-content active">
	<header class="header">
		<h2>Hero Video</h2>
	</header>
	<form method="POST" enctype="multipart/form-data" style="margin-bottom:32px;">
		<input type="hidden" name="upload_hero_video" value="1">
		<div class="form-group">
			<label>Upload Hero Video (mp4)</label>
			<input type="file" name="hero_video" accept="video/mp4" required>
		</div>
		<div class="modal-btns">
			<button type="submit" class="btn-add">Upload</button>
		</div>
		<?php if ($hero_video): ?>
			<p style="margin-top:10px;">Current video: <code><?= htmlspecialchars($hero_video) ?></code></p>
			<video src="/Images/<?= htmlspecialchars($hero_video) ?>" style="max-width:320px;max-height:180px;" controls></video>
		<?php endif; ?>
	</form>

	<header class="header">
		<h2>Our Work Gallery</h2>
	</header>
	<form method="POST" enctype="multipart/form-data" style="margin-bottom:32px;">
		<input type="hidden" name="upload_gallery" value="1">
		<div class="form-group">
			<label>Type</label>
			<select name="type" required>
				<option value="image">Image</option>
				<option value="video">Video</option>
			</select>
		</div>
		<div class="form-group">
			<label>File</label>
			<input type="file" name="gallery_file" accept="image/*,video/mp4" required>
		</div>
		<div class="modal-btns">
			<button type="submit" class="btn-add">Upload</button>
		</div>
	</form>
	<div class="table-container">
		<table>
			<thead>
				<tr>
					<th>Preview</th>
					<th>Type</th>
					<th>File</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $gallery->fetch_assoc()): ?>
					<tr>
						<td>
							<?php if ($row['type'] === 'image'): ?>
								<img src="/gallery/<?= htmlspecialchars($row['file']) ?>" style="width:60px;height:60px;object-fit:cover;">
							<?php else: ?>
								<video src="/gallery/<?= htmlspecialchars($row['file']) ?>" style="width:60px;height:40px;" controls></video>
							<?php endif; ?>
						</td>
						<td><?= htmlspecialchars($row['type']) ?></td>
						<td><?= htmlspecialchars($row['file']) ?></td>
						<td>
							<a class="btn-delete" href="?tab=images&delete_gallery=<?= $row['id'] ?>" onclick="return confirm('Delete this item?')">Delete</a>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>