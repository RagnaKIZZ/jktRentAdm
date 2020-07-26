<div class="row justify-content-center">
  <div class="col-12 col-sm-6 col-md-6 text-center">
    <?php echo $this->session->flashdata('message'); ?>
  </div>
</div>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-4">
      <div class="card card-info">
        <div class="card-header bg-tosca">
        </div>
        <?php foreach ($getDataById as $i) : ?>
          <div class="col-md-12">
            <div class="card-body">
              <form role="form" action="<?php echo base_url('peminjaman/insertPengembalian') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="order_id" value="<?php echo $i['order_id'] ?>">
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label class="text-sm mb-0">Nama User</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukan Nama User" value="<?php echo $i['nama_user'] ?>" readonly>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label class="text-sm mb-0">Mobil yang disewa</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo $i['nama_mobil'] ?>" readonly>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label class="text-sm mb-0">Tanggal Pinjam</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo $i['start_date'] ?>" readonly>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label class="text-sm mb-0">Estimasi Tanggal Pengembalian</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo $i['end_date'] ?>" readonly>
                  </div>
                </div>
                <!-- <div class="col-sm-12">
                  <div class="form-group input-group-sm ml-4">
                    <input class="form-check-input" type="checkbox" name="">
                    <label class="form-check-label">Konfirmasi</label>
                  </div>
                </div> -->

                <div class="col-sm-12">
                  <div class="modal-footer pull-right">
                    <button type="submit" class="btn btn-tosca btn-outline-light">Kembalikan</button>
                  </div>
                </div>
              </form>
              <!-- <a href="<?php echo base_url('peminjaman') ?>">
                <button class="btn btn-danger btn-outline-light">Kembali</button>
              </a> -->
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>