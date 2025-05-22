<?php
use App\Models\Patient;
use App\Models\Doctor;
use App\Helpers\Helper;
$controllerRoute      = $module['controller_route'];
$current_url          = url()->current();
?>
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light"><a href="<?=url('admin/dashboard')?>">Dashboard</a> /</span> <?=$page_header?>
  </h4>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">
            <a href="<?=url('admin/' . $controllerRoute . '/add/')?>" class="btn btn-outline-success btn-sm">Add <?=$module['title']?></a>
          </h5>
          <div class="dt-responsive table-responsive">
            <table id="simpletable" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Page Name</th>
                  <th scope="col">Page Image</th>
                  <th scope="col">Page Banner Image</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($rows) > 0){ $sl=1; foreach($rows as $row){?>
                  <tr>
                    <th scope="row"><?=$sl++?></th>
                    <td><?=$row->page_name?></td>
                    <td>
                      <?php if($row->page_image != ''){?>
                        <img src="<?=env('UPLOADS_URL').'page/'.$row->page_image?>" class="img-thumbnail" alt="<?=$row->page_name?>" style="width: 150px; height: 150px; margin-top: 10px;">
                      <?php } else {?>
                        <img src="<?=env('NO_IMAGE')?>" alt="<?=$row->page_name?>" class="img-thumbnail" style="width: 150px; height: 150px; margin-top: 10px;">
                      <?php }?>
                    </td>
                    <td>
                      <?php if($row->page_banner_image != ''){?>
                        <img src="<?=env('UPLOADS_URL').'page/'.$row->page_banner_image?>" class="img-thumbnail" alt="<?=$row->page_name?>" style="width: 150px; height: 150px; margin-top: 10px;">
                      <?php } else {?>
                        <img src="<?=env('NO_IMAGE')?>" alt="<?=$row->page_name?>" class="img-thumbnail" style="width: 150px; height: 150px; margin-top: 10px;">
                      <?php }?>
                    </td>
                    <td>
                      <a href="<?=url('admin/' . $controllerRoute . '/edit/'.Helper::encoded($row->id))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$module['title']?>"><i class="fa fa-edit"></i></a>
                      <a href="<?=url('admin/' . $controllerRoute . '/delete/'.Helper::encoded($row->id))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$module['title']?>" onclick="return confirm('Do You Want To Delete This <?=$module['title']?>');"><i class="fa fa-trash"></i></a>
                      <?php if($row->status){?>
                        <a href="<?=url('admin/' . $controllerRoute . '/change-status/'.Helper::encoded($row->id))?>" class="btn btn-outline-success btn-sm" title="Activate <?=$module['title']?>"><i class="fa fa-check"></i></a>
                      <?php } else {?>
                        <a href="<?=url('admin/' . $controllerRoute . '/change-status/'.Helper::encoded($row->id))?>" class="btn btn-outline-warning btn-sm" title="Deactivate <?=$module['title']?>"><i class="fa fa-times"></i></a>
                      <?php }?>
                    </td>
                  </tr>
                <?php } } else {?>
                  <tr>
                    <td colspan="5" style="text-align: center;color: red;">No Records Found !!!</td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>