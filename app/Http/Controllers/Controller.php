<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Models\GeneralSetting;
use App\Models\HomePage;
use App\Models\Admin;
use App\Models\User;
use App\Models\UserAccess;
use App\Models\Category;
use App\Models\Manufacturer;
use Session;
use Helper;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
    protected function sendMail($email, $subject, $message, $file = '')
    {
        $generalSetting             = GeneralSetting::find('1');
        $mailLibrary                = new PHPMailer(true);
        $mailLibrary->CharSet       = 'UTF-8';
        $mailLibrary->SMTPDebug     = 0;
        //$mailLibrary->IsSMTP();
        $mailLibrary->Host          = $generalSetting->smtp_host;
        $mailLibrary->SMTPAuth      = true;
        $mailLibrary->Port          = $generalSetting->smtp_port;
        $mailLibrary->Username      = $generalSetting->smtp_username;
        $mailLibrary->Password      = $generalSetting->smtp_password;
        $mailLibrary->SMTPSecure    = 'ssl';
        $mailLibrary->From          = $generalSetting->from_email;
        $mailLibrary->FromName      = $generalSetting->from_name;
        $mailLibrary->AddReplyTo($generalSetting->from_email, $generalSetting->from_name);
        if(is_array($email)) :
            foreach($email as $eml):
                $mailLibrary->addAddress($eml);
            endforeach;
        else:
            $mailLibrary->addAddress($email);
        endif;
        $mailLibrary->WordWrap      = 5000;
        $mailLibrary->Subject       = $subject;
        $mailLibrary->Body          = $message;
        $mailLibrary->isHTML(true);
        if (!empty($file)):
            $mailLibrary->AddAttachment($file);
        endif;
        return (!$mailLibrary->send()) ? false : true;
    }
    // single file upload
    public function upload_single_file($fieldName, $fileName, $uploadedpath, $uploadType, $tempFile = '')
    {
        $imge = $fileName;
        if($imge == '') {
            $slider_image = 'no-user-image.jpg';
        } else {
            $imageFileType1 = pathinfo($imge, PATHINFO_EXTENSION);
            if($uploadType == 'image') {
                if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "JPG" && $imageFileType1 != "PNG" && $imageFileType1 != "JPEG" && $imageFileType1 != "ico" && $imageFileType1 != "ICO" && $imageFileType1 != "SVG" && $imageFileType1 != "svg" && $imageFileType1 != "GIF" && $imageFileType1 != "gif" && $imageFileType1 != "WEBP" && $imageFileType1 != "webp" && $imageFileType1 != "AVIF" && $imageFileType1 != "avif") {
                    $message = 'Sorry, only JPG, JPEG, ICO, SVG, PNG, GIF, WEBP & AVIF files are allowed';
                    $status = 0;
                } else {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType == 'pdf') {
                if($imageFileType1 != "pdf" && $imageFileType1 != "PDF") {
                    $message = 'Sorry, only PDF files are allowed';
                    $status = 0;
                } else {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType == 'word') {
                if($imageFileType1 != "doc" && $imageFileType1 != "DOC" && $imageFileType1 != "docx" && $imageFileType1 != "DOCX") {
                    $message = 'Sorry, only DOC files are allowed';
                    $status = 0;
                } else {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType == 'excel') {
                if($imageFileType1 != "xls" && $imageFileType1 != "XLS" && $imageFileType1 != "xlsx" && $imageFileType1 != "XLSX") {
                    $message = 'Sorry, only EXCEl files are allowed';
                    $status = 0;
                } else {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType == 'powerpoint') {
                if($imageFileType1 != "ppt" && $imageFileType1 != "PPT" && $imageFileType1 != "pptx" && $imageFileType1 != "PPTX") {
                    $message = 'Sorry, only PPT files are allowed';
                    $status = 0;
                } else {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType == 'video') {
                if($imageFileType1 != "mp4" && $imageFileType1 != "3gp" && $imageFileType1 != "webm" && $imageFileType1 != "MP4" && $imageFileType1 != "3GP" && $imageFileType1 != "WEBM") {
                    $message = 'Sorry, only Video files are allowed';
                    $status = 0;
                } else {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType == 'custom') {
                if($imageFileType1 != "doc" && $imageFileType1 != "DOC" && $imageFileType1 != "docx" && $imageFileType1 != "DOCX" && $imageFileType1 != "pdf" && $imageFileType1 != "PDF" && $imageFileType1 != "ppt" && $imageFileType1 != "PPT" && $imageFileType1 != "pptx" && $imageFileType1 != "PPTX" && $imageFileType1 != "txt" && $imageFileType1 != "TXT" && $imageFileType1 != "xls" && $imageFileType1 != "XLS" && $imageFileType1 != "xlsx" && $imageFileType1 != "XLSX" && $imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "JPG" && $imageFileType1 != "PNG" && $imageFileType1 != "JPEG" && $imageFileType1 != "ico" && $imageFileType1 != "ICO" && $imageFileType1 != "SVG" && $imageFileType1 != "svg" && $imageFileType1 != "GIF" && $imageFileType1 != "gif" && $imageFileType1 != "WEBP" && $imageFileType1 != "webp" && $imageFileType1 != "AVIF" && $imageFileType1 != "avif") {
                    $message = 'Sorry, only DOC, DOCX, PPT, PPTX, PDF, XLS, XLSX, JPG, JPEG, ICO, SVG, PNG, GIF, WEBP & AVIF files are allowed';
                    $status = 0;
                } else {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType == 'customapplication') {
                if($imageFileType1 != "doc" && $imageFileType1 != "DOC" && $imageFileType1 != "docx" && $imageFileType1 != "DOCX" && $imageFileType1 != "pdf" && $imageFileType1 != "PDF" && $imageFileType1 != "txt" && $imageFileType1 != "TXT") {
                    $message = 'Sorry, only .DOC,.DOCX,.PDF,.TXT files are allowed';
                    $status = 0;
                } else {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType == 'csv') {
                if($imageFileType1 != "csv" && $imageFileType1 != "CSV") {
                    $message = 'Sorry, only CSV files are allowed';
                    $status = 0;
                } else {
                    $message = 'Upload ok';
                    $status = 1;
                }
            }

            $newFilename = time().$imge;
            if($tempFile == ''){
                $temp = $_FILES[$fieldName]["tmp_name"];
            } else {
                $temp = $tempFile;
            }
            if($uploadedpath == '') {
                $upload_path = 'public/uploads/';
            } else {
                $upload_path = 'public/uploads/'.$uploadedpath.'/';
            }
            if($status) {
                move_uploaded_file($temp, $upload_path.$newFilename);
                $return_array = array('status' => 1, 'message' => $message, 'newFilename' => $newFilename);
            } else {
                $return_array = array('status' => 0, 'message' => $message, 'newFilename' => '');
            }
            return $return_array;
        }
    }
    // multiple files upload
    public function commonFileArrayUpload($path = '', $images = array(), $uploadType = '')
    {
        $apiStatus = false;
        $apiMessage = [];
        $apiResponse = [];
        if(count($images) > 0) {
            for($p = 0;$p < count($images);$p++) {
                $imge = $images[$p]->getClientOriginalName();
                if($imge == '') {
                    $slider_image = 'no-user-image.jpg';
                } else {
                    $imageFileType1 = pathinfo($imge, PATHINFO_EXTENSION);
                    if($uploadType == 'image') {
                        if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" && $imageFileType1 != "JPG" && $imageFileType1 != "PNG" && $imageFileType1 != "JPEG" && $imageFileType1 != "GIF" && $imageFileType1 != "ico" && $imageFileType1 != "ICO" && $imageFileType1 != "svg" && $imageFileType1 != "SVG" && $imageFileType1 != "GIF" && $imageFileType1 != "gif" && $imageFileType1 != "WEBP" && $imageFileType1 != "webp" && $imageFileType1 != "AVIF" && $imageFileType1 != "avif") {
                            $message = 'Sorry, only JPG, JPEG, ICO, PNG, GIF, SVG & AVIF files are allowed';
                            $status = 0;
                        } else {
                            $message = 'Upload ok';
                            $status = 1;
                        }
                    } elseif($uploadType == 'pdf') {
                        if($imageFileType1 != "pdf" && $imageFileType1 != "PDF") {
                            $message = 'Sorry, only PDF files are allowed';
                            $status = 0;
                        } else {
                            $message = 'Upload ok';
                            $status = 1;
                        }
                    } elseif($uploadType == 'word') {
                        if($imageFileType1 != "doc" && $imageFileType1 != "DOC" && $imageFileType1 != "docx" && $imageFileType1 != "DOCX") {
                            $message = 'Sorry, only DOC files are allowed';
                            $status = 0;
                        } else {
                            $message = 'Upload ok';
                            $status = 1;
                        }
                    } elseif($uploadType == 'excel') {
                        if($imageFileType1 != "xls" && $imageFileType1 != "XLS" && $imageFileType1 != "xlsx" && $imageFileType1 != "XLSX") {
                            $message = 'Sorry, only EXCEl files are allowed';
                            $status = 0;
                        } else {
                            $message = 'Upload ok';
                            $status = 1;
                        }
                    } elseif($uploadType == 'powerpoint') {
                        if($imageFileType1 != "ppt" && $imageFileType1 != "PPT" && $imageFileType1 != "pptx" && $imageFileType1 != "PPTX") {
                            $message = 'Sorry, only PPT files are allowed';
                            $status = 0;
                        } else {
                            $message = 'Upload ok';
                            $status = 1;
                        }
                    } elseif($uploadType == 'all') {
                        if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" && $imageFileType1 != "JPG" && $imageFileType1 != "PNG" && $imageFileType1 != "JPEG" && $imageFileType1 != "GIF" && $imageFileType1 != "ico" && $imageFileType1 != "ICO" && $imageFileType1 != "ppt" && $imageFileType1 != "PPT" && $imageFileType1 != "pptx" && $imageFileType1 != "PPTX" && $imageFileType1 != "pdf" && $imageFileType1 != "PDF" && $imageFileType1 != "doc" && $imageFileType1 != "DOC" && $imageFileType1 != "docx" && $imageFileType1 != "DOCX" && $imageFileType1 != "xls" && $imageFileType1 != "XLS" && $imageFileType1 != "xlsx" && $imageFileType1 != "XLSX") {
                            $message = 'Sorry, only image,pdf,docs,xls,ppt files are allowed';
                            $status = 0;
                        } else {
                            $message = 'Upload ok';
                            $status = 1;
                        }
                    }

                    $newFilename = uniqid().".".$imageFileType1;
                    // $temp = $images[$p]->getTempName();
                    $temp = $images[$p]->getPathName();
                    if($path == '') {
                        $upload_path = 'public/uploads/';
                    } else {
                        $upload_path = 'public/uploads/'.$path.'/';
                    }
                    if($status) {
                        move_uploaded_file($temp, $upload_path.$newFilename);
                        //$apiStatus      = TRUE;
                        //$apiMessage     = $message;
                        $apiResponse[]  = $newFilename;
                    } else {
                        //$apiStatus      = FALSE;
                        //$apiMessage     = $message;
                    }
                }
            }
        }
        //$return_array = array('status'=> $apiStatus, 'message'=> $apiMessage, 'newFilename'=> $apiResponse);
        return $apiResponse;
    }
    // front before login layout
    public function front_before_login_layout($title, $page_name, $data)
    {
        $data['generalSetting']             = GeneralSetting::find('1');
        $data['content']                    = HomePage::where('status', '=', 1)->orderBy('id', 'ASC')->first();
        $data['user']                       = [];
        $data['title']                      = $title.' :: '.$data['generalSetting']->site_name;
        $data['page_header']                = $title;
        $user_id                            = session('user_id');
        $data['user']                       = User::find($user_id);
        $data['cats']                       = Category::select('id', 'category_name')->where('status', '=', 1)->where('parent_id', '=', 0)->orderBy('id', 'ASC')->get();
        $data['manufacturers']              = Manufacturer::select('id', 'name')->where('status', '=', 1)->orderBy('id', 'ASC')->get();

        $data['before_head']                = view('front.elements.beforehead', $data);
        $data['before_header']              = view('front.elements.beforeheader', $data);
        $data['before_footer']              = view('front.elements.beforefooter', $data);
        $data['maincontent']                = view('front.pages.'.$page_name, $data);
        return view('front.layout-before-login', $data);
    }
    // front after login layout
    public function front_after_login_layout($title, $page_name, $data)
    {
        $data['generalSetting']     = GeneralSetting::find('1');
        $data['content']            = HomePage::where('status', '=', 1)->orderBy('id', 'ASC')->first();
        $data['title']              = $title.' :: '.$data['generalSetting']->site_name;
        $data['page_header']        = $title;
        $user_id                    = session('user_id');
        $data['user']               = User::find($user_id);

        $data['after_head']         = view('front.elements.afterhead', $data);
        $data['after_header']       = view('front.elements.afterheader', $data);
        $data['after_sidebar']      = view('front.elements.sidebar', $data);
        $data['after_footer']       = view('front.elements.afterfooter', $data);
        $data['maincontent']        = view('front.pages.user.'.$page_name, $data);
        return view('front.layout-after-login', $data);
    }
    // admin authentication layout
    public function admin_before_login_layout($title, $page_name, $data)
    {
        $data['generalSetting']     = GeneralSetting::find('1');
        $data['title']              = $title.' :: '.$data['generalSetting']->site_name;
        $data['page_header']        = $title;

        $data['head']               = view('admin.elements.head-before-login', $data);
        $data['maincontent']        = view('admin.maincontents.'.$page_name, $data);
        return view('admin.layout-before-login', $data);
    }
    // admin after login layout
    public function admin_after_login_layout($title, $page_name, $data)
    {
        $data['generalSetting']     = GeneralSetting::find('1');
        $data['title']              = $title.' :: '.$data['generalSetting']->site_name;
        $data['page_header']        = $title;
        $user_id                    = session('user_id');
        $data['admin']              = Admin::find($user_id);
        $userAccess                 = UserAccess::where('user_id', '=', $user_id)->where('status', '=', 1)->first();
        if($userAccess) {
            $data['module_id']      = json_decode($userAccess->module_id);
        } else {
            $data['module_id']      = [];
        }

        $data['head']               = view('admin.elements.head', $data);
        $data['header']             = view('admin.elements.header', $data);
        $data['footer']             = view('admin.elements.footer', $data);
        $data['sidebar']            = view('admin.elements.sidebar', $data);
        $data['maincontent']        = view('admin.maincontents.'.$page_name, $data);
        return view('admin.layout-after-login', $data);
    }
    // admin after login billing layout
    public function admin_after_login_billing_layout($title, $page_name, $data)
    {
        $data['generalSetting']     = GeneralSetting::find('1');
        $data['title']              = $title.' :: '.$data['generalSetting']->site_name;
        $data['page_header']        = $title;
        $user_id                    = session('user_id');
        $data['admin']              = Admin::find($user_id);
        $userAccess                 = UserAccess::where('user_id', '=', $user_id)->where('status', '=', 1)->first();
        if($userAccess) {
            $data['module_id']      = json_decode($userAccess->module_id);
        } else {
            $data['module_id']      = [];
        }

        $data['head']               = view('admin.elements.billing-head', $data);
        $data['header']             = view('admin.elements.billing-header', $data);
        $data['maincontent']        = view('admin.maincontents.'.$page_name, $data);
        return view('admin.layout-billing', $data);
    }
    // sale operator authentication layout
    public function user_before_login_layout($title, $page_name, $data)
    {
        $data['generalSetting']     = GeneralSetting::find('1');
        $data['title']              = $title.' :: '.$data['generalSetting']->site_name;
        $data['page_header']        = $title;

        $data['head']               = view('front.elements.head-before-login', $data);
        $data['maincontent']        = view('front.maincontents.'.$page_name, $data);
        return view('front.layout-before-login', $data);
    }
    // sale operator after login layout
    public function user_after_login_layout($title, $page_name, $data)
    {
        $data['generalSetting']     = GeneralSetting::find('1');
        $data['title']              = $title.' :: '.$data['generalSetting']->site_name;
        $data['page_header']        = $title;
        $user_id                    = session('user_id');
        $data['admin']              = Admin::find($user_id);
        $userAccess                 = UserAccess::where('user_id', '=', $user_id)->where('status', '=', 1)->first();
        if($userAccess) {
            $data['module_id']      = json_decode($userAccess->module_id);
        } else {
            $data['module_id']      = [];
        }

        $data['head']               = view('front.elements.head', $data);
        $data['header']             = view('front.elements.header', $data);
        // $data['footer']             = view('front.elements.footer', $data);
        // $data['sidebar']            = view('front.elements.sidebar', $data);
        $data['maincontent']        = view('front.maincontents.'.$page_name, $data);
        return view('front.layout-after-login', $data);
    }
    // admin after login billing layout
    public function user_after_login_billing_layout($title, $page_name, $data)
    {
        $data['generalSetting']     = GeneralSetting::find('1');
        $data['title']              = $title.' :: '.$data['generalSetting']->site_name;
        $data['page_header']        = $title;
        $user_id                    = session('user_id');
        $data['admin']              = Admin::find($user_id);
        $userAccess                 = UserAccess::where('user_id', '=', $user_id)->where('status', '=', 1)->first();
        if($userAccess) {
            $data['module_id']      = json_decode($userAccess->module_id);
        } else {
            $data['module_id']      = [];
        }

        $data['head']               = view('front.elements.billing-head', $data);
        $data['header']             = view('front.elements.billing-header', $data);
        $data['maincontent']        = view('front.maincontents.'.$page_name, $data);
        return view('front.layout-billing', $data);
    }
    // currency converter
    public function convertCurrency($amount, $from, $to)
    {
        // Fetching JSON
        $req_url = 'https://api.exchangerate-api.com/v4/latest/'.$from;
        $response_json = file_get_contents($req_url);
        // Continuing if we got a result
        if(false !== $response_json) {
            // Try/catch for json_decode operation
            try {
                // Decoding
                $response_object = json_decode($response_json);
                // YOUR APPLICATION CODE HERE, e.g.
                $base_price = $amount; // Your price in USD
                $EUR_price = round(($base_price * $response_object->rates->$to), 2);
                return $EUR_price;
            } catch(Exception $e) {
                // Handle JSON parse error...
            }
        }
    }
    public function jobseekerNamingFormat($fname, $lname, $dob)
    {
        $formattedName = strtoupper(substr($fname, 0, 1)).'. '.$lname.' '.date_format(date_create($dob), "m-y");
        return $formattedName;
    }
    public function perform_http_request($method, $url, $data = array())
    {

        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); //If SSL Certificate Not Available, for example, I am calling from http://localhost URL
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    public function curl_request_post($method, $functionName, $data = array())
    {
        $url = "https://segen-enterprise.synergydevelopmentgroups.com/api/";

        $dataJson           = [
            'key' => 'facb6e0a6fcbe200dca2fb60dec75be7',
            'source' => 'WEB'
        ];
        $data = array_merge($dataJson, $data);
        // Helper::pr($data);

        $curl = curl_init($url.$functionName);
        curl_setopt($curl, CURLOPT_URL, $url.$functionName);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-type: application/json",
            "Accept: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        //pr($resp);
        return $resp;
    }
    public function getApiResponse($method, $functionName, $data = array())
    {
        $response               = json_decode($this->curl_request_post($method, $functionName));
        return $response->data;
    }
    /* For API Development */
    public function isJSON($string)
    {
        $valid = is_string($string) && is_array(json_decode($string, true)) ? true : false;
        if (!$valid) {
            $this->response_to_json(false, "Not JSON", 401);
        }
    }
    /* Process json from request */
    public function extract_json($key)
    {
        return json_decode($key, true);
    }
    /* Methods to check all necessary fields inside a requested post body */
    public function validateArray($keys, $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }
    /* Set response message response_to_json = set_response */
    public function response_to_json($success = true, $message = "success", $data = null, $extraField = null, $extraData = null)
    {
        $response = ["status" => $success, "message" => $message, "data" => $data];
        if ($extraField != null && $extraData != null) {
            $response[$extraField] = $extraData;
        }
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header("Access-Control-Allow-Headers: Content-Type, X-Auth-Token, X-Requested-With, Origin, Authorization");
        print json_encode($response);
        die;
    }
    public function responseJSON($data)
    {
        print json_encode($data);
        die;
    }
    /* For API Development */
}
