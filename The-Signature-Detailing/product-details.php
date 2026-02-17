<?php
require_once __DIR__ . '/db/db.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
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
  <title><?= htmlspecialchars($product['title']) ?> - The Park Detailing</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="shortcut icon" href="./Images/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
  <style>
    :root {
      --accent-gold: #d4af37;
      --premium-black: #111111;
      --soft-bg: #f8f9fa;
      --curve: cubic-bezier(0.2, 1, 0.3, 1);
    }

    body {
      background-color: #f4f4f7;
      font-family: 'Inter', sans-serif;
    }

    .product-detail-container {
      max-width: 1300px;
      margin: 180px auto 100px;
      padding: 0 25px;
    }

    .detail-wrapper {
      display: flex;
      gap: 70px;
      background: #ffffff;
      padding: 50px;
      border-radius: 40px;
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.05);
      align-items: center;
    }

    .detail-image {
      flex: 1.2;
      background: #fdfdfd;
      border-radius: 30px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .detail-image img {
      max-width: 100%;
      height: auto;
      transition: transform 1.2s var(--curve);
    }

    .detail-wrapper:hover .detail-image img {
      transform: scale(1.06);
    }

    .detail-info {
      flex: 1;
    }

    .badge-premium {
      display: inline-block;
      background: var(--premium-black);
      color: var(--accent-gold);
      padding: 7px 20px;
      border-radius: 50px;
      font-weight: 800;
      font-size: 10px;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      margin-bottom: 25px;
      opacity: 0;
      transform: translateY(15px);
      transition: all 0.8s var(--curve) 0.2s;
    }

    .detail-title {
      font-size: 48px;
      font-weight: 800;
      color: var(--premium-black);
      margin-bottom: 20px;
      line-height: 1.1;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.8s var(--curve) 0.3s;
    }

    .detail-price {
      font-size: 32px;
      font-weight: 300;
      color: var(--accent-gold);
      margin-bottom: 30px;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.8s var(--curve) 0.4s;
    }

    .detail-description {
      font-size: 17px;
      line-height: 1.8;
      color: #555;
      margin-bottom: 40px;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.8s var(--curve) 0.5s;
    }

    .btn-wrap {
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.8s var(--curve) 0.6s;
    }

    .aos-animate .badge-premium,
    .aos-animate .detail-title,
    .aos-animate .detail-price,
    .aos-animate .detail-description,
    .aos-animate .btn-wrap {
      opacity: 1;
      transform: translateY(0);
    }

    .btn-buy {
      background: var(--premium-black);
      color: #fff;
      padding: 18px 50px;
      border-radius: 100px;
      text-decoration: none;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      transition: all 0.4s var(--curve);
      border: 2px solid var(--premium-black);
    }

    .btn-buy:hover {
      background: transparent;
      color: var(--premium-black);
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    #nav {
      backdrop-filter: blur(15px);
      background: rgba(255, 255, 255, 0.85);
      transition: all 0.5s var(--curve);
    }

    @media (max-width: 992px) {
      .detail-wrapper {
        flex-direction: column;
        gap: 40px;
        padding: 30px;
        margin-top: 40px;
      }

      .detail-title {
        font-size: 34px;
      }

      .product-detail-container {
        margin-top: 120px;
      }
    }
  </style>
</head>

<body>
  <nav id="nav">
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
      <div class="detail-wrapper" data-aos="fade-up">
        <div class="detail-image" data-aos="zoom-out" data-aos-delay="100">
          <img src="products/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" />
        </div>
        <div class="detail-info">
          <div class="badge-premium">PREMIUM QUALITY</div>
          <h1 class="detail-title"><?= htmlspecialchars($product['title']) ?></h1>
          <div class="detail-price"><?= number_format($product['price'], 0, '.', ' ') ?> GEL</div>
          <?php
          $desc = $product['description'];
          $desc_limit = 180;
          $desc_short = mb_substr($desc, 0, $desc_limit);
          $is_long = mb_strlen($desc) > $desc_limit;
          ?>
          <p class="detail-description">
            <span id="desc-short"><?= nl2br(htmlspecialchars($desc_short)) ?><?= $is_long ? '...' : '' ?></span>
            <?php if ($is_long): ?>
              <span id="desc-full" style="display:none;"><?= nl2br(htmlspecialchars($desc)) ?></span>
              <a href="#" id="show-more-desc" style="color:#d4af37; text-decoration:underline; cursor:pointer;">Show more</a>
            <?php endif; ?>
          </p>
          <div class="btn-wrap">
            <a href="https://wa.me/995596502222?text=I%20want%20to%20order:%20<?= urlencode($product['title']) ?>" class="btn-buy">
              <i class="fab fa-whatsapp me-2"></i> Order Now
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      easing: 'cubic-bezier(0.2, 1, 0.3, 1)',
      once: true,
      offset: 50
    });

    document.addEventListener('DOMContentLoaded', function() {
      var showMore = document.getElementById('show-more-desc');
      if (showMore) {
        showMore.addEventListener('click', function(e) {
          e.preventDefault();
          document.getElementById('desc-short').style.display = 'none';
          document.getElementById('desc-full').style.display = '';
          showMore.style.display = 'none';
        });
      }
    });
  </script>
</body>

</html>