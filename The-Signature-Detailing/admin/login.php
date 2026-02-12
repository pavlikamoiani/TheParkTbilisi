<?php
session_start();
require_once __DIR__ . '/../db/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$login = trim($_POST['login'] ?? '');
	$password = trim($_POST['password'] ?? '');

	if ($login && $password) {
		$stmt = $conn->prepare("SELECT id, password FROM users WHERE login = ?");
		$stmt->bind_param("s", $login);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows === 1) {
			$user = $result->fetch_assoc();

			if (password_verify($password, $user['password'])) {
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['login'] = $login;

				header("Location: index.php");
				exit;
			} else {
				$error = "Invalid password";
			}
		} else {
			$error = "User not found";
		}
	} else {
		$error = "Fill in all fields";
	}
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		}

		body {
			height: 100vh;
			background: linear-gradient(135deg, #667eea, #764ba2);
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.login-box {
			width: 360px;
			background: #fff;
			border-radius: 16px;
			padding: 40px 35px;
			box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
		}

		h2 {
			text-align: center;
			margin-bottom: 25px;
			color: #333;
		}

		.error {
			background: #ffe1e1;
			color: #b30000;
			padding: 10px;
			border-radius: 8px;
			margin-bottom: 15px;
			font-size: 14px;
			text-align: center;
		}

		.input-group {
			margin-bottom: 18px;
		}

		label {
			display: block;
			margin-bottom: 6px;
			font-size: 14px;
			color: #555;
		}

		input {
			width: 100%;
			padding: 12px 14px;
			border-radius: 10px;
			border: 1px solid #ddd;
			font-size: 15px;
		}

		input:focus {
			outline: none;
			border-color: #667eea;
		}

		button {
			width: 100%;
			padding: 12px;
			background: linear-gradient(135deg, #667eea, #764ba2);
			border: none;
			border-radius: 12px;
			color: #fff;
			font-size: 16px;
			cursor: pointer;
		}

		button:hover {
			opacity: 0.9;
		}
	</style>
</head>

<body>

	<form class="login-box" method="post">
		<h2>Login</h2>

		<?php if ($error): ?>
			<div class="error"><?= htmlspecialchars($error) ?></div>
		<?php endif; ?>

		<div class="input-group">
			<label>Login</label>
			<input type="text" name="login" required>
		</div>

		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password" required>
		</div>

		<button type="submit">Login</button>
	</form>

</body>

</html>