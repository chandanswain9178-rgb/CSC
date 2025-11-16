<?php 
session_start();
$showForm = $_GET['show'] ?? '';
$emailForOTP = $_GET['email'] ?? '';
$identifierForReset = $_GET['identifier'] ?? '';
?>

<?php
// If BizPay hits root with callback params
if (isset($_REQUEST['REFNO']) && isset($_REQUEST['TRNSTATUS'])) {
    require __DIR__ . "/process_recharge.php";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Secure professional business website with login, signup, and services.">
<meta name="author" content="CSC Recharge">
<title>CSC Recharge - Home</title>

<!-- Bootstrap & Font Awesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<!-- Google Sign-In -->
<script src="https://accounts.google.com/gsi/client" async defer></script>

<style>
body { background: #f9fbfe; color: #333; font-family: 'Segoe UI', Tahoma, sans-serif; }
.navbar { background: #0d6efd; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.navbar-brand, .nav-link { color: #fff !important; font-weight: 500; }
.navbar .btn { background: #ffc107; border: none; font-weight: 600; color: #000; }
.hero { min-height: 90vh; display: flex; align-items: center; justify-content: center; text-align: center;
        background: linear-gradient(rgba(13,110,253,0.75), rgba(13,110,253,0.75)),
        url('https://source.unsplash.com/1600x900/?technology,office') no-repeat center center/cover;
        color: #fff; padding: 40px; }
.hero h1 { font-size: 3rem; font-weight: 700; }
.section { padding: 80px 20px; }
.section h2 { color: #0d6efd; margin-bottom: 20px; }
.service-card { background: #fff; border-radius: 12px; padding: 30px; border: 1px solid #e9ecef; transition: all 0.3s ease; height: 100%; }
.service-card:hover { transform: translateY(-6px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
.form-section { padding: 60px 20px; background: #f1f5f9; border-radius: 12px; margin-bottom: 40px; }
footer { background: #0d6efd; color: #fff; padding: 20px 10px; text-align: center; margin-top: 40px; }
footer a { color: #ffc107; text-decoration: none; font-weight: 500; }
footer a:hover { text-decoration: underline; }
.modal.show.d-block { background: rgba(0,0,0,0.5); }
.modal-header { border-bottom:none; }
.modal-footer { border-top:none; }
/* Carousel */
.recharge-carousel-wrapper { overflow: hidden; position: relative; padding-bottom: 10px;
  mask-image: linear-gradient(to right, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 10%, rgba(0,0,0,1) 90%, rgba(0,0,0,0) 100%);
  -webkit-mask-image: linear-gradient(to right, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 10%, rgba(0,0,0,1) 90%, rgba(0,0,0,0) 100%);
}
.recharge-carousel { display: flex; gap: 1rem; flex-wrap: nowrap; animation: scroll 10s linear infinite; }
.carousel-item-card { position: relative; min-width: 200px; flex: 0 0 auto; border-radius: 12px; overflow: hidden; transition: transform 0.3s ease; }
.carousel-item-card img { width: 100%; height: 150px; object-fit: cover; display: block; }
.carousel-item-card:hover { transform: scale(1.05); }
.carousel-overlay { position: absolute; bottom: 0; width: 100%; padding: 6px; background: rgba(0,0,0,0.5); color: #fff; text-align: center; font-weight: 600; font-size: 0.9rem; border-top-left-radius: 6px; border-top-right-radius: 6px; }
@keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
</style>
</head>
<body>
       
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">CSC Recharge</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="#privacy">Privacy</a></li>
        <li class="nav-item"><button class="btn btn-warning btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login / Signup</button></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section id="home" class="hero">
  <div class="container hero-content">
    <h1>Welcome to CSC Recharge</h1>
    <p class="lead">Fast, Secure & Reliable Business Solutions</p>
    <button class="btn btn-light btn-lg mt-3 fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal">Get Started</button>
  </div>
</section>

<!-- OTP / New Password Modals -->
<?php if($showForm === 'otp' && $emailForOTP): ?>
<div class="modal show d-block" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <h5 class="modal-title mb-3 text-center">Verify OTP</h5>
      <p class="text-center">OTP sent to Email & WhatsApp — Enter <strong>either</strong> Email OTP or Mobile OTP</p>
      <form action="auth.php" method="post">
        <input type="hidden" name="action" value="verify_otp">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($emailForOTP); ?>">
        <div class="mb-3"><input type="text" name="email_otp" class="form-control" placeholder="Email OTP (or leave blank)" ></div>
        <div class="mb-3"><input type="text" name="mobile_otp" class="form-control" placeholder="Mobile OTP (or leave blank)"></div>
        <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<?php if($showForm === 'verify_reset' && $identifierForReset): ?>
<div class="modal show d-block" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <h5 class="modal-title mb-3 text-center">Verify OTP</h5>
      <p class="text-center">OTP sent to the chosen method. Enter the OTP below:</p>
      <form action="auth.php" method="post">
        <input type="hidden" name="action" value="verify_reset_otp">
        <input type="hidden" name="identifier" value="<?php echo htmlspecialchars($identifierForReset); ?>">
        <div class="mb-3"><input type="text" name="otp" class="form-control" placeholder="Enter OTP" required></div>
        <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<?php if($showForm === 'new_password'): ?>
<div class="modal show d-block" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <h5 class="modal-title mb-3 text-center">Set New Password</h5>
      <form action="auth.php" method="post">
        <input type="hidden" name="action" value="set_new_password">
        <div class="mb-3"><input type="password" name="new_password" class="form-control" placeholder="New Password" required></div>
        <button type="submit" class="btn btn-success w-100">Set Password</button>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Login / Signup Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="modal-header d-flex justify-content-between">
        <div>
          <button id="showSignupBtn" class="btn btn-success btn-sm">Signup</button>
          <button id="showLoginBtn" class="btn btn-primary btn-sm">Login</button>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Signup Form -->
        <form id="signupForm" action="auth.php" method="post">
          <input type="hidden" name="action" value="signup">
          <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div>
          <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
          <div class="mb-3"><input type="text" name="mobile" class="form-control" placeholder="Mobile (10 digits)" required></div>
          <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
          <button type="submit" class="btn btn-success w-100">Signup</button>
        </form>

        <!-- Login Form -->
        <form id="loginForm" action="auth.php" method="post" class="d-none">
          <input type="hidden" name="action" value="login">
          <div class="mb-3"><input type="text" name="identifier" class="form-control" placeholder="Email or Mobile" required></div>
          <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <!-- Google Sign-In Button -->
        <div id="g_id_onload"
             data-client_id="850238488509-2240mj9rprpe3867v3uigkjrfh2ucvsp.apps.googleusercontent.com"
             data-auto_prompt="false"
             data-callback="handleCredentialResponse">
        </div>
        <div class="g_id_signin" data-type="standard"></div>

        <div class="text-center mt-3">
          <a href="#" data-bs-toggle="modal" data-bs-target="#forgotModal" data-bs-dismiss="modal">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Forgot Password Modal (unchanged) -->
<div class="modal fade" id="forgotModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title">Forgot Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="auth.php" method="post">
          <input type="hidden" name="action" value="forgot_password">
          <div class="mb-3"><input type="text" name="identifier" class="form-control" placeholder="Email or Mobile" required></div>
          <button type="submit" class="btn btn-warning w-100">Send OTP</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Sections: About, Services, Contact -->
<!-- About Section -->
<section id="about" class="section">
  <div class="container text-center">
    <h2>About Us</h2>
    <p>CSC Recharge provides professional recharge & online business solutions for your company.</p>
  </div>
</section>

<!-- Services Section -->
<section id="services" class="section" style="position: relative; background: #f0f4f8; padding:80px 0;">
  <div class="container">
    <h2 class="text-center mb-5" style="color:#0d6efd;">Our Recharge Portal</h2>

    <!-- Responsive Auto-scroll Carousel -->
    <div class="recharge-carousel-wrapper mb-5">
      <div class="recharge-carousel">

        <!-- Mobile Images (8) -->
        <a href="#mobileRecharge" class="carousel-item-card">
          <div class="carousel-overlay">Mobile Recharge</div>
          <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=400&q=80" alt="Mobile Recharge">
        </a>
        <a href="#mobileRecharge" class="carousel-item-card">
          <div class="carousel-overlay">Mobile Recharge</div>
          <img src="https://4.imimg.com/data4/BS/PL/MY-12125897/greenadd-500x500.png" alt="Mobile Recharge">
        </a>
        <a href="#mobileRecharge" class="carousel-item-card">
          <div class="carousel-overlay">Mobile Recharge</div>
          <img src="https://digishopeservices.in/webassets/mobile-recharge.jpg" alt="Mobile Recharge">
        </a>
        <a href="#mobileRecharge" class="carousel-item-card">
          <div class="carousel-overlay">Mobile Recharge</div>
          <img src="https://payalmultirecharge.in/new/assets/images/jnt/banner-1.png" alt="Mobile Recharge">
        </a>
        <a href="#mobileRecharge" class="carousel-item-card">
          <div class="carousel-overlay">Mobile Recharge</div>
          <img src="https://digishopeservices.in/webassets/DTH.jpg" alt="Mobile Recharge">
        </a>
        <a href="#mobileRecharge" class="carousel-item-card">
          <div class="carousel-overlay">Mobile Recharge</div>
          <img src="https://1.bp.blogspot.com/-5dbdORN29eU/XxOCBykCaqI/AAAAAAAAA5E/GmWln57UiosW-IR67FlqURyPLyfA22nGwCLcBGAsYHQ/w1200-h630-p-k-no-nu/1%2BZED%2BRECHARGE%2BPLAN%2BFREE.jpg" alt="Mobile Recharge">
        </a>
        <a href="#mobileRecharge" class="carousel-item-card">
          <div class="carousel-overlay">Mobile Recharge</div>
          <img src="https://4.imimg.com/data4/RF/BN/ANDROID-43842142/product-500x500.jpeg" alt="Mobile Recharge">
        </a>
        <a href="#mobileRecharge" class="carousel-item-card">
          <div class="carousel-overlay">Mobile Recharge</div>
          <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=400&q=80" alt="Mobile Recharge">
        </a>

        <!-- DTH Images (8) -->
        <a href="#dthRecharge" class="carousel-item-card">
          <div class="carousel-overlay">DTH Recharge</div>
          <img src="https://images.unsplash.com/photo-1605902711622-cfb43c443e3e?auto=format&fit=crop&w=400&q=80" alt="DTH Recharge">
        </a>
        <a href="#dthRecharge" class="carousel-item-card">
          <div class="carousel-overlay">DTH Recharge</div>
          <img src="https://images.unsplash.com/photo-1581092917332-4b6f0f6b5b44?auto=format&fit=crop&w=400&q=80" alt="DTH Recharge">
        </a>
        <a href="#dthRecharge" class="carousel-item-card">
          <div class="carousel-overlay">DTH Recharge</div>
          <img src="https://images.unsplash.com/photo-1603118036945-1b4cd6f52f4e?auto=format&fit=crop&w=400&q=80" alt="DTH Recharge">
        </a>
        <a href="#dthRecharge" class="carousel-item-card">
          <div class="carousel-overlay">DTH Recharge</div>
          <img src="https://images.unsplash.com/photo-1592754711500-41716c7fa7c6?auto=format&fit=crop&w=400&q=80" alt="DTH Recharge">
        </a>
        <a href="#dthRecharge" class="carousel-item-card">
          <div class="carousel-overlay">DTH Recharge</div>
          <img src="https://images.unsplash.com/photo-1618573845484-9283f109b94e?auto=format&fit=crop&w=400&q=80" alt="DTH Recharge">
        </a>
        <a href="#dthRecharge" class="carousel-item-card">
          <div class="carousel-overlay">DTH Recharge</div>
          <img src="https://images.unsplash.com/photo-1612831455544-0d5dc2fc5f2c?auto=format&fit=crop&w=400&q=80" alt="DTH Recharge">
        </a>
        <a href="#dthRecharge" class="carousel-item-card">
          <div class="carousel-overlay">DTH Recharge</div>
          <img src="https://images.unsplash.com/photo-1611111980177-4f5f20d6e028?auto=format&fit=crop&w=400&q=80" alt="DTH Recharge">
        </a>
        <a href="#dthRecharge" class="carousel-item-card">
          <div class="carousel-overlay">DTH Recharge</div>
          <img src="https://images.unsplash.com/photo-1611192078882-6c8e7e799b4d?auto=format&fit=crop&w=400&q=80" alt="DTH Recharge">
        </a>

        <!-- Wallet Images (8) -->
        <a href="#walletTopup" class="carousel-item-card">
          <div class="carousel-overlay">Wallet Top-up</div>
          <img src="https://images.unsplash.com/photo-1556742400-b5c53b53e65a?auto=format&fit=crop&w=400&q=80" alt="Wallet Top-up">
        </a>
        <a href="#walletTopup" class="carousel-item-card">
          <div class="carousel-overlay">Wallet Top-up</div>
          <img src="https://images.unsplash.com/photo-1555529669-8d6b7f69a1d0?auto=format&fit=crop&w=400&q=80" alt="Wallet Top-up">
        </a>
        <a href="#walletTopup" class="carousel-item-card">
          <div class="carousel-overlay">Wallet Top-up</div>
          <img src="https://images.unsplash.com/photo-1603791440384-56cd371ee9a7?auto=format&fit=crop&w=400&q=80" alt="Wallet Top-up">
        </a>
        <a href="#walletTopup" class="carousel-item-card">
          <div class="carousel-overlay">Wallet Top-up</div>
          <img src="https://images.unsplash.com/photo-1605902711587-2a9f3f9e5f84?auto=format&fit=crop&w=400&q=80" alt="Wallet Top-up">
        </a>
        <a href="#walletTopup" class="carousel-item-card">
          <div class="carousel-overlay">Wallet Top-up</div>
          <img src="https://images.unsplash.com/photo-1612831455554-98dc2fc5f3a2?auto=format&fit=crop&w=400&q=80" alt="Wallet Top-up">
        </a>
        <a href="#walletTopup" class="carousel-item-card">
          <div class="carousel-overlay">Wallet Top-up</div>
          <img src="https://images.unsplash.com/photo-1611111980180-3f5f20d6e039?auto=format&fit=crop&w=400&q=80" alt="Wallet Top-up">
        </a>
        <a href="#walletTopup" class="carousel-item-card">
          <div class="carousel-overlay">Wallet Top-up</div>
          <img src="https://images.unsplash.com/photo-1611192078885-7c8e7e799b5e?auto=format&fit=crop&w=400&q=80" alt="Wallet Top-up">
        </a>
        <a href="#walletTopup" class="carousel-item-card">
          <div class="carousel-overlay">Wallet Top-up</div>
          <img src="https://images.unsplash.com/photo-1611292078885-8c8e7e799b6f?auto=format&fit=crop&w=400&q=80" alt="Wallet Top-up">
        </a>

      </div>
    </div>

    <!-- Service Cards (keep as before) -->
    <div class="row g-4 text-center">
      <div class="col-md-4">
        <div class="service-card h-100 shadow-sm" id="mobileRecharge" style="background: linear-gradient(145deg,#4facfe,#00f2fe); color:#fff;">
          <i class="fas fa-mobile-alt fa-3x mb-3 text-white"></i>
          <h5>Mobile Recharge</h5>
          <p>Instant recharge for all major operators with secure payment options.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-card h-100 shadow-sm" id="dthRecharge" style="background: linear-gradient(145deg,#43e97b,#38f9d7); color:#fff;">
          <i class="fas fa-tv fa-3x mb-3 text-white"></i>
          <h5>DTH Recharge</h5>
          <p>Fast & reliable DTH recharge service for multiple providers.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-card h-100 shadow-sm" id="walletTopup" style="background: linear-gradient(145deg,#fbc2eb,#a6c1ee); color:#fff;">
          <i class="fas fa-wallet fa-3x mb-3 text-white"></i>
          <h5>Wallet Top-up</h5>
          <p>Recharge your wallet instantly and manage funds efficiently.</p>
        </div>
      </div>
    </div>
  </div>
<style>
/* Responsive Auto-scroll Carousel with Fade Edges */
.recharge-carousel-wrapper {
  overflow: hidden;
  position: relative;
  padding-bottom: 10px;

  /* Fade edges for professional look */
  mask-image: linear-gradient(to right, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 10%, rgba(0,0,0,1) 90%, rgba(0,0,0,0) 100%);
  -webkit-mask-image: linear-gradient(to right, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 10%, rgba(0,0,0,1) 90%, rgba(0,0,0,0) 100%);
}

.recharge-carousel {
  display: flex;
  gap: 1rem;
  flex-wrap: nowrap;
  animation: scroll 10s linear infinite; /* FAST scroll: 10s per cycle */
}

.carousel-item-card {
  position: relative;
  min-width: 200px;
  flex: 0 0 auto;
  border-radius: 12px;
  overflow: hidden;
  transition: transform 0.3s ease;
}

.carousel-item-card img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  display: block;
}

.carousel-item-card:hover {
  transform: scale(1.05);
}

.carousel-overlay {
  position: absolute;
  bottom: 0;
  width: 100%;
  padding: 6px;
  background: rgba(0,0,0,0.5);
  color: #fff;
  text-align: center;
  font-weight: 600;
  font-size: 0.9rem;
  border-top-left-radius: 6px;
  border-top-right-radius: 6px;
}

@keyframes scroll {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
</style>

<!-- Contact Section -->
<section id="contact" class="section form-section">
  <div class="container">
    <h2 class="text-center mb-5">Contact Us</h2>
    <form id="contactForm" method="post">
      <input type="hidden" name="action" value="contact">
      <div class="row g-3">
        <div class="col-md-4"><input type="text" name="name" class="form-control" placeholder="Name" required></div>
        <div class="col-md-4"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <div class="col-md-4"><input type="text" name="mobile" class="form-control" placeholder="Mobile" required></div>
      </div>
      <div class="mt-3"><textarea name="message" class="form-control" rows="4" placeholder="Your Message" required></textarea></div>
      <button type="submit" class="btn btn-primary mt-3 w-100">Send Message</button>
      <div id="contactResult" class="mt-2 text-center"></div>
    </form>
  </div>
</section>
    <!-- 🧾 Terms & Conditions Section -->
<section id="terms" class="section bg-light">
  <div class="container">
    <h2 class="text-center text-primary mb-4">Terms & Conditions</h2>
    <p>
      Welcome to CSC Recharge. By accessing or using our services, you agree to be bound by the following terms and conditions.
    </p>
    <ul>
      <li>All users must provide accurate personal details during signup and transactions.</li>
      <li>Unauthorized use of our platform, including fraudulent activities, is strictly prohibited.</li>
      <li>All recharges and services are processed based on data entered by the user. CSC Recharge will not be responsible for errors due to incorrect input.</li>
      <li>Users are responsible for maintaining the confidentiality of their account credentials.</li>
      <li>We reserve the right to modify or terminate services at any time without prior notice.</li>
      <li>Use of our platform indicates acceptance of these terms and any future amendments.</li>
    </ul>
  </div>
</section>

<!-- 💳 Refund & Cancellation Policy Section -->
<section id="refund" class="section">
  <div class="container">
    <h2 class="text-center text-primary mb-4">Refund & Cancellation Policy</h2>
    <p>
      CSC Recharge ensures secure and instant transactions. However, due to the nature of digital services, refunds are limited to specific cases as outlined below:
    </p>
    <ul>
      <li>Refunds are applicable only if the recharge or payment fails and the amount is not credited to the intended account/operator.</li>
      <li>If a transaction is marked “Successful” by the operator, no refund will be issued.</li>
      <li>For failed transactions, the refund will be processed automatically within 5–7 working days.</li>
      <li>Cancellations are not permitted once a recharge or payment request has been initiated.</li>
      <li>In case of any discrepancy, users must contact support with transaction details within 48 hours.</li>
      <li>All refunds will be credited to the original payment source.</li>
    </ul>
  </div>
</section
<!-- Privacy Policy Section -->
<section id="privacy" class="section" style="background:#f9fbfe; padding:80px 20px;">
  <div class="container">
    <h2 class="text-center mb-4" style="color:#0d6efd;">Privacy Policy</h2>
    <div class="mx-auto" style="max-width:800px; text-align:justify;">
      <p>
        At <strong>CSC Recharge</strong>, we respect your privacy and are committed to protecting your personal information.
        This Privacy Policy outlines how we collect, use, and protect the data you share with us.
      </p>
      <h5 class="mt-4">1. Information We Collect</h5>
      <p>
        We collect personal details such as your name, email, mobile number, and login credentials when you register or use our services.
      </p>

      <h5 class="mt-4">2. How We Use Your Information</h5>
      <p>
        Your information is used to provide and improve our services, process transactions, send notifications, and enhance user experience.
      </p>

      <h5 class="mt-4">3. Data Security</h5>
      <p>
        We implement strict security measures to protect your data against unauthorized access, alteration, or disclosure.
      </p>

      <h5 class="mt-4">4. Third-Party Services</h5>
      <p>
        Our website may use third-party APIs (like Google Sign-In or payment gateways). These third parties have their own privacy policies.
      </p>

      <h5 class="mt-4">5. Cookies</h5>
      <p>
        We use cookies to improve website functionality and user experience. You may disable cookies in your browser settings if preferred.
      </p>

      <h5 class="mt-4">6. Your Consent</h5>
      <p>
        By using our website, you consent to our Privacy Policy and agree to the collection and use of your information as described.
      </p>

      <h5 class="mt-4">7. Contact Us</h5>
      <p>
        If you have any questions about this Privacy Policy, please contact us at 
        <a href="mailto:service.cscrecharge@gmail.com">service.cscrecharge@gmail.com</a>.
      </p>
    </div>
  </div>
</section>
<!-- Google Maps Location Section -->
<section id="location" class="section bg-light">
  <div class="container text-center mb-4">
    <h2>Our Office Location</h2>
    <p>At-Manikunda, PO-Manatir, Dist-Kendrapara, Odisha, India, Pin Code-754212</p>
    <div style="width: 100%; height: 350px; border-radius: 10px; overflow: hidden;">
      <iframe 
        src="https://www.google.com/maps?q=Manikunda,Kendrapara,Odisha,India&output=embed"
        width="100%" 
        height="100%" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</section>


<!-- Footer -->
<footer>
  <p>&copy; 2025 CSC Recharge | All Rights Reserved</p>
  <p>
    <strong>Business Name:</strong> CSC Recharge Pvt. Ltd. | 
    <strong>Location:</strong> At-Manikunda, PO-Manatir, Dist-Kendrapara, Odisha, India,Pin Code-754212
  </p>
  <p>
    <strong>Owner:</strong> Chandan Swain | 
    <strong>Mobile:</strong> 9090384159 | 
    <strong>Email:</strong> chandanswain9178@gmail.com
  </p>
  <p>
    <a href="#privacy">Privacy Policy</a> | 
    <a href="#terms">Terms & Conditions</a>
  </p>
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const signupBtn = document.getElementById('showSignupBtn');
  const loginBtn = document.getElementById('showLoginBtn');
  const signupForm = document.getElementById('signupForm');
  const loginForm = document.getElementById('loginForm');

  signupBtn.addEventListener('click', function() {
    signupForm.classList.remove('d-none');
    loginForm.classList.add('d-none');
    signupBtn.classList.add('btn-success'); signupBtn.classList.remove('btn-outline-success');
    loginBtn.classList.add('btn-outline-primary'); loginBtn.classList.remove('btn-primary');
  });

  loginBtn.addEventListener('click', function() {
    loginForm.classList.remove('d-none');
    signupForm.classList.add('d-none');
    loginBtn.classList.add('btn-primary'); loginBtn.classList.remove('btn-outline-primary');
    signupBtn.classList.add('btn-outline-success'); signupBtn.classList.remove('btn-success');
  });

  signupBtn.classList.add('btn-success');
  loginBtn.classList.add('btn-outline-primary');

  // Contact Form AJAX
  $("#contactForm").submit(function(e){
    e.preventDefault();
    var form = $(this);
    $.post("auth.php", form.serialize(), function(response){
      $("#contactResult").html(response);
      form.trigger("reset");
    });
  });
});

// Google Sign-In Response
function handleCredentialResponse(response) {
  fetch('auth.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({ action: 'google_login', credential: response.credential })
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      window.location.href = data.redirect;
    } else {
      alert('❌ ' + data.message);
    }
  })
  .catch(err => alert('❌ Unexpected Error: ' + err.message));
}
</script>


</body>
</html>
