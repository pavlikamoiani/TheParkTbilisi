<?php $pageTitle = 'The Park Detailing'; ?>
<?php
require_once __DIR__ . '/db/db.php';

$hero_video = './Images/preview.mp4';
$res = $conn->query("SELECT value FROM settings WHERE name='hero_video' LIMIT 1");
if ($row = $res->fetch_assoc()) $hero_video = './Images/' . htmlspecialchars($row['value']);

$gallery = [];
$res = $conn->query("SELECT * FROM gallery ORDER BY id DESC LIMIT 8");
while ($row = $res->fetch_assoc()) $gallery[] = $row;
?>
<?php include 'header.php'; ?>

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
    <?php foreach ($gallery as $item): ?>
      <?php if ($item['type'] === 'image'): ?>
        <img src="/gallery/<?= htmlspecialchars($item['file']) ?>" style="max-width:320px;max-height:220px;margin:10px;border-radius:12px;box-shadow:0 2px 8px #0002;">
      <?php elseif ($item['type'] === 'video'): ?>
        <video src="/gallery/<?= htmlspecialchars($item['file']) ?>" style="max-width:320px;max-height:220px;margin:10px;border-radius:12px;box-shadow:0 2px 8px #0002;" controls></video>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <div style="text-align:center; margin-top:24px;">
    <button id="showMoreBtn" class="book-nowww">Show More</button>
  </div>
</section>

<!-- Remove this duplicated nav section -->
<!--
<nav id="nav" data-aos="fade-down">
  <input type="checkbox" id="check" />
  <label for="check" class="checkbtn" aria-label="Open Menu">
    <i class="fas fa-bars"></i>
  </label>
  <a href="./index.html">
    <img
      class="logoo"
      data-aos="fade-down"
      src="./Images/logo.png"
      alt="Logo" />
  </a>
  <ul id="navLinks">
    <li><a href="#home">Home</a></li>
    <li><a href="#our-services">Services</a></li>
    <li><a href="#our-work">Our Work</a></li>
    <li><a href="#footer">Contact</a></li>
    <li><a href="#products">Products</a></li>
    <li>
      <a href="#" class="lang" id="lang-en" data-lang="en">EN</a>
      <a href="#" class="lang" id="lang-ge" data-lang="ge">GE</a>
      <a href="#" class="lang" id="lang-ru" data-lang="ru">RU</a>
    </li>
  </ul>
</nav>
-->

<!-- Remove this duplicated footer section -->
<!--
<footer id="footer" data-aos="fade-up">
  <div class="footer-content">
    <div class="footer-section">
      <h3><i class="fas fa-address-book"></i> <span id="footer-contact-title">Contact</span></h3>
      <div class="contact-item">
        <i class="fas fa-phone"></i>
        <p><a href="tel:+995 596 502 222" id="footer-phone">+995 596 502 222</a></p>
      </div>
    </div>

    <div class="footer-section last">
      <h3><i class="fas fa-clock"></i> <span id="footer-hours-title">Hours</span></h3>
      <p id="footer-hours-desc"><b>We are open every day:</b> 8:00 AM - 7:00 PM</p>
    </div>
    <div class="footer-section">
      <h3><i class="fas fa-map-marker-alt"></i> <span id="footer-location-title">Location</span></h3>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2978.440411730577!2d44.75516489999999!3d41.7110145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4044730031a5120d%3A0x151fb43a84ebb50f!2sThe%20Park%20Detailing%20and%20Car%20Wash!5e0!3m2!1sru!2sge!4v1756394178004!5m2!1sru!2sge"
        width="350" height="350" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</footer>
<a
  href="https://wa.me/995596502222"
  class="floating-contact"
  target="_blank">
  <i class="fab fa-whatsapp"></i>
</a>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
  integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
  integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
  crossorigin="anonymous"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="./script.js"></script>
<script src="./gallery.js"></script>
<script src="./translation.js"></script>
</body>
</html>
-->

<?php include 'footer.php'; ?>