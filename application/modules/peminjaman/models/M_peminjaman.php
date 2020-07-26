<?php defined('BASEPATH') or exit('No direct script allowed');
class M_peminjaman extends CI_Model
{
  function getAllData()
  {
    return $this->db->query("SELECT
                            `tb_order`.`order_id`, 
                            `tb_order`.`user_id`, 
                            `tb_order`.`mobil_id`, 
                            `tb_order`.`jenis_order`, 
                            `tb_order`.`order_date`, 
                            `tb_order`.`start_date`, 
                            `tb_order`.`end_date`, 
                            `tb_order`.`status`, 
                            `tb_transaksi`.`status` AS `status_trans`, 
                            `tb_transaksi`.`metode_pembayaran`, 
                            `tb_transaksi`.`harga`, 
                            `tb_transaksi`.`create_date`, 
                            `tb_mobil`.`nama` AS `nama_mobil`,
                            `tb_mobil`.`tipe`, 
                            `tb_mobil`.`alamat_id`, 
                            LEFT(`tb_alamat`.`alamat_detail`, 10) AS `alamat`, 
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
                              WHERE 
                              (`tb_order`.`status` = 1 OR  `tb_order`.`status` = 2) AND `tb_transaksi`.`status` = 1")->result_array();
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
}
