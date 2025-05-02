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
      $page_name            = $row->page_name;
      $page_content         = $row->page_content;
      $page_image           = $row->page_image;
      $page_banner_image    = $row->page_banner_image;
      $page_video           = $row->page_video;
    } else {
      $page_name            = '';
      $page_content         = '';
      $page_image           = '';
      $page_banner_image    = '';
      $page_video           = '';
    }
    ?>
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <small class="text-danger">Star (*) marked fields are mandatory</small>
          <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
              <label for="page_name" class="col-md-2 col-lg-2 col-form-label">Page Title</label>
              <div class="col-md-10 col-lg-10">
                <input type="text" name="page_name" class="form-control" id="page_name" rows="5" value="<?=$page_name?>" required>
              </div>
            </div>
            <div class="row mb-3">
              <label for="page_content" class="col-md-2 col-lg-2 col-form-label">Page Content</label>
              <div class="col-md-10 col-lg-10">
                <textarea type="text" name="page_content" class="form-control" id="ckeditor1" rows="5" required><?=$page_content?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <label for="page_image" class="col-md-2 col-lg-2 col-form-label">Page Image</label>
              <div class="col-md-10 col-lg-10">
                <input type="file" name="page_image" class="form-control" id="page_image">
                <small class="text-info">* Only JPG, JPEG, ICO, SVG, PNG files are allowed</small><br>
                <?php if($page_image != ''){?>
                  <img src="<?=env('UPLOADS_URL').'page/'.$page_image?>" class="img-thumbnail" alt="<?=$page_name?>" style="width: 150px; height: 150px; margin-top: 10px;">
                <?php } else {?>
                  <img src="<?=env('NO_IMAGE')?>" alt="<?=$page_name?>" class="img-thumbnail" style="width: 150px; height: 150px; margin-top: 10px;">
                <?php }?>
                
                <div class="pt-2">
                  <!-- <a href="#profile_image" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a> -->
                  <!-- <a href="javascript:void(0);" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a> -->
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label for="page_banner_image" class="col-md-2 col-lg-2 col-form-label">Page Banner Image</label>
              <div class="col-md-10 col-lg-10">
                <input type="file" name="page_banner_image" class="form-control" id="page_banner_image">
                <small class="text-info">* Only JPG, JPEG, ICO, SVG, PNG files are allowed</small><br>
                <?php if($page_banner_image != ''){?>
                  <img src="<?=env('UPLOADS_URL').'page/'.$page_banner_image?>" class="img-thumbnail" alt="<?=$page_name?>" style="width: 150px; height: 150px; margin-top: 10px;">
                <?php } else {?>
                  <img src="<?=env('NO_IMAGE')?>" alt="<?=$page_name?>" class="img-thumbnail" style="width: 150px; height: 150px; margin-top: 10px;">
                <?php }?>
                
                <div class="pt-2">
                  <!-- <a href="#profile_image" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a> -->
                  <!-- <a href="javascript:void(0);" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a> -->
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label for="page_video" class="col-md-2 col-lg-2 col-form-label">Page Video</label>
              <div class="col-md-10 col-lg-10">
                <?php
                if($page_video != ''){
                  $page_video_array = explode("vimeo.com/", $page_video);
                  $video_code = $page_video_array[1];
                } else {
                  $video_code = '';
                }
                if($video_code != ''){
                ?>
                  <iframe title="vimeo-player" src="https://player.vimeo.com/video/<?=$video_code?>?h=54c29e5502" width="400" height="220" frameborder="0"    allowfullscreen></iframe>
                  <br><br>
                <?php }?>
                <input type="text" name="page_video" class="form-control" id="page_video" rows="5" value="<?=$page_video?>">
                <small class="text-info">Enter Vimeo video link</small>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary"><?=(($row)?'Save':'Add')?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>