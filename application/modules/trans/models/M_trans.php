<?php

class M_trans extends CI_Model
{

  function getAllTransaksi()
  {
    return $this->db->query("SELECT
                            `tb_order`.`order_id`, 
                            `tb_order`.`user_id`, 
                            `tb_order`.`mobil_id`, 
                            `tb_order`.`jenis_order`, 
                            `tb_order`.`order_date`, 
                            `tb_order`.`start_date`, 
                            `tb_order`.`end_date`, 
                            `tb_transaksi`.`status`, 
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
                              `tb_order`.`user_id` = `tb_user`.`user_id`")->result_array();
  }

  function getHistoryTrans($order_id)
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
                            WHERE `tb_order`.`order_id` = '$order_id'")->result_array();
  }

  function getAllDataMobil()
  {
    return $this->db->query("SELECT * FROM `tb_mobil`")->result_array();
  }

  function confirmTrans($order_id)
  {
    $query =  $this->db->query("UPDATE
                            `tb_order`
                            INNER JOIN `tb_transaksi` ON `tb_order`.`order_id` = `tb_transaksi`.`order_id`
                            SET
                            `tb_order`.`status` = 1,
                            `tb_transaksi`.`status` = 1
                            WHERE `tb_order`.`order_id` = '$order_id'");

    if ($query) {
      return $query;
    } else {
      return 0;
    }

    // if ($query->num_rows() === 1) {
    //   return $query->num_rows();
    // } else {
    //   return 0;
    // }
  }

  function cancelTrans($order_id)
  {
    $query =  $this->db->query("UPDATE
                            `tb_order`
                            INNER JOIN `tb_transaksi` ON `tb_order`.`order_id` = `tb_transaksi`.`order_id`
                            SET
                            `tb_order`.`status` = 3,
                            `tb_transaksi`.`status` = 2
                            WHERE `tb_order`.`order_id` = '$order_id'");

    if ($query) {
      return $query;
    } else {
      return 0;
    }
  }
}
