<?php
use App\Helpers\Helper;
$controllerRoute                = $module['controller_route'];
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
      $role_id                      = $row->role_id;
      $name                         = $row->name;
      $email                        = $row->email;
      $username                     = $row->username;
      $mobile                       = $row->mobile;
      $status                       = $row->status;
    } else {
      $role_id                      = '';
      $name                         = '';
      $email                        = '';
      $username                     = '';
      $mobile                       = '';
      $status                       = '';
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
                 <label for="role_id" class="form-label">Role <small class="text-danger">*</small></label>
                 <select name="role_id" class="form-control" id="role_id" required>
                  <option value="" selected>Select Role</option>
                  <?php if($roles){ foreach($roles as $role){?>
                  <option value="<?=$role->id?>" <?=(($role->id == $role_id)?'selected':'')?>><?=$role->name?></option>
                  <?php } }?>
                </select>
              </div>
              <div class="mb-3 col-md-6">
                 <label for="name" class="form-label">Name <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="name" name="name" value="<?=$name?>" required />
              </div>
              <div class="mb-3 col-md-6">
                 <label for="email" class="form-label">Email <small class="text-danger">*</small></label>
                 <input class="form-control" type="email" id="email" name="email" value="<?=$email?>" required />
              </div>
              <div class="mb-3 col-md-6">
                 <label for="username" class="form-label">Username <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="username" name="username" value="<?=$username?>" required />
              </div>
              <div class="mb-3 col-md-6">
                 <label for="mobile" class="form-label">Mobile <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="mobile" name="mobile" value="<?=$mobile?>" required />
              </div>
              <div class="mb-3 col-md-6">
                 <label for="password" class="form-label">PIN <small class="text-danger">*</small></label>
                 <input class="form-control" type="password" id="password" name="password" maxlength="4" minlength="4" onkeypress="return isNumber(event)" <?=((empty($row))?'required':'')?> />
              </div>
              <div class="mb-3 col-md-6">
                <label for="status" class="form-label d-block">Status <small class="text-danger">*</small></label>
                <div class="form-check form-check-inline mt-3">
                  <input name="status" class="form-check-input" type="radio" value="1" id="status1" <?=(($status == 1)?'checked':'')?> required />
                  <label class="form-check-label" for="status1">
                    Active
                  </label>
                </div>
                <div class="form-check form-check-inline mt-3">
                  <input name="status" class="form-check-input" type="radio" value="0" id="status2" <?=(($status == 0)?'checked':'')?> required />
                  <label class="form-check-label" for="status2">
                    Deactive
                  </label>
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
<script type="text/javascript">
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
  }
</script>