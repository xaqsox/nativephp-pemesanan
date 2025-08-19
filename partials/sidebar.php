<?php include_once __DIR__."/../config/base_url.php"; ?>
<div class="col-md-2 sidebar p-3 d-none d-md-block" style="background:#f8f9fa;min-height:100vh;">
  
  <?php if ($_SESSION['role'] === 'owner' || $_SESSION['role'] === 'admin'): ?>
    <h6 class="text-muted text-uppercase">Data Master</h6>
    <ul class="nav flex-column mb-3">

      <?php if ($_SESSION['role'] === 'owner'): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>/modules/pengguna/list.php">
            <i class="fas fa-user me-2"></i> Pengguna
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>/modules/kurir/list.php">
            <i class="fas fa-user-plus me-2"></i> Kurir
          </a>
        </li>
      <?php endif; ?>

      <!-- Pelanggan -->
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#menuPelanggan" role="button" aria-expanded="false">
          <i class="fas fa-users me-2"></i> Pelanggan
        </a>
        <div class="collapse ms-3" id="menuPelanggan">
          <a class="nav-link small" href="<?= BASE_URL ?>/modules/pelanggan/list.php">
            <i class="fas fa-angle-right me-1"></i> Data Pelanggan
          </a>
          <a class="nav-link small" href="<?= BASE_URL ?>/modules/jenis_pelanggan/list.php">
            <i class="fas fa-angle-right me-1"></i> Jenis Pelanggan
          </a>
        </div>
      </li>

      <?php if ($_SESSION['role'] === 'owner'): ?>
        <!-- Air Minum -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#menuAir" role="button" aria-expanded="false">
            <i class="fas fa-tint me-2"></i> Air Minum
          </a>
          <div class="collapse ms-3" id="menuAir">
            <a class="nav-link small" href="<?= BASE_URL ?>/modules/air_minum/list.php">
              <i class="fas fa-angle-right me-1"></i> Data Air Minum
            </a>
            <a class="nav-link small" href="<?= BASE_URL ?>/modules/jenis_air_minum/list.php">
              <i class="fas fa-angle-right me-1"></i> Jenis Air Minum
            </a>
          </div>
        </li>
      <?php endif; ?>

    </ul>
  <?php endif; ?>

  <?php if (in_array($_SESSION['role'], ['owner', 'admin', 'pelanggan'])): ?>
    <h6 class="text-muted text-uppercase">Pemesanan</h6>
    <ul class="nav flex-column mb-3">

      <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL ?>/modules/pemesanan/list.php">
          <i class="fas fa-clipboard-list me-2"></i> Pemesanan
        </a>
      </li>

      <?php if ($_SESSION['role'] !== 'pelanggan'): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>/modules/pengiriman/list.php">
            <i class="fas fa-truck me-2"></i> Pengiriman
          </a>
        </li>
      <?php endif; ?>

    </ul>
  <?php endif; ?>

  <?php if (in_array($_SESSION['role'], ['owner', 'admin'])): ?>
    <h6 class="text-muted text-uppercase">Reports</h6>
    <ul class="nav flex-column mb-3">
      <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL ?>/modules/reports/pemesanan.php">
          <i class="fas fa-file-alt me-2"></i> Laporan Pemesanan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL ?>/modules/reports/pengiriman.php">
          <i class="fas fa-file-invoice me-2"></i> Laporan Pengiriman
        </a>
      </li>
    </ul>
  <?php endif; ?>

  <?php if ($_SESSION['role'] === 'kurir'): ?>
    <h6 class="text-muted text-uppercase">Kurir</h6>
    <ul class="nav flex-column mb-3">
      <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL ?>/modules/tracking/index.php">
          <i class="fas fa-map-marker-alt me-2"></i> Tracking
        </a>
      </li>
    </ul>
  <?php endif; ?>

  <hr>

  <!-- Logout -->
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link text-danger" href="<?= BASE_URL ?>/logout.php" onclick="return confirm('Yakin ingin logout?');">
        <i class="fas fa-sign-out-alt me-2"></i> Logout
      </a>
    </li>
  </ul>
</div>
