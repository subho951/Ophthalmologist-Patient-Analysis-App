<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;


use App\Models\GeneralSetting;
use App\Models\Page;
use App\Models\Notification;
use App\Models\NotificationTemplate;

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
    public function deleteaccount(Request $request)
    {
        if($request->isMethod('get')){
            $postData           = $request->all();
            $Entityname         = $postData['entity_name'];
            $email             = $postData['email'];
            $phone           = $postData['phone'];
            $comment           = $postData['comment'];
            $rules = [                                 
                'email'                => 'required'
            ];
            $doctor         = Doctor::where('email', $email)->first();
            if($doctor){
                $doctor_id         = $doctor->id;
            }
            if ($this->validate($request, $rules)) {
                $fields = [
                    'status'         => 3,
                    'approve_date'   => date('Y-m-d H:i:s'),               
                ];
                Helper::pr($fields);
                Doctor::where('id', $doctor_id)->update($fields);
                return redirect('delete-account')->with('success_message', 'Delete acoount successfully');
            } else {
                return redirect('delete-account')->with('error_message', 'Please enter valid email');
            }
        }
        $data = [];
        $title                          = 'Delete Account';
        $page_name                      = 'delete-account';     

        return view('delete-account', $data);
        // echo $this->front_before_login_layout($title, $page_name, $data);
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
