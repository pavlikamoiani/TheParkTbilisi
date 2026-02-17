<?php
require_once __DIR__ . '/db/db.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result =
  $stmt->get_result();
$product = $result->fetch_assoc();
if (!$product) {
  header("Location: index.php");
  exit;
} ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>
    <?= htmlspecialchars($product['title']) ?> - The Park Detailing
  </title>
  <link rel="stylesheet" href="style.css" />
  <link rel="shortcut icon" href="./Images/favicon.ico" type="image/x-icon" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
  <style>
    body {
      background-color: #f4f4f7;
    }

    .product-detail-container {
      max-width: 1400px;
      margin: 160px auto 80px;
    }

    .detail-wrapper {
      display: flex;
      gap: 60px;
    }

    .detail-image {
      flex: 1;
      display: flex;
      justify-content: center;
      background: #f9f9fb;
      border-radius: 20px;
      padding: 40px;
    }

    .detail-image img {
      max-width: 100%;
      height: auto;
      transition: transform 0.5s ease;
      border-radius: 10px;
    }

    .detail-image img:hover {
      transform: scale(1.05);
    }

    .detail-info {
      flex: 1;
      padding-top: 10px;
    }

    .detail-info .badge-premium {
      display: inline-block;
      background: #000;
      color: #d4af37;
      padding: 5px 15px;
      border-radius: 50px;
      font-weight: 800;
      font-size: 12px;
      margin-bottom: 20px;
    }

    .detail-title {
      font-size: 32px;
      font-weight: 800;
      color: #111;
      margin-bottom: 20px;
    }

    .detail-price {
      font-size: 28px;
      font-weight: 700;
      color: #d4af37;
      margin-bottom: 25px;
    }

    .detail-description {
      font-size: 16px;
      line-height: 1.8;
      color: #555;
      margin-bottom: 30px;
    }

    .btn-buy {
      background: #000;
      color: #fff;
      padding: 15px 40px;
      border-radius: 12px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
      display: inline-block;
      border: none;
    }

    .btn-buy:hover {
      background: #d4af37;
      color: #000;
      transform: translateY(-3px);
    }

    @media (max-width: 992px) {
      .detail-wrapper {
        flex-direction: column;
        gap: 40px;
      }

      .product-detail-container {
        margin-top: 120px;
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  <nav id="nav" data-aos="fade-down">
    <input type="checkbox" id="check" />
    <label for="check" class="checkbtn"><i class="fas fa-bars"></i></label>
    <a href="index.php"><img class="logoo" src="./Images/logo.png" alt="Logo" /></a>
    <ul id="navLinks">
      <li><a href="index.php#home">Home</a></li>
      <li><a href="index.php#our-services">Services</a></li>
      <li><a href="index.php#our-work">Our Work</a></li>
      <li><a href="index.php#footer">Contact</a></li>
      <li><a href="index.php#products">Products</a></li>
      <li>
        <a href="#" class="lang">EN</a>
        <a href="#" class="lang">GE</a>
        <a href="#" class="lang">RU</a>
      </li>
    </ul>
  </nav>

  <div class="container">
    <div class="product-detail-container">
      <div class="detail-wrapper">
        <div class="detail-image" data-aos="zoom-in">
          <img
            src="products/<?= htmlspecialchars($product['image']) ?>"
            alt="<?= htmlspecialchars($product['title']) ?>" />
        </div>
        <div class="detail-info" data-aos="fade-left">
          <div class="badge-premium">PREMIUM QUALITY</div>
          <h1 class="detail-title">
            <?= htmlspecialchars($product['title']) ?>
          </h1>
          <div class="detail-price">
            <?= number_format($product['price'], 0, '.', ' ') ?>
            GEL
          </div>
          <p class="detail-description">
            <?= nl2br(htmlspecialchars($product['description'])) ?>
          </p>
          <a
            href="https://wa.me/995596502222?text=I%20want%20to%20order:%20<?= urlencode($product['title']) ?>"
            class="btn-buy">
            <i class="fab fa-whatsapp me-2"></i> Order Now
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 500,
      once: true
    });
  </script>
</body>

</html>