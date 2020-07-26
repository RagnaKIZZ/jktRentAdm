<?php defined('BASEPATH') or exit('no direct script access allowed');

class User extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->wandalibs->_checkLoginSession();
    $this->load->model('M_user', 'p');
    $this->load->library('form_validation');
  }

  function index()
  {
    $email = $this->session->userdata('email');

    $data['title']      = 'Daftar User';
    $data['breadcumb']  = 'Pengguna';
    $data['contents']   = 'list_user';
    $data['getAllUser'] = $this->p->getAllUser();
    $data['lastLogin'] = $this->wandalibs->_lastLoginUserById($email);
    $this->load->view('templates/core', $data);
  }

  function getAllTableUser()
  {

    $queryDataTable = $this->p->datatables_getAllTableUser();
    $queryGetAllData = $this->p->getAllUser();
    $data = array();
    // $no = $_POST['start'];
    $no = 1;
    foreach ($queryDataTable as $value) {
      $foto =  '<a href="' . base_url('user/getFotoProfile/') . $value['user_id'] . '" data-toggle="lightbox"><img src="' . base_url() . 'assets/img/profile-user/' . $value['foto'] . '" style="user_width: 50px; height: 50px;"></a>';

      $queryAction = '<a href="#">
        <button class="btn btn-xs btn-primary view_edit_user" id="' . $value['user_id'] . '"><i class="fa fa-edit"></i>&nbsp;Edit</button>
        </a>';

      $row = array();
      $row[] = $no++;
      $row[] = $value['nama'];
      $row[] = $value['telepon'];
      $row[] = $value['email'];
      $row[] = $foto;
      $action = $queryAction;
      $row[] = $action;
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->p->countAll(),
      "recordsFiltered" => $this->p->countFiltered(),
      "data" => $data
    );
    echo json_encode($output);
  }

  function getFotoProfile($user_id)
  {
    $data['title']    = $this->session->userdata('nama');
    // $data['contents'] = 'detail_foto_profile';
    $data['getFotoProfile'] = $this->p->getFotoProfile($user_id);

    $this->load->view('detail_foto_profile', $data);
  }

  function detailById()
  {
    $user_id = $this->input->post('user_id');
    if (isset($user_id) and !empty($user_id)) {
      $query = $this->p->getFormEdit($user_id);
      $output = '';
      foreach ($query as $i) {
        $output .= '
      <form role="form" action="' . base_url('user/update') . '" method="post" enctype="multipart/form-data" id="form-edit-user">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group input-group-sm">
              <label class="text-sm mb-0">Nama User</label>
              <input type="hidden" name="user_id" value="' . $i['user_id'] . '">
              <input type="text" name="nama" class="form-control" value="' . $i['nama'] . '">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group input-group-sm">
              <label class="text-sm mb-0">Email</label>
              <input type="text" name="email" class="form-control" value="' . $i['email'] . '">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group input-group-sm">
              <label class="text-sm mb-0">No Handphone</label>
              <input type="text" name="telepon" class="form-control" value="' . $i['telepon'] . '">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group input-group-sm">
              <label class="text-sm mb-0">Tanggal Registrasi</label>
              <input type="text" name="tgl_input" class="form-control" value="' . $i['tgl_input'] . '" disabled>
            </div>
          </div>
          <div class="col-sm-6 justify-content-center">
            <div class="form-group input-group-sm">
              <img src="' . base_url('assets/img/profile-user/') . $i['foto'] . '" width="70px;">
            </div>
          </div>
          <div class="col-sm-6 justify-content-center">
            <div class="form-group input-group-sm">
              <label class="text-sm mb-0">Update Foto</label>
              <input type="file" name="foto" value="' . $i['foto'] . '">
            </div>
          </div>
          
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-save"></i>&nbsp;Update</button>
            </div>
          </div>
      </form>
						    ';
      }
      echo $output;
    } else {
      echo 'not founds';
    }
  }

  function profileUser()
  {
    $data['title']      = $this->session->userdata('nama');
    $data['breadcumb']  = $this->session->userdata('nama');
    $data['contents']   = 'profile_user';
    // $data['getProfileUser'] = $this->p->getProfileUser();
    $this->load->view('templates/core', $data);
  }

  function insertUser()
  {
    $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required', [
      'required'    => '*Nama lengkap wajib diisi'
    ]);
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tb_user_admin.email]', [
      'required'    => '*Email wajib diisi',
      'valid_email' => '*Email tidak valid',
      'is_unique'   => '*Email sudah terdaftar'
    ]);
    $this->form_validation->set_rules('telepon', 'No Handphone', 'required|trim|is_unique[tb_user_admin.no_hp]', [
      'required'    => '*No handphone wajib diisi',
      'is_unique'   => '*No handphone sudah terdaftar'
    ]);
    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[password2]', [
      'required'    => '*Password wajib diisi',
      'min_length'  => '*Password minimal 6 karakter',
      'matches'     => '*Password tidak sama'
    ]);
    $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[6]|matches[password]', [
      'required'    => '*Password wajib diisi',
      'min_length'  => '*Password minimal 6 karakter',
      'matches'     => '*Password tidak sama'
    ]);

    if ($this->form_validation->run() == false) {

      $data['title']      = 'Form Tambah User';
      $data['breadcumb']  = 'Form Tambah User';
      $data['contents']   = 'form_add_user';

      $this->load->view('templates/core', $data);
    } else {
      $nama         = htmlspecialchars($this->input->post('nama', true));
      $telepon      = htmlspecialchars($this->input->post('telepon', true));
      $email        = htmlspecialchars($this->input->post('email', true));
      $password     = password_hash($this->input->post('password', true), PASSWORD_DEFAULT);

      $uploadGambar   = $_FILES['foto']['name'];
      if ($uploadGambar) {
        $config['upload_path']      = './assets/img/profile-user/';
        $config['allowed_types']    = 'gif|jpg|png|pdf';
        $config['max_size']         = '2048';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto')) {
          $this->upload->data('file_name');
        } else {
          echo $this->upload->display_errors();
        }
      } else {
        $uploadGambar = 'default-avatar.png';
      }

      $data = [
        'nama'        => $nama,
        'email'       => $email,
        'telepon'     => $telepon,
        'password'    => $password,
        'tgl_input'   => date('Y-m-d H:i:s'),
        'foto'        => $uploadGambar
      ];

      $this->db->insert('tb_user', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <i class="icon fa fa-check"></i><b>Yeay!.</b>Berhasil, Data user sudah disimpan
    </div>');
      redirect('user');
    }
  }

  function update()
  {
    $user_id      = htmlspecialchars($this->input->post('user_id', true));
    $nama         = htmlspecialchars($this->input->post('nama', true));
    $telepon      = htmlspecialchars($this->input->post('telepon', true));
    $email        = htmlspecialchars($this->input->post('email', true));

    $query =  $this->db->get_where('tb_user', ['user_id' => $user_id])->row_array();
    // $fotoLama = $query['foto'];
    // var_dump($fotoLama);
    // die;

    $uploadGambar   = $_FILES['foto']['name'];
    if ($uploadGambar) {
      $config['upload_path']      = './assets/img/profile-user/';
      $config['allowed_types']    = 'gif|jpg|png|pdf';
      $config['max_size']         = '2048';
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('foto')) {
        $this->upload->data('file_name');
      } else {
        echo $this->upload->display_errors();
      }
    } else {
      $uploadGambar = $query['foto'];
    }

    $data = [
      'nama'        => $nama,
      'email'       => $email,
      'telepon'     => $telepon,
      'foto'        => $uploadGambar
    ];
    $this->db->where('user_id', $user_id);
    $this->db->update('tb_user', $data);
    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <i class="icon fa fa-check"></i><b>Yeay!.</b>Berhasil, Data user sudah diupdate
    </div>');
    redirect('user');
  }
}
