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
use App\Models\Doctor;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Patient;
use App\Models\Product;
use App\Models\ProductDiscountVoucher;
use App\Models\ProductMultipleBuy;
use App\Models\Supplier;
use App\Models\Size;
use App\Models\Test;
use App\Models\Unit;

use Auth;
use Session;
use Helper;
use Hash;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\Help;

class ReportController extends Controller
{
    public function __construct()
    {        
        $this->data = array(
            'title'             => 'Reports',
            'controller'        => 'ReportController',
            'controller_route'  => 'test-report',
            'primary_key'       => 'id',
        );
    }
    
    /* test report */
        public function testReport(Request $request){
            $data['module']                 = $this->data;
            $title                          = 'Test ' . $this->data['title'];
            $page_name                      = 'report.test-report';                        
            $data['from_date']              = '';
            $data['to_date']                = '';
            $data['doctorId']          = '';
            $data['patientId']           = '';
            $data['diagnosisDate']            = '';
            $data['rows']                   = [];
            $data['is_search']              = 0;

            if ($request->isMethod('get') && $request->has('mode')) {
                if (
                    !$request->filled('from_date') &&
                    !$request->filled('to_date') &&
                    !$request->filled('doctor') &&
                    !$request->filled('patient') &&
                    !$request->filled('diagnosis_date')
                ) {
                    return back()
                        ->withInput()
                        ->withErrors(['filter' => 'At least one field must be filled.']);
                }
                
                $fromDate           = $request->from_date;
                $toDate             = $request->to_date;
                $doctorid       = $request->doctor;
                $patientid        = $request->patient;
                $diagnosisdate         = $request->diagnosis_date;                
                // DB::enableQueryLog();
                $data['rows']       = Test::query()
                                        ->where('status', 1) // fixed condition
                                        ->when(request('from_date'), fn ($query, $fromDate) => $query->whereDate('test_date', '>=', $fromDate))
                                        ->when(request('to_date'), fn ($query, $toDate) => $query->whereDate('test_date', '<=', $toDate))
                                        ->when(request('doctor'), fn ($query, $doctorid) => $query->where('doctor_id', $doctorid))
                                        ->when(request('patient'), fn ($query, $patientid) => $query->where('patient_id', $patientid))
                                        ->when(request('diagnosis_date'), fn ($query, $diagnosisdate) => $query->where('diagnosis_date', $diagnosisdate))
                                        ->get();
                                            // dd(DB::getQueryLog());
                // Helper::pr($data['rows']);
                // echo count($data['rows']);
                // $data['response'] = [];
                $response           = [];
                if($data['rows']){
                    foreach($data['rows'] as $row){                          
                        $getpatientDetails = Patient::where('id', $row->patient_id)->first();                        
                        // Helper::pr($getpatientDetails);
                        $response[]           = [
                            'test_id'                => $row->id,
                            'test_no'           => $row->test_no,
                            'doctor_name'       => $row->doctor_name,
                            'patient_name'      => $getpatientDetails->name,
                            'diagnosis_date'    => $row->diagnosis_date,
                            'test_date'         => $row->test_date,
                            'test_time'         => $row->test_time,
                            'test_total_weight' => $row->test_total_weight,
                            'test_result'       => $row->test_result,
                            'test_fullscore'    => $row->test_fullscore,
                            'test_score'        => $row->test_score,   
                            'test_report'      => $row->test_report_pdf,                              
                        ];
                    }
                }
                $data['response'] = $response;
                $data['response_count'] = count($response);
                $data['row_count'] = count($data['rows']);
                $data['from_date'] = $fromDate;
                $data['to_date'] = $toDate;
                $data['doctorId'] = $doctorid;
                $data['patientId'] = $patientid;
                $data['diagnosisDate'] = $diagnosisdate;
                // Helper::pr($response,0);
                // Helper::pr($data['rows']);
                // echo count($response);
                if(count($response) >= 0){
                    $data['is_search'] = 1;
                }
            }
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* sale report */
}
