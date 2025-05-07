<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\DeleteAccountRequest;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;


use App\Models\GeneralSetting;
use App\Models\Page;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Models\TestParameter;
use Auth;
use Session;
use Helper;
use Hash;
use Illuminate\Http\Request;
use stripe;

class FrontController extends Controller
{    
    /* page */
        public function page($slug){
            $data['generalSetting']             = GeneralSetting::find('1');
            $data['page']                       = Page::where('page_slug', '=', $slug)->first();
            $data['title']                      = (($data['page'])?$data['page']->page_name:"Page");
            $page_name                          = 'page-content';
            return view('front.page-content', $data);
        }
    /* page */
    public function deleteaccountview(Request $request)
    {        
        $data = [];
        $title                          = 'Delete Account';
        $page_name                      = 'delete-account';     

        return view('delete-account', $data);
        // echo $this->front_before_login_layout($title, $page_name, $data);
    }
    public function deleteaccount(Request $request)
    {
        if($request->isMethod('post')){
            $postData           = $request->all();
            // Helper::pr($postData);
            $user_type         = $postData['user_type'];
            $Entityname         = $postData['entity_name'];
            $email             = $postData['email'];
            $phone           = $postData['phone'];
            $comment           = !empty($request->comment) ? $request->comment : null;
            $rules = [                                 
                'user_type'           => 'required',
                'entity_name'         => 'required',
                'email'               => 'required|email',
                'phone'               => 'required|numeric',                
            ];
            
            if ($this->validate($request, $rules)) {
                $email_validation    = DeleteAccountRequest::where('email', $email)->first();
                $user_id           = $email_validation->id;
                if($email_validation){
                    $fields = [
                        'user_type'       => $user_type,
                        'entity_name'     => $Entityname,
                        'email'           => $email,
                        'is_email_verify' => 1,
                        'is_phone_verify' => 1,
                        'phone'           => $phone,
                        'comment'         => $comment,
                        'created_at'      => date('Y-m-d H:i:s'), 
                        'updated_at'    => date('Y-m-d H:i:s'),             
                        'status'          => 1,                                  
                    ];
                    DeleteAccountRequest::where('id', $user_id)->update($fields);
                }
                $fields2 = [
                    'user_type'       => $user_type,
                    'entity_name'     => $Entityname,
                    'email'           => $email,
                    'is_email_verify' => 1,
                    'is_phone_verify' => 1,
                    'phone'           => $phone,
                    'comment'         => $comment,
                    'created_at'      => date('Y-m-d H:i:s'),                    
                    'status'          => 1,                                  
                ];
                // Helper::pr($fields);
                // DB::enableQueryLog();
                DeleteAccountRequest::insert($fields2);
                // DeleteAccountRequest::where('id', $doctor_id)->update($fields);
                // dd(DB::getQueryLog());
                return redirect('delete-account')->with('success_message', 'Delete account request send successfully');
            } else {
                return redirect('delete-account')->with('error_message', 'Please enter valid data');
                
            }
        }        
    }
    public function cron_for_attendance_notification(){
        /* throw notification */
            $getTemplate = $this->getNotificationTemplates('ATTENDANCE');
            if($getTemplate){
                $getUserFCMTokens   = DB::table('user_devices')
                                        ->select('fcm_token', DB::raw('MIN(user_id) as user_id'))
                                        ->where('fcm_token', '!=', '')
                                        ->groupBy('fcm_token')
                                        ->get();
                $tokens             = [];
                $type               = 'attendance';
                if($getUserFCMTokens){
                    foreach($getUserFCMTokens as $getUserFCMToken){
                        $employee_id        = $getUserFCMToken->user_id;
                        $response           = $this->sendCommonPushNotification($getUserFCMToken->fcm_token, $getTemplate['title'], $getTemplate['description'], $type);
                        $users[]            = $employee_id;
                        $notificationFields = [
                            'title'             => $getTemplate['title'],
                            'description'       => $getTemplate['description'],
                            'to_users'          => $employee_id,
                            'users'             => json_encode($users),
                            'is_send'           => 1,
                            'send_timestamp'    => date('Y-m-d H:i:s'),
                        ];
                        Notification::insert($notificationFields);
                    }
                }
            }
            echo "Attendance notification";
        /* throw notification */
    }
    public function getNotificationTemplates($notificationType){
        $returnArray                    = [];
        $getRandomNotificationTemplate  = NotificationTemplate::select('title', 'description')->where('status', '=', 1)->where('type', '=', $notificationType)->inRandomOrder()->first();
        if($getRandomNotificationTemplate){
            $returnArray                = [
                'title'         => $getRandomNotificationTemplate->title,
                'description'   => $getRandomNotificationTemplate->description,
            ];
        }
        return $returnArray;
    }
}
