<?php
use App\Models\Patient;
use App\Models\Comorbidity;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Patient Report</title>
  <style>
    *{
        margin: 0;
        padding: 0;
    }
    h1,h2,h3,h4,h5,h6,p,ul,li,ol,span,a{
        margin: 0;
        padding: 0;
    }
    body {
      font-family: sans-serif;
      background: #fff;
      color: #333;
    }

    .container {
      width: 350px;
      margin: 0 auto;
      text-align: center;
    }
    .report_number{
        background: #e8d2df;
        color: #531635;
        font-size: 18px;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    .report_number p{
        margin: 0;
    }
   
    .info-box {
      background: #f2ecf0;
      padding: 10px;
      border-radius: 8px;
      margin-top: 15px;
      text-align: left;
    }

    .info-box p {
      margin: 5px 0;
      font-size: 13px;
    }

    .label {
      display: inline-block;
      width: 160px;
    }

    .value {
      display: inline-block;
      font-weight: 600;
      font-size: 14px;
    }
    .info-box table td {
      padding: 6px 0;
      width: 50%;
    }
  </style>
</head>
<body>
    <?php if($test_report){?>
        <?php
        $getPatient            = Patient::where('id', '=', $test_report->patient_id)->first();
        $getcomorbidity        = Comorbidity::select('name')->where('id', '=', (($getPatient)?$getPatient->comorbidities_id:'')->first();
        ?>
        <div class="container">
            <!-- <div class="gauge-label">
              <span style="color:red;">Negative</span>
              <span style="color:green;">Positive</span>
            </div> -->
            <div class="report_number">
                <p><?=$test_report->test_no?></p>
            </div>
            <div class="metter_box">
                <img src="speedo-metter.jpg" alt="" style="width: 100%; max-width: 100%; height: auto;">
            </div>
            <div class="status"><?=$test_report->test_result?></div>

            <div class="info-box">
                <table valign="top" style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td valign="top"><span class="label">Patient’s Name <span style="float: right; margin-right: 2px; margin-top: -2px;">:</span></span></td>
                        <td valign="top"><span class="value highlight"><?=(($getPatient)?$getPatient->name:'')?></span></td>
                    </tr>
                    <tr>
                        <td valign="top"><span class="label">Patient’s Age <span style="float: right; margin-right: 2px; margin-top: -2px;">:</span></span></td>
                        <td valign="top"><span class="value"><?=(($getPatient)?$getPatient->age:'')?></span></td>
                    </tr>
                    <tr>
                        <td valign="top"><span class="label">Patient’s Gender <span style="float: right; margin-right: 2px; margin-top: -2px;">:</span></span></td>
                        <td valign="top"><span class="value"><?=(($getPatient)?$getPatient->gender:'')?></span></td>
                    </tr>
                    <tr>
                        <td valign="top"><span class="label">Patient’s Contact No <span style="float: right; margin-right: 2px; margin-top: -2px;">:</span></span></td>
                        <td valign="top"><span class="value"><?=(($getPatient)?$getPatient->phone:'')?></span></td>
                    </tr>
                    <tr>
                        <td valign="top"><span class="label">Affected Eye <span style="float: right; margin-right: 2px; margin-top: -2px;">:</span></span></td>
                        <td valign="top"><span class="value"><?=(($getPatient)?$getPatient->eye:'')?></span></td>
                    </tr>
                </table>
            </div>

            <div class="info-box">
                <table>
                    <tr>
                        <td valign="top"><span class="label">Co-Morbidities <span style="float: right; margin-right: 2px; margin-top: -2px;">:</span></span></td>
                        <td valign="top"><span class="value"><?=(($getcomorbidity)?$getcomorbidity->name:'')?></span></td>
                    </tr>
                </table>
            </div>

            <div class="info-box">
                <table>
                    <tr>
                        <td valign="top"><span class="label">Doctor’s Name <span style="float: right; margin-right: 2px; margin-top: -2px;">:</span></span></td>
                        <td valign="top"><span class="value"><?=$test_report->doctor_name?></span></td>
                    </tr>
                    <tr>
                        <td valign="top"><span class="label">Diagnosis Date <span style="float: right; margin-right: 2px; margin-top: -2px;">:</span></span></td>
                        <td valign="top"><span class="value"><?=date_format(date_create($test_report->diagnosis_date), "M d, Y")?></span></td>
                    </tr>
                </table>
            </div>

            <div class="info-box">
                <table>
                    <tr>
                        <td valign="middle"><span class="label" style="width: 230px;">Polypoidal Choroidal Vasculopathy Status</span></td>
                        <td valign="middle"><span class="value"><span style="float: left; margin-right: 2px;">:</span><?=$test_report->test_result?></span></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php }?>
</body>
</html>