<style>
   .doctr-dashboard{
    font-size: 39px;
    color: yellowgreen;
}
.patient-dashboard{
    font-size: 39px;
    color: #20caee;
}
.test-dashboard{
      font-size: 39px;
      color: #ff725a;
}
</style>
<?php
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\GeneralSetting;
use App\Helpers\Helper;
// $controllerRoute      = $module['controller_route'];
$current_url          = url()->current();
$generalSetting             = GeneralSetting::find('1');
?>
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">      
      <div class="col-lg-12 col-md-4 order-1">
         <div class="row">
            <div class="col-lg-4 col-md-12 col-6 mb-4">
               <div class="card">
                  <div class="card-body">
                     <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                           <!-- <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded"> -->
                           <i class="doctr-dashboard fas fa-user-md"></i>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="bx bx-dots-vertical-rounded"></i>
                           </button>
                           <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                              <a class="dropdown-item" href="<?=url('admin/doctors/list')?>">View More</a>
                              <!-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> -->
                           </div>
                        </div>
                     </div>
                     <span class="fw-medium d-block mb-1">Doctor</span>
                     <h3 class="card-title mb-2"><?=$doctr_count?></h3>
                     <!-- <small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i> +72.80%</small> -->
                  </div>
               </div>
            </div>           
            <div class="col-lg-4 col-md-12 col-6 mb-4">
               <div class="card">
                  <div class="card-body">
                     <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                           <!-- <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded">   -->
                           <i class="patient-dashboard fa fa-users"></i>                        
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="bx bx-dots-vertical-rounded"></i>
                           </button>
                           <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                              <a class="dropdown-item" href="<?=url('admin/patients/list')?>">View More</a>
                              <!-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> -->
                           </div>
                        </div>
                     </div>
                     <span class="d-block mb-1">Patient</span>
                     <h3 class="card-title text-nowrap mb-2"><?=$patient_count?></h3>
                     <!-- <small class="text-danger fw-medium"><i class='bx bx-down-arrow-alt'></i> -14.82%</small> -->
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-12 col-6 mb-4">
               <div class="card">
                  <div class="card-body">
                     <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                           <!-- <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded">   -->
                           <i class="test-dashboard fa-solid fa-eye"></i>                         
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="bx bx-dots-vertical-rounded"></i>
                           </button>
                           <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                              <a class="dropdown-item" href="<?=url('admin/tests/list')?>">View More</a>
                              <!-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> -->
                           </div>
                        </div>
                     </div>
                     <span class="d-block mb-1">Test</span>
                     <h3 class="card-title text-nowrap mb-2"><?=$test_count?></h3>
                     <!-- <small class="text-danger fw-medium"><i class='bx bx-down-arrow-alt'></i> -14.82%</small> -->
                  </div>
               </div>
            </div>
         </div>
      </div>            
   </div>
   <div class="row">            
      <!-- Transactions -->
      <div class="col-md-6 col-lg-12 order-2 mb-4">
         <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
               <h5 class="card-title m-0 me-2">Latest Test Results</h5>               
            </div>   
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
                           <td><span class="badge <?=(($row->test_score >= $generalSetting->test_result_cut_off_marks)?'bg-success':'bg-danger')?>"><?=$row->test_result?></span> <a target="_blank" href="<?=url('admin/tests/test-details/'.Helper::encoded($row->id))?>" class="btn btn-outline-primary btn-sm" title="View Test Details"><i class="fa fa-info-circle"></i></a></td>                           
                           </tr>
                        <?php } }?>
                     </tbody>
                  </table>
               </div>
            </div>         
         </div>
      </div>
      <!--/ Transactions -->
   </div>
</div>