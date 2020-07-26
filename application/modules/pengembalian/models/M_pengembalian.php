<?php
class M_pengembalian extends CI_Model
{
  function getAllData()
  {
    return $this->db->query("SELECT
                            tb_pengembalian.pengembalian_id,
                            tb_pengembalian.order_id,
                            tb_pengembalian.user_id,
                            tb_pengembalian.create_date,
                            tb_pengembalian.denda,
                            tb_user.nama AS nama_user,
                            tb_user.email,
                            tb_user.foto AS foto_user,
                            tb_mobil.nama AS nama_mobil,
                            tb_mobil.tipe,
                            tb_mobil.mobil_id,
                            tb_mobil.foto AS foto_mobil,
                            tb_order.start_date,
                            tb_order.end_date,
                            tb_transaksi.harga,
                            tb_order.`status`,
                            tb_alamat.kota,
                            tb_alamat.alamat_detail,
                            tb_user_admin.nama AS nama_admin
                            FROM
                            tb_pengembalian
                            INNER JOIN tb_transaksi ON tb_pengembalian.order_id = tb_transaksi.order_id
                            INNER JOIN tb_user ON tb_user.user_id = tb_pengembalian.user_id
                            INNER JOIN tb_order ON tb_pengembalian.order_id = tb_order.order_id
                            INNER JOIN tb_mobil ON tb_mobil.mobil_id = tb_order.mobil_id
                            INNER JOIN tb_alamat ON tb_mobil.alamat_id = tb_alamat.alamat_id
                            INNER JOIN tb_user_admin ON tb_pengembalian.admin_id = tb_user_admin.id
                            ")->result_array();
  }

  function getDataById($order_id)
  {
    return $this->db->query("SELECT
                            `tb_order`.`order_id`, 
                            `tb_order`.`user_id`, 
                            `tb_order`.`mobil_id`, 
                            `tb_order`.`jenis_order`, 
                            `tb_order`.`order_date`, 
                            `tb_order`.`start_date`, 
                            `tb_order`.`end_date`, 
                            `tb_order`.`status` AS `status_order`, 
                            `tb_transaksi`.`status`, 
                            `tb_transaksi`.`metode_pembayaran`, 
                            `tb_transaksi`.`harga`, 
                            `tb_transaksi`.`create_date`, 
                            `tb_mobil`.`nama` AS `nama_mobil`,
                            `tb_mobil`.`tipe`, 
                            `tb_mobil`.`foto`, 
                            `tb_mobil`.`alamat_id`, 
                            LEFT(`tb_alamat`.`alamat_detail`, 30) AS `alamat`, 
                            `tb_alamat`.`kota`, 
                            `tb_user`.`nama` AS `nama_user`, 
                            `tb_user`.`telepon`, 
                            `tb_user`.`email`
                          FROM
                            tb_order
                            INNER JOIN
                            tb_transaksi
                            ON 
                              `tb_order`.`order_id` = `tb_transaksi`.`order_id`
                            INNER JOIN
                            tb_mobil
                            ON 
                              `tb_order`.`mobil_id` = `tb_mobil`.`mobil_id`
                            INNER JOIN
                            tb_alamat
                            ON 
                              `tb_mobil`.`alamat_id` = `tb_alamat`.`alamat_id`
                            INNER JOIN
                            tb_user
                            ON 
                              `tb_order`.`user_id` = `tb_user`.`user_id`
                            WHERE `tb_order`.`order_id` = '$order_id'")->result_array();
  }

  function getFotoMobil($mobil_id)
  {
    return $this->db->query("SELECT `tb_mobil`.`foto` FROM `tb_mobil` WHERE `tb_mobil`.`mobil_id` = '$mobil_id'")->result_array();
  }

  function getDataMobilById($mobil_id)
  {
    return $this->db->query("SELECT * FROM `tb_mobil` WHERE `mobil_id` = '$mobil_id'")->result_array();
  }

  function getDataPengembalianById($pengembalian_id)
  {
    return $this->db->query("SELECT
                            tb_pengembalian.pengembalian_id,
                            tb_pengembalian.order_id,
                            tb_pengembalian.user_id,
                            tb_pengembalian.create_date,
                            tb_pengembalian.denda,
                            tb_user.nama AS nama_user,
                            tb_user.email,
                            tb_user.foto AS foto_user,
                            tb_mobil.nama AS nama_mobil,
                            tb_mobil.tipe,
                            tb_mobil.mobil_id,
                            tb_mobil.foto AS foto_mobil,
                            tb_order.start_date,
                            tb_order.end_date,
                            tb_transaksi.harga,
                            tb_order.`status`,
                            tb_alamat.kota,
                            LEFT(`tb_alamat`.`alamat_detail`, 30) AS `alamat`, 
                            tb_user_admin.nama AS nama_admin
                            FROM
                            tb_pengembalian
                            INNER JOIN tb_transaksi ON tb_pengembalian.order_id = tb_transaksi.order_id
                            INNER JOIN tb_user ON tb_user.user_id = tb_pengembalian.user_id
                            INNER JOIN tb_order ON tb_pengembalian.order_id = tb_order.order_id
                            INNER JOIN tb_mobil ON tb_mobil.mobil_id = tb_order.mobil_id
                            INNER JOIN tb_alamat ON tb_mobil.alamat_id = tb_alamat.alamat_id
                            INNER JOIN tb_user_admin ON tb_pengembalian.admin_id = tb_user_admin.id
                            WHERE
                            tb_pengembalian.pengembalian_id = '$pengembalian_id'
                            ")->result_array();
  }
}
