<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\GeneralSetting;
use App\Models\Admin;
use App\Models\Role;

use Auth;
use Session;
use Helper;
use Hash;
use DB;
class SubUserController extends Controller
{
    public function __construct()
    {        
        $this->data = array(
            'title'             => 'Sub User',
            'controller'        => 'SubUserController',
            'controller_route'  => 'sub-users',
            'primary_key'       => 'id',
        );
    }
    /* list */
        public function list(){
            $data['module']                 = $this->data;
            $title                          = $this->data['title'].' List';
            $page_name                      = 'sub-user.list';
            $sessionType                    = Session::get('type');
            $data['rows']                   = DB::table('admins')
                                                ->join('roles', 'admins.role_id', '=', 'roles.id')
                                                ->select('admins.*', 'roles.name as role_name')
                                                ->where('admins.status', '!=', 3)
                                                ->where('admins.type', '=', 'SU')
                                                ->orderBy('admins.id', 'DESC')
                                                ->get();
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* list */
    /* add */
        public function add(Request $request){
            $data['module']           = $this->data;
            if($request->isMethod('post')){
                $postData = $request->all();
                $rules = [
                    'role_id'               => 'required',
                    'name'                  => 'required',
                    'email'                 => 'required',
                    'username'              => 'required',
                    'mobile'                => 'required',
                    'password'              => 'required',
                ];
                if($this->validate($request, $rules)){
                    $checkValue = Admin::where('name', '=', $postData['name'])->count();
                    if($checkValue <= 0){
                        $checkValue2 = Admin::where('email', '=', $postData['email'])->count();
                        if($checkValue2 <= 0){
                            $checkValue3 = Admin::where('username', '=', $postData['username'])->count();
                            if($checkValue3 <= 0){
                                $checkValue4 = Admin::where('mobile', '=', $postData['mobile'])->count();
                                if($checkValue4 <= 0){
                                    $fields = [
                                        'role_id'           => $postData['role_id'],
                                        'type'              => 'SU',
                                        'name'              => $postData['name'],
                                        'mobile'            => $postData['mobile'],
                                        'email'             => $postData['email'],
                                        'username'          => $postData['username'],
                                        'status'            => $postData['status'],
                                        'password'          => Hash::make($postData['password']),
                                    ];
                                    Admin::insert($fields);
                                    return redirect("admin/" . $this->data['controller_route'] . "/list")->with('success_message', $this->data['title'].' Inserted Successfully !!!');
                                } else {
                                    return redirect()->back()->with('error_message', $this->data['title'].' Mobile Already Exists !!!');
                                }
                            } else {
                                return redirect()->back()->with('error_message', $this->data['title'].' Username Already Exists !!!');
                            }
                        } else {
                            return redirect()->back()->with('error_message', $this->data['title'].' Email Already Exists !!!');
                        }
                    } else {
                        return redirect()->back()->with('error_message', $this->data['title'].' Name Already Exists !!!');
                    }
                } else {
                    return redirect()->back()->with('error_message', 'All Fields Required !!!');
                }
            }
            $data['module']                 = $this->data;
            $title                          = $this->data['title'].' Add';
            $page_name                      = 'sub-user.add-edit';
            $data['row']                    = [];
            $data['roles']                  = Role::select('id', 'name')->where('status', '=', 1)->where('id', '=', 6)->get();
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* add */
    /* edit */
        public function edit(Request $request, $id){
            $data['module']                 = $this->data;
            $id                             = Helper::decoded($id);
            $title                          = $this->data['title'].' Update';
            $page_name                      = 'sub-user.add-edit';
            $data['row']                    = Admin::where($this->data['primary_key'], '=', $id)->first();
            $data['roles']                  = Role::select('id', 'name')->where('status', '=', 1)->where('id', '=', 6)->get();
            if($request->isMethod('post')){
                $postData = $request->all();
                $rules = [
                    'role_id'               => 'required',
                    'name'                  => 'required',
                    'email'                 => 'required',
                    'username'              => 'required',
                    'mobile'                => 'required',
                ];
                if($this->validate($request, $rules)){
                    $checkValue = Admin::where('name', '=', $postData['name'])->where('id', '!=', $id)->count();
                    if($checkValue <= 0){
                        $checkValue2 = Admin::where('email', '=', $postData['email'])->where('id', '!=', $id)->count();
                        if($checkValue2 <= 0){
                            $checkValue3 = Admin::where('username', '=', $postData['username'])->where('id', '!=', $id)->count();
                            if($checkValue3 <= 0){
                                $checkValue4 = Admin::where('mobile', '=', $postData['mobile'])->where('id', '!=', $id)->count();
                                if($checkValue4 <= 0){
                                    if($postData['password'] != ''){
                                        $fields = [
                                            'role_id'               => $postData['role_id'],
                                            'name'                  => $postData['name'],
                                            'mobile'                => $postData['mobile'],
                                            'email'                 => $postData['email'],
                                            'status'                => $postData['status'],
                                            'password'              => Hash::make($postData['password']),
                                            'updated_at'            => date('Y-m-d H:i:s')
                                        ];
                                    } else {
                                        $fields = [
                                            'role_id'               => $postData['role_id'],
                                            'name'                  => $postData['name'],
                                            'mobile'                => $postData['mobile'],
                                            'email'                 => $postData['email'],
                                            'status'                => $postData['status'],
                                            'updated_at'            => date('Y-m-d H:i:s')
                                        ];
                                    }
                                    Admin::where($this->data['primary_key'], '=', $id)->update($fields);
                                    return redirect("admin/" . $this->data['controller_route'] . "/list")->with('success_message', $this->data['title'].' Updated Successfully !!!');
                                } else {
                                    return redirect()->back()->with('error_message', $this->data['title'].' Mobile Already Exists !!!');
                                }
                            } else {
                                return redirect()->back()->with('error_message', $this->data['title'].' Username Already Exists !!!');
                            }
                        } else {
                            return redirect()->back()->with('error_message', $this->data['title'].' Email Already Exists !!!');
                        }
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
            Admin::where($this->data['primary_key'], '=', $id)->update($fields);
            return redirect("admin/" . $this->data['controller_route'] . "/list")->with('success_message', $this->data['title'].' Deleted Successfully !!!');
        }
    /* delete */
    /* change status */
        public function change_status(Request $request, $id){
            $id                             = Helper::decoded($id);
            $model                          = Admin::find($id);
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
