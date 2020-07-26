<?php defined('BASEPATH') or exit('no direct script access allowed');

class Pengembalian extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->wandalibs->_checkLoginSession();
    $this->load->library('wandalibs');
    $this->load->model('m_pengembalian', '_model');
  }

  function index()
  {
    $data['title']                    = 'Jakarta Rent | List Pengembalian';
    $data['breadcumb']                = 'List Pengembalian';
    $data['contents']                 = 'list_pengembalian';
    $data['getAllData']               = $this->_model->getAllData();

    $this->load->view('templates/core', $data);
  }

  // function rincian($order_id)
  // {
  //   $data['title']    = 'Detail Peminjaman';
  //   $data['contents'] = 'detail_peminjaman';
  //   $data['getDataById']    = $this->_model->getDataById($order_id);

  //   $this->load->view('templates/core', $data);
  // }

  function getFotoMobil($mobil_id)
  {
    $data['getFotoMobil'] = $this->_model->getFotoMobil($mobil_id);

    $this->load->view('detail_foto_mobil', $data);
  }

  function getDataPengembalianById()
  {
    $pengembalian_id = htmlspecialchars($this->input->post('pengembalian_id', true));
    if (isset($pengembalian_id) and !empty($pengembalian_id)) {
      $query = $this->_model->getDataPengembalianById($pengembalian_id);
      $output = '';
      foreach ($query as $i) {
        $output .= '
        <table class="table-modal-forward">
        <tr>
          <td width="100px">Nama Mobil</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['nama_user'] . '</td>
        </tr>
        <tr>
          <td width="100px">Tipe</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['nama_mobil'] . '</td>
        </tr>
        <tr>
          <td width="100px">Transmisi</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['tipe'] . '</td>
        </tr>
        <tr>
          <td width="100px">Tahun</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['start_date'] . '</td>
        </tr>
        <tr>
          <td width="100px">Harga</td>
          <td width="50px">:</td>
          <td width="400px">' . $this->wandalibs->_rupiah($i['harga']) . '</td>
        </tr>
      </table>
        <div class="text-center pt-3">
      <img src="' . base_url() . 'assets/img/mobil/' . $i['foto_mobil'] . '" style="width: 200px;" class="img-thumbnail">
        </div>  
      ';
      }
      echo $output;
    } else {
      echo '<p class="text-center text-danger">Data tidak ditemukan</p>';
    }
  }

  function getDataPengById()
  {
    $pengembalian_id = $this->input->post('pengembalian_id');
    if (isset($pengembalian_id) and !empty($pengembalian_id)) {
      $query = $this->_model->getDataPengembalianById($pengembalian_id);
      $output = '';
      foreach ($query as $i) {
        $output .= '
        <table class="table-modal-forward">
         <tr>
          <td width="100px">Nama Peminjam</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['nama_user'] . '</td>
        </tr>
        <tr>
          <td width="100px">Nama Mobil</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['nama_mobil'] . '</td>
        </tr>
        <tr>
          <td width="100px">Tipe</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['tipe'] . '</td>
        </tr>
        <tr>
          <td width="100px">Tanggal Pinjam</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['start_date'] . '</td>
        </tr>
        <tr>
          <td width="100px">Estimasi Tanggal Kembali</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['end_date'] . '</td>
        </tr>
          <tr>
          <td width="100px">Tanggal Kembali</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['create_date'] . '</td>
        </tr>
        <tr>
          <td width="100px">Harga</td>
          <td width="50px">:</td>
          <td width="400px">' . $this->wandalibs->_rupiah($i['harga']) . '</td>
        </tr>
         <tr>
          <td width="100px">Denda</td>
          <td width="50px">:</td>
          <td width="400px">' . $this->wandalibs->_rupiah($i['denda']) . '</td>
        </tr>
      </table>
        <div class="text-center pt-3">
      <img src="' . base_url() . 'assets/img/mobil/' . $i['foto'] . '" style="width: 200px;" class="img-thumbnail">
        </div>  
      ';
      }
      echo $output;
    } else {
      echo '<p class="text-center text-danger">Data tidak ditemukan</p>';
    }
  }

  function getDataById()
  {
    $mobil_id = htmlspecialchars($this->input->post('mobil_id', true));
    if (isset($mobil_id) and !empty($mobil_id)) {
      $query = $this->_model->getDataMobilById($mobil_id);
      $output = '';
      foreach ($query as $i) {
        $output .= '
        <table class="table-modal-forward">
        <tr>
          <td width="100px">Nama Mobil</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['nama'] . '</td>
        </tr>
        <tr>
          <td width="100px">Tipe</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['tipe'] . '</td>
        </tr>
        <tr>
          <td width="100px">Transmisi</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['transmisi'] . '</td>
        </tr>
        <tr>
          <td width="100px">Tahun</td>
          <td width="50px">:</td>
          <td width="400px">' . $i['tahun'] . '</td>
        </tr>
        <tr>
          <td width="100px">Harga</td>
          <td width="50px">:</td>
          <td width="400px">' . $this->wandalibs->_rupiah($i['harga']) . '</td>
        </tr>
      </table>
        <div class="text-center pt-3">
      <img src="' . base_url() . 'assets/img/mobil/' . $i['foto'] . '" style="width: 200px;" class="img-thumbnail">
        </div>  
      ';
      }
      echo $output;
    } else {
      echo '<p class="text-center text-danger">Data tidak ditemukan</p>';
    }
  }
}
