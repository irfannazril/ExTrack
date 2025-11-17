<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExTrack - Expense Tracker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/css/landing.css">
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="navbar-content">
      <div class="logo">
        <span class="logo-color">Ex</span>Track
      </div>
      <div class="nav-links">
        <a href="#features" class="nav-link">Features</a>
        <a href="#about" class="nav-link">About</a>
        <a href="./login.php" class="btn-login">Login</a>
        <a href="./register.php" class="btn-register">Get Started</a>
      </div>
      <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="bi bi-list"></i>
      </button>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobileMenu">
    <a href="#features" class="mobile-link">Features</a>
    <a href="#about" class="mobile-link">About</a>
    <a href="./login.php" class="mobile-link">Login</a>
    <a href="./register.php" class="btn-register-mobile">Get Started</a>
  </div>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <div class="hero-content">
        <div class="hero-text">
          <h1 class="hero-title">
            Track Your <span class="text-highlight">Expenses</span><br>
            Manage Your <span class="text-highlight">Money</span>
          </h1>
          <p class="hero-description">
            Aplikasi pelacak pengeluaran yang sederhana dan powerful untuk membantu Anda mengelola keuangan dengan lebih baik.
            Catat transaksi, pantau aset, dan analisis pola pengeluaran Anda.
          </p>
          <div class="hero-buttons">
            <a href="./register.php" class="btn-hero-primary">
              <i class="bi bi-rocket-takeoff me-2"></i>Start Free
            </a>
            <a href="#features" class="btn-hero-secondary">
              <i class="bi bi-play-circle me-2"></i>Learn More
            </a>
          </div>
        </div>
        <div class="hero-image">
          <div class="dashboard-preview">
            <div class="preview-header">
              <div class="preview-dot"></div>
              <div class="preview-dot"></div>
              <div class="preview-dot"></div>
            </div>
            <div class="preview-content">
              <div class="preview-card">
                <div class="preview-card-label">Total Balance</div>
                <div class="preview-card-amount">Rp 15,250,000</div>
              </div>
              <div class="preview-stats">
                <div class="preview-stat income">
                  <i class="bi bi-arrow-up-circle"></i>
                  <span>Income</span>
                  <div class="preview-stat-amount">+Rp 8,500,000</div>
                </div>
                <div class="preview-stat expense">
                  <i class="bi bi-arrow-down-circle"></i>
                  <span>Expense</span>
                  <div class="preview-stat-amount">-Rp 3,250,000</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features" id="features">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Powerful Features</h2>
        <p class="section-description">Semua yang Anda butuhkan untuk mengelola keuangan</p>
      </div>
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-cash-stack"></i>
          </div>
          <h3 class="feature-title">Track Transactions</h3>
          <p class="feature-description">
            Catat semua pemasukan dan pengeluaran Anda dengan kategori dan deskripsi yang detail.
          </p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-wallet2"></i>
          </div>
          <h3 class="feature-title">Manage Assets</h3>
          <p class="feature-description">
            Pantau dompet, rekening bank, dan aset keuangan lainnya dalam satu tempat.
          </p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-graph-up"></i>
          </div>
          <h3 class="feature-title">Visual Statistics</h3>
          <p class="feature-description">
            Analisis pola pengeluaran Anda dengan grafik yang indah dan laporan yang detail.
          </p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-tags"></i>
          </div>
          <h3 class="feature-title">Custom Categories</h3>
          <p class="feature-description">
            Buat dan kelola kategori kustom untuk mengorganisir transaksi Anda secara efektif.
          </p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-shield-check"></i>
          </div>
          <h3 class="feature-title">Secure & Private</h3>
          <p class="feature-description">
            Data keuangan Anda dienkripsi dan disimpan dengan aman dengan privasi sebagai prioritas.
          </p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-phone"></i>
          </div>
          <h3 class="feature-title">Responsive Design</h3>
          <p class="feature-description">
            Akses keuangan Anda dari perangkat apa pun dengan aplikasi web responsif kami.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section class="about" id="about">
    <div class="container">
      <div class="about-content">
        <div class="about-text">
          <h2 class="section-title">About ExTrack</h2>
          <p class="about-description">
            ExTrack adalah aplikasi pelacak pengeluaran modern yang dirancang untuk membantu Anda mengambil kendali
            atas keuangan Anda. Dengan antarmuka yang intuitif dan fitur yang powerful, mengelola uang
            tidak pernah semudah ini.
          </p>
          <p class="about-description">
            Baik Anda melacak pengeluaran harian, memantau beberapa akun, atau menganalisis
            kebiasaan pengeluaran Anda, ExTrack menyediakan semua alat yang Anda butuhkan dalam satu platform sederhana.
          </p>
          <div class="about-stats">
            <div class="stat-item">
              <div class="stat-number">10K+</div>
              <div class="stat-label">Users</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">50K+</div>
              <div class="stat-label">Transactions</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">100+</div>
              <div class="stat-label">Categories</div>
            </div>
          </div>
        </div>
        <div class="about-image">
          <div class="about-card">
            <i class="bi bi-piggy-bank"></i>
            <h3>Start Saving Today</h3>
            <p>Ambil langkah pertama menuju kebebasan finansial</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta">
    <div class="container">
      <div class="cta-content">
        <h2 class="cta-title">Ready to Take Control?</h2>
        <p class="cta-description">Bergabunglah dengan ribuan pengguna yang mengelola keuangan mereka dengan ExTrack</p>
        <a href="./register.php" class="btn-cta">
          Get Started for Free <i class="bi bi-arrow-right ms-2"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-brand">
          <div class="logo">
            <span class="logo-color">Ex</span>Track
          </div>
          <p class="footer-description">
            Simple expense tracking for better financial management.
          </p>
        </div>
        <div class="footer-links">
          <div class="footer-column">
            <h4>Product</h4>
            <a href="#features">Features</a>
            <a href="#about">About</a>
          </div>
          <div class="footer-column">
            <h4>Connect</h4>
            <a href="https://github.com/irfannazril"><i class="bi bi-github me-2"></i>GitHub</a>
            <a href="mailto:irfannazrilasdf@gmail.com"><i class="bi bi-envelope me-2"></i>Email</a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 ExTrack. Irfan Nazril.</p>
      </div>
    </div>
  </footer>

  <script src="../assets/js/landing.js"></script>
</body>

</html>