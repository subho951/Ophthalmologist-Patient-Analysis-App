<?php
use App\Models\Admin;
use App\Helpers\Helper;
$controllerRoute                = $module['controller_route'];
?>
<style type="text/css">
  .form-label{
    font-weight: bold;
  }
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
        <small class="text-danger">Star (*) marked fields are mandatory</small>
        <form method="GET" action="" enctype="multipart/form-data">
          <input type="hidden" name="mode" value="sale_report">
          <div class="row">
            <!-- <div class="col-lg-1 col-md-1">
              <label for="brand_id" class="form-label">Brand</label>
              <select class="form-control" name="brand_id" id="brand_id">
                <option value="" selected>Select</option>
                <?php if($brands){ foreach($brands as $brand){?>
                  <option value="<?=$brand->id?>" <?=(($brand_id == $brand->id)?'selected':'')?>><?=$brand->name?></option>
                <?php } }?>
              </select>
            </div>
            <div class="col-lg-1 col-md-1">
              <label for="supplier_id" class="form-label">Supplier</label>
              <select class="form-control" name="supplier_id" id="supplier_id">
                <option value="" selected>Select</option>
                <?php if($suppliers){ foreach($suppliers as $supplier){?>
                  <option value="<?=$supplier->id?>" <?=(($supplier_id == $supplier->id)?'selected':'')?>><?=$supplier->name?></option>
                <?php } }?>
              </select>
            </div> -->
            <div class="col-lg-2 col-md-2">
              <label for="from_date" class="form-label">From Date <small class="text-danger">*</small></label>
              <input type="date" class="form-control" id="from_date" name="from_date" value="<?=$from_date?>" required />
            </div>
            <div class="col-lg-2 col-md-2">
              <label for="to_date" class="form-label">To Date <small class="text-danger">*</small></label>
              <input type="date" class="form-control" id="to_date" name="to_date" value="<?=$to_date?>" required />
            </div>
            <div class="col-lg-2 col-md-2">
              <label for="delivery_mode" class="form-label">Delivery Mode</label>
              <select class="form-control" name="delivery_mode" id="delivery_mode">
                <option value="" selected>Select</option>
                <option value="Take" <?=(($delivery_mode == 'Take')?'selected':'')?>>Take</option>
                <option value="Deliver" <?=(($delivery_mode == 'Deliver')?'selected':'')?>>Deliver</option>
                <option value="Pickup" <?=(($delivery_mode == 'Pickup')?'selected':'')?>>Pickup</option>
              </select>
            </div>
            <div class="col-lg-2 col-md-2">
              <label for="payment_mode" class="form-label">Payment Mode</label>
              <select class="form-control" name="payment_mode" id="payment_mode">
                <option value="" selected>Select</option>
                <option value="CASH" <?=(($payment_mode == 'CASH')?'selected':'')?>>CASH</option>
                <option value="CARD" <?=(($payment_mode == 'CARD')?'selected':'')?>>CARD</option>
                <option value="VOUCHER" <?=(($payment_mode == 'VOUCHER')?'selected':'')?>>VOUCHER</option>
              </select>
            </div>
            <div class="col-lg-2 col-md-2">
              <label for="operator_id" class="form-label">Operator</label>
              <select class="form-control" name="operator_id" id="operator_id">
                <option value="" selected>Select</option>
                <?php if($operators){ foreach($operators as $operator){?>
                  <option value="<?=$operator->id?>" <?=(($operator_id == $operator->id)?'selected':'')?>><?=$operator->name?></option>
                <?php } }?>
              </select>
            </div>
            <div class="col-lg-2 col-md-2" style="margin-top: 33px;">
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane"></i>&nbsp;GENERATE</button>
              <?php if($is_search){?>
                <a href="<?=url('admin/report/sale-report')?>" class="btn btn-secondary btn-sm"><i class="fa fa-refresh"></i>&nbsp;Reset</a>
              <?php }?>
            </div>
         </div>
        </form>
      </div>
    </div>
    <?php if(count($rows)>0){ ?>
      <div class="card mt-3">
        <div class="card-body">
          <p><button type="button" class="btn btn-info btn-sm" id="printReport"><i class="fa fa-print"></i>&nbsp;PRINT</button></p>
          <div class="dt-responsive table-responsive" id="reportTable">
            <!-- <table class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th scope="col" class="form-label">#</th>
                  <th scope="col" class="form-label">Order No.</th>
                  <th scope="col" class="form-label">Operator</th>
                  <th scope="col" class="form-label">Customer Info</th>
                  <th scope="col" class="form-label">Delivery Info</th>
                  <th scope="col" class="form-label">Net Amount</th>
                  <th scope="col" class="form-label">Payment Mode</th>
                  <th scope="col" class="form-label">Payment Info</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($rows)>0){ $sl=1; foreach($rows as $row){?>
                  <tr style="page-break-inside: avoid;">
                    <th scope="row" style="text-align:center;"><?=$sl++?></th>
                    <td>
                      <a href="<?=url('admin/customer/order-details/' . Helper::encoded($row->id))?>" target="_blank"><?=$row->order_no?></a><br>
                      <?=date_format(date_create($row->created_at), "M d, Y")?><br>
                      <?=date_format(date_create($row->created_at), "h:i A")?>
                    </td>
                    <td>
                      <?php
                      $getOperator = Admin::select('id', 'name')->where('id', '=', $row->operator_id)->first();
                      echo (($getOperator)?$getOperator->name:'');
                      ?>
                    </td>
                    <td>
                      <?=$row->customer_name?><br>
                      <?=$row->customer_phone?><br>
                      <?=$row->customer_email?>
                    </td>
                    <td>
                      <?=$row->delivery_mode?><br>
                      <?php if($row->delivery_mode == 'Pickup'){?>
                        <?=$row->pickup_name?><br>
                        <?=$row->pickup_phone?><br>
                        <?=$row->pickup_email?>
                      <?php }?>
                      <?php if($row->delivery_mode == 'Deliver'){?>
                        <?=$row->delivery_name?><br>
                        <?=$row->delivery_phone?><br>
                        <?=$row->delivery_email?><br>
                        <?=$row->delivery_address?> <?=$row->delivery_suburb?><br>
                        <?=$row->delivery_state?> <?=$row->delivery_postcode?>
                      <?php }?>
                    </td>
                    <td>$<?=number_format($row->net_amount,2)?></td>
                    <td><?=$row->payment_mode?></td>
                    <td>
                      <?=(($row->payment_status)?'<span class="badge bg-success">PAID</span>':'<span class="badge bg-danger">UNPAID</span>')?><br>
                      $<?=number_format($row->payment_amount,2)?><br>
                      <?=date_format(date_create($row->payment_date_time), "M d, Y h:i A")?>
                    </td>
                  </tr>
                <?php } } else {?>
                  <tr>
                    <td colspan="12" style="text-align: center;color: red;">No Orders Found !!!</td>
                  </tr>
                <?php }?>
              </tbody>
            </table> -->
            <table class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th align="center" scope="col" class="form-label">#</th>
                  <th align="center" scope="col" class="form-label">SKU</th>
                  <th align="center" scope="col" class="form-label">Product (short name)</th>
                  <th align="center" scope="col" class="form-label">Qty (sold)</th>
                  <th align="center" scope="col" class="form-label">Buy</th>
                  <th align="center" scope="col" class="form-label">Sell</th>
                  <th align="center" scope="col" class="form-label">Gross Profit (%)</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($response)>0){ $sl=1; foreach($response as $row){?>
                  <tr style="page-break-inside: avoid;">
                    <th scope="row" style="text-align:center;"><?=$sl++?></th>
                    <td align="center"><?=$row['sku']?></td>
                    <td align="center"><?=$row['product_name']?></td>
                    <td align="center"><?=$row['qty']?></td>
                    <td align="center">$<?=$row['buy_ex']?></td>
                    <td align="center">$<?=$row['sell_ex']?></td>
                    <td align="center"><?=$row['gp']?>%</td>
                  </tr>
                <?php } } else {?>
                  <tr>
                    <td colspan="7" style="text-align: center;color: red;">No Orders Found !!!</td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php }?>
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