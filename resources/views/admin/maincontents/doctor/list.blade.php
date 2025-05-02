<?php
use App\Models\TestTab;
use App\Models\Test;
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
            <a href="<?=url('admin/' . $controllerRoute . '/add/')?>" class="btn btn-outline-success btn-sm float-right">Add <?=$module['title']?></a>
          </h5>
          <div class="dt-responsive table-responsive">
            <table id="simpletable" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Initials</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Registration No.</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($rows)>0){ $sl=1; foreach($rows as $row){?>
                  <tr>
                    <th scope="row"><?=$sl++?></th>
                    <td><?=$row->initials?></td>
                    <td><?=$row->name?></td>
                    <td><?=$row->email?></td>
                    <td><?=$row->phone?></td>
                    <td><?=$row->regn_no?></td>
                    <td>
                      <a href="<?=url('admin/' . $controllerRoute . '/edit/'.Helper::encoded($row->id))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$module['title']?>"><i class="fa fa-edit"></i></a>
                      <a href="<?=url('admin/' . $controllerRoute . '/delete/'.Helper::encoded($row->id))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$module['title']?>" onclick="return confirm('Do You Want To Delete This <?=$module['title']?>');"><i class="fa fa-trash"></i></a>
                      <?php if($row->status){?>
                        <a href="<?=url('admin/' . $controllerRoute . '/change-status/'.Helper::encoded($row->id))?>" class="btn btn-outline-success btn-sm" title="Activate <?=$module['title']?>"><i class="fa fa-check"></i></a>
                      <?php } else {?>
                        <a href="<?=url('admin/' . $controllerRoute . '/change-status/'.Helper::encoded($row->id))?>" class="btn btn-outline-warning btn-sm" title="Deactivate <?=$module['title']?>"><i class="fa fa-times"></i></a>
                      <?php }?>
                      <?php $testCount = Test::where('status', 1)->where('doctor_id', $row->id)->count();?>
                      <a target="_blank" href="<?=url('admin/' . $controllerRoute . '/doctors-tests/'.Helper::encoded($row->id))?>" class="btn btn-info btn-sm" title="<?=$module['title']?> Test List"><i class="fa fa-list"></i>&nbsp;Test List (<?=$testCount?>)</a>
                    </td>
                  </tr>
                <?php } }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>