<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Modern Homepage</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .navbar-custom {
      background-color: #f8f9fa;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .navbar-nav .nav-link {
      padding: 0.5rem 1rem;
    }
    .dropdown-menu {
      min-width: 180px;
    }
    .menu-section {
      flex: 0 0 80%;
    }
    .action-section {
      flex: 0 0 20%;
    }
    .search-input {
      width: 150px;
    }
    @media (max-width: 991.98px) {
      .menu-section,
      .action-section {
        flex: 100%;
      }
      .search-input {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<header class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid d-flex flex-wrap justify-content-between align-items-center">
    
    <!-- Logo -->
    <a class="navbar-brand fw-bold text-primary me-4" href="#">Brand</a>

    <!-- Menu Section (80%) -->
    <div class="collapse navbar-collapse menu-section" id="navbarMenu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Services
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Web Design</a></li>
            <li><a class="dropdown-item" href="#">Development</a></li>
            <li><a class="dropdown-item" href="#">SEO</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>

    <!-- Action Section (20%) -->
    <div class="d-flex align-items-center action-section gap-2">
      <input class="form-control form-control-sm search-input" type="search" placeholder="Search">
      <select class="form-select form-select-sm" style="width: 70px;">
        <option selected>EN</option>
        <option>BN</option>
      </select>

      @if (Route::has('login'))
        @auth
          <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary btn-sm">Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm">Register</a>
          @endif
        @endauth
      @endif
    </div>
  </div>
</header>

<!-- Optional: Hero Section -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, #0d6efd, #6610f2);">
  <div class="container">
    <h1 class="display-4 fw-bold">Welcome to Our Website</h1>
    <p class="lead">Your modern Laravel + Bootstrap solution</p>
    <a href="#" class="btn btn-light btn-lg mt-3">Get Started</a>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
