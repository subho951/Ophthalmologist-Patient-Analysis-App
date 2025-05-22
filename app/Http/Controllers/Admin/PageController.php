<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\GeneralSetting;
use App\Models\Page;
use Auth;
use Session;
use Helper;
use Hash;

class PageController extends Controller
{
    public function __construct()
    {        
        $this->data = array(
            'title'             => 'Page',
            'controller'        => 'PageController',
            'controller_route'  => 'page',
            'primary_key'       => 'id',
        );
    }
    /* list */
        public function list(){
            $data['module']                 = $this->data;
            $title                          = $this->data['title'].' List';
            $page_name                      = 'page.list';
            $data['rows']                   = Page::where('status', '!=', 3)->orderBy('id', 'DESC')->get();
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* list */
    /* add */
        public function add(Request $request){
            $data['module']           = $this->data;
            if($request->isMethod('post')){
                $postData = $request->all();
                $rules = [
                    'page_name'             => 'required',
                    'page_content'          => 'required'
                ];
                if($this->validate($request, $rules)){
                    /* page image */
                        $imageFile      = $request->file('page_image');
                        if($imageFile != ''){
                            $imageName      = $imageFile->getClientOriginalName();
                            $uploadedFile   = $this->upload_single_file('page_image', $imageName, 'page', 'image');
                            if($uploadedFile['status']){
                                $page_image = $uploadedFile['newFilename'];
                            } else {
                                return redirect()->back()->with(['error_message' => $uploadedFile['message']]);
                            }
                        } else {
                            $page_image = '';
                        }
                    /* page image */
                    /* page banner image */
                        $imageFile      = $request->file('page_banner_image');
                        if($imageFile != ''){
                            $imageName      = $imageFile->getClientOriginalName();
                            $uploadedFile   = $this->upload_single_file('page_banner_image', $imageName, 'page', 'image');
                            if($uploadedFile['status']){
                                $page_banner_image = $uploadedFile['newFilename'];
                            } else {
                                return redirect()->back()->with(['error_message' => $uploadedFile['message']]);
                            }
                        } else {
                            $page_banner_image = '';
                        }
                    /* page banner image */
                    $fields = [
                        'page_name'             => $postData['page_name'],
                        'page_slug'             => Helper::clean($postData['page_name']),
                        'page_content'          => $postData['page_content'],
                        'page_image'            => $page_image,
                        'page_banner_image'     => $page_banner_image,
                        'page_video'            => $postData['page_video'],
                    ];
                    Page::insert($fields);
                    return redirect("admin/" . $this->data['controller_route'] . "/list")->with('success_message', $this->data['title'].' Inserted Successfully !!!');
                } else {
                    return redirect()->back()->with('error_message', 'All Fields Required !!!');
                }
            }
            $data['module']                 = $this->data;
            $title                          = $this->data['title'].' Add';
            $page_name                      = 'page.add-edit';
            $data['row']                    = [];
            echo $this->admin_after_login_layout($title,$page_name,$data);
        }
    /* add */
    /* edit */
        public function edit(Request $request, $id){
            $data['module']                 = $this->data;
            $id                             = Helper::decoded($id);
            $title                          = $this->data['title'].' Update';
            $page_name                      = 'page.add-edit';
            $data['row']                    = Page::where($this->data['primary_key'], '=', $id)->first();
            if($request->isMethod('post')){
                $postData = $request->all();
                $rules = [
                    'page_name'             => 'required',
                    'page_content'          => 'required'
                ];
                if($this->validate($request, $rules)){
                    /* page image */
                        $imageFile      = $request->file('page_image');
                        if($imageFile != ''){
                            $imageName      = $imageFile->getClientOriginalName();
                            $uploadedFile   = $this->upload_single_file('page_image', $imageName, 'page', 'image');
                            if($uploadedFile['status']){
                                $page_image = $uploadedFile['newFilename'];
                            } else {
                                return redirect()->back()->with(['error_message' => $uploadedFile['message']]);
                            }
                        } else {
                            $page_image = $data['row']->page_image;
                        }
                    /* page image */
                    /* page banner image */
                        $imageFile      = $request->file('page_banner_image');
                        if($imageFile != ''){
                            $imageName      = $imageFile->getClientOriginalName();
                            $uploadedFile   = $this->upload_single_file('page_banner_image', $imageName, 'page', 'image');
                            if($uploadedFile['status']){
                                $page_banner_image = $uploadedFile['newFilename'];
                            } else {
                                return redirect()->back()->with(['error_message' => $uploadedFile['message']]);
                            }
                        } else {
                            $page_banner_image = $data['row']->page_banner_image;
                        }
                    /* page banner image */
                    $fields = [
                        'page_name'             => $postData['page_name'],
                        'page_slug'             => Helper::clean($postData['page_name']),
                        'page_content'          => $postData['page_content'],
                        'page_image'            => $page_image,
                        'page_banner_image'     => $page_banner_image,
                        'page_video'            => $postData['page_video'],
                    ];
                    // Helper::pr($fields);
                    Page::where($this->data['primary_key'], '=', $id)->update($fields);
                    return redirect("admin/" . $this->data['controller_route'] . "/list")->with('success_message', $this->data['title'].' Updated Successfully !!!');
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
            Page::where($this->data['primary_key'], '=', $id)->update($fields);
            return redirect("admin/" . $this->data['controller_route'] . "/list")->with('success_message', $this->data['title'].' Deleted Successfully !!!');
        }
    /* delete */
    /* change status */
        public function change_status(Request $request, $id){
            $id                             = Helper::decoded($id);
            $model                          = Page::find($id);
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
