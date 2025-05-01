<?php
use App\Helpers\Helper;
$current_url = url()->current();
?>
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light"><a href="<?=url('admin/dashboard')?>">Dashboard</a> /</span> <?=$page_header?>
  </h4>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body" style="margin-top: 20px">
          <!-- Table with stripped rows -->
          <table style="width: 100%;  border-spacing: 2px;">
            <tbody>
                <tr>
                  <th style="background: #ccc; color: #000; width: 30%; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Full Name</th>
                  <td style="padding: 10px; background: #ccc; text-align: left; color: #000;font-family: sans-serif;font-size: 15px;"><?=$logData->name?></td>
                </tr>
                <tr>
                  <th style="background: #cccccc42; color: #000; width: 30%; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Email Address</th>
                  <td style="padding: 10px; background: #cccccc42; text-align: left; color: #000;font-family: sans-serif;font-size: 15px;"><?=$logData->email?></td>
                </tr>
                <tr>
                  <th style="background: #ccc; color: #000; width: 30%; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Phone</th>
                  <td style="padding: 10px; background: #ccc; text-align: left; color: #000;font-family: sans-serif;font-size: 15px;"><?=$logData->phone?></td>
                </tr>
                <tr>
                  <th style="background: #cccccc42; color: #000; width: 30%; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Subject</th>
                  <td style="padding: 10px; background: #cccccc42; text-align: left; color: #000;font-family: sans-serif;font-size: 15px;"><?=$logData->subject?></td>
                </tr>
                <tr>
                  <th style="background: #ccc; color: #000; width: 30%; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Description</th>
                  <td style="padding: 10px; background: #ccc; text-align: left; color: #000;font-family: sans-serif;font-size: 15px;"><?=$logData->message?></td>
                </tr>
                <tr>
                  <th style="background: #cccccc42; color: #000; width: 30%; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Added On</th>
                  <td style="padding: 10px; background: #cccccc42; text-align: left; color: #000;font-family: sans-serif;font-size: 15px;"><?=date_format(date_create($logData->created_at), "M d, Y h:i A")?></td>
                </tr>
              </tbody>
          </table>
          <!-- End Table with stripped rows -->
        </div>
      </div>
    </div>
  </div>
</div>