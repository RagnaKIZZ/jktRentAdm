<?php

use FontLib\Table\Type\post;

defined('BASEPATH') or exit('no direct script access allowed');

class Peminjaman extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->wandalibs->_checkLoginSession();
    $this->load->library('wandalibs');
    $this->load->model('m_peminjaman', '_model');
  }

  function index()
  {
    $data['title']                    = 'Jakarta Rent | List Peminjaman';
    $data['breadcumb']                = 'List Peminjaman';
    $data['contents']                 = 'list_peminjaman';
    $data['getAllData']               = $this->_model->getAllData();
    $this->load->view('templates/core', $data);
  }

  function rincian($order_id)
  {
    $data['title']    = 'Detail Peminjaman';
    $data['contents'] = 'detail_peminjaman';
    $data['getDataById']    = $this->_model->getDataById($order_id);

    $this->load->view('templates/core', $data);
  }

  function konfirmasi($order_id)
  {
    $data['title']    = 'Detail Peminjaman';
    $data['contents'] = 'konfirmasi';
    $data['getDataById']    = $this->_model->getDataById($order_id);

    $this->load->view('templates/core', $data);
  }

  function updateKonfirmasi()
  {
    $order_id   = htmlspecialchars($this->input->post('order_id', true));
    $konfirmasi = htmlspecialchars($this->input->post('konfirmasi', true));
    $this->db->set('relasi_tabel', $konfirmasi);
    $this->db->where('order_id', $order_id);
    $this->db->update('order_id');
  }

  function insertPengembalian()
  {
    $order_id =
      htmlspecialchars($this->input->post('order_id', true));
    $admin_id = $this->session->userdata('id');
    if (isset($order_id) and !empty($order_id)) {
      $record = $this->_model->getDataById($order_id);


      foreach ($record as $i) {
        $denda = $this->getDenda($i['end_date']);
        $data = [
          'order_id' => $order_id,
          'admin_id' => $admin_id,
          'user_id' => $i['user_id'],
          'create_date' => date('Y-m-d H:i:s', time()),
          'denda' => $denda
        ];
        $this->db->set('status', 2);
        $this->db->where('order_id', $order_id);
        $this->db->update('tb_order');
        $this->db->insert('tb_pengembalian', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fa fa-check"></i><small><b>Yeay!.</b>Berhasil dikembalikan</small>
  </div>');
      }
    } else {
      // $data = $this->_model->getDataById($order_id);
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fa fa-window-close"></i><small><b>Yahh!.</b>Gagal dicancel</small>
  </div>');
    }
    redirect('peminjaman');
  }

  function getDenda($endDate)
  {
    $thisTime = time();
    $end_date = strtotime($endDate);
    $total = $thisTime - $end_date;
    $diff = round($total / (60 * 60));
    $denda = $diff * 30000;
    if ($total > 0) {
      return $denda;
    } else {
      return 0;
    }
  }
}
