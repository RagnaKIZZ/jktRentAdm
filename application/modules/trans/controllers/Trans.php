<?php

use FontLib\Table\Type\post;

defined('BASEPATH') or exit('No direct script access allowed');
class Trans extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->wandalibs->_checkLoginSession();
    $this->load->model('m_trans', '_model');
    $this->load->library('datatables');
    $this->load->library('form_validation');
  }

  function index()
  {
    $data['title']    = 'Jakarta Rent | List Transaksi';
    $data['contents'] = 'list_transaksi';
    $data['getAllTransaksi']  = $this->_model->getAllTransaksi();

    $this->load->view('templates/core', $data);
  }

  function getHistoryTrans()
  {
    $order_id = $this->input->post('order_id');
    if (isset($order_id) and !empty($order_id)) {
      $records = $this->_model->getHistoryTrans($order_id);
      $status = $records['0']['status'];
      $status_order = $records['0']['status_order'];

      // $end_date   = strtotime($records['0']['end_date']);
      // $start_date = strtotime($records['0']['start_date']);
      $today      = time();
      $end_date   = $records['0']['end_date'];
      $start_date = $records['0']['start_date'];
      $diff       = $this->wandalibs->diffByDay($end_date, $start_date);

      if ($status == 0) {
        $status = '
        <span class="btn btn-warning btn-xs"> Belum lunas</span>
        ';
      } elseif ($status == 1) {
        $status = '
        <span class="btn btn-success btn-xs"><i class="fa fa-check"></i> Sudah Lunas</span>
        ';
      } else {
        $status = '
        <span class="btn btn-danger btn-xs">Sudah Dicancel</span>
        ';
      }

      $output = '';

      foreach ($records as $i) {
        $output .= '
        <div class="">
        <table class="table-modal-forward">
          <tr>
            <td width="100px">Nama</td>
            <td width="50px">:</td>
            <td width="400px">' . $i['nama_user'] . '</td>
          </tr>
          <tr>
            <td width="100px">Email</td>
            <td width="50px">:</td>
            <td width="400px">' . $i['email'] . '</td>
          </tr>
          <tr>
            <td width="100px">Mobil</td>
            <td width="50px">:</td>
            <td width="400px">' . $i['nama_mobil'] . '</td>
          </tr>
          <tr>
            <td width="100px">Harga</td>
            <td width="50px">:</td>
            <td width="400px">' . $this->wandalibs->_rupiah($i['harga']) . '&nbsp;' . $status . '</td>
          </tr>
        </table>
        <table class="table-modal-forward">
        <hr>
          <tr>
            <td width="100px">Waktu Order</td>
            <td width="50px">:</td>
            <td width="400px">' . $i['order_date'] . '</td>
          </tr>
          <tr>
            <td width="100px">Mulai Sewa</td>
            <td width="50px">:</td>
            <td width="400px">' . $i['start_date'] . '</td>
          </tr>
          <tr>
            <td width="100px">Pengembalian</td>
            <td width="50px">:</td>
            <td width="400px">' . $i['end_date'] . '</td>
          </tr>
          <tr>
            <td width="100px">Total Waktu</td>
            <td width="50px">:</td>
            <td width="400px">' . $diff . ' Hari</td>
          </tr>
        </table>
      </div>
        ';
      }
      echo $output;
    } else {
      echo '<p class="text-center text-danger">Data tidak ditemukan</p>';
    }
  }

  function showConfirmTrans()
  {
    $order_id = $this->input->post('order_id');
    if (isset($order_id) and !empty($order_id)) {
      $records = $this->_model->getHistoryTrans($order_id);
      $status = $records['0']['status'];

      $output = '';

      foreach ($records as $i) {
        $output .= '
        <div class="">
        <table class="table-modal-forward">
          <tr>
            <td width="100px">Nama</td>
            <td width="50px">:</td>
            <td width="400px">' . $i['nama_user'] . '</td>
          </tr>
          <tr>
            <td width="100px">Email</td>
            <td width="50px">:</td>
            <td width="400px">' . $i['email'] . '</td>
          </tr>
        </table>
        <hr>
        </div>
       
        <p class="text-danger text-center">Apakah ingin dikonfirmasi</p>
        <div class="text-center">
        <a href="' . base_url('trans/confirmTrans/') . $i['order_id'] . '">
          <button class="btn btn-success btn-sm mr-2"><i class="fa fa-check mr-2"></i>Iya</button>
        </a>
          <button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-window-close mr-2"></i>Tidak</button>
        </div>
     
        ';
      }
      echo $output;
    } else {
      echo '<p class="text-center text-danger">Data tidak ditemukan</p>';
    }
  }

  function showConfirmDelete()
  {
    $namaUser = $this->session->userdata('nama');
    $order_id = $this->input->post('order_id');
    if (isset($order_id) and !empty($order_id)) {
      $records = $this->_model->getHistoryTrans($order_id);
      $output = '';

      foreach ($records as $i) {
        $output .= '
        <p class="text-muted text-center">Apakah Anda yakin akan menghapus data transaksi dari ' . $i['email'] . ' ?</p>
        <div class="text-center">
        <a href="' . base_url('trans/cancelTrans/') . $i['order_id'] . '">
          <button class="btn btn-success btn-sm mr-2"><i class="fa fa-check mr-2"></i>Iya</button>
        </a>
          <button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-window-close mr-2"></i>Tidak</button>
        </div>
        ';
      }
      echo $output;
    } else {
      echo '<p class="text-center text-danger">Data tidak ditemukan</p>';
    }
  }

  function cancelTrans($order_id)
  {
    // $this->db->update('tb_order', ['order_id', $order_id]);
    // $this->db->update('tb_transaksi', ['order_id', $order_id]);
    $this->_model->cancelTrans($order_id);
    if (!empty($order_id)) {
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fa fa-check"></i><small><b>Yeay!.</b>Berhasil dicancel</small>
  </div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fa fa-window-close"></i><small><b>Yahh!.</b>Gagal dicancel</small>
  </div>');
    }
    redirect('trans');
  }

  function _getStatusTrans($status)
  {
    $email      = htmlspecialchars($this->input->post('email'), true);
    $query = $this->db->get_where('tb_user_admin', ['email' => $email])->row_array();
    $nama = $query['nama'];
    $status = $query['status'];
    var_dump($status);
    die;

    if ($status == 0) {
      echo '<span class="badge badge-warning"><i class="fa fa-spinner fa-spin"></i> Belum Lunas</span>';
    } elseif ($status == 1) {
      echo '<span class="badge badge-success-"><i class="fa fa-check-square"></i> Lunas</span>';
    } else {
      echo '<span class="badge badge-danger"><i class="fa fa-window-close"> Dibatalkan</i></span>';
    }
  }

  function confirmTrans($order_id)
  {
    // $order_id = htmlspecialchars($this->input->post('order_id', true));
    $this->_model->confirmTrans($order_id);
    if (!empty($order_id)) {
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fa fa-check"></i><small><b>Yeay!.</b>Berhasil dikonfirmasi</small>
  </div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fa fa-check"></i><small><b>Yahh!.</b>Gagal dikonfirmasi</small>
  </div>');
    }

    redirect('trans');
  }


  function tambahTransaksi()
  {
    $this->form_validation->set_rules('nama_user', 'Nama User', 'required');

    if ($this->form_validation->run() == false) {
      $data['title']    = 'Form Tambah Transaksi';
      $data['contents'] = 'form_transaksi';
      $data['getAllDataMobil'] = $this->_model->getAllDataMobil();

      $this->load->view('templates/core', $data);
    } else {


      $nama_user      = htmlspecialchars($this->input->post('nama_user', true));
      $nama_mobil     = htmlspecialchars($this->input->post('nama_mobil', true));
      $mobil_id       = htmlspecialchars($this->input->post('mobil_id', true));
      $jenis_order    = htmlspecialchars($this->input->post('jenis_order', true));
      $start_date     = htmlspecialchars($this->input->post('start_date', true));
      $end_date       = htmlspecialchars($this->input->post('end_date', true));

      $order_id       = htmlspecialchars($this->input->post('order_id', true));



      $dataOrder = [
        'mobil_id'      => $mobil_id,
        'jenis_order'   => $jenis_order,
        'order_date'    => date('Y-m-d H:i:s'),
        'start_date'    => $start_date,
        'end_date'      => $end_date
      ];
      // $this->db->insert('tb_order', $dataOrder);
      $selectMaxIdMobil = $this->_model->selectMaxIdMobil();
      var_dump($selectMaxIdMobil);
      die;

      // $dataTransaksi = [
      //   'oder_id'      => $nama
      //   'user_id'      => $user_id
      //   'metode_pembayaran'      => $metode_pembayaran
      //   'harga'      => $harga
      //   'create_date'      => $nama
      // ];

      //select
      // $dataMobil = [
      //   'status'      => $nama
      // ];
      // $this->db->where('mobil_id', $mobil_id);
      // $this->db->update('tb_mobil');

      // $this->db->insert('tb_transaksi', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <i class="icon fa fa-check"></i><small><b>Yeay!.</b>Data transaksi berhasil disimpan</small>
        </div>');
      redirect('trans');
    }
  }
}
