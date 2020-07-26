<?php defined('BASEPATH') or exit('No direct script access allowed');
class Logout extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
  }

  function logoutUser()
  {
    $email  = $this->session->userdata('email');
    $query  = $this->db->get_where('tb_user', ['email' => $email])->row_array();
    $dataSession = [
      'id'        => $query['id'],
      'email'     => $query['email'],
      'nama'      => $query['nama'],
      'no_hp'      => $query['no_hp'],
      'foto'      => $query['foto'],
      'nama'      => $query['nama'],
      'user_access' => $query['user_access']
    ];
    $this->session->unset_userdata('id');
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('nama');
    $this->session->unset_userdata('no_hp');
    $this->session->unset_userdata('foto');
    $this->session->unset_userdata('date_created');
    $this->session->unset_userdata('user_access');
    // $this->session->unset_userdata($dataSession);
    // $this->session->sess_destroy($dataSession);
    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
              <i class="nc-icon nc-simple-remove"></i>
            </button>
            <span><small><b>Terimakasih - </b> Anda telah berhasil logout </span></small>
          </div>');
    redirect('auth/login');
  }
}
