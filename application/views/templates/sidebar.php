<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo base_url() ?>" class="brand-link">
    <img src="<?php echo base_url() ?>/assets/img/logo-jakarta-rent.png" alt="AdminLTE Logo" style="width: 45px;">
    <span class="brand-text font-weight-light" style="font-size: 15px; margin-left: 0px;"> Jakarta Rent</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar text-sm">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <a href="<?php echo base_url('user/profileUser') ?>"><img src="<?php echo base_url('/assets/img/profile-user/') . $this->session->userdata('foto') ?>" class="img-circle elevation-2" alt="User Image"></a>
      </div>
      <div class="info">
        <a href="<?php echo base_url('user/profileUser')  ?>" class="d-block"><?php echo $this->session->userdata('nama') ?></a>
      </div>
    </div>

    <nav class="mt-2 nav-legacy nav-flat">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?php echo base_url('dashboard') ?>" class="nav-link">
            <i class="nav-icon fa fa-signal"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="<?php echo base_url('trans') ?>" class="nav-link">
            <i class="nav-icon fa fa-money-bill-alt"></i>
            <p>Transaksi</p>
          </a>
        </li>

        <li class="nav-header">Master Data</li>
        <li class="nav-item">
          <a href="<?php echo base_url('peminjaman') ?>" class="nav-link">
            <i class="nav-icon far fa-calendar"></i>
            <p>Peminjaman</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('pengembalian') ?>" class="nav-link">
            <i class="nav-icon far fa-calendar"></i>
            <p>Pengembalian</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('mobil') ?>" class="nav-link">
            <i class="nav-icon fa fa-car"></i>
            <p>Mobil</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('user') ?>" class="nav-link">
            <i class="nav-icon fa fa-users"></i>
            <p>User</p>
          </a>
        </li>
        <?php
        if ($this->session->userdata('user_access') == 'administrator') { ?>
          <li class="nav-item">
            <a href="<?php echo base_url('user_admin') ?>" class="nav-link">
              <i class="nav-icon fa fa-user"></i>
              <p>User Admin</p>
            </a>
          </li>
        <?php }
        ?>

        <li class="nav-item">
          <a href="<?php echo base_url('logout/logoutUser') ?>" class="nav-link">
            <i class="nav-icon fas fa-power-off"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>