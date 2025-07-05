<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?= base_url('dashboard') ?>" class="nav-link">Home</a>
        </li>
        <!-- Menu lainnya -->
        <li class="nav-item d-none d-sm-inline-block" style="position: absolute; right: 140px;">
          <a href="<?= site_url('akun') ?>" class="nav-link">
            <i class="fa fa-user success mr-1"> </i>
            <span> Akun</span>
          </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block" style="position: absolute; right: 50px;">
          <a href=" <?php echo base_url('auth/logout'); ?>"
            onclick="return confirm('Konfirmasi logout: Anda harus login ulang setelah logout.');"
            class="nav-link "> <i class="fa fa-sign-out-alt mr-1"></i>
            Logout
          </a>
        </li>

        <!-- Menu lainnya -->
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= base_url('dashboard') ?>" class="brand-link">
        <img src="<?= base_url('assets/template/') ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold" style="color:#F3F7EC;">FreeRADIUS Billing </span>
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <?php
            $foto = $this->session->userdata('foto');
            $foto_path = !empty($foto) ? './uploads/foto_profil/' . htmlspecialchars($foto, ENT_QUOTES, 'UTF-8') : 'assets/template/dist/img/user2-160x160.jpg';
            ?>
            <img src="<?= base_url($foto_path) ?>"
              class="img-circle elevation-2"
              alt="User Image"
              style="object-fit: cover; width: 40px; height: 40px;">
          </div>
          <div class="info">
            <a href="<?= site_url('akun') ?>" class="d-block"><?= $this->session->userdata('username'); ?></a>
          </div>
        </div>





        <!-- Sidebar Menu -->
        <nav class="">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header" style="font-size: 15px; color:#E88D67; "> Home </li>
            <li class="nav-item">
              <a href="<?= base_url('dashboard') ?>"
                class="nav-link <?php if ($this->uri->segment(1) == 'dashboard') echo 'active'; ?>"
                style="<?php if ($this->uri->segment(1) == 'dashboard') echo 'background-color: #6c757d; color: white;'; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-header" style="font-size: 15px; color:#E88D67;"> Radius Manajemen</li>
            <li class="nav-item">
              <a href="<?= base_url('nas') ?>"
                class="nav-link <?php if ($this->uri->segment(1) == 'nas') echo 'active'; ?>"
                style="<?php if ($this->uri->segment(1) == 'nas') echo 'background-color: #6c757d; color: white;'; ?>">
                <i class="nav-icon fas fa-network-wired"></i>
                <p>Nas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('user') ?>"
                class="nav-link <?php if ($this->uri->segment(1) == 'user') echo 'active'; ?>"
                style="<?php if ($this->uri->segment(1) == 'user') echo 'background-color: #6c757d; color: white;'; ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>User</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#"
                class="nav-link <?php if ($this->uri->segment(1) == 'voucher') echo 'active'; ?>"
                style="<?php if ($this->uri->segment(1) == 'voucher') echo 'background-color: #6c757d; color: white;'; ?>"
                <?php if ($this->session->userdata('role') !== 'admin'): ?>
                onclick="event.preventDefault(); showAccessDeniedAlert();"
                <?php else: ?>
                onclick="window.location.href='<?= base_url('voucher') ?>';"
                <?php endif; ?>>
                <i class="fas fa-ticket-alt mr-1"></i>
                <p>Voucher</p>
              </a>
            </li>


            <li class="nav-header" style="font-size: 15px; color:#E88D67;"> Service Plan</li>
            <li class="nav-item">
              <a href="<?= base_url('bandwith') ?>"
                class="nav-link <?php if ($this->uri->segment(1) == 'bandwith') echo 'active'; ?>"
                style="<?php if ($this->uri->segment(1) == 'bandwith') echo 'background-color: #6c757d; color: white;'; ?>">
                <i class="nav-icon fas fa-wifi"></i>
                <p>Bandwith Paket</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('kategori') ?>"
                class="nav-link <?php if ($this->uri->segment(1) == 'kategori') echo 'active'; ?>"
                style="<?php if ($this->uri->segment(1) == 'kategori') echo 'background-color: #6c757d; color: white;'; ?>">
                <i class="nav-icon fas fa-door-open"></i>
                <p>Kategori</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('sesi') ?>"
                class="nav-link <?php if ($this->uri->segment(1) == 'sesi') echo 'active'; ?>"
                style="<?php if ($this->uri->segment(1) == 'sesi') echo 'background-color: #6c757d; color: white;'; ?>">
                <i class="nav-icon fas fa-clock"></i>
                <p>Sesi Waktu</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('site') ?>"
                class="nav-link <?php if ($this->uri->segment(1) == 'site') echo 'active'; ?>"
                style="<?php if ($this->uri->segment(1) == 'site') echo 'background-color: #6c757d; color: white;'; ?>">
                <i class="nav-icon fas fa-thumbtack	"></i>
                <p>Site</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <!-- /.sidebar -->
    </aside>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark"><?= $title ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active"><?= $title ?></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">

          <script>
            function showAccessDeniedAlert() {
              var alertElement = document.getElementById('access-denied-alert');
              alertElement.style.display = 'block';
              alertElement.classList.add('show');

              // Menghilangkan alert setelah 3 detik
              setTimeout(function() {
                alertElement.classList.remove('show');
                alertElement.classList.add('fade');
                setTimeout(function() {
                  alertElement.style.display = 'none';
                }, 700); // Waktu untuk animasi fade out
              }, 3000);
            }
          </script>