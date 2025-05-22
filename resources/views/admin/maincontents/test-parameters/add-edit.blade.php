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
      $test_tab_id    = $row->test_tab_id;
      $name           = $row->name;
      $weight         = $row->weight;
      $hints          = $row->hints;
      $options        = json_decode($row->options);
      $rank           = $row->rank;
      $status         = $row->status;
    } else {
      $test_tab_id    = '';
      $name           = '';
      $weight         = '';
      $hints          = '';
      $options        = [];
      $rank           = '';
      $status         = '';
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
                 <label for="test_tab_id" class="form-label">Test Tab <small class="text-danger">*</small></label>
                 <select name="test_tab_id" class="form-control" id="test_tab_id" required>
                  <option value="" selected>Select Test Tab</option>
                  <?php if($testTabs){ foreach($testTabs as $testTab){?>
                  <option value="<?=$testTab->id?>" <?=(($testTab->id == $test_tab_id)?'selected':'')?>><?=$testTab->name?></option>
                  <?php } }?>
                </select>
              </div>
              <div class="mb-3 col-md-6">
                 <label for="name" class="form-label">Name <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="name" name="name" value="<?=$name?>" required autofocus />
              </div>
              <div class="mb-3 col-md-4">
                 <label for="weight" class="form-label">Weight <small class="text-danger">*</small></label>
                 <input class="form-control" type="number" id="weight" name="weight" value="<?=$weight?>" min="1" required autofocus />
              </div>
              <div class="mb-3 col-md-4">
                 <label for="rank" class="form-label">Rank <small class="text-danger">*</small></label>
                 <input class="form-control" type="number" id="rank" name="rank" value="<?=$rank?>" min="1" required autofocus />
              </div>
              <div class="mb-3 col-md-4">
                <label for="rank" class="form-label">Options <small class="text-danger">*</small></label>
                  <div>
                    <input type="checkbox" id="options1" name="options[]" value="1" required <?=((in_array(1, $options))?'checked':'')?>> <label for="options1">YES</label>
                    <input type="checkbox" id="options2" name="options[]" value="0" required <?=((in_array(0, $options))?'checked':'')?>> <label for="options2">NO</label>
                  </div>
              </div>
              <div class="mb-3 col-md-6">
                 <label for="hints" class="form-label">Hints <small class="text-danger">*</small></label>
                 <textarea class="form-control" id="hints" name="hints" rows="3"><?=$hints?></textarea>
              </div>
              <div class="col-md-6">
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