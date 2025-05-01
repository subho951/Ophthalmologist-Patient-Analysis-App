<?php
use App\Models\Module;
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
      $name         = $row->name;
      $module_id    = (($row->module_id != '')?json_decode($row->module_id):[]);
      $status       = $row->status;
    } else {
      $name         = '';
      $module_id    = [];
      $status       = '';
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
                 <label for="name" class="form-label">Name <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="name" name="name" value="<?=$name?>" required autofocus />
              </div>
              <div class="mb-3 col-md-6">
                <label for="username" class="form-label d-block">Status <small class="text-danger">*</small></label>
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
           <div class="row mb-5">
              <label class="col-md-2 col-lg-2 col-form-label">Modules</label>
              <div class="col-md-10 col-lg-10">
                <div class="row">
                  <?php if($modules){ foreach($modules as $module){?>
                    <div class="col-md-4 col-lg-4">
                      <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="module_id[]" value="<?=$module->id?>" id="module<?=$module->id?>" <?=((in_array($module->id, $module_id))?'checked':'')?>>
                        <label class="form-check-label" for="module<?=$module->id?>"><?=$module->name?></label>
                      </div>
                    </div>
                  <?php } }?>
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