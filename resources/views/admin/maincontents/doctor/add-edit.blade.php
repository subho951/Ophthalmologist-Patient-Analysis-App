<?php
use App\Helpers\Helper;
$controllerRoute                = $module['controller_route'];
$current_url = url()->current();
?>
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light"><a href="<?=url('admin/dashboard')?>">Dashboard</a> /</span>
    <span class="text-muted fw-light"><a href="<?=url('admin/' . $controllerRoute . '/list/')?>"><?=$module['title']?> List</a> /</span>
    <?=$page_header?>
  </h4>
  <div class="row">
    <?php
    if($row){
      $doctor_id          = $row->id;
      $initials           = $row->initials;
      $name               = $row->name;
      $email              = $row->email;
      $phone              = $row->phone;
      $regn_no            = $row->regn_no;
      $profile_image      = $row->profile_image;
      $status             = $row->status;
    } else {
      $doctor_id          = '';
      $initials           = '';
      $name               = '';
      $email              = '';
      $phone              = '';
      $regn_no            = '';
      $profile_image      = '';
      $status             = '';
    }
    ?>
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <small class="text-danger">Star (*) marked fields are mandatory</small>
          <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="mb-3 col-md-6">
                 <label for="initials" class="form-label">Initials <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="initials" name="initials" value="<?=$initials?>" required autofocus />
              </div>
              <div class="mb-3 col-md-6">
                 <label for="name" class="form-label">Name <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="name" name="name" value="<?=$name?>" required autofocus />
              </div>
              <div class="mb-3 col-md-6">
                 <label for="email" class="form-label">Email <small class="text-danger">*</small></label>
                 <input class="form-control" type="email" id="email" name="email" value="<?=$email?>" required autofocus />
              </div>
              <div class="mb-3 col-md-6">
                 <label for="phone" class="form-label">Phone <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="phone" name="phone" value="<?=$phone?>" required autofocus />
              </div>
              <div class="mb-3 col-md-6">
                 <label for="regn_no" class="form-label">Registration No. <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="regn_no" name="regn_no" value="<?=$regn_no?>" required autofocus />
              </div>
              <div class="col-md-6">
                <label for="status" class="form-label d-block">Status <small class="text-danger">*</small></label>
                <div class="form-check form-switch mt-0 ">
                  <input class="form-check-input" type="checkbox" name="status" role="switch" id="status" <?=(($status == 1)?'checked':'')?>>
                  <label class="form-check-label" for="status">Active</label>
                </div>
              </div>
              <div class="mb-3 col-md-12">
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                  <?php if($profile_image != ''){?>
                  <img src="<?=env('UPLOADS_URL').'/doctor/'.$profile_image?>" alt="<?=$name?>" class="d-block" height="100" width="100" style="border-radius: 50%;" id="uploadedAvatar" />
                  <?php } else {?>
                  <img src="<?=env('NO_USER_IMAGE')?>" alt="<?=$name?>" class="d-block" height="100" width="100" style="border-radius: 50%;" id="uploadedAvatar" />
                  <?php } ?>
                  <div class="button-wrapper">
                     <label for="profile_image" class="btn btn-primary me-2 mb-4" tabindex="0">
                     <span class="d-none d-sm-block">Upload Profile Image</span>
                     <i class="bx bx-upload d-block d-sm-none"></i>
                     <input type="file" id="profile_image" name="profile_image" class="account-file-input" hidden accept="image/png, image/jpeg" />
                     </label>
                     <a href="<?=url('admin/common-delete-image/'.Helper::encoded($current_url).'/doctors/profile_image/id/'.$doctor_id)?>" title="Remove image" onclick="return confirm('Do You Want To Delete This Image ?');">
                     <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                     <i class="bx bx-reset d-block d-sm-none"></i>
                     <span class="d-none d-sm-block">Reset</span>
                     </button>
                     </a>
                     <p class="text-muted mb-0">Allowed JPG, JPEG, ICO, PNG, GIF, SVG, AVIF</p>
                  </div>
                </div>
              </div>
           </div>
           <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2"><?=(($row)?'Save':'Add')?></button>
           </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>