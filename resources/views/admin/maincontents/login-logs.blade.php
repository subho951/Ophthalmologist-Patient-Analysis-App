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
       <div class="nav-align-top mb-4">
          <ul class="nav nav-tabs nav-tabs-bordered">
            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab2">Success Login</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab1">Falied Login</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab3">Logout</button>
            </li>
          </ul>
          <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="tab2">
              <div class="dt-responsive table-responsive">
                <table id="simpletable" class="table table-striped table-bordered nowrap">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">User Type</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">IP Address</th>
                      <th scope="col">Activity Details</th>
                      <th scope="col">Activity Date</th>
                      <th scope="col">Activity Type</th>
                      <th scope="col">Platform</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(count($rows2) > 0){ $sl=1; foreach($rows2 as $row){?>
                      <tr>
                        <th scope="row"><?=$sl++?></th>
                        <td><?=$row->user_type?></td>
                        <td><?=$row->user_name?></td>
                        <td><?=$row->user_email?></td>
                        <td><?=$row->ip_address?></td>
                        <td><?=$row->activity_details?></td>
                        <td><?=date_format(date_create($row->created_at), "M d, Y h:i A")?></td>
                        <td>
                          <?php if($row->activity_type == 0) {?>
                            <span class="badge bg-danger">FAILED</span>
                          <?php } elseif($row->activity_type == 1) {?>
                            <span class="badge bg-success">SUCCESS</span>
                          <?php } elseif($row->activity_type == 2) {?>
                            <span class="badge bg-primary">Log Out</span>
                          <?php }?>
                        </td>
                        <td><?=$row->platform_type?></td>
                      </tr>
                    <?php } }?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade show profile-overview" id="tab1">
              <div class="dt-responsive table-responsive">
                <table id="simpletable2" class="table table-striped table-bordered nowrap">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">User Type</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">IP Address</th>
                      <th scope="col">Activity Details</th>
                      <th scope="col">Activity Date</th>
                      <th scope="col">Activity Type</th>
                      <th scope="col">Platform</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(count($rows1) > 0){ $sl=1; foreach($rows1 as $row){?>
                      <tr>
                        <th scope="row"><?=$sl++?></th>
                        <td><?=$row->user_type?></td>
                        <td><?=$row->user_name?></td>
                        <td><?=$row->user_email?></td>
                        <td><?=$row->ip_address?></td>
                        <td><?=$row->activity_details?></td>
                        <td><?=date_format(date_create($row->created_at), "M d, Y h:i A")?></td>
                        <td>
                          <?php if($row->activity_type == 0) {?>
                            <span class="badge bg-danger">FAILED</span>
                          <?php } elseif($row->activity_type == 1) {?>
                            <span class="badge bg-success">SUCCESS</span>
                          <?php } elseif($row->activity_type == 2) {?>
                            <span class="badge bg-primary">Log Out</span>
                          <?php }?>
                        </td>
                        <td><?=$row->platform_type?></td>
                      </tr>
                    <?php } }?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade show profile-overview" id="tab3">
              <div class="dt-responsive table-responsive">
                <table id="simpletable3" class="table table-striped table-bordered nowrap">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">User Type</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">IP Address</th>
                      <th scope="col">Activity Details</th>
                      <th scope="col">Activity Date</th>
                      <th scope="col">Activity Type</th>
                      <th scope="col">Platform</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(count($rows3) > 0){ $sl=1; foreach($rows3 as $row){?>
                      <tr>
                        <th scope="row"><?=$sl++?></th>
                        <td><?=$row->user_type?></td>
                        <td><?=$row->user_name?></td>
                        <td><?=$row->user_email?></td>
                        <td><?=$row->ip_address?></td>
                        <td><?=$row->activity_details?></td>
                        <td><?=date_format(date_create($row->created_at), "M d, Y h:i A")?></td>
                        <td>
                          <?php if($row->activity_type == 0) {?>
                            <span class="badge bg-danger">FAILED</span>
                          <?php } elseif($row->activity_type == 1) {?>
                            <span class="badge bg-success">SUCCESS</span>
                          <?php } elseif($row->activity_type == 2) {?>
                            <span class="badge bg-primary">Log Out</span>
                          <?php }?>
                        </td>
                        <td><?=$row->platform_type?></td>
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
</div>