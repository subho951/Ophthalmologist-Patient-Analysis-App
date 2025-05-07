<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Attendance;
use App\Models\Banner;
use App\Models\Country;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\ClientCheckIn;
use App\Models\ClientOrder;
use App\Models\ClientOrderDetail;
use App\Models\District;
use App\Models\DeleteAccountRequest;
use App\Models\EmailLog;
use App\Models\Employees;
use App\Models\EmployeeType;
use App\Models\Enquiry;
use App\Models\GeneralSetting;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Models\Odometer;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategories;
use App\Models\Quote;
use App\Models\Size;
use App\Models\State;
use App\Models\Unit;
use App\Models\UserActivity;
use App\Models\User;
use App\Models\UserDevice;

use Auth;
use Session;
use Helper;
use Hash;
use DB;
use App\Libraries\CreatorJwt;
use App\Libraries\JWT;
use App\Models\Comorbidity;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Test;
use App\Models\TestParameter;
use App\Models\TestTab;

date_default_timezone_set("Asia/Calcutta");
class ApiController extends Controller
{

    /* before login screen */
        public function getAppSetting(Request $request){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $generalSetting = GeneralSetting::find(1);
                if($generalSetting){
                    $apiResponse = [
                        'site_name'             => $generalSetting->site_name,
                        'site_phone'            => $generalSetting->site_phone,
                        'site_phone2'           => $generalSetting->site_phone2,
                        'site_mail'             => $generalSetting->site_mail,
                        'system_email'          => $generalSetting->system_email,
                        'site_url'              => $generalSetting->site_url,
                        'site_logo'             => env('UPLOADS_URL').$generalSetting->site_logo,
                        'site_footer_logo'      => env('UPLOADS_URL').$generalSetting->site_footer_logo,
                        'site_favicon'          => env('UPLOADS_URL').$generalSetting->site_favicon,
                        'site_address'          => $generalSetting->description,
                        'theme_color'           => $generalSetting->theme_color,
                        'font_color'            => $generalSetting->font_color,
                        'sidebar_bgcolor'       => $generalSetting->sidebar_bgcolor,
                        'header_bgcolor'        => $generalSetting->header_bgcolor,
                        'twitter_profile'       => $generalSetting->twitter_profile,
                        'facebook_profile'      => $generalSetting->facebook_profile,
                        'instagram_profile'     => $generalSetting->instagram_profile,
                        'linkedin_profile'      => $generalSetting->linkedin_profile,
                        'youtube_profile'       => $generalSetting->youtube_profile,
                    ];
                }
                http_response_code(200);
                $apiStatus          = TRUE;
                $apiMessage         = 'Data Available !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            } else {
                http_response_code(200);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        public function getStaticPages(Request $request){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source', 'page_slug'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $page_slug = $requestData['page_slug'];
                $pageContent  = Page::select('page_name', 'page_content')->where('status', '=', 1)->where('page_slug', '=', $page_slug)->first();
                if($pageContent){
                    $apiResponse[] = [
                        'page_name'                 => $pageContent->page_name,
                        'page_content'              => $pageContent->page_content
                    ];
                    http_response_code(200);
                    $apiStatus          = TRUE;
                    $apiMessage         = 'Data Available !!!';
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                } else {
                    http_response_code(404);
                    $apiStatus          = FALSE;
                    $apiMessage         = 'Page not found !!!';
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
    /* before login screen */
    /* authentication */
        public function signup(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source', 'prefix', 'name', 'email', 'mobile', 'reg_no'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $prefix                     = $requestData['prefix'];
                $email                      = $requestData['email'];                
                $name                       = $requestData['name'];                
                $mobile                     = $requestData['mobile'];      
                $reg_no                     = $requestData['reg_no'];
                // $reg_no                     = $this->generateAlphanumeric10();  
                // Generate a random alphanumeric password
                                        
                $checkUser                  = Doctor::where('email', '=', $email)->where('phone', '=', $mobile)->first();
                if($checkUser){                                                      
                    $user_status = $checkUser->status;
                    if($user_status == 0){
                        $remember_token  = rand(10000,99999);
                        $updatefields = [
                            'initials'         => $prefix,
                            'name'             => $name,
                            'regn_no'          => $reg_no,
                            'email'            => $email,
                            'phone'            => $mobile,                             
                            'otp'        => $remember_token
                        ];
                        $apiResponse            = [  
                            'id'                => $checkUser->id,     
                            'initials'         => $prefix,
                            'name'             => $name,
                            'regn_no'          => $reg_no,
                            'email'            => $email,
                            'phone'            => $mobile, 
                            'otp'               => $remember_token,                                                                     
                        ]; 
                        Doctor::where('id', '=', $checkUser->id)->update($updatefields);
                        $mailData                   = [
                            'id'    => $checkUser->id,
                            'email' => $email,                        
                            'otp'   => $remember_token,
                        ];
                        $generalSetting             = GeneralSetting::find('1');
                        $subject                    = $generalSetting->site_name.' :: SignUp Validate OTP';
                        $message                    = view('email-templates.otp',$mailData);
                        $this->sendMail($email, $subject, $message);             
                        /* email log save */
                            $postData2 = [
                                'name'                  => $name,
                                'email'                 => $email,
                                'subject'               => $subject,
                                'message'               => $message
                            ];
                            EmailLog::insert($postData2);
                        /* email log save */ 
                        $apiStatus                              = TRUE;
                        $apiMessage                             = 'Again Email send for Sign up otp validation  !!!';                                                                   
                    } else {  
                        $apiStatus                              = FALSE;
                        $apiMessage                             = 'Doctor Already exsist Plz sign in with cretentials  !!!';                       
                    }                            
                } else {                                            
                    $remember_token  = rand(10000,99999);
                    $fields = [
                        'initials'         => $prefix,
                        'name'             => $name,
                        'regn_no'          => $reg_no,
                        'email'            => $email,
                        'phone'            => $mobile,                         
                        'otp'        => $remember_token
                    ];     
                    // Doctor::insert($fields);    
                    $lastInsertId = DB::table('doctors')->insertGetId($fields);                    
                    $apiResponse            = [  
                        'id'                => $lastInsertId,     
                        'initials'         => $prefix,
                        'name'             => $name,
                        'regn_no'          => $reg_no,
                        'email'            => $email,
                        'phone'            => $mobile,                          
                        'otp'               => $remember_token,                                                                   
                    ];  

                    $mailData                   = [
                        'id'    => $lastInsertId,
                        'email' => $email,                        
                        'otp'   => $remember_token,
                    ];
                    $generalSetting             = GeneralSetting::find('1');
                    $subject                    = $generalSetting->site_name.' :: SignUp Validate OTP';
                    $message                    = view('email-templates.otp',$mailData);
                    $this->sendMail($email, $subject, $message);             
                    /* email log save */
                    $postData2 = [
                        'name'                  => $name,
                        'email'                 => $email,
                        'subject'               => $subject,
                        'message'               => $message
                    ];
                    EmailLog::insert($postData2);
                /* email log save */                                                                      
                    $apiStatus                          = TRUE;
                    $apiMessage                         = 'OTP Sent To Email For Validation !!!';                                    
                }
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        function generateAlphanumeric10() {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
        
            for ($i = 0; $i < 10; $i++) {
                $randomIndex = random_int(0, $charactersLength - 1);
                $randomString .= $characters[$randomIndex];
            }
        
            return $randomString;
        }
        
        public function signupVerifyOTP(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source', 'id', 'otp', 'device_token', 'fcm_token'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $id                         = $requestData['id'];               
                $otp                        = $requestData['otp'];
                $device_type                = $headerData['source'][0];
                $device_token               = $requestData['device_token'];
                $fcm_token                  = $requestData['fcm_token'];                
                $checkUser                  = Doctor::where('id', '=', $id)->first();
                if($checkUser){
                    if($checkUser->otp == $otp){
                        $objOfJwt               = new CreatorJwt();
                        $app_access_token       = $objOfJwt->GenerateToken($checkUser->id, $checkUser->email, $checkUser->phone);
                        $user_id                = $checkUser->id;
                        // Doctor::where('id', '=', $user_id)->update(['otp' => $otp]);
                        $randomPassword = bin2hex(random_bytes(8)); 
                        $password = Hash::make($randomPassword);  
                        Doctor::where('id', '=', $checkUser->id)->update(['password' => $password, 'otp' => 0, 'status' => 1]);
                        $fields     = [
                            'user_id'               => $user_id,
                            'device_type'           => $device_type,
                            'device_token'          => $device_token,
                            'fcm_token'             => $fcm_token,
                            'app_access_token'      => $app_access_token,
                        ];
                        $checkUserTokenExist            = UserDevice::where('user_id', '=', $user_id)->where('published', '=', 1)->where('device_type', '=', $device_type)->where('device_token', '=', $device_token)->first();
                        if(!$checkUserTokenExist){
                            UserDevice::insert($fields);
                        } else {
                            UserDevice::where('id','=',$checkUserTokenExist->id)->update($fields);
                        }
                        $apiResponse            = [
                            'user_id'               => $user_id,
                            'name'                  => $checkUser->name,
                            'email'                 => $checkUser->email,
                            'password'              => $randomPassword,
                            'phone'                 => $checkUser->phone,                           
                            'device_type'           => $device_type,
                            'device_token'          => $device_token,
                            'fcm_token'             => $fcm_token,
                            'app_access_token'      => $app_access_token,
                        ];  
                        /* user activity */
                            $activityData = [
                                'user_email'        => $checkUser->email,
                                'user_name'         => $checkUser->name,
                                'user_type'         => 'USER',
                                'ip_address'        => $request->ip(),
                                'activity_type'     => 1,
                                'activity_details'  => 'SignUp Successfully !!!',
                                'platform_type'     => 'ANDROID',
                            ];
                            UserActivity::insert($activityData); 
                        /* user activity */  
                        $mailData                   = [
                            'id'    => $checkUser->id,
                            'name'  => $checkUser->name,
                            'email' => $checkUser->email,                        
                            'randomPassword'   => $randomPassword,
                        ];
                        $generalSetting             = GeneralSetting::find('1');
                        $subject                    = $generalSetting->site_name.' :: Your Login Credentials for Portal Access';                                                                      
                        $message                    = view('email-templates.cretential',$mailData);
                        $this->sendMail($checkUser->email, $subject, $message);
                        /* email log save */
                            $postData2 = [
                                'name'                  => $checkUser->name,
                                'email'                 => $checkUser->email,
                                'subject'               => $subject,
                                'message'               => $message
                            ];
                            EmailLog::insert($postData2);
                        /* email log save */                        
                        $apiStatus                          = TRUE;
                        $apiMessage                         = 'SignUp Successfully !!!';
                    } else {    
                        /* user activity */
                            $activityData = [
                                'user_email'        => $checkUser->email,
                                'user_name'         => $checkUser->name,
                                'user_type'         => 'USER',
                                'ip_address'        => $request->ip(),
                                'activity_type'     => 0,
                                'activity_details'  => 'OTP Mismatched !!!',
                                'platform_type'     => 'ANDROID',
                            ];
                            UserActivity::insert($activityData); 
                        /* user activity */                  
                        $apiStatus                              = FALSE;
                        http_response_code(200);
                        $apiMessage                             = 'OTP Mismatched !!!';
                        $apiExtraField      = 'response_code';
                    }
                }else {
                        /* user activity */
                            $activityData = [
                                'user_email'        => $requestData['phone'],
                                'user_name'         => '',
                                'user_type'         => 'USER',
                                'ip_address'        => $request->ip(),
                                'activity_type'     => 0,
                                'activity_details'  => 'We Don\'t Recognize You !!!',
                                'platform_type'     => 'ANDROID',
                            ];
                            UserActivity::insert($activityData);
                        /* user activity */
                        $apiStatus                              = FALSE;
                        $apiMessage                             = 'We Don\'t Recognize You !!!';
                    }
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function signin(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source', 'email', 'password', 'device_token', 'fcm_token'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $email                      = $requestData['email'];
                $password                   = $requestData['password'];
                $device_type                = $headerData['source'][0];
                $device_token               = $requestData['device_token'];
                $fcm_token                  = $requestData['fcm_token'];
                $checkUser                  = Doctor::where('email', '=', $email)->where('status', '=', 1)->first();
                if($checkUser){
                    if(Hash::check($password, $checkUser->password)){
                        $objOfJwt           = new CreatorJwt();
                        $app_access_token   = $objOfJwt->GenerateToken($checkUser->id, $checkUser->email, $checkUser->phone);
                        $user_id                        = $checkUser->id;
                        $fields     = [
                            'user_id'               => $user_id,
                            'device_type'           => $device_type,
                            'device_token'          => $device_token,
                            'fcm_token'             => $fcm_token,
                            'app_access_token'      => $app_access_token,
                        ];
                        $checkUserTokenExist            = UserDevice::where('user_id', '=', $user_id)->where('published', '=', 1)->where('device_type', '=', $device_type)->where('device_token', '=', $device_token)->first();
                        if(!$checkUserTokenExist){
                            UserDevice::insert($fields);
                        } else {
                            UserDevice::where('id','=',$checkUserTokenExist->id)->update($fields);
                        }                        
                        $apiResponse            = [
                            'user_id'               => $user_id,
                            'name'                  => $checkUser->name,
                            'email'                 => $checkUser->email,
                            'phone'                 => $checkUser->phone,                            
                            'device_type'           => $device_type,
                            'device_token'          => $device_token,
                            'fcm_token'             => $fcm_token,
                            'app_access_token'      => $app_access_token,
                        ];
                        /* user activity */
                            $activityData = [
                                'user_email'        => $checkUser->email,
                                'user_name'         => $checkUser->name,
                                'user_type'         => 'USER',
                                'ip_address'        => $request->ip(),
                                'activity_type'     => 1,
                                'activity_details'  => 'SignIn Successfully !!!',
                                'platform_type'     => 'ANDROID',
                            ];
                            UserActivity::insert($activityData);
                        /* user activity */
                        $apiStatus                          = TRUE;
                        $apiMessage                         = 'SignIn Successfully !!!';
                    } else {
                        /* user activity */
                            $activityData = [
                                'user_email'        => $requestData['email'],
                                'user_name'         => '',
                                'user_type'         => 'USER',
                                'ip_address'        => $request->ip(),
                                'activity_type'     => 0,
                                'activity_details'  => 'Invalid Email Or Password !!!',
                                'platform_type'     => 'ANDROID',
                            ];
                            UserActivity::insert($activityData);
                        /* user activity */
                        $apiStatus                          = FALSE;
                        $apiMessage                         = 'Invalid Email Or Password !!!';
                    }                   
                } else {                    
                    /* user activity */
                        $activityData = [
                            'user_email'        => $requestData['email'],
                            'user_name'         => '',
                            'user_type'         => 'USER',
                            'ip_address'        => $request->ip(),
                            'activity_type'     => 0,
                            'activity_details'  => 'We Don\'t Recognize You !!!',
                            'platform_type'     => 'ANDROID',
                        ];
                        UserActivity::insert($activityData);
                    /* user activity */
                    $apiStatus                              = FALSE;
                    $apiMessage                             = 'We Don\'t Recognize You !!!';
                }
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function signinWithEmail(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['email'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $email                      = $requestData['email'];
                $checkUser                  = Doctor::where('email', '=', $email)->first();
                if($checkUser){
                    $user_status = $checkUser->status;
                    if($user_status == 0){
                        $remember_token  = rand(10000,99999);
                        $updatefields = [                            
                            'email'            => $email,                                                         
                            'otp'        => $remember_token
                        ];
                        $apiResponse            = [  
                            'id'                => $checkUser->id,                                 
                            'email'            => $email,                             
                            'otp'               => $remember_token,                                                                     
                        ]; 
                        Doctor::where('id', '=', $checkUser->id)->update($updatefields);
                        $mailData                   = [
                            'id'    => $checkUser->id,
                            'email' => $email,                        
                            'otp'   => $remember_token,
                        ];
                        $generalSetting             = GeneralSetting::find('1');
                        $subject                    = $generalSetting->site_name.' :: SignUp Validate OTP';
                        $message                    = view('email-templates.otp',$mailData);
                        $this->sendMail($email, $subject, $message);             
                        /* email log save */
                            $postData2 = [
                                'name'                  => $checkUser->name,
                                'email'                 => $email,
                                'subject'               => $subject,
                                'message'               => $message
                            ];
                            EmailLog::insert($postData2);
                        /* email log save */ 
                        $apiStatus                              = TRUE;
                        $apiMessage                             = 'Again Email send for Sign up otp validation through sign in with email !!!';                                                                   
                    } elseif($user_status == 1){
                        $remember_token  = rand(10000,99999);
                        Doctor::where('id', '=', $checkUser->id)->update(['otp' => $remember_token]);
                        $mailData                   = [
                            'id'    => $checkUser->id,
                            'email' => $checkUser->email,                        
                            'otp'   => $remember_token,
                        ];
                        $generalSetting             = GeneralSetting::find('1');
                        $subject                    = $generalSetting->site_name.' :: SignIn Validate OTP';
                        $message                    = view('email-templates.otp',$mailData);
                        $this->sendMail($checkUser->email, $subject, $message);

                        /* email log save */
                            $postData2 = [
                                'name'                  => $checkUser->name,
                                'email'                 => $checkUser->email,
                                'subject'               => $subject,
                                'message'               => $message
                            ];
                            EmailLog::insert($postData2);
                        /* email log save */                    
                        $apiResponse                        = $mailData;
                        $apiStatus                          = TRUE;
                        $apiMessage                         = 'OTP Sent To Email For Validation !!!';                         
                    } else{
                        $apiStatus                              = FALSE;
                        $apiMessage                             = 'Your Account Is Deactivated Contact to Admin !!!'; 
                    } 
                } else {
                    /* user activity */
                    $activityData = [
                        'user_email'        => $requestData['email'],
                        'user_name'         => '',
                        'user_type'         => 'USER',
                        'ip_address'        => $request->ip(),
                        'activity_type'     => 0,
                        'activity_details'  => 'We Don\'t Recognize You !!!',
                        'platform_type'     => 'ANDROID',
                    ];
                    UserActivity::insert($activityData);
                    /* user activity */
                    $apiStatus                              = FALSE;
                    $apiMessage                             = 'We Don\'t Recognize You !!!'; 
                                       
                }
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }        
        public function signinValidateEmail(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source', 'id', 'otp', 'device_token', 'fcm_token'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){ 
                $id                         = $requestData['id'];               
                $otp                        = $requestData['otp'];
                $device_type                = $headerData['source'][0];
                $device_token               = $requestData['device_token'];
                $fcm_token                  = $requestData['fcm_token'];
                $checkUser                  = Doctor::where('id', '=', $id)->first();
                if($checkUser){
                    $user_status = $checkUser->status;
                    if($user_status == 0){
                        if($checkUser->otp == $otp){
                            $objOfJwt               = new CreatorJwt();
                            $app_access_token       = $objOfJwt->GenerateToken($checkUser->id, $checkUser->email, $checkUser->phone);
                            $user_id                = $checkUser->id;
                            $randomPassword = bin2hex(random_bytes(8)); 
                            $password = Hash::make($randomPassword); 
                            Doctor::where('id', '=', $user_id)->update(['password' => $password, 'otp' => 0, 'status' => 1]);
                            $fields     = [
                                'user_id'               => $user_id,
                                'device_type'           => $device_type,
                                'device_token'          => $device_token,
                                'fcm_token'             => $fcm_token,
                                'app_access_token'      => $app_access_token,
                            ];
                            $checkUserTokenExist            = UserDevice::where('user_id', '=', $user_id)->where('published', '=', 1)->where('device_type', '=', $device_type)->where('device_token', '=', $device_token)->first();
                            if(!$checkUserTokenExist){
                                UserDevice::insert($fields);
                            } else {
                                UserDevice::where('id','=',$checkUserTokenExist->id)->update($fields);
                            }
                            // $getEmployeeType        = EmployeeType::select('name')->where('id', '=', $checkUser->employee_type_id)->first();
                            $apiResponse            = [
                                'user_id'               => $user_id,
                                'name'                  => $checkUser->name,
                                'email'                 => $checkUser->email,
                                'phone'                 => $checkUser->phone,  
                                'password'              => $randomPassword,          
                                'device_type'           => $device_type,
                                'device_token'          => $device_token,
                                'fcm_token'             => $fcm_token,
                                'app_access_token'      => $app_access_token,
                            ];
                            /* user activity */
                                $activityData = [
                                    'user_email'        => $checkUser->email,
                                    'user_name'         => $checkUser->name,
                                    'user_type'         => 'USER',
                                    'ip_address'        => $request->ip(),
                                    'activity_type'     => 1,
                                    'activity_details'  => 'SignIn Successfully !!!',
                                    'platform_type'     => 'ANDROID',
                                ];
                                UserActivity::insert($activityData);
                            /* user activity */
                            $mailData                   = [
                                'id'    => $checkUser->id,
                                'name'  => $checkUser->name,
                                'email' => $checkUser->email,                        
                                'randomPassword'   => $randomPassword,
                            ];
                            $generalSetting             = GeneralSetting::find('1');
                            $subject                    = $generalSetting->site_name.' :: Your Login Credentials for Portal Access';
                            $message                    = view('email-templates.cretential',$mailData);
                            $this->sendMail($checkUser->email, $subject, $message);
                            /* email log save */
                                $postData2 = [
                                    'name'                  => $checkUser->name,
                                    'email'                 => $checkUser->email,
                                    'subject'               => $subject,
                                    'message'               => $message
                                ];
                                EmailLog::insert($postData2);
                            /* email log save */
                            $apiStatus                          = TRUE;
                            $apiMessage                         = 'SignIn Successfully !!!';
                        } else {
                            /* user activity */
                                $activityData = [
                                    'user_email'        => $checkUser->email,
                                    'user_name'         => $checkUser->name,
                                    'user_type'         => 'USER',
                                    'ip_address'        => $request->ip(),
                                    'activity_type'     => 0,
                                    'activity_details'  => 'OTP Mismatched !!!',
                                    'platform_type'     => 'ANDROID',
                                ];
                                UserActivity::insert($activityData);
                            /* user activity */
                            $apiStatus          = FALSE;
                            http_response_code(200);
                            $apiMessage         = 'OTP Mismatched !!!';
                            $apiExtraField      = 'response_code';
                        }
                    } elseif($user_status == 1){
                        if($checkUser->otp == $otp){
                            $objOfJwt               = new CreatorJwt();
                            $app_access_token       = $objOfJwt->GenerateToken($checkUser->id, $checkUser->email, $checkUser->phone);
                            $user_id                = $checkUser->id;                            
                            Doctor::where('id', '=', $user_id)->update(['otp' => 0]);
                            $fields     = [
                                'user_id'               => $user_id,
                                'device_type'           => $device_type,
                                'device_token'          => $device_token,
                                'fcm_token'             => $fcm_token,
                                'app_access_token'      => $app_access_token,
                            ];
                            $checkUserTokenExist            = UserDevice::where('user_id', '=', $user_id)->where('published', '=', 1)->where('device_type', '=', $device_type)->where('device_token', '=', $device_token)->first();
                            if(!$checkUserTokenExist){
                                UserDevice::insert($fields);
                            } else {
                                UserDevice::where('id','=',$checkUserTokenExist->id)->update($fields);
                            }
                            // $getEmployeeType        = EmployeeType::select('name')->where('id', '=', $checkUser->employee_type_id)->first();
                            $apiResponse            = [
                                'user_id'               => $user_id,
                                'name'                  => $checkUser->name,
                                'email'                 => $checkUser->email,
                                'phone'                 => $checkUser->phone,                                            
                                'device_type'           => $device_type,
                                'device_token'          => $device_token,
                                'fcm_token'             => $fcm_token,
                                'app_access_token'      => $app_access_token,
                            ];
                            /* user activity */
                                $activityData = [
                                    'user_email'        => $checkUser->email,
                                    'user_name'         => $checkUser->name,
                                    'user_type'         => 'USER',
                                    'ip_address'        => $request->ip(),
                                    'activity_type'     => 1,
                                    'activity_details'  => 'SignIn Successfully !!!',
                                    'platform_type'     => 'ANDROID',
                                ];
                                UserActivity::insert($activityData);
                            /* user activity */                        
                            $apiStatus                          = TRUE;
                            $apiMessage                         = 'SignIn Successfully !!!';
                        } else {
                            /* user activity */
                                $activityData = [
                                    'user_email'        => $checkUser->email,
                                    'user_name'         => $checkUser->name,
                                    'user_type'         => 'USER',
                                    'ip_address'        => $request->ip(),
                                    'activity_type'     => 0,
                                    'activity_details'  => 'OTP Mismatched !!!',
                                    'platform_type'     => 'ANDROID',
                                ];
                                UserActivity::insert($activityData);
                            /* user activity */
                            $apiStatus          = FALSE;
                            http_response_code(200);
                            $apiMessage         = 'OTP Mismatched !!!';
                            $apiExtraField      = 'response_code';
                        }
                    } 
                    
                } else {
                    /* user activity */
                        $activityData = [
                            'user_email'        => $requestData['phone'],
                            'user_name'         => '',
                            'user_type'         => 'USER',
                            'ip_address'        => $request->ip(),
                            'activity_type'     => 0,
                            'activity_details'  => 'We Don\'t Recognize You !!!',
                            'platform_type'     => 'ANDROID',
                        ];
                        UserActivity::insert($activityData);
                    /* user activity */
                    $apiStatus                              = FALSE;
                    $apiMessage                             = 'We Don\'t Recognize You !!!';
                }
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function forgotPassword(Request $request){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source', 'email'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $checkEmail = Doctor::where('email', '=', $requestData['email'])->first();
                if($checkEmail){
                    $remember_token  = rand(10000,99999);
                    Doctor::where('id', '=', $checkEmail->id)->update(['otp' => $remember_token]);
                    $mailData                   = [
                        'id'    => $checkEmail->id,
                        'email' => $checkEmail->email,
                        'otp'   => $remember_token,
                    ];
                    $generalSetting             = GeneralSetting::find('1');
                    $subject                    = $generalSetting->site_name.' :: Forgot Password OTP';
                    $message                    = view('email-templates.otp',$mailData);
                    $this->sendMail($requestData['email'], $subject, $message);

                    /* email log save */
                        $postData2 = [
                            'name'                  => $checkEmail->name,
                            'email'                 => $checkEmail->email,
                            'subject'               => $subject,
                            'message'               => $message
                        ];
                        EmailLog::insert($postData2);
                    /* email log save */

                    $apiResponse                        = $mailData;
                    $apiStatus                          = TRUE;
                    http_response_code(200);
                    $apiMessage                         = 'OTP Sent To Email Validation !!!';
                    $apiExtraField                      = 'response_code';
                    $apiExtraData                       = http_response_code();
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(200);
                    $apiMessage         = 'Email Not Registered With Us !!!';
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }
            } else {
                http_response_code(200);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        public function validateOtp(Request $request){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source', 'id', 'otp'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $getUser = Doctor::where('id', '=', $requestData['id'])->first();
                if($getUser){
                    $remember_token  = $getUser->otp;
                    if($remember_token == $requestData['otp']){
                        Doctor::where('id', '=', $requestData['id'])->update(['otp' => 0]);
                        // $this->sendMail('subhomoysamanta1989@gmail.com', $requestData['subject'], $requestData['message']);
                        $apiResponse        = [
                            'id'    => $getUser->id,
                            'email' => $getUser->email
                        ];
                        $apiStatus                          = TRUE;
                        http_response_code(200);
                        $apiMessage                         = 'OTP Validated Successfully !!!';
                        $apiExtraField                      = 'response_code';
                        $apiExtraData                       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(200);
                        $apiMessage         = 'OTP Mismatched !!!';
                        $apiExtraField      = 'response_code';
                    }
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(200);
                    $apiMessage         = 'Doctor Not Found !!!';
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }
            } else {
                http_response_code(200);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        public function resendOtp(Request $request){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source', 'id'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $id         = $requestData['id'];
                $getUser    = Doctor::where('id', '=', $id)->first();
                if($getUser){
                    $remember_token = rand(10000,99999);
                    $postData = [
                        'otp'        => $remember_token
                    ];
                    Doctor::where('id', '=', $id)->update($postData);
                    
                    $mailData                   = [
                        'id'    => $getUser->id,
                        'email' => $getUser->email,
                        'otp'   => $remember_token,
                    ];
                    $generalSetting             = GeneralSetting::find('1');
                    $subject                    = $generalSetting->site_name.' :: Resend OTP';
                    $message                    = view('email-templates.otp',$mailData);
                    $this->sendMail($getUser->email, $subject, $message);

                    /* email log save */
                        $postData2 = [
                            'name'                  => $getUser->name,
                            'email'                 => $getUser->email,
                            'subject'               => $subject,
                            'message'               => $message
                        ];
                        EmailLog::insert($postData2);
                    /* email log save */

                    $apiResponse                        = $mailData;
                    $apiStatus                          = TRUE;
                    http_response_code(200);
                    $apiMessage                         = 'OTP Resend !!!';
                    $apiExtraField                      = 'response_code';
                    $apiExtraData                       = http_response_code();
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(200);
                    $apiMessage         = 'Doctor Not Found !!!';
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }
            } else {
                http_response_code(200);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        public function resetPassword(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source', 'id', 'password', 'confirm_password'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $getUser = Doctor::where('id', '=', $requestData['id'])->first();
                if($getUser){
                    if (!empty($requestData['password']) && !empty($requestData['confirm_password'])) {
                        if($requestData['password'] == $requestData['confirm_password']){
                            Doctor::where('id', '=', $requestData['id'])->update(['password' => Hash::make($requestData['password'])]);
                            $mailData        = [
                                'id'        => $getUser->id,
                                'name'      => $getUser->name,
                                'email'     => $getUser->email
                            ];

                            $generalSetting             = GeneralSetting::find('1');
                            $subject                    = $generalSetting->site_name.' :: Reset Password';
                            $message                    = view('email-templates.change-password',$mailData);
                            $this->sendMail($getUser->email, $subject, $message);

                            /* email log save */
                                $postData2 = [
                                    'name'                  => $getUser->name,
                                    'email'                 => $getUser->email,
                                    'subject'               => $subject,
                                    'message'               => $message
                                ];
                                EmailLog::insert($postData2);
                            /* email log save */
                            $apiResponse                        = $mailData;                        
                            $apiStatus                          = TRUE;
                            http_response_code(200);
                            $apiMessage                         = 'Password Reset Successfully !!!';
                            $apiExtraField                      = 'response_code';
                            $apiExtraData                       = http_response_code();
                        } else {
                            $apiStatus          = FALSE;
                            http_response_code(200);
                            $apiMessage         = 'Password & Confirm Password Not Matched !!!';
                            $apiExtraField      = 'response_code';
                        }
                    } else {
                        $apiStatus = FALSE;
                        http_response_code(200);
                        $apiMessage = 'Password fields cannot be blank !!!';
                        $apiExtraField = 'response_code';
                    }
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(200);
                    $apiMessage         = 'Doctor Not Found !!!';
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }
            } else {
                http_response_code(200);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
    /* authentication */
    /* after login */
        public function signout(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = [];
            $headerData         = $request->header();
            // Helper::pr($headerData);
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $app_access_token           = $headerData['authorization'][0];
                $checkUserTokenExist        = UserDevice::where('app_access_token', '=', $app_access_token)->where('published', '=', 1)->first();
                if($checkUserTokenExist){
                    /* user activity */
                        $getTokenValue              = $this->tokenAuth($app_access_token);
                        $uId                        = $getTokenValue['data'][1];
                        $getUser                    = Doctor::where('id', '=', $uId)->first();
                        $activityData = [
                            'user_email'        => (($getUser)?$getUser->email:''),
                            'user_name'         => (($getUser)?$getUser->name:''),
                            'user_type'         => 'USER',
                            'ip_address'        => $request->ip(),
                            'activity_type'     => 2,
                            'activity_details'  => 'Signout Successfully !!!',
                            'platform_type'     => 'ANDROID',
                        ];
                        UserActivity::insert($activityData);
                    /* user activity */
                    UserDevice::where('app_access_token', '=', $app_access_token)->delete();
                    
                    $apiStatus                      = TRUE;
                    $apiMessage                     = 'Signout Successfully !!!';
                } else {
                    $apiStatus                      = FALSE;
                    $apiMessage                     = 'Something Went Wrong !!!';
                }               
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function dashboard(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $app_access_token           = $headerData['authorization'][0];
                $checkUserTokenExist        = UserDevice::where('app_access_token', '=', $app_access_token)->where('published', '=', 1)->first();
                if($checkUserTokenExist){
                    $getTokenValue              = $this->tokenAuth($app_access_token);
                    if($getTokenValue['status']){
                        $uId        = $getTokenValue['data'][1];
                        $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                        $getUser    = Doctor::where('id', '=', $uId)->first();
                        if($getUser){
                            $patient_count = Patient::where('status', '=', 1)->where('doctor_id', '=', $getUser->id)->count();
                            $test_count    = Test::where('status', '=', 1)->where('doctor_id', '=', $getUser->id)->count();
                            $apiResponse = [
                                'doctorId'     => $getUser->id,
                                'patientCount' => $patient_count,
                                'testCount'    => $test_count
                            ];
                            $apiStatus          = TRUE;
                            $apiMessage         = 'Data Available !!!';
                        } else {
                            $apiStatus          = FALSE;
                            $apiMessage         = 'Doctor Not Found !!!';
                        }
                    } else {
                        $apiStatus                      = FALSE;
                        $apiMessage                     = $getTokenValue['data'];
                    }
                } else {
                    $apiStatus                      = FALSE;
                    $apiMessage                     = 'Something Went Wrong !!!';
                }               
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function changePassword(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $app_access_token           = $headerData['authorization'][0];
                $old_password               = $requestData['old_password'];
                $new_password               = $requestData['new_password'];
                $confirm_password           = $requestData['confirm_password'];
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = Doctor::where('id', '=', $uId)->first();
                    if($getUser){
                        if(Hash::check($old_password, $getUser->password)){
                            if($new_password == $confirm_password){
                                if($new_password != $old_password){
                                    $fields = [
                                        'password'                  => Hash::make($new_password)
                                    ];
                                    Doctor::where('id', '=', $uId)->update($fields);
                                    // new password send mail
                                        $generalSetting                 = GeneralSetting::find('1');
                                        $subject                        = $generalSetting->site_name.' Change Password';
                                        $mailData['name']               = $getUser->name;
                                        $mailData['email']              = $getUser->email;
                                        $message                        = view('email-templates/change-password', $mailData);
                                        $this->sendMail($getUser->email, $subject, $message);
                                    // new password send mail
                                    /* email log save */
                                        $postData2 = [
                                            'name'                  => $getUser->name,
                                            'email'                 => $getUser->email,
                                            'subject'               => $subject,
                                            'message'               => $message
                                        ];
                                        EmailLog::insert($postData2);
                                    /* email log save */
                                    $apiStatus          = TRUE;
                                    $apiMessage         = 'Password Updated Successfully !!!';
                                } else {
                                    $apiStatus          = FALSE;
                                    $apiMessage         = 'Current & New Password Should Not Be Same !!!';
                                }
                            } else {
                                $apiStatus          = FALSE;
                                $apiMessage         = 'New & Confirm Password Doesn\'t Matched !!!';
                            }
                        } else {
                            $apiStatus          = FALSE;
                            $apiMessage         = 'Current Password Doesn\'t Matched !!!';
                        }
                    } else {
                        $apiStatus          = FALSE;
                        $apiMessage         = 'Doctor Not Found !!!';
                    }
                } else {
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $getTokenValue['data'];
                }                                               
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function getProfile(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                // Check 'authorization' header exists
                if (!isset($headerData['authorization'][0])) {
                    $apiStatus          = FALSE;
                    $apiMessage         = 'Authorization header missing !!!';
                    // return $this->response_to_json(false, 'Authorization header missing !!!', []);
                }
                $app_access_token           = $headerData['authorization'][0];
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = Doctor::where('id', '=', $uId)->first();
                    if($getUser){
                        // $getEmployeeType     = EmployeeType::select('name', 'is_report')->where('id', '=', $getUser->employee_type_id)->first();
                        $profileData    = [
                            'id'                => $getUser->id,                            
                            'initials'          => $getUser->initials,                            
                            'name'              => $getUser->name,
                            'regn_no'           => $getUser->regn_no,
                            'email'             => $getUser->email,                           
                            'phone'             => $getUser->phone,                                                        
                            'created_at'        => date_format(date_create($getUser->created_at), "M d, Y h:i A"),
                            'profile_image'     => (($getUser->profile_image != '')?env('UPLOADS_URL').'user/'.$getUser->profile_image:env('NO_USER_IMAGE')),
                        ];
                        $apiStatus          = TRUE;
                        $apiMessage         = 'Data Available !!!';
                        $apiResponse        = $profileData;
                    } else {
                        $apiStatus          = FALSE;
                        $apiMessage         = 'Doctor Not Found !!!';
                    }
                } else {
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $getTokenValue['data'];
                }                                               
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        // public function editProfile(Request $request)
        // {
        //     $apiStatus          = TRUE;
        //     $apiMessage         = '';
        //     $apiResponse        = [];
        //     $apiExtraField      = '';
        //     $apiExtraData       = '';
        //     $requestData        = $request->all();
        //     $requiredFields     = ['key', 'source'];
        //     $headerData         = $request->header();
        //     if (!$this->validateArray($requiredFields, $requestData)){
        //         $apiStatus          = FALSE;
        //         $apiMessage         = 'All Data Are Not Present !!!';
        //     }
        //     if($headerData['key'][0] == env('PROJECT_KEY')){
        //         $app_access_token           = $headerData['authorization'][0];
        //         $getTokenValue              = $this->tokenAuth($app_access_token);
        //         if($getTokenValue['status']){
        //             $uId        = $getTokenValue['data'][1];
        //             $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
        //             $getUser    = Employees::where('id', '=', $uId)->first();
        //             if($getUser){
        //                 $getEmployeeType     = EmployeeType::select('name')->where('id', '=', $getUser->employee_type_id)->first();
        //                 $profileData    = [
        //                     'employee_type_id'      => $getUser->employee_type_id,
        //                     'name'                  => $getUser->name,
        //                     'email'                 => $getUser->email,
        //                     'alt_email'             => $getUser->alt_email,
        //                     'phone'                 => $getUser->phone,
        //                     'whatsapp_no'           => $getUser->whatsapp_no,
        //                     'short_bio'             => $getUser->short_bio,
        //                     'dob'                   => $getUser->dob,
        //                     'doj'                   => $getUser->doj,
        //                     'qualification'         => (($getUser->qualification != '')?$getUser->qualification:''),
        //                 ];
        //                 $apiStatus          = TRUE;
        //                 $apiMessage         = 'Data Available !!!';
        //                 $apiResponse        = $profileData;
        //             } else {
        //                 $apiStatus          = FALSE;
        //                 $apiMessage         = 'User Not Found !!!';
        //             }
        //         } else {
        //             $apiStatus                      = FALSE;
        //             $apiMessage                     = $getTokenValue['data'];
        //         }                                               
        //     } else {
        //         $apiStatus          = FALSE;
        //         $apiMessage         = 'Unauthenticate Request !!!';
        //     }
        //     $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        // }
        public function updateProfile(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source', 'prefix', 'name', 'email', 'mobile', 'regn_no',];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $app_access_token           = $headerData['authorization'][0];
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = Doctor::where('id', '=', $uId)->first();
                    if($getUser){
                        $postData = [
                                    'initials'          => $requestData['prefix'],
                                    'name'                      => $requestData['name'],
                                    'email'                 => $requestData['email'],
                                    'regn_no'               => $requestData['regn_no'],
                                    'phone'                 => $requestData['mobile'],                                    
                                ];
                        Doctor::where('id', '=', $uId)->update($postData);
                        $apiStatus                  = TRUE;
                        $apiMessage                 = 'Profile Updated Successfully !!!';
                    } else {
                        $apiStatus          = FALSE;
                        $apiMessage         = 'Doctor Not Found !!!';
                    }
                } else {
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $getTokenValue['data'];
                }                                               
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);            
        }
        public function uploadProfileImage(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['profile_image'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $app_access_token           = $request->header('Authorization');
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = Doctor::where('id', '=', $uId)->first();
                    if($getUser){
                        $profile_image  = $requestData['profile_image'];
                        if(!empty($profile_image)){
                            $profile_image      = $profile_image;
                            $upload_type        = $profile_image[0]['type'];
                            if($upload_type == 'image/jpeg' || $upload_type == 'image/jpg' || $upload_type == 'image/png' || $upload_type == 'image/gif'){
                                $upload_base64      = $profile_image[0]['base64'];
                                $img                = $upload_base64;
                                $proof_type         = $profile_image[0]['type'];
                                if($proof_type == 'image/png'){
                                    $extn = 'png';
                                } elseif($proof_type == 'image/jpg'){
                                    $extn = 'jpg';
                                } elseif($proof_type == 'image/jpeg'){
                                    $extn = 'jpeg';
                                } elseif($proof_type == 'image/gif'){
                                    $extn = 'gif';
                                } else {
                                    $extn = 'png';
                                }
                                $data               = base64_decode($img);
                                $fileName           = uniqid() . '.' . $extn;
                                $file               = 'public/uploads/user/' . $fileName;
                                $success            = file_put_contents($file, $data);
                                $profile_image      = $fileName;
                            } else {
                                $apiStatus          = FALSE;
                                http_response_code(404);
                                $apiMessage         = 'Please Upload Image !!!';
                                $apiExtraField      = 'response_code';
                                $apiExtraData       = http_response_code();
                            }
                        } else {
                            $profile_image = $getUser->profile_image;
                        }
                        $postData = [
                                    'profile_image'         => $profile_image
                                ];
                        Doctor::where('id', '=', $uId)->update($postData);
                        $apiStatus                  = TRUE;
                        $apiMessage                 = 'Profile Image Uploaded Successfully !!!';
                    } else {
                        $apiStatus          = FALSE;
                        $apiMessage         = 'Doctor Not Found !!!';
                    }
                } else {
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $getTokenValue['data'];
                }                                               
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function deleteAccount(Request $request)
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $requestData        = $request->all();
            $requiredFields     = ['key', 'source'];
            $headerData         = $request->header();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['key'][0] == env('PROJECT_KEY')){
                $app_access_token           = $headerData['authorization'][0];
                $checkUserTokenExist        = UserDevice::where('app_access_token', '=', $app_access_token)->where('published', '=', 1)->first();
                if($checkUserTokenExist){
                    $getTokenValue              = $this->tokenAuth($app_access_token);
                    if($getTokenValue['status']){
                        $uId        = $getTokenValue['data'][1];
                        $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                        $getUser    = Doctor::where('id', '=', $uId)->first();
                        if($getUser){                            
                            $fields = [
                                'user_type'                 => 'DOCTOR',
                                'entity_name'               => $getUser->name,
                                'email'                     => $getUser->email,
                                'is_email_verify'           => 1,
                                'phone'                     => $getUser->phone,
                                'is_phone_verify'           => 1,
                            ];
                            DeleteAccountRequest::insert($fields);

                            $apiStatus          = TRUE;
                            $apiMessage         = 'Account Delete Requests Submitted Successfully !!!';
                        } else {
                            $apiStatus          = FALSE;
                            $apiMessage         = 'User Not Found !!!';
                        }
                    } else {
                        $apiStatus                      = FALSE;
                        $apiMessage                     = $getTokenValue['data'];
                    }
                } else {
                    $apiStatus                      = FALSE;
                    $apiMessage                     = 'Something Went Wrong !!!';
                }               
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
    /* after login */
    /*
    Get http response code
    Author : Subhomoy
    */
    private function getResponseCode($code = NULL){
        if ($code !== NULL) {
            switch ($code) {
                case 100: $text = 'Continue'; break;
                case 101: $text = 'Switching Protocols'; break;
                case 200: $text = 'OK'; break;
                case 201: $text = 'Created'; break;
                case 202: $text = 'Accepted'; break;
                case 203: $text = 'Non-Authoritative Information'; break;
                case 204: $text = 'No Content'; break;
                case 205: $text = 'Reset Content'; break;
                case 206: $text = 'Partial Content'; break;
                case 300: $text = 'Multiple Choices'; break;
                case 301: $text = 'Moved Permanently'; break;
                case 302: $text = 'Moved Temporarily'; break;
                case 303: $text = 'See Other'; break;
                case 304: $text = 'Not Modified'; break;
                case 305: $text = 'Use Proxy'; break;
                case 400: $text = 'Unauthenticated Request !!!'; break;
                case 401: $text = 'Token Not Found !!!'; break;
                case 402: $text = 'Payment Required'; break;
                case 403: $text = 'Token Has Expired !!!'; break;
                case 404: $text = 'User Not Found !!!'; break;
                case 405: $text = 'Method Not Allowed'; break;
                case 406: $text = 'All Data Are Not Present !!!'; break;
                case 407: $text = 'Proxy Authentication Required'; break;
                case 408: $text = 'Request Time-out'; break;
                case 409: $text = 'Conflict'; break;
                case 410: $text = 'Gone'; break;
                case 411: $text = 'Length Required'; break;
                case 412: $text = 'Precondition Failed'; break;
                case 413: $text = 'Request Entity Too Large'; break;
                case 414: $text = 'Request-URI Too Large'; break;
                case 415: $text = 'Unsupported Media Type'; break;
                case 500: $text = 'Internal Server Error'; break;
                case 501: $text = 'Not Implemented'; break;
                case 502: $text = 'Bad Gateway'; break;
                case 503: $text = 'Service Unavailable'; break;
                case 504: $text = 'Gateway Time-out'; break;
                case 505: $text = 'HTTP Version not supported'; break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                break;
            }
            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
            header($protocol . ' ' . $code . ' ' . $text);
            $GLOBALS['http_response_code'] = $code;
        } else {
            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
            $text = '';
        }
        return $text;
    }
    /*
    Generate JWT tokens for authentication
    Author : Subhomoy
    */
    private static function generateToken($userId, $email, $phone){
        $token      = array(
            'id'                => $userId,
            'email'             => $email,
            'phone'             => $phone,
            'exp'               => time() + (30 * 24 * 60 * 60) // 30 days
        );
        // pr($token);
        return JWT::encode($token, TOKEN_SECRET, 'HS256');
    }
    /*
    Check Authentication
    Author : Subhomoy
    */
    private function tokenAuth($appAccessToken){
        $headers = apache_request_headers();
        if (isset($appAccessToken) && !empty($appAccessToken)) :
            $userdata = $this->matchToken($appAccessToken);
            // pr($userdata);
            if ($userdata['status']) :
                $checkToken =  UserDevice::where('user_id', '=', $userdata['data']->id)->where('app_access_token', '=', $appAccessToken)->first();
                // echo $this->db->last_query();
                // pr($userdata);
                if (!empty($checkToken)) :
                    if ($userdata['data']->exp && $userdata['data']->exp > time()) :
                        $tokenStatus = array(TRUE, $userdata['data']->id, $userdata['data']->email, $userdata['data']->phone, $userdata['data']->exp);
                    else :
                        $tokenStatus = array(FALSE, 'Token Has Expired 1 !!!');
                    endif;
                else :
                    $tokenStatus = array(FALSE, 'Token Has Expired 2 !!!');
                endif;
            else :
                $tokenStatus = array(FALSE, 'Token Not Found !!!');
            endif;
        else :
            $tokenStatus = array(FALSE, 'Token Not Found In Request !!!');
        endif;
        if ($tokenStatus[0]) :
            $this->userId           = $tokenStatus[1];
            $this->userEmail        = $tokenStatus[2];
            $this->userMobile       = $tokenStatus[3];
            $this->userExpiry       = $tokenStatus[4];
            // pr($tokenStatus);
            return array('status' => TRUE, 'data' => $tokenStatus);
        else :
            return array('status' => FALSE, 'data' => $tokenStatus[1]);
            // $this->response_to_json(FALSE, $tokenStatus[1]);
        endif;
    }
    /*
    Match JWT token with user token saved in database
    Author : Subhomoy
    */
    private static function matchToken($token){
        // try{
        //     // $decoded    = JWT::decode($token, TOKEN_SECRET, 'HS256');
        //     $decoded    = JWT::decode($token, new Key(TOKEN_SECRET, 'HS256'));
        //     // pr($decoded);
        // } catch (\Exception $e) {
        //     //echo 'Caught exception: ',  $e->getMessage(), "\n";
        //     return array('status' => FALSE, 'data' => '');
        // }
        
        // return array('status' => TRUE, 'data' => $decoded);


        try{
            $key = "1234567890qwertyuiopmnbvcxzasdfghjkl";
            $decoded = JWT::decode($token, $key, array('HS256'));
            // $decodedData = (array) $decoded;
        } catch (\Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
            return array('status' => FALSE, 'data' => '');
        }
        return array('status' => TRUE, 'data' => $decoded);
    }

    /*
    code: Deblina        
    */
    public function getcomorbidities(Request $request){
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $requestData        = $request->all();
        $requiredFields     = ['key', 'source'];
        $headerData         = $request->header();
        if (!$this->validateArray($requiredFields, $requestData)){
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if($headerData['key'][0] == env('PROJECT_KEY')){
            $comorbidities = Comorbidity::select('id', 'name')->where('status', '=', 1)->orderBy('name', 'ASC')->get();
            if($comorbidities){
                foreach ($comorbidities as $row) {
                    $apiResponse[] = [
                        'name'          => $row->name,
                        'id'            => $row->id
                    ];
                }
            }
            http_response_code(200);
            $apiStatus          = TRUE;
            $apiMessage         = 'Data Available !!!';
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        } else {
            http_response_code(200);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
    }
    public function getpatient(Request $request){
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $requestData        = $request->all();
        $requiredFields     = ['key', 'source'];
        $headerData         = $request->header();
        if (!$this->validateArray($requiredFields, $requestData)){
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if($headerData['key'][0] == env('PROJECT_KEY')){
            $app_access_token           = $headerData['authorization'][0];
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if($getTokenValue['status']){
                $uId        = $getTokenValue['data'][1];
                $getUser    = Doctor::where('id', '=', $uId)->first();
                if($getUser){
                    $doctor_name = $getUser->name;
                } else {
                    $doctor_name = '';
                }
                $patients = Patient::where('status', '=', 1)->where('doctor_id', '=', $uId)->orderBy('name', 'ASC')->get();
                if($patients){
                    foreach ($patients as $row) {                        
                        $comorbidities = Comorbidity::where('id', '=', $row->comorbidities_id)->first();
                        if($comorbidities){
                            $comorbidity_name = $comorbidities->name;
                        } else {
                            $comorbidity_name = '';
                        }                        
                        $apiResponse[] = [
                            'id'            => $row->id,
                            'name'          => $row->name,
                            'email'         => $row->email,
                            'phone'         => $row->phone,
                            'dob'          => $row->dob,
                            'age'           => $row->age,
                            'country'       => $row->country,
                            'state'         => $row->state,
                            'city'          => $row->city,
                            'pincode'       => $row->pincode,
                            'gender'        => $row->gender,
                            'eye'           => $row->eye,
                            'comorbidity'   => $comorbidity_name,
                            'doctor_name'   => $doctor_name
                        ];                    
                    }
                }
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = $getTokenValue['data'];
            }            
            http_response_code(200);
            $apiStatus          = TRUE;
            $apiMessage         = 'Data Available !!!';
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        } else {
            http_response_code(200);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
    }
    public function gettest_parameters(Request $request){
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $requestData        = $request->all();
        $requiredFields     = ['key', 'source'];
        $headerData         = $request->header();
        if (!$this->validateArray($requiredFields, $requestData)){
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if($headerData['key'][0] == env('PROJECT_KEY')){
            $test_tabs = TestTab::where('status', '=', 1)->orderBy('rank', 'ASC')->get();
            foreach ($test_tabs as $tab) {
                $parameters = TestParameter::where('status', '=', 1)
                    ->where('test_tab_id', '=', $tab->id)
                    ->orderBy('rank', 'ASC')
                    ->get();
    
                $parameterArray = [];
    
                foreach ($parameters as $param) {
                    $optionsArray = json_decode($param->options, true);
                    $parameterArray[] = [
                        'id'      => $param->id,
                        'name'    => $param->name,
                        'weight'  => $param->weight,
                        'options' => implode(',', $optionsArray),
                        'hints'    => $param->hints
                    ];
                }    
                $apiResponse[] = [
                    'tab_id'    => $tab->id,
                    'tab_name'  => $tab->name,
                    'parameters'=> $parameterArray
                ];
            }            
            http_response_code(200);
            $apiStatus          = TRUE;
            $apiMessage         = 'Data Available !!!';
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        } else {
            http_response_code(200);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
    }
}
