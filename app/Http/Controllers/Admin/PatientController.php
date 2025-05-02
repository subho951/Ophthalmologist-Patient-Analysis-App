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
use DateTime;
class PatientController extends Controller
{
    public function __construct()
    {        
        $this->data = array(
            'title'             => 'Patient',
            'controller'        => 'PatientController',
            'controller_route'  => 'patients',
            'primary_key'       => 'id',
        );
    }
    /* list */
        public function list(){
            $data['module']                 = $this->data;
            $title                          = $this->data['title'].' List';
            $page_name                      = 'patient.list';
            $data['rows']                   = Patient::where('status', '!=', 3)->orderBy('id', 'DESC')->get();
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* list */
    /* edit */
        public function edit(Request $request, $id){
            $data['module']                 = $this->data;
            $id                             = Helper::decoded($id);
            $title                          = $this->data['title'].' Update';
            $page_name                      = 'patient.add-edit';
            $data['row']                    = Patient::where($this->data['primary_key'], '=', $id)->first();
            $data['comorbodities']          = Comorbidity::select('id', 'name')->where('status', 1)->orderBy('id', 'ASC')->get();
            $data['doctors']                = Doctor::select('id', 'name')->where('status', 1)->orderBy('name', 'ASC')->get();
            if($request->isMethod('post')){
                $postData = $request->all();
                $rules = [
                    'doctor_id'                     => 'required',
                    'name'                          => 'required',
                    'email'                         => 'required',
                    'phone'                         => 'required',
                    'dob'                           => 'required',
                    'pincode'                       => 'required',
                    'gender'                        => 'required',
                    'eye'                           => 'required',
                    'comorbidities_id'              => 'required',
                ];
                if($this->validate($request, $rules)){
                    $checkData = Patient::where('name', 'LIKE', '%'.$postData['name'].'%')->where('status', '!=', 3)->where('id', '!=', $id)->first();
                    if(!$checkData){
                        $dob        = date_format(date_create($postData['dob']), "Y-m-d");
                        $dobDate    = new DateTime($dob);
                        $today      = new DateTime();
                        $age        = $today->diff($dobDate)->y;

                        $fields = [
                            'doctor_id'                     => $postData['doctor_id'],
                            'name'                          => $postData['name'],
                            'email'                         => $postData['email'],
                            'phone'                         => $postData['phone'],
                            'dob'                           => $postData['dob'],
                            'age'                           => $age,
                            'pincode'                       => $postData['pincode'],
                            'gender'                        => $postData['gender'],
                            'eye'                           => $postData['eye'],
                            'comorbidities_id'              => $postData['comorbidities_id'],
                            'status'                        => ((array_key_exists("status",$postData))?1:0),
                        ];
                        Patient::where($this->data['primary_key'], '=', $id)->update($fields);
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
    /* doctor tests */
        public function patientTests($patient_id){
            $patient_id                      = Helper::decoded($patient_id);
            $data['row']                    = Patient::where($this->data['primary_key'], '=', $patient_id)->first();
            $data['module']                 = $this->data;
            $title                          = 'Test List : ' . (($data['row'])?$data['row']->name:'');
            $page_name                      = 'patient.test-list';
            $data['rows']                   = Test::where('patient_id', '=', $patient_id)
                                                ->where('status', '=', 1)
                                                ->orderBy('id', 'DESC')
                                                ->get();
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* doctor tests */
}
