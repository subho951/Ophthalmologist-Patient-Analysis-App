<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\GeneralSetting;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductDiscountVoucher;
use App\Models\ProductMultipleBuy;
use App\Models\Supplier;
use App\Models\Size;
use App\Models\Unit;

use Auth;
use Session;
use Helper;
use Hash;
class ReportController extends Controller
{
    public function __construct()
    {        
        $this->data = array(
            'title'             => 'Report',
            'controller'        => 'ReportController',
            'controller_route'  => 'brands',
            'primary_key'       => 'id',
        );
    }
    /* advance search report */
        public function advanceSearchReport(Request $request){
            $data['module']                 = $this->data;
            $title                          = 'Advance Search ' . $this->data['title'];
            $page_name                      = 'report.advance-search-report';
            $data['brands']                 = Brand::select('id', 'name')->where('status', '=', 1)->orderBy('name', 'ASC')->get();
            $data['suppliers']              = Supplier::select('id', 'name')->where('status', '=', 1)->orderBy('name', 'ASC')->get();

            $data['brand_id']               = '';
            $data['supplier_id']            = '';
            $data['from_date']              = '';
            $data['to_date']                = '';
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* advance search report */
    /* sale report */
        public function testReport(Request $request){
            $data['module']                 = $this->data;
            $title                          = 'Sale ' . $this->data['title'];
            $page_name                      = 'report.test-report';
            $data['brands']                 = Brand::select('id', 'name')->where('status', '=', 1)->orderBy('name', 'ASC')->get();
            $data['suppliers']              = Supplier::select('id', 'name')->where('status', '=', 1)->orderBy('name', 'ASC')->get();
            $data['operators']              = Admin::select('id', 'name')->where('status', '=', 1)->where('type', '=', 'SO')->orderBy('name', 'ASC')->get();

            $data['brand_id']               = '';
            $data['supplier_id']            = '';
            $data['from_date']              = '';
            $data['to_date']                = '';
            $data['delivery_mode']          = '';
            $data['payment_mode']           = '';
            $data['operator_id']            = '';
            $data['rows']                   = [];
            $data['is_search']              = 0;

            if ($request->isMethod('get') && $request->has('mode')) {
                // $brand_id           = $request->brand_id;
                // $supplier_id        = $request->supplier_id;
                $fromDate           = $request->from_date;
                $toDate             = $request->to_date;
                $deliveryMode       = $request->delivery_mode;
                $paymentMode        = $request->payment_mode;
                $operatorId         = $request->operator_id;                

                $data['rows']       = Order::query()
                                        ->where('status', 5) // fixed condition
                                        ->when(request('from_date'), fn ($query, $fromDate) => $query->whereDate('order_date', '>=', $fromDate))
                                        ->when(request('to_date'), fn ($query, $toDate) => $query->whereDate('order_date', '<=', $toDate))
                                        ->when(request('delivery_mode'), fn ($query, $deliveryMode) => $query->where('delivery_mode', $deliveryMode))
                                        ->when(request('payment_mode'), fn ($query, $paymentMode) => $query->where('payment_mode', $paymentMode))
                                        ->when(request('operator_id'), fn ($query, $operatorId) => $query->where('operator_id', $operatorId))
                                        ->get();
                $response           = [];
                if($data['rows']){
                    foreach($data['rows'] as $row){
                        $getOrderDetails = OrderDetail::where('order_id', $row->id)->get();
                        if($getOrderDetails){
                            foreach($getOrderDetails as $getOrderDetail){
                                $getProduct = Product::where('id', $getOrderDetail->item_id)->first();
                                if($getProduct){
                                    $profit     = ($getProduct->retail_price_inc_tax - $getProduct->cost_price_inc_tax);
                                    $gp         = (($profit / $getProduct->cost_price_inc_tax) * 100);
                                    $response[]           = [
                                        'sku'           => $getProduct->sku,
                                        'product_name'  => $getProduct->receipt_short_name,
                                        'qty'           => $getOrderDetail->qty,
                                        'buy_ex'        => number_format($getProduct->cost_price_inc_tax,2),
                                        'sell_ex'       => number_format($getProduct->retail_price_inc_tax,2),
                                        'gp'            => number_format($gp,2),
                                    ];
                                }
                            }
                        }
                    }
                }
                $data['response'] = $response;
                // Helper::pr($response,0);
                // Helper::pr($data['rows']);
                if(count($response) > 0){
                    $data['is_search'] = 1;
                }
            }
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* sale report */
}
