<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	echo json_encode(['success' => false, 'msg' => 'Method not allowed']);
	exit;
}

$name = trim($_POST['customerName'] ?? '');
$phone = trim($_POST['customerPhone'] ?? '');
$address = trim($_POST['customerAddress'] ?? '');
$cart = $_POST['cart'] ?? '';

if (!$name || !$phone || !$address || !$cart) {
	http_response_code(400);
	echo json_encode(['success' => false, 'msg' => 'Все поля обязательны']);
	exit;
}

$cartArr = json_decode($cart, true);
if (!is_array($cartArr) || !count($cartArr)) {
	http_response_code(400);
	echo json_encode(['success' => false, 'msg' => 'Корзина пуста']);
	exit;
}

$to = 'amoyanpavlik9@gmail.com';
$subject = 'შეკვეთა The Park Detailing';
$body = "<b>სახელი/გვარი:</b> " . htmlspecialchars($name) . "<br>";
$body .= "<b>ტელეფონი:</b> " . htmlspecialchars($phone) . "<br>";
$body .= "<b>მისამართი:</b> " . htmlspecialchars($address) . "<br><br>";
$body .= "<b>პროდუქტები:</b><br>";
foreach ($cartArr as $item) {
	$body .= htmlspecialchars($item['title']) . " — " . intval($item['price']) . " GEL x " . intval($item['qty']) . "<br>";
}

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: The Park Detailing <noreply@thepark.ge>' . "\r\n";

$sent = mail($to, $subject, $body, $headers);

if ($sent) {
	echo json_encode(['success' => true]);
} else {
	http_response_code(500);
	echo json_encode(['success' => false, 'msg' => 'Ошибка отправки письма']);
}
