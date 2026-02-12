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
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Admin Login | The Park</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
	<style>
		:root {
			--bg: #050505;
			--card: #0d0d0d;
			--accent: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
			--text: #ffffff;
			--text-dim: #94a3b8;
			--border: rgba(255, 255, 255, 0.08);
		}

		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: 'Plus Jakarta Sans', sans-serif;
		}

		body {
			height: 100vh;
			background-color: var(--bg);
			background-image:
				radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.1) 0%, transparent 40%),
				radial-gradient(circle at 90% 80%, rgba(168, 85, 247, 0.1) 0%, transparent 40%);
			display: flex;
			align-items: center;
			justify-content: center;
			overflow: hidden;
		}

		.login-box {
			width: 100%;
			max-width: 400px;
			background: var(--card);
			border: 1px solid var(--border);
			border-radius: 24px;
			padding: 40px;
			box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
			position: relative;
		}

		.login-box::before {
			content: '';
			position: absolute;
			top: -1px;
			left: -1px;
			right: -1px;
			bottom: -1px;
			background: var(--accent);
			z-index: -1;
			border-radius: 25px;
			opacity: 0.2;
		}

		.logo-area {
			text-align: center;
			margin-bottom: 30px;
		}

		.logo-area h2 {
			font-size: 24px;
			font-weight: 700;
			background: var(--accent);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			text-transform: uppercase;
			letter-spacing: 2px;
		}

		.error {
			background: rgba(239, 68, 68, 0.1);
			color: #ef4444;
			padding: 12px;
			border-radius: 12px;
			margin-bottom: 20px;
			font-size: 14px;
			border: 1px solid rgba(239, 68, 68, 0.2);
			text-align: center;
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
		}

		.input-group {
			margin-bottom: 20px;
		}

		label {
			display: block;
			margin-bottom: 8px;
			font-size: 13px;
			font-weight: 600;
			color: var(--text-dim);
			text-transform: uppercase;
			letter-spacing: 1px;
		}

		.input-wrapper {
			position: relative;
		}

		.input-wrapper i {
			position: absolute;
			left: 15px;
			top: 50%;
			transform: translateY(-50%);
			color: var(--text-dim);
			font-size: 16px;
		}

		input {
			width: 100%;
			padding: 14px 14px 14px 45px;
			background: #151515;
			border: 1px solid var(--border);
			border-radius: 12px;
			color: var(--text);
			font-size: 15px;
			transition: all 0.3s ease;
		}

		input:focus {
			outline: none;
			border-color: #6366f1;
			background: #1a1a1a;
			box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
		}

		button {
			width: 100%;
			padding: 14px;
			background: var(--accent);
			border: none;
			border-radius: 12px;
			color: #fff;
			font-size: 16px;
			font-weight: 700;
			cursor: pointer;
			transition: transform 0.2s ease, box-shadow 0.2s ease;
			margin-top: 10px;
		}

		button:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.5);
		}

		button:active {
			transform: translateY(0);
		}

		.back-link {
			display: block;
			text-align: center;
			margin-top: 25px;
			color: var(--text-dim);
			text-decoration: none;
			font-size: 13px;
			transition: color 0.2s;
		}

		.back-link:hover {
			color: var(--text);
		}
	</style>
</head>

<body>

	<div class="login-box">
		<div class="logo-area">
			<h2>The Park</h2>
			<p style="color: var(--text-dim); font-size: 14px; margin-top: 5px;">Admin Control Panel</p>
		</div>

		<form method="post">
			<?php if ($error): ?>
				<div class="error">
					<i class="fas fa-exclamation-circle"></i>
					<?= htmlspecialchars($error) ?>
				</div>
			<?php endif; ?>

			<div class="input-group">
				<label>Login</label>
				<div class="input-wrapper">
					<i class="fas fa-user"></i>
					<input type="text" name="login" placeholder="Enter your username" required autofocus>
				</div>
			</div>

			<div class="input-group">
				<label>Password</label>
				<div class="input-wrapper">
					<i class="fas fa-lock"></i>
					<input type="password" name="password" placeholder="••••••••" required>
				</div>
			</div>

			<button type="submit">Sign In</button>
		</form>

		<a href="../index.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to website</a>
	</div>

</body>

</html>