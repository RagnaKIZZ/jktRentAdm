<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets/img/logo-jakarta-rent.png">
  <title><?php echo $title ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/toastr/toastr.min.css">
  <!-- oneda-cassading -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/one-da-css/one-da-cassading.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="one-da-login-logo">
      <div style="background-color: #13a9e2; width: 360px;" class="text-center mb-0">
        <a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>/assets/img/logo-jakarta-rent.png" alt="" style="width: 30%;" class="mb-0"></a>
      </div>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <?php echo $this->session->flashdata('message'); ?>
        <p class="login-box-msg text-uppercase" style="color: #13a9e2; font-weight: bold;"><?php echo $title ?></p>
        <form action="<?php echo base_url('auth/login') ?>" method="post" id="">
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="first" name="email" value="<?php echo set_value('email') ?>" placeholder="Masukan Email Kamu" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <small class="text-danger font-italic"><?php echo form_error('email') ?></small>
          <div class="input-group mb-3">
            <input type="password" id="second" name="password" class="form-control" placeholder="Masukan Password Kamu" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <small class="text-danger font-italic"><?php echo form_error('password') ?></small>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-sm one-da-btn-login btn-tosca"> <i class="fa fa-power-off"></i> Sign In</button>
            </div>
          </div>
        </form>
        <!-- <p class="mb-0 one-da-text-unlink" style="font-size: 14px;">Tidak bisa login? <a href="#" class="one-da-text-unlink one-da-text-tosca swalDefaultError" style="font-size: 14px;">Lupa password</a></p>
        <p class="mb-0 one-da-text-unlink" style="font-size: 14px;"> Belum punya akun? <a href="#" class="one-da-text-unlink one-da-text-tosca swalDefaultError">Register</a></p> -->
      </div>
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="<?php echo base_url() ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="<?php echo base_url() ?>/assets/plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() ?>/assets/dist/js/adminlte.min.js"></script>

  <script>
    var instance = $('#first').parsley();
    console.log(instance.isValid()); // maxlength is 42, so field is valid
    $('#first').attr('data-parsley-maxlength', 4);
    console.log(instance.isValid()); // No longer valid, as maxlength is 4
    // You can access and override options in javascript too:
    instance.options.maxlength++;
    console.log(instance.isValid()); // Back to being valid, as maxlength is 5
    // Alternatively, the options can be specified as:
    var otherInstance = $('#second').parsley({
      maxlength: 10
    });
    console.log(otherInstance.options);
  </script>
  <!-- Toast SweetAlert2-->
  <script type="text/javascript">
    $(function() {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: true,
        timer: 3000
      });

      $('.wrongPassword').ready(function() {
        Toast.fire({
          type: 'error',
          title: 'Ups! Jika kamu masih belum bisa login. Silahkan hubungi administrator'
        })
      });
    });
  </script>
  <script type="text/javascript">
    $(function() {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      $('.swalDefaultSuccess').click(function() {
        Toast.fire({
          type: 'success',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.swalDefaultInfo').click(function() {
        Toast.fire({
          type: 'info',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.swalDefaultError').click(function() {
        Toast.fire({
          type: 'error',
          title: 'Maaf!. Silahkan hubungi administrator unuk mendaftar dan mengubah password baru.'
        })
      });
    });
  </script>

</body>

</html>