<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author		Wanda Azhar
 * @link        wandaazhar@gmail.com
 * @copyright	(c) 2018
 * 
 */

class Wandalibs
{
    public function __construct()
    {
        $CI = &get_instance();
        $this->db = $CI->load->database('default', TRUE);
    }

    function _checkLoginSession()
    {
        $CI = &get_instance();
        if (empty($CI->session->userdata('email'))) {
            redirect('auth/login');
        }
    }

    function _setSessionUser()
    {
        $CI = &get_instance();
        $email      = htmlspecialchars($CI->input->post('email'), true);
        $query = $CI->db->get_where('tb_user_admin', ['email' => $email])->row_array();
        $data = [
            'id'                => $query['id'],
            'email'             => $query['email'],
            'nama'              => $query['nama'],
            'no_hp'             => $query['no_hp'],
            'user_access'       => $query['user_access'],
            'foto'              => $query['foto'],
            'active'            => $query['active'],
            'date_created'      => $query['date_created']
        ];
        $CI->session->set_userdata($data);
    }

    function _insertLoginTime()
    {
        $CI = &get_instance();
        $email      = htmlspecialchars($CI->input->post('email'), true);
        $query = $CI->db->get_where('tb_user_admin', ['email' => $email])->row_array();
        $nama = $query['nama'];

        $data = [
            'nama'          => $nama,
            'email'         => $email,
            'date_created'  => time()
        ];

        $CI->db->insert('history_login', $data);
    }

    function redirectLoginExist()
    {
        $CI = &get_instance();
        if ($CI->session->userdata('nama')) {
            $CI->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-close"></i><small><b>Yeay!</b>. Anda sedang login login dengan email ' . $CI->session->userdata('email') . '</small>
            </div>');
            redirect('dashboard');
        }
    }

    function _loginProcess()
    {
        $CI = &get_instance();
        $email      = htmlspecialchars($CI->input->post('email'), true);
        $password   = htmlspecialchars($CI->input->post('password'), true);

        $query = $CI->db->get_where('tb_user_admin', ['email' => $email])->row_array();
        $nama = $query['nama'];

        if ($query['active'] == 'tidak aktif') {
            $CI->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-close"></i><small><b>Maaf!</b>. Akun Anda tidak aktif, Silahkan cek Email untuk verifikasi</small>
            </div>');
            redirect('auth/login');
        }
        if (password_verify($password, $query['password'])) {
            $CI->wandalibs->_setSessionUser();
            $CI->wandalibs->_insertLoginTime();
            $CI->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fa fa-check"></i><b>Berhasil</b> Login! &nbsp;
            Selamat Datang <b>' . $nama . '</b>
            </div>');
            redirect('dashboard');
        } elseif ($query['email'] != $email) {
            $CI->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-close"></i><small><b>Ups!</b>. Email belum terdaftar</small>
            </div>');
            redirect('auth/login');
        } elseif ($query['password'] != $password) {
            $CI->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-close"></i><small><b>Ups!</b>. Password Anda salah!</small>
            </div>');
            redirect('auth/login');
        }
    }

    function _loginProcessFirstTime()
    {
        $CI = &get_instance();
        $email      = htmlspecialchars($CI->input->post('email'), true);
        $password   = htmlspecialchars($CI->input->post('password'), true);

        $query = $CI->db->get_where('tb_user_admin', ['email' => $email])->row_array();
        $nama = $query['nama'];

        if ($query['active'] == 'tidak aktif') {
            $CI->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fa fa-check"></i><small><b>Status</b>. Akun Anda sudah aktif sejak tanggal ' . date('d F Y', $query['date_created']) . '</small>
            </div>');
            redirect('auth/loginFirstTime');
        } elseif (password_verify($password, $query['password'])) {
            $CI->wandalibs->_setSessionUser();
            $CI->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h6><i class="icon fas fa-check"></i> Berhasil Login!</h6>
            Selamat datang <b>' . $nama . '</b>
            </div>');
            redirect('dashboard');
        } elseif ($query['email'] != $email) {
            $CI->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-close"></i><small><b>Ups!</b>. Email belum terdaftar</small>
            </div>');
            redirect('auth/loginFirstTime');
        } elseif ($query['password'] != $password) {
            $CI->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-close"></i><small><b>Ups!</b>. Password Anda salah!</small>
            </div>');
            redirect('' . $_SERVER['HTTP_REFERER'] . '');
        }
    }

    function _doLogout()
    {
        $CI = &get_instance();
        $email  = $CI->session->userdata('email');
        $query  = $CI->db->get_where('tb_user', ['email' => $email])->row_array();
        $dataSession = [
            'id'        => $query['id'],
            'email'     => $query['email'],
            'nama'      => $query['nama'],
            'no_hp'      => $query['no_hp'],
            'foto'      => $query['foto']
        ];
        $CI->session->unset_userdata('id');
        $CI->session->unset_userdata('email');
        $CI->session->unset_userdata('nama');
        $CI->session->unset_userdata('no_hp');
        $CI->session->unset_userdata('foto');
        $CI->session->unset_userdata('date_created');
        // $CI->session->sess_destroy($dataSession);
        $CI->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
              <i class="nc-icon nc-simple-remove"></i>
            </button>
            <span><small><b>Terimakasih - </b> Anda telah berhasil logout </small></span>
          </div>');
        redirect('auth/login');
    }


    function _getToken($length = 6)
    {
        $characters = '0123456789';
        $characters_length = strlen($characters);
        $output = '';
        for ($i = 0; $i < $length; $i++)
            $output .= $characters[rand(0, $characters_length - 1)];

        return $output;
    }


    function countNotif($email)
    {
        $CI = &get_instance();
        $email    = $CI->session->userdata('email');
        $query = $CI->db->get_where('pesan', ['email' => $email]);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function getNotif($email)
    {
        $CI = &get_instance();
        return $CI->db->query("SELECT COUNT(`pesan`.`email`) FROM `pesan` WHERE `pesan`.`email` = '$email'")->row_array();
    }

    function regHash($par, $length = 6)
    {

        $keyHash = '';
        $chars     = "ABCDEFGHJKLMNPQRSTUVWXYZ";
        for ($i = 0; $i < $length; $i++) {
            $x = mt_rand(0, strlen($chars) - 1);
            $keyHash .= $chars{
                $x};
        }
        $return = '' . $par . '_' . $keyHash . '';
        return $return;
    }

    function _lastLoginUserById($email)
    {
        $CI = &get_instance();
        return $CI->db->query("SELECT `history_login`.`date_created` FROM `history_login` WHERE `email` = '$email' ORDER BY `history_login`.`id` DESC")->row_array();
    }

    function countLoginUserById($email)
    {
        $CI = &get_instance();
        $query = $CI->db->query("SELECT `history_login`.`id` FROM `history_login` WHERE `email` = '$email'");
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function _rupiah($angka)
    {
        $resultRupiah = "Rp. " . number_format($angka, 0, ',', '.');
        return $resultRupiah;
    }

    function diffByDay($end_date, $start_date)
    {
        // $dateDiff = '';
        $end_date   = strtotime($end_date);
        $start_date = strtotime($start_date);
        $diff       = $end_date - $start_date;

        return round($diff / (60 * 60 * 24));
    }

    function diffByHour($end_date, $start_date)
    {
        // $dateDiff = '';
        $end_date   = strtotime($end_date);
        $start_date = strtotime($start_date);
        $diff       = $end_date - $start_date;

        return round($diff / (60 * 60));
    }
}
