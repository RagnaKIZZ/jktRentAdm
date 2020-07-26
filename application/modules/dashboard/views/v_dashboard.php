<div class="row justify-content-center">
  <div class="col-12 col-sm-6 col-md-6 text-center">
    <?php echo $this->session->flashdata('message'); ?>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 col-sm-6 col-md-3">
      <a href="<?php echo base_url('trans') ?>" class="wan-text-title-dashboard">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="far fa-envelope"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Transaksi</span>
            <span class="info-box-number" style="display: inline;"><?php //echo $getAllPesanPenunjang 
                                                                    ?></span>
            <small class="">Jumlah Transaksi</small>
          </div>
        </div>
      </a>
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
      <a href="<?php echo base_url('peminjaman') ?>" class="wan-text-title-dashboard">
        <div class="info-box">
          <span class="info-box-icon bg-primary"><i class="far fa-envelope"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Peminjaman</span>
            <span class="info-box-number" style="display: inline;"><?php //echo $getAllPesanYanmed 
                                                                    ?></span>
            <small class="">Jumlah Peminjaman</small>
          </div>
        </div>
      </a>
    </div>


    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
      <a href="<?php echo base_url('pengembalian') ?>" class="wan-text-title-dashboard">
        <div class="info-box">
          <span class="info-box-icon bg-danger"><i class="far fa-envelope"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Pengembalian</span>
            <span class="info-box-number" style="display: inline;"><?php //echo $getAllPesanKeperawatan 
                                                                    ?></span>
            <small class="">Jumlah Pengembalian</small>
          </div>
        </div>
      </a>
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
      <a href="<?php echo base_url('user') ?>" class="wan-text-title-dashboard">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="far fa-envelope"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">User</span>
            <span class="info-box-number" style="display: inline;"><?php //echo $getAllPesanUmum 
                                                                    ?></span>
            <small class="">Jumlah User</small>
          </div>
        </div>
      </a>
    </div>
    <!-- /.col -->
  </div>
</div>
<!--/. container-fluid -->