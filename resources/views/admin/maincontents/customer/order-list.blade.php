<?php
use App\Models\Order;
use App\Helpers\Helper;
$controllerRoute = $module['controller_route'];
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
            <div class="nav-align-top mb-4">
              <ul class="nav nav-pills mb-3" role="tablist">
                 <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#tab1" aria-controls="tab1" aria-selected="true">Take (<?=count($rows1)?>)</button>
                 </li>
                 <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab2" aria-controls="tab2" aria-selected="false">Pickup (<?=count($rows2)?>)</button>
                 </li>
                 <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab3" aria-controls="tab3" aria-selected="false">Delivery (<?=count($rows3)?>)</button>
                 </li>
              </ul>
              <div class="tab-content">
               <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                  <h5>Take Orders</h5>
                  <table <?=((count($rows1)>0)?'id="simpletable"':'')?> class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order No.</th>
                        <th scope="col">Order Date/Time</th>
                        <th scope="col">Net Amount</th>
                        <th scope="col">Payment Mode</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Payment Amount</th>
                        <th scope="col">Payment Date/Time</th>
                        <!-- <th scope="col">Note</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(count($rows1)>0){ $sl=1; foreach($rows1 as $row){?>
                        <tr>
                          <th scope="row"><?=$sl++?></th>
                          <td><a href="<?=url('admin/customer/order-details/' . Helper::encoded($row->id))?>" target="_blank"><?=$row->order_no?></a></td>
                          <td>
                            <?=date_format(date_create($row->created_at), "M d, Y")?><br>
                            <?=date_format(date_create($row->created_at), "h:i A")?>
                          </td>
                          <td>$<?=number_format($row->net_amount,2)?></td>
                          <td><?=$row->payment_mode?></td>
                          <td><?=(($row->payment_status)?'<span class="badge bg-success">PAID</span>':'<span class="badge bg-danger">UNPAID</span>')?></td>
                          <td>$<?=number_format($row->payment_amount,2)?></td>
                          <td><?=date_format(date_create($row->payment_date_time), "M d, Y h:i A")?></td>
                          <!-- <td><?=$row->note?></td> -->
                        </tr>
                      <?php } } else {?>
                        <tr>
                          <td colspan="8" style="text-align: center;color: red;">No Take Orders Found !!!</td>
                        </tr>
                      <?php }?>
                    </tbody>
                  </table>
               </div>
               <div class="tab-pane fade" id="tab2" role="tabpanel">
                  <h5>Pickup Orders</h5>
                  <table <?=((count($rows2)>0)?'id="simpletable2"':'')?> class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order No.</th>
                        <th scope="col">Order Date/Time</th>
                        <th scope="col">Pickup Info</th>
                        <th scope="col">Net Amount</th>
                        <th scope="col">Payment Mode</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Payment Amount</th>
                        <th scope="col">Payment Date/Time</th>
                        <!-- <th scope="col">Note</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(count($rows2)>0){ $sl=1; foreach($rows2 as $row){?>
                        <tr>
                          <th scope="row"><?=$sl++?></th>
                          <td><a href="<?=url('admin/customer/order-details/' . Helper::encoded($row->id))?>" target="_blank"><?=$row->order_no?></a></td>
                          <td>
                            <?=date_format(date_create($row->created_at), "M d, Y")?><br>
                            <?=date_format(date_create($row->created_at), "h:i A")?>
                          </td>
                          <td>
                            <?=$row->pickup_name?><br>
                            <?=$row->pickup_phone?><br>
                            <?=$row->pickup_email?>
                          </td>
                          <td>$<?=number_format($row->net_amount,2)?></td>
                          <td><?=$row->payment_mode?></td>
                          <td><?=(($row->payment_status)?'<span class="badge bg-success">PAID</span>':'<span class="badge bg-danger">UNPAID</span>')?></td>
                          <td>$<?=number_format($row->payment_amount,2)?></td>
                          <td><?=date_format(date_create($row->payment_date_time), "M d, Y h:i A")?></td>
                          <!-- <td><?=$row->note?></td> -->
                        </tr>
                      <?php } } else {?>
                        <tr>
                          <td colspan="9" style="text-align: center;color: red;">No Pickup Orders Found !!!</td>
                        </tr>
                      <?php }?>
                    </tbody>
                  </table>
               </div>
               <div class="tab-pane fade" id="tab3" role="tabpanel">
                  <h5>Delivery Orders</h5>
                  <table <?=((count($rows3)>0)?'id="simpletable3"':'')?> class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order No.</th>
                        <th scope="col">Order Date/Time</th>
                        <th scope="col">Delivery Info</th>
                        <th scope="col">Net Amount</th>
                        <th scope="col">Payment Mode</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Payment Amount</th>
                        <th scope="col">Payment Date/Time</th>
                        <!-- <th scope="col">Note</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(count($rows3)>0){ $sl=1; foreach($rows3 as $row){?>
                        <tr>
                          <th scope="row"><?=$sl++?></th>
                          <td><a href="<?=url('admin/customer/order-details/' . Helper::encoded($row->id))?>" target="_blank"><?=$row->order_no?></a></td>
                          <td>
                            <?=date_format(date_create($row->created_at), "M d, Y")?><br>
                            <?=date_format(date_create($row->created_at), "h:i A")?>
                          </td>
                          <td>
                            <?=$row->delivery_name?><br>
                            <?=$row->delivery_phone?><br>
                            <?=$row->delivery_email?><br>
                            <?=$row->delivery_address?> <?=$row->delivery_suburb?><br>
                            <?=$row->delivery_state?> <?=$row->delivery_postcode?>
                          </td>
                          <td>$<?=number_format($row->net_amount,2)?></td>
                          <td><?=$row->payment_mode?></td>
                          <td><?=(($row->payment_status)?'<span class="badge bg-success">PAID</span>':'<span class="badge bg-danger">UNPAID</span>')?></td>
                          <td>$<?=number_format($row->payment_amount,2)?></td>
                          <td><?=date_format(date_create($row->payment_date_time), "M d, Y h:i A")?></td>
                          <!-- <td><?=$row->note?></td> -->
                        </tr>
                      <?php } } else {?>
                        <tr>
                          <td colspan="9" style="text-align: center;color: red;">No Delivery Orders Found !!!</td>
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
    </div>
  </div>
</div>