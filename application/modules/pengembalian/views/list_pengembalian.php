<div class="row justify-content-center">
  <div class="col-12 col-sm-6 col-md-6 text-center">
    <?php echo $this->session->flashdata('message'); ?>
  </div>
</div>

<div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('flash'); ?>"></div>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <span class="text-muted one-da-text-tosca"><?php echo $title ?></span>
        </div>
        <div class="card-body table-responsive p-3">
          <table id="example1" class="table table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Nama Admin</th>
                <th>Nama Mobil</th>
                <th>Tipe</th>
                <th>Harga</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($getAllData as $i) :
              ?>
                <tr>
                  <td><small><?php echo $no++ ?></small></td>
                  <td><small><?php echo $i['nama_user'] ?></small></td>
                  <td><small><?php echo $i['nama_admin'] ?></small></td>
                  <td><small><?php echo $i['nama_mobil'] ?></small></td>
                  <td><small><?php echo $i['tipe'] ?></small></td>
                  <td><small><?php echo $this->wandalibs->_rupiah($i['harga']) ?></small></td>
                  <td><small><?php echo $i['create_date'] ?></small></td>
                  <td><small><?php echo $this->wandalibs->_rupiah($i['denda']) ?></small></td>
                  <td>
                    <!-- <button class="btn btn-success btn-xs view_mobil_pengembalian" id="<?= $i['mobil_id'] ?>"><i class="fa fa-search"></i> Detail</button> -->
                    <button class="btn btn-success btn-xs modal_pengembalian" id="<?= $i['pengembalian_id'] ?>"><i class="fa fa-search"></i> Detail</button>
                  </td>
                </tr>
              <?php endforeach; ?>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Pengembalian  -->
<div class="modal fade" id="modal_detail_pengembalian">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-tosca">
        <h4 class="modal-title"> <i class="fa fa-car"></i> Detail Pengembalian</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div id="result_detail_pengembalian"></div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal History transaksi -->
<div class="modal fade" id="modal_detail_mobil">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-tosca">
        <h4 class="modal-title"> <i class="fa fa-car"></i> Detail Pengembalian</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div id="result_detail_mobil"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <div class="modal fade" id="modal_detail_pengembalian">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-tosca">
        <h4 class="modal-title"> <i class="fa fa-car"></i> Detail Pengembalian</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div id="result_detail_pengembalian"></div>
        </div>
      </div>
    </div>
  </div>
</div> -->

<!-- Modal History transaksi -->
<div class="modal fade" id="modal_confirm_delete_mobil">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h4 class="modal-title"> <i class="fa fa-car"></i> Hapus Data Pengembalian</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div id="result_confirm_delete_mobil" class="justify-content-center"></div>
        </div>
      </div>
    </div>
  </div>
</div>