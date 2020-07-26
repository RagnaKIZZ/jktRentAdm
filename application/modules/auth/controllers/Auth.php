<?php defined('BASEPATH') or exit('no direct script access allowed');

class Auth extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->wandalibs->redirectLoginExist();
  }

  function login()
  {
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email', [
      'required'        => '*email harus diisi',
      'valid_email'     => '*format email tidak sesuai'
    ]);
    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]', [
      'required'    => '*password belum diisi',
      'min_length'   => '*password kurang dari 6 karakter'
    ]);

    if ($this->form_validation->run() == false) {
      $data['title']      = 'Jakarta Rent | Login';
      $data['contents']   = 'login';

      $this->load->view('login', $data);
    } else {
      $this->wandalibs->_loginProcess();
    }
  }

  function pageVerifikasiAkun()
  {
    //   $email = $this->input->get('email');
    //   $token = $this->input->get('token');
    //   $query = $this->db->get_where('form_token', ['token' => $token])->row_array();

    //   if ($token != $query['token']) {
    //     $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
    //     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    //     <i class="icon fa fa-exclamation-triangle"></i><small><b>Ups!.</b>Email ' . $email . ' sudah diverifkasi sebelumnya</small>
    //   </div>');
    //     redirect('auth/pageBlocked');
    //   }
    //   if ($email != $query['email']) {
    //     $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
    //     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    //     <i class="icon fa fa-exclamation-triangle"></i><small><b>Ups!.</b>Email ' . $email . ' sudah tidak terdaftar</small>
    //   </div>');
    //     redirect('auth/pageBlocked');
    //   } else {
    //     $this->db->set('active', 'aktif');
    //     $this->db->where('email', $email);
    //     $this->db->update('tb_user_admin');
    //     $data['title']    = 'Selamat Datang';
    //     $data['getEmail'] = $this->db->get_where('tb_user_admin', ['email' => $email])->row_object();
    //     $this->load->view('v_verifikasi', $data);
    //   }
    // $this->pageBlocked();
    redirect(base_url());
  }

  function loginFirstTime()
  {
    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]', [
      'required'    => '*password belum diisi',
      'min_length'   => '*password kurang dari 6 karakter'
    ]);

    if ($this->form_validation->run() == false) {
      $data['title']      = 'Jakarta Rent | Login';
      redirect('' . $_SERVER['HTTP_REFERER'] . '');
      $this->load->view('v_verifikasi', $data);
    } else {
      $this->wandalibs->_loginProcessFirstTime();
    }
  }

  function pageBlocked()
  {
    $this->load->view('v_blocked');
  }

  function registerUser()
  {
    // $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required', [
    //   'required'    => '*Nama lengkap wajib diisi'
    // ]);
    // $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tb_user_admin.email]', [
    //   'required'    => '*Email wajib diisi',
    //   'valid_email' => '*Email tidak valid',
    //   'is_unique'   => '*Email sudah terdaftar'
    // ]);
    // $this->form_validation->set_rules('bidang', 'Bidang', 'required', [
    //   'required'    => '*Bidang user wajib diisi'
    // ]);
    // $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[password2]', [
    //   'required'    => '*Password wajib diisi',
    //   'min_length'  => '*Password minimal 6 karakter',
    //   'matches'     => '*Password tidak sama'
    // ]);
    // $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[6]|matches[password]', [
    //   'required'    => '*Password wajib diisi',
    //   'min_length'  => '*Password minimal 6 karakter',
    //   'matches'     => '*Password tidak sama'
    // ]);
    // $this->form_validation->set_rules('terms', 'Ketentuan', 'required', [
    //   'required'    => '*Ketentuan belum di checklist'
    // ]);

    // if ($this->form_validation->run() == false) {

    //   $data['title']      = 'Jakarta Rent | Register';
    //   $data['breadcumb']  = 'Form Register User';
    //   $data['contents']   = 'form_register';

    //   $this->load->view('form_register', $data);
    // } else {
    //   $nama         = htmlspecialchars($this->input->post('nama', true));
    //   $email        = htmlspecialchars($this->input->post('email', true));
    //   $bidang       = htmlspecialchars($this->input->post('bidang', true));
    //   $password     = password_hash($this->input->post('password', true), PASSWORD_DEFAULT);

    //   $data = [
    //     'nama'        => $nama,
    //     'email'       => $email,
    //     'password'    => $password,
    //     'bidang'      => $bidang,
    //     'user_access' => 'user',
    //     'foto'        => 'default-avatar.png',
    //     'password'    => $password,
    //     'date_created' => time(),
    //     'active'      => 'tidak aktif'
    //   ];

    //   $token = $this->wandalibs->_getToken(32);
    //   $dataToken = [
    //     'nama'              => $nama,
    //     'email'             => $email,
    //     'token'             => $token,
    //     'date_created'      => time()
    //   ];
    //   $this->wandalibs->_sendEmail($token, 'verify');
    //   $this->db->insert('form_token', $dataToken);
    //   $this->db->insert('tb_user_admin', $data);
    //   $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    //   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    //   <i class="icon fa fa-check"></i><small><b>Berhasil.</b>Silahkan cek email ' . $email . ' untuk proses verifikasi</small>
    // </div>');
    redirect(base_url());
    // }
  }

  function forgotPassword()
  {
    // $this->form_validation->set_rules('email', 'Email', 'required|valid_email', [
    //   'required'  => '*email belum diisi'
    // ]);

    // if ($this->form_validation->run() == false) {

    //   $data['title']      = 'Jakarta Rent | Forgot Password';
    //   $data['breadcumb']  = 'Form Lupa Password';

    //   $this->load->view('forgot_password', $data);
    // } else {
    //   $email = htmlspecialchars($this->input->post('email', true));
    //   $query = $this->db->get_where('tb_user_admin', ['email' => $email])->row_array();

    //   if ($query['email'] != $email) {
    //     $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
    //       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    //       <i class="icon fa fa-check"></i><small><b>Ups.</b> Email ' . $email . ' tidak terdaftar</small>
    //     </div>');
    //     redirect('auth/forgotPassword');
    //   } else {
    //     $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    //       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    //       <i class="icon fa fa-check"></i><small><b>Berhasil.</b>Silahkan cek ' . $email . ' untuk proses verifikasi</small>
    //     </div>');
    //     redirect('auth/login');
    //   }
    // }
    redirect(base_url());
  }
}
