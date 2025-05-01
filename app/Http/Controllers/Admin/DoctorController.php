<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\GeneralSetting;
use App\Models\Doctor;
use App\Models\Test;
use App\Models\TestResultParameter;

use Auth;
use Session;
use Helper;
use Hash;
use DB;
class DoctorController extends Controller
{
    public function __construct()
    {        
        $this->data = array(
            'title'             => 'Doctor',
            'controller'        => 'DoctorController',
            'controller_route'  => 'doctors',
            'primary_key'       => 'id',
        );
    }
    /* list */
        public function list(){
            $data['module']                 = $this->data;
            $title                          = $this->data['title'].' List';
            $page_name                      = 'doctor.list';
            $data['rows']                   = Doctor::where('status', '!=', 3)->orderBy('id', 'DESC')->get();
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* list */
    /* edit */
        public function edit(Request $request, $id){
            $data['module']                 = $this->data;
            $id                             = Helper::decoded($id);
            $title                          = $this->data['title'].' Update';
            $page_name                      = 'doctor.add-edit';
            $data['row']                    = Doctor::where($this->data['primary_key'], '=', $id)->first();
            if($request->isMethod('post')){
                $postData = $request->all();
                $rules = [
                    'initials'                      => 'required',
                    'name'                          => 'required',
                    'regn_no'                       => 'required',
                    'email'                         => 'required',
                    'phone'                         => 'required',
                ];
                if($this->validate($request, $rules)){
                    $checkData = Doctor::where('name', 'LIKE', '%'.$postData['name'].'%')->where('status', '!=', 3)->where('id', '!=', $id)->first();
                    if(!$checkData){
                        /* profile image */
                            $imageFile      = $request->file('profile_image');
                            if($imageFile != ''){
                                $imageName      = $imageFile->getClientOriginalName();
                                $uploadedFile   = $this->upload_single_file('profile_image', $imageName, 'doctor', 'image');
                                if($uploadedFile['status']){
                                    $profile_image = $uploadedFile['newFilename'];
                                } else {
                                    return redirect()->back()->with(['error_message' => $uploadedFile['message']]);
                                }
                            } else {
                                $profile_image = $data['row']->profile_image;
                            }
                        /* profile image */
                        $fields = [
                            'initials'                  => $postData['initials'],
                            'name'                      => $postData['name'],
                            'regn_no'                   => $postData['regn_no'],
                            'email'                     => $postData['email'],
                            'phone'                     => $postData['phone'],
                            'profile_image'             => $profile_image,
                            'status'                    => ((array_key_exists("status",$postData))?1:0),
                        ];
                        Doctor::where($this->data['primary_key'], '=', $id)->update($fields);
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
            Doctor::where($this->data['primary_key'], '=', $id)->update($fields);
            return redirect("admin/" . $this->data['controller_route'] . "/list")->with('success_message', $this->data['title'].' Deleted Successfully !!!');
        }
    /* delete */
    /* change status */
        public function change_status(Request $request, $id){
            $id                             = Helper::decoded($id);
            $model                          = Doctor::find($id);
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
    /* doctor tests */
        public function doctorTests($doctor_id){
            $doctor_id                      = Helper::decoded($doctor_id);
            $data['row']                    = Doctor::where($this->data['primary_key'], '=', $doctor_id)->first();
            $data['module']                 = $this->data;
            $title                          = 'Test List : ' . (($data['row'])?$data['row']->name:'');
            $page_name                      = 'doctor.test-list';
            $data['rows']                   = Test::where('doctor_id', '=', $doctor_id)
                                                ->where('status', '=', 1)
                                                ->orderBy('id', 'DESC')
                                                ->get();
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* doctor tests */
}
