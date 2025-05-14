<?php
use App\Models\Admin;
use App\Helpers\Helper;
use App\Models\Doctor;
use App\Models\Patient;

$controllerRoute                = $module['controller_route'];
?>
<style type="text/css">
  .form-label{
    font-weight: bold;
  }
  .error { color: red; }
  table>tbody>tr>th, table>tbody>tr>td {
    padding: 1px 5px !important;
    font-size: 12px !important;
  }
  @media print {
    body * {
        visibility: hidden; /* Hide everything by default */
    }
    
    #reportTable, #reportTable * {
        visibility: visible; /* Show only the table */
    }

    #reportTable {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    table>tbody>tr>th, table>tbody>tr>td {
      padding: 1px 4px !important;
      font-size: 10px !important;
    }
    table>thead>tr>th {
      font-weight: bold;
    }
}
</style>
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light"><a href="<?=url('admin/dashboard')?>">Dashboard</a> /</span>
    <span class="text-muted fw-light"><a href="<?=url('admin/' . $controllerRoute . '/list/')?>"><?=$module['title']?> List</a> /</span>
    <?=$page_header?>
  </h4>
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
      <!-- @if ($errors->has('filter'))
          <div class="alert alert-danger">
              {{ $errors->first('filter') }}
          </div>
      @endif -->
        <!-- <small class="text-danger">Star (*) marked fields are mandatory</small> -->
        <div id="search-error" class="error" style="display: none;"></div>
        <form method="GET" action="" enctype="multipart/form-data">
          <input type="hidden" name="mode" value="test_report">
          <div class="row">           
            <div class="col-lg-2 col-md-2">
              <label for="from_date" class="form-label">From Date <small class="text-danger">*</small></label>
              <input type="date" class="form-control" id="from_date" name="from_date" value="<?=$from_date?>"  />
            </div>
            <div class="col-lg-2 col-md-2">
              <label for="to_date" class="form-label">To Date <small class="text-danger">*</small></label>
              <input type="date" class="form-control" id="to_date" name="to_date" value="<?=$to_date?>"  />
            </div>
            <div class="col-lg-2 col-md-2">
              <label for="doctor" class="form-label">Docters</label>
              <select class="form-control" name="doctor" id="doctor">
                <option value="" selected>Select</option>                           
                <?php
                $getDoctor = Doctor::where('status', 1)->get();              
                foreach($getDoctor as $doctor){
                  $doctor_id = $doctor->id;
                  $doctor_name = $doctor->name;                
                  ?>
                  <option value="<?=$doctor_id?>" <?=(($doctorId == $doctor_id)?'selected':'')?>><?=$doctor_name?></option>                
                <?php }
                ?>
              </select>
            </div>
            <div class="col-lg-2 col-md-2">
              <label for="patient" class="form-label">Pataients</label>
              <select class="form-control" name="patient" id="patient">
              <option value="" selected>Select</option>
              <?php
                $getPatient = Patient::where('status', 1)->get();              
                foreach($getPatient as $patient){
                  $patient_id = $patient->id;
                  $patient_name = $patient->name;                
                  ?>                  
                  <option value="<?=$patient_id?>" <?=(($patientId == $patient_id)?'selected':'')?>><?=$patient_name?></option>                
                <?php }
                ?>
              </select>
            </div>
            <div class="col-lg-2 col-md-2">
              <label for="diagnosis_date" class="form-label">Diagnosis Date</label>
              <input type="date" class="form-control" id="diagnosis_date" name="diagnosis_date" value="<?=$diagnosisDate?>" />               
            </div>
            <div class="col-lg-2 col-md-2" style="margin-top: 33px;">
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane"></i>&nbsp;GENERATE</button>
              <?php if($is_search){?>
                <a href="<?=url('admin/report/test-report')?>" class="btn btn-secondary btn-sm"><i class="fa fa-refresh"></i>&nbsp;Reset</a>
              <?php }?>
            </div>
         </div>
        </form>
      </div>
    </div>
    <?php if($is_search) { ?>
    <div class="card mt-3">
      <div class="card-body">
        <p><button type="button" class="btn btn-info btn-sm" id="printReport"><i class="fa fa-print"></i>&nbsp;PRINT</button></p>
        <div class="dt-responsive table-responsive" id="reportTable">
          <table class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                <th>#</th>
                <th>Test No.</th>
                <th>Doctor Info</th>
                <th>Patient Info</th>
                <th>Dianosis Date</th>
                <th>Test Date/Time</th>
                <th>Test Score</th>
                <th>Test Result</th>
                <th>Report</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($response) && count($response) > 0){ $sl=1; foreach($response as $row){ ?>
              <tr>
                <th><?=$sl++?></th>
                <td><?=$row['test_no']?></td>
                <td><?=$row['doctor_name']?></td>
                <td><?=$row['patient_name']?></td>
                <td><?=date('M d, Y', strtotime($row['diagnosis_date']))?></td>
                <td><?=date('M d, Y', strtotime($row['test_date']))?> <?=date('h:i A', strtotime($row['test_time']))?></td>
                <td><?=$row['test_score']?> / <?=$row['test_fullscore']?></td>
                <td>
                  <span class="badge <?=($row['test_score'] >= $generalSetting['test_result_cut_off_marks']) ? 'bg-success' : 'bg-danger'?>">
                    <?=$row['test_result']?>
                  </span>
                  <a target="_blank" href="<?=url('admin/tests/test-details/'.Helper::encoded($row['test_id']))?>" class="btn btn-outline-primary btn-sm" title="View Test Details">
                    <i class="fa fa-info-circle"></i>
                  </a>
                </td>
                <td>
                  <img src="<?=url('public/uploads/test-report/'.$row->test_no.'.png')?>" alt="Test Image" class="img-fluid" style="width: 100%; height: auto; border-radius: 5px;border: 2px solid">
                </td>
              </tr>
              <?php }} else { ?>
              <tr>
                <td colspan="9" style="text-align:center; color:red;">No Records Found !!!</td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
<script>
  document.getElementById("printReport").addEventListener("click", function() {
      var printContents = document.getElementById("reportTable").outerHTML;
      var originalContents = document.body.innerHTML;
      
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
      window.location.reload(); // Reload to restore original page
  });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const today = new Date().toISOString().split('T')[0];

    // Set max attribute to today
    document.getElementById("from_date").setAttribute("max", today);
    document.getElementById("to_date").setAttribute("max", today);
    document.getElementById("diagnosis_date").setAttribute("max", today);
});
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const searchError = document.getElementById("search-error");

    const fromDate = document.getElementById("from_date");
    const toDate = document.getElementById("to_date");
    const doctor = document.getElementById("doctor");
    const patient = document.getElementById("patient");
    const diagnosisDate = document.getElementById("diagnosis_date");

    function handleRequiredFields() {
      // Set required based on whether the other is filled
      if (fromDate.value && !toDate.value) {
        toDate.setAttribute("required", "required");
      } else {
        toDate.removeAttribute("required");
      }

      if (toDate.value && !fromDate.value) {
        fromDate.setAttribute("required", "required");
      } else {
        fromDate.removeAttribute("required");
      }
    }

    form.addEventListener("submit", function (e) {
      handleRequiredFields(); // Ensure proper required attributes are set

      const isAllEmpty =
        !fromDate.value &&
        !toDate.value &&
        !doctor.value &&
        !patient.value &&
        !diagnosisDate.value;

      if (isAllEmpty) {
        e.preventDefault();
        $('#search-error').text('At least one field must be filled.').show();
      } else {
        $('#search-error').hide();
      }
    });

    // Dynamically hide error and update required attributes
    [fromDate, toDate, doctor, patient, diagnosisDate].forEach(el => {
      el.addEventListener('input', () => {
        $('#search-error').hide();
        handleRequiredFields();
      });
      el.addEventListener('change', () => {
        $('#search-error').hide();
        handleRequiredFields();
      });
    });
  });
</script>

