<?php defined('BASEPATH') or exit('no direct script access allowed');

class User_admin extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->wandalibs->_checkLoginSession();
    $this->load->model('m_user_admin', 'p');
    $this->load->library('form_validation');
  }

  function index()
  {
    $email = $this->session->userdata('email');

    $data['title']      = 'Daftar User Admin';
    $data['breadcumb']  = 'Pengguna';
    $data['contents']   = 'list_user_admin';
    $data['getAllUser'] = $this->p->getAllUser();
    $data['lastLogin'] = $this->wandalibs->_lastLoginUserById($email);
    $this->load->view('templates/core', $data);
    if ($this->session->userdata('user_access') != 'administrator') {
      redirect('dashboard');
    }
  }

  function getAllTableUserAdmin()
  {

    $queryDataTable = $this->p->datatables_getAllTableUserAdmin();
    $data = array();
    // $no = $_POST['start'];
    $no = 1;
    foreach ($queryDataTable as $value) {
      $foto =  '<a href="' . base_url('user_admin/getFotoProfile/') . $value['id'] . '" data-toggle="lightbox"><img src="' . base_url() . 'assets/img/profile-user/' . $value['foto'] . '" style="user_width: 50px; height: 50px;"></a>';

      $queryAction = '<a href="#">
        <button class="btn btn-xs btn-primary view_edit_user_admin" id="' . $value['id'] . '"><i class="fa fa-edit"></i>&nbsp;Edit</button>
        </a>';
      if ($value['user_access'] == 'administrator') {
        $hak_akses = '<span class="badge badge-danger"><i class="fa fa-key"></i>&nbsp;' . $value['user_access'] . '</span>';
      } else {
        $hak_akses = '<span class="badge badge-success"><i class="fa fa-user"></i>&nbsp;' . $value['user_access'] . '</span>';
      }

      $row = array();
      $row[] = $no++;
      $row[] = $value['nama'];
      $row[] = $value['no_hp'];
      $row[] = $value['email'];
      $row[] = $hak_akses;
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

  function getFotoProfile($id)
  {
    $data['title']    = $this->session->userdata('nama');
    // $data['contents'] = 'detail_foto_profile';
    $data['getFotoProfile'] = $this->p->getFotoProfile($id);

    $this->load->view('detail_foto_profile', $data);
  }

  function detailById()
  {
    $id = $this->input->post('id');
    if (isset($id) and !empty($id)) {
      $query = $this->p->getFormEdit($id);
      $output = '';
      foreach ($query as $i) {
        $output .= '
      <form role="form" action="' . base_url('user_admin/update') . '" method="post" enctype="multipart/form-data" id="form-edit-user">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group input-group-sm">
              <label class="text-sm mb-0">Nama User</label>
              <input type="hidden" name="id" value="' . $i['id'] . '">
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
              <input type="text" name="no_hp" class="form-control" value="' . $i['no_hp'] . '">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group input-group-sm">
              <label class="text-sm mb-0">Tanggal Registrasi</label>
              <input type="text" name="tgl_input" class="form-control" value="' . date('d F Y', $i['date_created']) . '" disabled>
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

  function profileUser($id)
  {
    $data['title']      = $this->session->userdata('nama');
    $data['breadcumb']  = $this->session->userdata('nama');
    $data['contents']   = 'profile_user';
    $data['getProfileUser'] = $this->p->getProfileUser($id);
    $this->load->view('templates/core', $data);
  }

  function insertUserAdmin()
  {
    $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required', [
      'required'    => '*Nama lengkap wajib diisi'
    ]);
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tb_user_admin.email]', [
      'required'    => '*Email wajib diisi',
      'valid_email' => '*Email tidak valid',
      'is_unique'   => '*Email sudah terdaftar'
    ]);
    $this->form_validation->set_rules('no_hp', 'No Handphone', 'required|trim|is_unique[tb_user_admin.no_hp]', [
      'required'    => '*No handphone wajib diisi',
      'is_unique'   => '*No handphone sudah terdaftar'
    ]);
    $this->form_validation->set_rules('user_access', 'Hak Akses', 'required', [
      'required'    => '*Hak akses wajib dipilih',
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
      $no_hp        = htmlspecialchars($this->input->post('no_hp', true));
      $user_access  = htmlspecialchars($this->input->post('user_access', true));
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
        'no_hp'       => $no_hp,
        'user_access' => $user_access,
        'password'    => $password,
        'date_created' => time(),
        'foto'        => $uploadGambar
      ];

      $this->db->insert('tb_user_admin', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <i class="icon fa fa-check"></i><b>Yeay!.</b>Berhasil, Data user admin sudah disimpan
    </div>');
      redirect('user_admin');
    }
  }

  function update()
  {
    $id           = htmlspecialchars($this->input->post('id', true));
    $nama         = htmlspecialchars($this->input->post('nama', true));
    $no_hp        = htmlspecialchars($this->input->post('no_hp', true));
    $email        = htmlspecialchars($this->input->post('email', true));

    $query =  $this->db->get_where('tb_user_admin', ['id' => $id])->row_array();
    // $fotoLama = $query['foto'];
    // var_dump($fotoLama);
    // die;

    $uploadGambar   = $_FILES['foto']['name'];
    if ($uploadGambar) {
      $config['upload_path']      = './assets/img/profile-user/';
      $config['allowed_types']    = 'gif|jpg|png|pdf';
      $config['max_size']         = '100000';
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
      'no_hp'       => $no_hp,
      'foto'        => $uploadGambar
    ];
    $this->db->where('id', $id);
    $this->db->update('tb_user_admin', $data);
    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <i class="icon fa fa-check"></i><b>Yeay!.</b>Berhasil, Data user admin sudah diupdate
    </div>');
    redirect('user_admin');
  }
}
