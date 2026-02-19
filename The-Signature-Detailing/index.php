<?php $pageTitle = 'The Park Detailing'; ?>
<?php
require_once __DIR__ . '/db/db.php';

$hero_video = './Images/preview.mp4';
$res = $conn->query("SELECT value FROM settings WHERE name='hero_video' LIMIT 1");
if ($row = $res->fetch_assoc()) $hero_video = './Images/' . htmlspecialchars($row['value']);

$gallery = [];
$res = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
while ($row = $res->fetch_assoc()) $gallery[] = $row;
?>
<?php include './components/header.php'; ?>

<section id="home" class="hero">
  <video autoplay muted loop playsinline>
    <source src="<?= $hero_video ?>" type="video/mp4" />
    Your browser does not support the video tag.
  </video>

  <div class="overlay"></div>

  <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
    <h1 id="hero-title">DETAILING CENTER
      IN TBILISI - The Park.</h1>
    <p id="hero-desc">Professional car care and protection,
      with the best result and level of service: car polishing, ceramic coating, pasting in a protective film, car
      cleaning, paintless dent removal, interior restoration.</p>
    <a href="https://wa.me/995596502222" target="_blank" class="book-now" id="book-now-btn">
      Book Now
    </a>
  </div>
</section>

<section id="our-services" style="scroll-margin-top: 50px;">
  <div class="how-it-works">
    <div class="how-it-works-header" data-aos="fade-up">
      <h1 id="services-title">Our Services</h1>
    </div>

    <div class="step-card" data-aos="fade-up" data-aos-delay="100">
      <div class="step-number">
        <i class="fas fa-car" style="font-size:2.5rem;"></i>
      </div>
      <h3 id="service-wash">Car Wash</h3>
      <p id="service-wash-desc">Thorough exterior and interior cleaning for a spotless finish.</p>
    </div>

    <div class="step-card" data-aos="fade-up" data-aos-delay="200">
      <div class="step-number">
        <i class="fas fa-shield-alt" style="font-size:2.5rem;"></i>
      </div>
      <h3 id="service-ppf">PPF Wrap</h3>
      <p id="service-ppf-desc">Paint Protection Film application to shield your car from scratches and chips.</p>
    </div>

    <div class="step-card" data-aos="fade-up" data-aos-delay="300">
      <div class="step-number">
        <i class="fas fa-magic" style="font-size:2.5rem;"></i>
      </div>
      <h3 id="service-polish">Polishing</h3>
      <p id="service-polish-desc">Professional polishing to restore gloss and remove imperfections.</p>
    </div>

    <div class="step-card" data-aos="fade-up" data-aos-delay="400">
      <div class="step-number">
        <i class="fas fa-tint" style="font-size:2.5rem;"></i>
      </div>
      <h3 id="service-ceramic">Ceramic Coating</h3>
      <p id="service-ceramic-desc">Advanced ceramic protection for long-lasting shine and durability.</p>
    </div>

    <div class="step-card" data-aos="fade-up" data-aos-delay="500">
      <div class="step-number">
        <i class="fas fa-wind" style="font-size:2.5rem;"></i>
      </div>
      <h3 id="service-dry">Dry Cleaning</h3>
      <p id="service-dry-desc">Deep interior dry cleaning for seats, carpets, and surfaces.</p>
    </div>

    <div class="step-card" data-aos="fade-up" data-aos-delay="600">
      <div class="step-number">
        <i class="fas fa-volume-mute" style="font-size:2.5rem;"></i>
      </div>
      <h3 id="service-sound">Sound Proofing</h3>
      <p id="service-sound-desc">Reduce road noise and enhance comfort with professional sound proofing.</p>
    </div>

    <div class="step-card" data-aos="fade-up" data-aos-delay="700">
      <div class="step-number">
        <i class="fas fa-door-open" style="font-size:2.5rem;"></i>
      </div>
      <h3 id="service-door">Door Vacuum</h3>
      <p id="service-door-desc">Specialized vacuuming for door panels and hard-to-reach areas.</p>
    </div>
  </div>
</section>

<section id="our-work" class="our-work-section">
  <div class="our-work-header" data-aos="fade-up">
    <h1 id="work-title">Our Work</h1>
    <p class="section-subtitle" id="work-subtitle">See some of our recent detailing projects</p>
  </div>
  <div class="work-gallery" id="workGallery">
    <?php
    $defaultGalleryImage = './Images/logo.png';
    $i = 0;
    foreach ($gallery as $item):
      $file = !empty($item['file']) ? '/gallery/' . htmlspecialchars($item['file']) : $defaultGalleryImage;
      $hidden = $i >= 8 ? 'style="display:none;"' : '';
    ?>
      <?php if ($item['type'] === 'image'): ?>
        <img src="<?= $file ?>" class="gallery-item" <?= $hidden ?>>
      <?php elseif ($item['type'] === 'video' && !empty($item['file'])): ?>
        <video src="<?= $file ?>" controls class="gallery-item" <?= $hidden ?>></video>
      <?php elseif ($item['type'] === 'video' && empty($item['file'])): ?>
        <img src="<?= $defaultGalleryImage ?>" class="gallery-item" <?= $hidden ?>>
      <?php endif; ?>
    <?php $i++;
    endforeach; ?>
  </div>
  <div style="text-align:center; margin-top:24px;">
    <button id="showMoreBtn" class="book-nowww">Show More</button>
  </div>
</section>

<section id="products" style="padding: 60px 0; background: #fff;">
  <div style="max-width: 1400px; margin: 0 auto;">
    <h1 id="categories-title" style="color: #111; text-align: center; font-size: 2.3rem; font-weight: 700; margin-bottom: 40px; letter-spacing: -1px;">
      SHOP POPULAR CATEGORIES
    </h1>
    <div class="categories-grid">
      <?php
      require_once __DIR__ . '/db/db.php';
      $result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
      $defaultCategoryImage = './Images/logo.png';

      if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
          $catImage = (!empty($row['image'])) ? '/categories/' . htmlspecialchars($row['image']) : $defaultCategoryImage;
      ?>
          <div class="category-card">
            <a href="products.php?category_id=<?= $row['id'] ?>" style="width: 100%; display: flex; justify-content: center; align-items: center;">
              <img src="<?= $catImage ?>" alt="<?= htmlspecialchars($row['name']) ?>" />
            </a>
            <div class="category-title">
              <?= htmlspecialchars($row['name']) ?>
            </div>
          </div>
        <?php
        endwhile;
      else: ?>
        <p style="color: #222; text-align: center; width: 100%;">No categories available.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const items = document.querySelectorAll('#workGallery .gallery-item');
    const btn = document.getElementById('showMoreBtn');
    let visible = 8;
    const step = 8;

    function updateGallery() {
      let shown = 0;
      items.forEach((el, idx) => {
        if (idx < visible) {
          el.style.display = '';
          shown++;
        } else {
          el.style.display = 'none';
        }
      });
      if (shown >= items.length) {
        btn.style.display = 'none';
      } else {
        btn.style.display = '';
      }
    }

    btn.addEventListener('click', function(e) {
      e.preventDefault();
      visible += step;
      updateGallery();
    });

    updateGallery();
  });
</script>

<?php include './components/footer.php'; ?>