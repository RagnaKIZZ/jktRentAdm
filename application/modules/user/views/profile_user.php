<div class="row justify-content-center">
  <div class="col-12 col-sm-6 col-md-3 text-center">
    <?php echo $this->session->flashdata('message'); ?>
  </div>
</div>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-3">
      <div class="card card-widget widget-user">
        <div class="widget-user-header btn-tosca">
          <h3 class="widget-user-username"><?php echo $this->session->userdata('nama') ?></h3>
          <h5 class="widget-user-desc"><?php echo $this->session->userdata('email') ?></h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle elevation-2" src="<?php echo base_url('assets/img/profile-user/') . $this->session->userdata('foto') ?>" alt="User Avatar">
        </div>
        <div class="dropdown-divider"></div>
        <div class="card-footer" style="margin-top: -30px;">
          <div class="row">
            <div class="col-sm-12 border-right">
              <div class="description-block">
                <h5 class="text-muted"><?php echo $this->session->userdata('user_access') ?></h5>
                <span class="text-muted"><?php echo $this->session->userdata('no_hp') ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>