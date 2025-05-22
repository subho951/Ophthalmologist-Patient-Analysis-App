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
          <h5 class="card-title">
          <div class="dt-responsive table-responsive">
            <table id="simpletable" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Customer Name</th>
                  <th scope="col">Customer Phone</th>
                  <th scope="col">Customer Email</th>
                  <th scope="col">Created At</th>
                  <th scope="col">Updated At</th>
                  <th scope="col">Orders</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($rows)>0){ $sl=1; foreach($rows as $row){?>
                  <tr>
                    <th scope="row"><?=$sl++?></th>
                    <td><?=$row->customer_name?></td>
                    <td><?=$row->customer_phone?></td>
                    <td><?=$row->customer_email?></td>
                    <td><?=date_format(date_create($row->created_at), "M d, Y h:i A")?></td>
                    <td><?=date_format(date_create($row->updated_at), "M d, Y h:i A")?></td>
                    <td>
                      <?php
                      $orderCount = Order::where('customer_phone', '=', $row->customer_phone)->where('status', 5)->count();
                      ?>
                      <a href="<?=url('admin/' . $controllerRoute . '/customer-orders/'.Helper::encoded($row->customer_phone))?>" class="btn btn-outline-info btn-sm" title="<?=$module['title']?> Orders" target="_blank"><i class="fa fa-list"></i>&nbsp; <?=$orderCount?> orders</a>
                    </td>
                  </tr>
                <?php } } else {?>
                  <tr>
                    <td colspan="7" style="text-align: center;color: red;">No Records Found !!!</td>
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