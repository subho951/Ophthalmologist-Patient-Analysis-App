<?php
    use App\Models\Patient;
    use App\Models\Comorbidity;
    use App\Helpers\Helper;
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
            body {
            font-family: sans-serif;
            background: #fff;
            color: #333;
            }
            h1,h2,h3,h4,h5,h6,p,ul,li,ol,span,a{
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            }
            .container {
            width: 100%;
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
            margin: 15px 30px 0;
            text-align: left;
            }
            .info-box p {
            margin: 5px 0;
            font-size: 13px;
            }
            .label {
            display: inline-block;
            width: max-content;
            }
            .value {
            display: inline-block;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            }
            .info-box table td {
            padding: 6px 0;
            /* width: 50%; */
            text-align: left;
            }
            canvas {
              display: block;
              margin: 40px auto;
              background: #fff;
            }
            @media print {
                .no-page-break {
                    page-break-inside: avoid; /* Legacy */
                    break-inside: avoid;      /* Modern browsers */
                }
            }
        </style>
    </head>
    <body class="no-page-break">
        <?php if($test_report){?>
        <?php
            $getPatient            = Patient::where('id', '=', $test_report->patient_id)->first();
            $getcomorbidity        = Comorbidity::select('name')->where('id', '=', $getPatient->comorbidities_id)->first();
            // Helper::pr($getcomorbidity);
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
                <img src="data:image/svg+xml;base64,<?php echo base64_encode(file_get_contents(base_path('public/uploads/test-report/'.$test_report->test_no.'.png'))); ?>" alt="" style="width: 100%; max-width: 200px; height: auto;">
                <!-- <canvas id="gaugeCanvas" width="400" height="250"></canvas> -->
            </div>
            <!-- <div class="status"><?=$test_report->test_result?></div> -->
            <div class="info-box">
                <table valign="top" style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td valign="top" style="width: 160px;">
                            <span class="label" style="width: 160px;">Patient’s Name <span style="float: right; margin-right: 2px;">:</span></span>
                        </td>
                        <td valign="top" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">
                            <p class="value highlight" style="width: 100%; text-align: left; font-family: sans-serif; display: block;"><?=(($getPatient)?$getPatient->name:'')?></p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="width: 160px;">
                            <span class="label" style="width: 160px;">Patient’s Age <span style="float: right; margin-right: 2px;">:</span></span>
                        </td>
                        <td valign="top" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">
                            <p class="value" style="width: 100%; text-align: left; font-family: sans-serif; display: block;"><?=(($getPatient)?$getPatient->age:'')?></p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="width: 160px;">
                        <span class="label" style="width: 160px;">Patient’s Gender <span style="float: right; margin-right: 2px;">:</span></span>
                        </td>
                        <td valign="top" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">
                            <p class="value" style="width: 100%; text-align: left; font-family: sans-serif; display: block;"><?=(($getPatient)?(($getPatient->gender == 'F')?'Female':'Male'):'')?></p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="width: 160px;">
                            <span class="label" style="width: 160px;">Patient’s Contact No <span style="float: right; margin-right: 2px;">:</span></span>
                        </td>
                        <td valign="top" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">
                            <p class="value" style="width: 100%; text-align: left; font-family: sans-serif; display: block;"><?=(($getPatient)?$getPatient->phone:'')?></p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="width: 160px;">
                            <span class="label" style="width: 160px;">Affected Eye <span style="float: right; margin-right: 2px;">:</span></span>
                        </td>
                        <td valign="top" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">
                            <p class="value" style="width: 100%; text-align: left; font-family: sans-serif; display: block;"><?=(($getPatient)?$getPatient->eye:'')?></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="info-box">
                <table>
                    <tr>
                        <td valign="top" style="width: 160px;">
                            <span class="label" style="width: 160px;">Co-Morbidities <span style="float: right; margin-right: 2px;">:</span></span>
                        </td>
                        <td valign="top" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">
                            <p class="value" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">
                                <?php
                                $comorbiditiesArray = [];
                                $comorbidities_id = json_decode($getPatient->comorbidities_id);
                                if (is_array($comorbidities_id)) {
                                    foreach ($comorbidities_id as $comorbidity) {
                                        $comorbidityData = Comorbidity::where('id', $comorbidity)->first();
                                        if ($comorbidityData) {
                                            $comorbiditiesArray[] = $comorbidityData->name;
                                        }
                                    }
                                }
                                echo implode(", ", $comorbiditiesArray);
                                ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <?php if($getPatient){ if($getPatient->comorbidities_note != ''){?>
                <div class="info-box">
                    <table>
                        <tr>
                            <td valign="top" style="width: 160px;">
                                <span class="label" style="width: 160px;">Co-Morbidities note <span style="float: right; margin-right: 2px;">:</span></span>
                            </td>
                            <td valign="top" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">
                                <p class="value" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">
                                    <?=(($getPatient)?$getPatient->comorbidities_note:'')?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } }?>
            <div class="info-box">
                <table>
                    <tr>
                        <td valign="top" style="width: 160px;">
                            <span class="label" style="width: 160px;">Doctor’s Name <span style="float: right; margin-right: 2px;">:</span></span>
                        </td>
                        <td valign="top" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">
                            <p class="value" style="width: 100%; text-align: left; font-family: sans-serif; display: block;"><?=$test_report->doctor_name?></p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="width: 160px;">
                            <span class="label" style="width: 160px;">Diagnosis Date <span style="float: right; margin-right: 2px; margin-top: -2px;">:</span></span>
                        </td>
                        <td valign="top" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">
                            <p class="value" style="width: 100%; text-align: left; font-family: sans-serif; display: block;"><?=date_format(date_create($test_report->diagnosis_date), "M d, Y")?></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="info-box">
                <table>
                    <tr>
                        <td valign="middle" style="width: 200px;">
                            <span class="label" style="width: 200px;">Polypoidal Choroidal Vasculopathy Status</span>
                        </td>
                        <td valign="middle" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">
                            <p class="value" style="width: 100%; text-align: left; font-family: sans-serif; display: block;">: <?=$test_report->test_result?></p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php }?>
    </body>
</html>
<script>
    function drawGauge(value) {
      const canvas = document.getElementById('gaugeCanvas');
      const ctx = canvas.getContext('2d');
      const centerX = 200;
      const centerY = 200;
      const radius = 150;
      const cutOff = 47.74;

      ctx.clearRect(0, 0, canvas.width, canvas.height);

      // Draw negative (left) arc in red
      const cutOffAngle = Math.PI * (cutOff / 100);
      ctx.beginPath();
      ctx.arc(centerX, centerY, radius, Math.PI, Math.PI + cutOffAngle);
      ctx.strokeStyle = '#f44236';
      ctx.lineWidth = 45;
      ctx.stroke();
      ctx.fillText('Negative', centerX-170, centerY+10);

      // Draw positive (right) arc in green
      ctx.beginPath();
      ctx.arc(centerX, centerY, radius, Math.PI + cutOffAngle, 2 * Math.PI);
      ctx.strokeStyle = 'green';
      ctx.lineWidth = 45;
      ctx.stroke();
      ctx.fillText('Positive', centerX+130, centerY+10);

      // Draw cut-off marker
      const markerAngle = Math.PI + Math.PI * (cutOff / 100);
      const mx1 = centerX + Math.cos(markerAngle) * (radius - 10);
      const my1 = centerY + Math.sin(markerAngle) * (radius - 10);
      const mx2 = centerX + Math.cos(markerAngle) * (radius + 10);
      const my2 = centerY + Math.sin(markerAngle) * (radius + 10);
      ctx.beginPath();
      ctx.moveTo(mx1, my1);
      ctx.lineTo(mx2, my2);
      ctx.strokeStyle = 'black';
      ctx.lineWidth = 3;
      ctx.stroke();

      // Draw needle
      const needleAngle = Math.PI + Math.PI * (value / 100);
      const needleLength = radius - 30;
      const nx = centerX + Math.cos(needleAngle) * needleLength;
      const ny = centerY + Math.sin(needleAngle) * needleLength;
      ctx.beginPath();
      ctx.moveTo(centerX, centerY);
      ctx.lineTo(nx, ny);
      ctx.strokeStyle = '#000';
      ctx.lineWidth = 5;
      ctx.stroke();

      // Center dot
      ctx.beginPath();
      ctx.arc(centerX, centerY, 6, 0, 2 * Math.PI);
      ctx.fillStyle = '#000';
      ctx.fill();

      // Value Text
      ctx.font = '20px sans-serif';
      ctx.fillStyle = '#333';
      ctx.textAlign = 'center';
      // ctx.fillText(`${value.toFixed(2)}%`, centerX, centerY + 40);
      ctx.fillText('Negative', centerX, centerY + 40);
    }

    // Example usage
    drawGauge(60);  // Change this to test different values
</script>