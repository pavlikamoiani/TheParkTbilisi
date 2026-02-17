<?php
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
		header("Location: ?tab=images");
		exit;
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_gallery'])) {
	$type = $_POST['type'];
	$target_dir = dirname(__DIR__) . "/gallery/";
	if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

	// Support multiple files
	$files = $_FILES["gallery_file"];
	$file_count = is_array($files['name']) ? count($files['name']) : 0;
	if ($file_count > 0) {
		for ($i = 0; $i < $file_count; $i++) {
			if ($files['error'][$i] === UPLOAD_ERR_OK) {
				$file_ext = pathinfo($files["name"][$i], PATHINFO_EXTENSION);
				$file_name = time() . "_" . uniqid() . "." . $file_ext;
				$target_file = $target_dir . $file_name;
				if (move_uploaded_file($files["tmp_name"][$i], $target_file)) {
					$stmt = $conn->prepare("INSERT INTO gallery (file, type) VALUES (?, ?)");
					$stmt->bind_param("ss", $file_name, $type);
					$stmt->execute();
				}
			}
		}
		header("Location: ?tab=images");
		exit;
	} else {
		if (isset($files["tmp_name"]) && is_string($files["tmp_name"]) && $files["error"] === UPLOAD_ERR_OK) {
			$file_ext = pathinfo($files["name"], PATHINFO_EXTENSION);
			$file_name = time() . "_" . uniqid() . "." . $file_ext;
			$target_file = $target_dir . $file_name;
			if (move_uploaded_file($files["tmp_name"], $target_file)) {
				$stmt = $conn->prepare("INSERT INTO gallery (file, type) VALUES (?, ?)");
				$stmt->bind_param("ss", $file_name, $type);
				$stmt->execute();
			}
			header("Location: ?tab=images");
			exit;
		}
	}
}

if (isset($_GET['delete_gallery'])) {
	$id = (int)$_GET['delete_gallery'];
	// Get file name before deleting from DB
	$stmt = $conn->prepare("SELECT file FROM gallery WHERE id=?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($file_name);
	$stmt->fetch();
	$stmt->close();

	if (!empty($file_name)) {
		$file_path = dirname(__DIR__) . "/gallery/" . $file_name;
		if (file_exists($file_path)) {
			unlink($file_path);
		}
	}

	$stmt = $conn->prepare("DELETE FROM gallery WHERE id=?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	header("Location: ?tab=images");
	exit;
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
			<input type="file" name="gallery_file[]" accept="image/*,video/mp4" multiple required>
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