<?php
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Comorbidity;
use App\Models\TestTab;
use App\Models\TestParameter;
use App\Models\Test;
use App\Models\TestResultParameter;
use App\Helpers\Helper;
$controllerRoute      = $module['controller_route'];
$current_url          = url()->current();
?>
<style type="text/css">
  .fw-light{
    font-weight: 100;
  }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light"><a href="<?=url('admin/dashboard')?>">Dashboard</a> /</span> <?=$page_header?>
  </h4>
  <?php if($row){?>
    <?php
    $getDoctor      = Doctor::where('id', $row->doctor_id)->first();
    $getPatient     = Patient::where('id', $row->patient_id)->first();
    $getComorbodity = Comorbidity::select('name')->where('id', (($getPatient)?$getPatient->comorbidities_id:''))->first();
    ?>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <h5>Test Date : <span class="fw-light"><?=date_format(date_create($row->test_date), "M d, Y")?></span></h5>
                <h5>Doctor Info :</h5>
                <h6>Initials : <span class="fw-light"><?=(($getDoctor)?$getDoctor->initials:'')?></span></h6>
                <h6>Name : <span class="fw-light"><?=(($getDoctor)?$getDoctor->name:'')?></span></h6>
                <h6>Email : <span class="fw-light"><?=(($getDoctor)?$getDoctor->email:'')?></span></h6>
                <h6>Phone : <span class="fw-light"><?=(($getDoctor)?$getDoctor->phone:'')?></span></h6>
                <h6>Registration No. : <span class="fw-light"><?=(($getDoctor)?$getDoctor->regn_no:'')?></span></h6>
                <h6>Diagnosis Date : <span class="fw-light"><?=date_format(date_create($row->diagnosis_date), "M d, Y")?></span></h6>
              </div>
              <div class="col-md-6">
                <h5>Test Time : <span class="fw-light"><?=date_format(date_create($row->test_time), "h:i A")?></span></h5>
                <h5>Patient Info :</h5>
                <h6>Name : <span class="fw-light"><?=(($getPatient)?$getPatient->name:'')?></span></h6>
                <h6>Email : <span class="fw-light"><?=(($getPatient)?$getPatient->email:'')?></span></h6>
                <h6>Phone : <span class="fw-light"><?=(($getPatient)?$getPatient->phone:'')?></span></h6>
                <h6>DOB : <span class="fw-light"><?=(($getPatient)?date_format(date_create($getPatient->dob), "M d, Y"):'')?></span> (<span class="fw-light">Age : <?=(($getPatient)?$getPatient->age:'')?></span>)</h6>
                <h6>Pincode : <span class="fw-light"><?=(($getPatient)?$getPatient->pincode:'')?></span></h6>
                <h6>Gender : <span class="fw-light"><?=(($getPatient)?$getPatient->gender:'')?></span></h6>
                <h6>Affected Eye : <span class="fw-light"><?=(($getPatient)?$getPatient->eye:'')?></span></h6>
                <h6>Co-morbodities : <span class="fw-light"><?=(($getComorbodity)?$getComorbodity->name:'')?></span></h6>
              </div>
            </div>
            <div class="row mt-3">
              <hr>
              <div class="col-md-6">
                <h6>Polypodial Choroidal Vasculopathy Score : <span class="fw-light"><?=$row->test_score?>/<?=$row->test_fullscore?></span></h6>
              </div>
              <div class="col-md-6">
                <h6>Polypodial Choroidal Vasculopathy Status : <span class="fw-light"><span class="badge <?=(($row->test_score > 70)?'bg-success':'bg-danger')?>"><?=$row->test_result?></span></span></h6>
              </div>
            </div>
            <div class="row mt-3">
              <hr>
              <?php
              $testTabs = TestResultParameter::select('test_tab_id')->where('test_id', '=', $row->id)->where('status', '=', 1)->groupBy('test_tab_id')->orderBy('test_tab_id', 'asc')->get();
              if($testTabs){ foreach ($testTabs as $testTab) {
                $getTestTab      = TestTab::select('name')->where('id', $testTab->test_tab_id)->first();
              ?>
                <div class="col-md-4">
                  <h5><?=(($getTestTab)?$getTestTab->name:'')?></h5>
                  <ul class="list-group">
                    <?php
                    $testTabParams = TestResultParameter::select('test_parameter_id', 'test_parameter_value', 'test_parameter_weight')->where('test_id', '=', $row->id)->where('status', '=', 1)->where('test_tab_id', '=', $testTab->test_tab_id)->orderBy('test_parameter_id', 'asc')->get();
                    if($testTabParams){ foreach ($testTabParams as $testTabParam) {
                      $getTestParam      = TestParameter::select('name')->where('id', $testTabParam->test_parameter_id)->first();
                    ?>
                      <li class="list-group-item"><?=(($getTestParam)?$getTestParam->name:'')?>: <span class="<?=(($testTabParam->test_parameter_value)?'text-success':'text-danger')?>" style="font-size: 12px;font-weight: bold;"><?=(($testTabParam->test_parameter_value)?'YES':'NO')?></span></li>
                    <?php } }?>
                  </ul>
                </div>
              <?php } }?>
          </div>
        </div>
      </div>
    </div>
  <?php }?>
</div>