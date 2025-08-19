<?php include_once __DIR__."/../config/base_url.php"; ?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background:#5D5CDE;">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= BASE_URL ?>/dashboard.php">
      <i class="fas fa-tint me-2"></i>Depot Blok Jambu
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle me-1"></i><?= htmlspecialchars($_SESSION['nama_lengkap']); ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
            <li><hr class="dropdown-divider"></li>
         <li><a class="dropdown-item" href="<?= BASE_URL ?>/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>

          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
