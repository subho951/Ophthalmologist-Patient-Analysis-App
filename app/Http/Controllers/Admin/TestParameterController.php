<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\GeneralSetting;
use App\Models\TestTab;
use App\Models\TestParameter;

use Auth;
use Session;
use Helper;
use Hash;
class TestParameterController extends Controller
{
    public function __construct()
    {        
        $this->data = array(
            'title'             => 'Test Parameter',
            'controller'        => 'TestParameterController',
            'controller_route'  => 'test-parameters',
            'primary_key'       => 'id',
        );
    }
    /* list */
        public function list(){
            $data['module']                 = $this->data;
            $title                          = $this->data['title'].' List';
            $page_name                      = 'test-parameters.list';
            $data['rows']                   = TestParameter::where('status', '!=', 3)->orderBy('rank', 'ASC')->get();
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* list */
    /* add */
        public function add(Request $request){
            $data['module']           = $this->data;
            if($request->isMethod('post')){
                $postData = $request->all();
                $rules = [
                    'test_tab_id'               => 'required',
                    'name'                      => 'required',
                    'weight'                    => 'required',
                    // 'hints'                     => 'required',
                    'rank'                      => 'required',
                ];
                if($this->validate($request, $rules)){
                    $checkData = TestParameter::where('name', 'LIKE', '%'.$postData['name'].'%')->where('status', '!=', 3)->first();
                    if(!$checkData){
                        $fields = [
                            'test_tab_id'             => $postData['test_tab_id'],
                            'name'                    => $postData['name'],
                            'weight'                  => $postData['weight'],
                            'options'                 => json_encode($postData['options']),
                            'hints'                   => $postData['hints'],
                            'rank'                    => $postData['rank'],
                            'status'                  => ((array_key_exists("status",$postData))?1:0),
                        ];
                        // Helper::pr($fields);
                        TestParameter::insert($fields);
                        return redirect("admin/" . $this->data['controller_route'] . "/list")->with('success_message', $this->data['title'].' Inserted Successfully !!!');
                    } else {
                        return redirect()->back()->with('error_message', $this->data['title'].' Already Exists !!!');
                    }
                } else {
                    return redirect()->back()->with('error_message', 'All Fields Required !!!');
                }
            }
            $data['module']                 = $this->data;
            $title                          = $this->data['title'].' Add';
            $page_name                      = 'test-parameters.add-edit';
            $data['row']                    = [];
            $data['testTabs']               = TestTab::select('id', 'name')->where('status', 1)->orderBy('rank', 'ASC')->get();
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* add */
    /* edit */
        public function edit(Request $request, $id){
            $data['module']                 = $this->data;
            $id                             = Helper::decoded($id);
            $title                          = $this->data['title'].' Update';
            $page_name                      = 'test-parameters.add-edit';
            $data['row']                    = TestParameter::where($this->data['primary_key'], '=', $id)->first();
            $data['testTabs']               = TestTab::select('id', 'name')->where('status', 1)->orderBy('rank', 'ASC')->get();
            if($request->isMethod('post')){
                $postData = $request->all();
                $rules = [
                    'test_tab_id'               => 'required',
                    'name'                      => 'required',
                    'weight'                    => 'required',
                    // 'hints'                     => 'required',
                    'rank'                      => 'required',
                ];
                if($this->validate($request, $rules)){
                    $checkData = TestParameter::where('name', 'LIKE', '%'.$postData['name'].'%')->where('status', '!=', 3)->where('id', '!=', $id)->first();
                    if(!$checkData){
                        $fields = [
                            'test_tab_id'             => $postData['test_tab_id'],
                            'name'                    => $postData['name'],
                            'weight'                  => $postData['weight'],
                            'options'                 => json_encode($postData['options']),
                            'hints'                   => $postData['hints'],
                            'rank'                    => $postData['rank'],
                            'status'                  => ((array_key_exists("status",$postData))?1:0),
                        ];
                        TestParameter::where($this->data['primary_key'], '=', $id)->update($fields);
                        return redirect("admin/" . $this->data['controller_route'] . "/list")->with('success_message', $this->data['title'].' Updated Successfully !!!');
                    } else {
                        return redirect()->back()->with('error_message', $this->data['title'].' Already Exists !!!');
                    }
                } else {
                    return redirect()->back()->with('error_message', 'All Fields Required !!!');
                }
            }
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* edit */
    /* delete */
        public function delete(Request $request, $id){
            $id                             = Helper::decoded($id);
            $fields = [
                'status'             => 3
            ];
            TestParameter::where($this->data['primary_key'], '=', $id)->update($fields);
            return redirect("admin/" . $this->data['controller_route'] . "/list")->with('success_message', $this->data['title'].' Deleted Successfully !!!');
        }
    /* delete */
    /* change status */
        public function change_status(Request $request, $id){
            $id                             = Helper::decoded($id);
            $model                          = TestParameter::find($id);
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
}
