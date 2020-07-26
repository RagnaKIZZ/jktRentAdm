$(function () {
	$('#example1').DataTable()
	$('#example2').DataTable({
		'paging': true,
		'lengthChange': false,
		'searching': false,
		'ordering': true,
		'info': true,
		'autoWidth': false
	})
});

//~ Datatable serverside user ~//
var save_method; //for save method string
var oTable;
$(document).ready(function () {
	oTable = $('#tabel_list_user').DataTable({
		"processing": true,
		"serverSide": true,
		//"lengthChange": false,
		//"displayLength" : 20,
		"order": [],
		"autoWidth": false,
		"ajax": {
			"url": base_url + "/user/getAllTableUser/",
			"type": "POST"
		},
		"aLengthMenu": [
			[10, 50, 100],
			[10, 50, 100]
		], // Combobox Limit
		"columnDefs": [{
				"targets": [0],
				"searchable": true,
				"sortable": true
			},
			{
				"targets": [1],
				"searchable": true,
				"sortable": true
			},
			{
				"targets": [2],
				"searchable": true,
				"sortable": true
			}
		],

	});
});


//~ Datatable serverside user admin ~//
var save_method; //for save method string
var oTable;
$(document).ready(function () {
	oTable = $('#tabel_list_user_admin').DataTable({
		"processing": true,
		"serverSide": true,
		//"lengthChange": false,
		//"displayLength" : 20,
		"order": [],
		"autoWidth": false,
		"ajax": {
			"url": base_url + "/user_admin/getAllTableUserAdmin/",
			"type": "POST"
		},
		"aLengthMenu": [
			[10, 50, 100],
			[10, 50, 100]
		], // Combobox Limit
		"columnDefs": [{
				"targets": [0],
				"searchable": true,
				"sortable": true
			},
			{
				"targets": [1],
				"searchable": true,
				"sortable": true
			},
			{
				"targets": [2],
				"searchable": true,
				"sortable": true
			}
		],

	});
});



const flashData = $('.flash-data').data('flashdata');

if (flashData) {
	Swal.fire({
		'title': 'Berhasil',
		'text': 'Transaksi berhasil dicancel',
		// 'type': 'success'
	});
}

$('#btnCancel').on('click', function (e) {
	e.preventDefault();
	// const href = $(this).attr('href');
	// const idCancel = $(this).data('cancel');
	const idCancel = $(this).attr('data-cancel');
	Swal.fire({
		title: 'Apa kamu sudah yakin?',
		text: "Data yang sudah di cancel tidak dapat dikembalikan",
		// type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#13a9e2',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Yakin',
		cancelButtonText: "Tidak Jadi",
	}).then((result) => {
		if (result.value) {
			// document.location.href = href;
			document.location.href = base_url + 'trans/cancelTrans/' + idCancel
		}
	})
})

//~ Modal History Transaksi ~//
$(document).ready(function () {
	$('#example1').on('click', '.view_data', function () {
		var order_id = $(this).attr('id');
		$.ajax({
			url: base_url + "trans/getHistoryTrans/",
			method: "POST",
			data: {
				order_id: order_id
			},
			success: function (data) {
				$('#result_history_transaksi').html(data);
				$('#modal_history_transaksi').modal('show');
			}
		});
	});
});

//~ Modal Konfirmasi Transaksi ~//
$(document).ready(function () {
	$('#example1').on('click', '.confirm_transaksi', function () {
		var order_id = $(this).attr('id');
		$.ajax({
			url: base_url + "trans/showConfirmTrans/",
			method: "POST",
			data: {
				order_id: order_id
			},
			success: function (data) {
				$('#result_confirm_transaksi').html(data);
				$('#modal_confirm_transaksi').modal('show');
			}
		});
	});
});

//~ Modal Confirm Hapus Transaksi ~//
$(document).ready(function () {
	$('#example1').on('click', '.confirm_delete', function () {
		var order_id = $(this).attr('id');
		$.ajax({
			url: base_url + "trans/showConfirmDelete/",
			method: "POST",
			data: {
				order_id: order_id
			},
			success: function (data) {
				$('#result_confirm_delete').html(data);
				$('#modal_confirm_delete').modal('show');
			}
		});
	});
});


//~ Modal Confirm Hapus Mobil ~//
$(document).ready(function () {
	$('#example1').on('click', '.confirm_delete_mobil', function () {
		var mobil_id = $(this).attr('id');
		$.ajax({
			url: base_url + "mobil/showConfirmDelete/",
			method: "POST",
			data: {
				mobil_id: mobil_id
			},
			success: function (data) {
				mobil_id.attr('disabled', false);
				$('#result_confirm_delete_mobil').html(data);
				$('#modal_confirm_delete_mobil').modal('show');
			}
		});
	});
});

//~ Modal Data Mobil ~//
$(document).ready(function () {
	$('#example1').on('click', '.view_mobil', function () {
		var mobil_id = $(this).attr('id');
		$.ajax({
			url: base_url + "mobil/getDataById/",
			method: "POST",
			data: {
				mobil_id: mobil_id
			},
			success: function (data) {
				$('#result_detail_mobil').html(data);
				$('#modal_detail_mobil').modal('show');
			}
		});
	});
});

//~ Modal Data Mobil Pengembalian~//
$(document).ready(function () {
	$('#example1').on('click', '.view_mobil_pengembalian', function () {
		var mobil_id = $(this).attr('id');
		$.ajax({
			url: base_url + "pengembalian/getDataById/",
			method: "POST",
			data: {
				mobil_id: mobil_id
			},
			success: function (data) {
				$('#result_detail_mobil').html(data);
				$('#modal_detail_mobil').modal('show');
			}
		});
	});
});

//~ Modal Data Mobil Pengembalian~/ /
$(document).ready(function () {
	$('#example1').on('click', '.modal_pengembalian', function () {
		var pengembalian_id = $(this).attr('id');
		$.ajax({
			url: base_url + "pengembalian/getDataPengById/",
			method: "POST",
			data: {
				pengembalian_id: pengembalian_id
			},
			success: function (data) {
				$('#result_detail_mobil').html(data);
				$('#modal_detail_mobil').modal('show');
			}
		});
	});
});

//~ Modal Edit User~//
$(document).ready(function () {
	// $('#form-edit-user')[0].reset();
	$('#tabel_list_user').on('click', '.view_edit_user', function () {
		var user_id = $(this).attr('id');
		$.ajax({
			url: base_url + "user/detailById",
			method: "POST",
			data: {
				user_id: user_id
			},
			success: function (data) {
				$('#result_edit_user').html(data);
				$('#modal_edit_user').modal('show');
			}
		});
	});
});

//~ Modal Edit User Admin~//
$(document).ready(function () {
	// $('#form-edit-user')[0].reset();
	$('#tabel_list_user_admin').on('click', '.view_edit_user_admin', function () {
		var id = $(this).attr('id');
		$.ajax({
			url: base_url + "user_admin/detailById",
			method: "POST",
			data: {
				id: id
			},
			success: function (data) {
				$('#result_edit_user_admin').html(data);
				$('#modal_edit_user_admin').modal('show');
			}
		});
	});
});


//~ Format Rupiah pada tag input harga produk di form input data produk ~//
var rupiah = document.getElementById('price');
rupiah.addEventListener('keyup', function (e) {
	// tambahkan 'Rp.' pada saat form di ketik
	// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
	rupiah.value = formatRupiah(this.value, 'Rp. ');
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
	var number_string = angka.replace(/[^,\d]/g, '').toString(),
		split = number_string.split(','),
		sisa = split[0].length % 3,
		rupiah = split[0].substr(0, sisa),
		ribuan = split[0].substr(sisa).match(/\d{3}/gi);

	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if (ribuan) {
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}

	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
