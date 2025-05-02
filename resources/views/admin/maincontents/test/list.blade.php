<?php
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\GeneralSetting;
use App\Helpers\Helper;
$controllerRoute      = $module['controller_route'];
$current_url          = url()->current();
$generalSetting             = GeneralSetting::find('1');
?>
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light"><a href="<?=url('admin/dashboard')?>">Dashboard</a> /</span> <?=$page_header?>
  </h4>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="dt-responsive table-responsive">
            <table id="simpletable" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Test No.</th>
                  <th scope="col">Doctor Info</th>
                  <th scope="col">Patient Info</th>
                  <th scope="col">Doctor Name</th>
                  <th scope="col">Dianosis Date</th>
                  <th scope="col">Test Date/Time</th>
                  <th scope="col">Test Score</th>
                  <th scope="col">Test Result</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($rows)>0){ $sl=1; foreach($rows as $row){?>
                  <tr>
                    <th scope="row"><?=$sl++?></th>
                    <td><?=$row->test_no?></td>
                    <td>
                      <?php
                      $getDoctor = Doctor::select('name')->where('id', $row->doctor_id)->first();
                      echo (($getDoctor)?$getDoctor->name:'');
                      ?>
                    </td>
                    <td>
                      <?php
                      $getPatient = Patient::select('name')->where('id', $row->patient_id)->first();
                      echo (($getPatient)?$getPatient->name:'');
                      ?>
                    </td>
                    <td><?=$row->doctor_name?></td>
                    <td><?=date_format(date_create($row->diagnosis_date), "M d, Y")?></td>
                    <td><?=date_format(date_create($row->test_date), "M d, Y")?> <?=date_format(date_create($row->test_time), "h:i A")?></td>
                    <td><?=$row->test_score?>/<?=$row->test_fullscore?></td>
                    <td><span class="badge <?=(($row->test_score >= $generalSetting->test_result_cut_off_marks)?'bg-success':'bg-danger')?>"><?=$row->test_result?></span></td>
                    <td>
                      <a target="_blank" href="<?=url('admin/' . $controllerRoute . '/test-details/'.Helper::encoded($row->id))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$module['title']?>"><i class="fa fa-info-circle"></i></a>
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