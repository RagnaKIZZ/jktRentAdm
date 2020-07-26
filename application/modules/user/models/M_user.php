<?php
class M_user extends CI_Model
{

  function getAllUser()
  {
    return $this->db->query("SELECT * FROM `tb_user` ORDER BY `tb_user`.`user_id` DESC")->result_array();
  }

  function datatables_getAllTableUser()
  {
    $column_order   = ['user_id', 'nama'];
    $column_search  = ['user_id', 'nama'];
    $def_order      = ['user_id' => 'asc'];

    $this->sql_user();
    $this->query_datatables($column_order, $column_search, $def_order);
    if ($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result_array();
  }

  function sql_user()
  {
    $this->db->select("user_id,nama,telepon,foto,email,tgl_input", false)
      ->from("tb_user");
    $this->db->order_by("user_id", "desc");
  }

  function query_datatables($column_order, $column_search, $def_order)
  {
    $i = 0;
    foreach ($column_search as $item) {
      if ($_POST['search']['value']) {
        if ($i === 0) {
          $this->db->group_start();
          $this->db->like($item, $_POST['search']['value']);
        } else {
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if (count($column_search) - 1 == $i)
          $this->db->group_end();
      }
      $i++;
    }

    if (isset($_POST['order'])) {
      $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($order)) {
      $order = $def_order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  public function countAll()
  {
    $this->sql_user();
    return $this->db->count_all_results();
  }

  function countFiltered()
  {
    $column_order       = ['user_id', 'nama', 'telepon'];
    $column_search      = [
      'user_id',
      'nama',
      'email'
    ];
    $def_order          = ['user_id' => 'asc'];

    $this->sql_user();
    $this->query_datatables($column_order, $column_search, $def_order);
    $query = $this->db->get();
    return $query->num_rows();
  }

  function getFotoProfile($user_id)
  {
    return $this->db->query("SELECT * FROM `tb_user` WHERE `tb_user`.`user_id` = '$user_id'")->result_array();
  }

  function countLogin($email)
  {
    return $this->db->query("SELECT
    `tb_user`.*, 
    `history_login`.`date_created` as `last_login`,
    `history_login`.`email`
      FROM
        tb_user
        INNER JOIN
        `history_login`
        ON 
          `tb_user`.`email` = `history_login`.`email`
          WHERE `history_login`.`email` = '$email'
      ORDER BY
        `tb_user_`.`id` ASC")->result_array();
  }

  function getFormEdit($user_id)
  {
    $this->db->select('*');
    $this->db->where('user_id', $user_id);
    $res2 = $this->db->get('tb_user')->result_array();
    return $res2;
  }

  function getProfileUser()
  {
    $this->db->select('*');
    $this->db->where('user_id', $this->session->userdata('id'));
    $res2 = $this->db->get('tb_user')->result_array();
    return $res2;
  }
}
