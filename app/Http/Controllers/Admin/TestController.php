<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\GeneralSetting;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Comorbidity;
use App\Models\Test;
use App\Models\TestResultParameter;

use Auth;
use Session;
use Helper;
use Hash;
use DB;
class TestController extends Controller
{
    public function __construct()
    {        
        $this->data = array(
            'title'             => 'Test',
            'controller'        => 'TestController',
            'controller_route'  => 'tests',
            'primary_key'       => 'id',
        );
    }
    /* list */
        public function list(){
            $data['module']                 = $this->data;
            $title                          = $this->data['title'].' List';
            $page_name                      = 'test.list';
            $data['rows']                   = Test::where('status', '!=', 3)->orderBy('id', 'DESC')->get();
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* list */
    /* delete */
        public function delete(Request $request, $id){
            $id                             = Helper::decoded($id);
            $fields = [
                'status'             => 3
            ];
            Patient::where($this->data['primary_key'], '=', $id)->update($fields);
            return redirect("admin/" . $this->data['controller_route'] . "/list")->with('success_message', $this->data['title'].' Deleted Successfully !!!');
        }
    /* delete */
    /* change status */
        public function change_status(Request $request, $id){
            $id                             = Helper::decoded($id);
            $model                          = Patient::find($id);
            if ($model->status == 1)
            {
                $model->status  = 0;
                $msg            = 'Deactivated';
            } else {
                $model->status  = 1;
                $msg            = 'Activated';
            }            
            $model->save();
            return redirect("admin/" . $this->data['controller_route'] . "/list")->with('success_message', $this->data['title'].' '.$msg.' Successfully !!!');
        }
    /* change status */
    /* test details */
        public function testDetails($id){
            $id                             = Helper::decoded($id);
            $data['row']                    = Test::where($this->data['primary_key'], '=', $id)->first();
            $data['module']                 = $this->data;
            $title                          = 'Test Details : ' . (($data['row'])?$data['row']->test_no:'');
            $page_name                      = 'doctor.test-details';
            $data['rows']                   = TestResultParameter::where('test_id', '=', $id)
                                                ->where('status', '=', 1)
                                                ->orderBy('id', 'DESC')
                                                ->get();
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* test details */
}
