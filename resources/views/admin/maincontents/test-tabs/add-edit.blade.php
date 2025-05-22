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
      $name         = $row->name;
      $rank         = $row->rank;
      $status       = $row->status;
    } else {
      $name         = '';
      $rank         = '';
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
              <div class="mb-3 col-md-4">
                 <label for="name" class="form-label">Name <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="name" name="name" value="<?=$name?>" required autofocus />
              </div>
              <div class="mb-3 col-md-4">
                 <label for="rank" class="form-label">Rank <small class="text-danger">*</small></label>
                 <input class="form-control" type="number" id="rank" name="rank" value="<?=$rank?>" min="1" required autofocus />
              </div>
              <div class="col-md-4">
                <label for="status" class="form-label d-block">Status <small class="text-danger">*</small></label>
                <div class="form-check form-switch mt-0 ">
                  <input class="form-check-input" type="checkbox" name="status" role="switch" id="status" <?=(($status == 1)?'checked':'')?>>
                  <label class="form-check-label" for="status">Active</label>
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