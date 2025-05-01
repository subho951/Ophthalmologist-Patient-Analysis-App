<?php
use App\Helpers\Helper;
$current_url = url()->current();
?>
<div class="container-xxl flex-grow-1 container-p-y">
   <h4 class="py-3 mb-4">
      <span class="text-muted fw-light"><a href="<?=url('admin/dashboard')?>">Dashboard</a> /</span> <?=$page_header?>
   </h4>
   <div class="row">
      <div class="col-md-12">
         <div class="nav-align-top mb-4">
            <ul class="nav nav-pills mb-3" role="tablist">
               <li class="nav-item">
                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#tab1" aria-controls="tab1" aria-selected="true">Profile</button>
               </li>
               <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab2" aria-controls="tab2" aria-selected="false">General</button>
               </li>
               <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab3" aria-controls="tab3" aria-selected="false">Change PIN</button>
               </li>
               <!-- <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab4" aria-controls="tab4" aria-selected="false">Application</button>
               </li> -->
               <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab5" aria-controls="tab5" aria-selected="false">Email</button>
               </li>
               <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab6" aria-controls="tab6" aria-selected="false">SMS</button>
               </li>
               <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab7" aria-controls="tab7" aria-selected="false">Color</button>
               </li>
               <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab8" aria-controls="tab8" aria-selected="false">SEO</button>
               </li>
               <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab9" aria-controls="tab9" aria-selected="false">Email Templates</button>
               </li>
            </ul>
            <div class="tab-content">
               <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                  <form method="POST" action="<?=url('admin/profile-settings')?>" enctype="multipart/form-data">
                     @csrf
                     <h5>Profile Settings</h5>
                     <div class="row">
                        <div class="mb-3 col-md-6">
                           <label for="name" class="form-label">Name</label>
                           <input class="form-control" type="text" id="name" name="name" value="<?=$admin->name?>" required autofocus />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="username" class="form-label">Username</label>
                           <input class="form-control" type="text" name="username" id="username" value="<?=$admin->username?>" required />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="email" class="form-label">E-mail</label>
                           <input class="form-control" type="text" id="email" name="email" value="<?=$admin->email?>" required />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label class="form-label" for="mobile">Phone Number</label>
                           <div class="input-group input-group-merge">
                              <span class="input-group-text">IN (+91)</span>
                              <input type="text" id="mobile" name="mobile" class="form-control" value="<?=$admin->mobile?>" required />
                           </div>
                        </div>
                        <div class="mb-3 col-md-12">
                           <div class="d-flex align-items-start align-items-sm-center gap-4">
                              <?php if($admin->image != ''){?>
                              <img src="<?=env('UPLOADS_URL').'/'.$admin->image?>" alt="<?=$admin->name?>" class="d-block rounded" height="100" width="100" style="border-radius: 50%;" id="uploadedAvatar" />
                              <?php } else {?>
                              <img src="<?=env('NO_USER_IMAGE')?>" alt="<?=$admin->name?>" class="d-block rounded" height="100" width="100" style="border-radius: 50%;" id="uploadedAvatar" />
                              <?php } ?>
                              <div class="button-wrapper">
                                 <label for="image" class="btn btn-primary me-2 mb-4" tabindex="0">
                                 <span class="d-none d-sm-block">Upload Profile Image</span>
                                 <i class="bx bx-upload d-block d-sm-none"></i>
                                 <input type="file" id="image" name="image" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                 </label>
                                 <a href="<?=url('admin/common-delete-image/'.Helper::encoded($current_url).'/admins/image/id/'.$uId)?>" title="Remove image" onclick="return confirm('Do You Want To Delete This Image ?');">
                                 <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                 <i class="bx bx-reset d-block d-sm-none"></i>
                                 <span class="d-none d-sm-block">Reset</span>
                                 </button>
                                 </a>
                                 <p class="text-muted mb-0">Allowed JPG, JPEG, ICO, PNG, GIF, SVG, AVIF</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <!-- <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                     </div>
                  </form>
               </div>
               <div class="tab-pane fade" id="tab2" role="tabpanel">
                  <form method="POST" action="<?=url('admin/general-settings')?>" enctype="multipart/form-data">
                     @csrf
                     <h5>General Settings</h5>
                     <div class="row">
                        <div class="mb-3 col-md-6">
                           <label for="site_name" class="form-label">Site Name</label>
                           <input class="form-control" type="text" id="site_name" name="site_name" value="<?=$setting->site_name?>" required autofocus />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="site_url" class="form-label">Site URL</label>
                           <input class="form-control" type="text" id="site_url" name="site_url" value="<?=$setting->site_url?>" required />
                        </div>

                        <div class="mb-3 col-md-6">
                           <label class="form-label" for="site_phone">Site Phone 1</label>
                           <div class="input-group input-group-merge">
                              <span class="input-group-text">IN (+91)</span>
                              <input type="text" id="site_phone" name="site_phone" class="form-control" value="<?=$setting->site_phone?>" required />
                           </div>
                        </div>
                        <div class="mb-3 col-md-6">
                           <label class="form-label" for="site_phone2">Site Phone 2</label>
                           <div class="input-group input-group-merge">
                              <span class="input-group-text">IN (+91)</span>
                              <input type="text" id="site_phone2" name="site_phone2" class="form-control" value="<?=$setting->site_phone2?>" required />
                           </div>
                        </div>

                        <div class="mb-3 col-md-6">
                           <label for="site_mail" class="form-label">Site E-mail</label>
                           <input class="form-control" type="text" id="site_mail" name="site_mail" value="<?=$setting->site_mail?>" required />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="system_email" class="form-label">System E-mail</label>
                           <input class="form-control" type="text" id="system_email" name="system_email" value="<?=$setting->system_email?>" required />
                        </div>

                        <div class="mb-3 col-md-4">
                           <label for="description" class="form-label">Address</label>
                           <textarea class="form-control" id="description" name="description" rows="5"><?=$setting->description?></textarea>
                        </div>
                        <div class="mb-3 col-md-4">
                           <label for="become_partner_text" class="form-label">Description</label>
                           <textarea class="form-control" id="become_partner_text" name="become_partner_text" rows="5"><?=$setting->become_partner_text?></textarea>
                        </div>
                        <div class="mb-3 col-md-4">
                           <label for="copyright_statement" class="form-label">Copyright Statement</label>
                           <textarea class="form-control" id="copyright_statement" name="copyright_statement" rows="5"><?=$setting->copyright_statement?></textarea>
                        </div>

                        <div class="mb-3 col-md-4">
                           <label for="tax_percent" class="form-label">TAX Percentage (%)</label>
                           <input type="text" class="form-control" id="tax_percent" name="tax_percent" value="<?=$setting->tax_percent?>" required>
                        </div>
                        <div class="mb-3 col-md-4">
                           <label for="google_map_api_code" class="form-label">Google Map API Code</label>
                           <input type="text" class="form-control" id="google_map_api_code" name="google_map_api_code" value="<?=$setting->google_map_api_code?>">
                        </div>
                        <div class="mb-3 col-md-4">
                           <label for="google_analytics_code" class="form-label">Google Analytics Code</label>
                           <textarea class="form-control" id="google_analytics_code" name="google_analytics_code" rows="5"><?=$setting->google_analytics_code?></textarea>
                        </div>

                        <div class="mb-3 col-md-6">
                           <label for="google_pixel_code" class="form-label">Google Pixel Code</label>
                           <textarea class="form-control" id="google_pixel_code" name="google_pixel_code" rows="5"><?=$setting->google_pixel_code?></textarea>
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="facebook_tracking_code" class="form-label">Facebook Tracking Code</label>
                           <textarea class="form-control" id="facebook_tracking_code" name="facebook_tracking_code" rows="5"><?=$setting->facebook_tracking_code?></textarea>
                        </div>

                        <div class="mb-3 col-md-6">
                           <label class="form-label" for="whatsapp_no">Whatsapp No.</label>
                           <div class="input-group input-group-merge">
                              <span class="input-group-text">IN (+91)</span>
                              <input type="text" id="whatsapp_no" name="whatsapp_no" class="form-control" value="<?=$setting->whatsapp_no?>" />
                           </div>
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="twitter_profile" class="form-label">Twitter Profile</label>
                           <input class="form-control" type="text" id="twitter_profile" name="twitter_profile" value="<?=$setting->twitter_profile?>" />
                        </div>

                        <div class="mb-3 col-md-6">
                           <label for="facebook_profile" class="form-label">Facebook Profile</label>
                           <input class="form-control" type="text" id="facebook_profile" name="facebook_profile" value="<?=$setting->facebook_profile?>" />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="instagram_profile" class="form-label">Instagram Profile</label>
                           <input class="form-control" type="text" id="instagram_profile" name="instagram_profile" value="<?=$setting->instagram_profile?>" />
                        </div>

                        <div class="mb-3 col-md-6">
                           <label for="linkedin_profile" class="form-label">Linkedin Profile</label>
                           <input class="form-control" type="text" id="linkedin_profile" name="linkedin_profile" value="<?=$setting->linkedin_profile?>" />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="youtube_profile" class="form-label">Youtube Profile</label>
                           <input class="form-control" type="text" id="youtube_profile" name="youtube_profile" value="<?=$setting->youtube_profile?>" />
                        </div>

                        <div class="mb-3 col-md-4">
                           <div class="d-flex align-items-start align-items-sm-center gap-4">
                              <?php if($setting->site_logo != ''){?>
                              <img src="<?=env('UPLOADS_URL').'/'.$setting->site_logo?>" alt="<?=$setting->site_name?>" class="d-block rounded" height="100" width="100" style="border-radius: 50%;" id="uploadedAvatar" />
                              <?php } else {?>
                              <img src="<?=env('NO_USER_IMAGE')?>" alt="<?=$setting->site_name?>" class="d-block rounded" height="100" width="100" style="border-radius: 50%;" id="uploadedAvatar" />
                              <?php } ?>
                              <div class="button-wrapper">
                                 <label for="site_logo" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Site Logo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="site_logo" name="site_logo" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                 </label>
                                 <a href="<?=url('admin/common-delete-image/'.Helper::encoded($current_url).'/general_settings/site_logo/id/1')?>" title="Remove image" onclick="return confirm('Do You Want To Delete This Image ?');">
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                       <i class="bx bx-reset d-block d-sm-none"></i>
                                       <span class="d-none d-sm-block">Reset</span>
                                    </button>
                                 </a>
                                 <p class="text-muted mb-0">Allowed JPG, JPEG, ICO, PNG, GIF, SVG, AVIF</p>
                              </div>
                           </div>
                        </div>
                        <div class="mb-3 col-md-4">
                           <div class="d-flex align-items-start align-items-sm-center gap-4">
                              <?php if($setting->site_footer_logo != ''){?>
                              <img src="<?=env('UPLOADS_URL').'/'.$setting->site_footer_logo?>" alt="<?=$setting->site_name?>" class="d-block rounded" height="100" width="100" style="border-radius: 50%;" id="uploadedAvatar" />
                              <?php } else {?>
                              <img src="<?=env('NO_USER_IMAGE')?>" alt="<?=$setting->site_name?>" class="d-block rounded" height="100" width="100" style="border-radius: 50%;" id="uploadedAvatar" />
                              <?php } ?>
                              <div class="button-wrapper">
                                 <label for="site_footer_logo" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Site Footer Logo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="site_footer_logo" name="site_footer_logo" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                 </label>
                                 <a href="<?=url('admin/common-delete-image/'.Helper::encoded($current_url).'/general_settings/site_footer_logo/id/1')?>" title="Remove image" onclick="return confirm('Do You Want To Delete This Image ?');">
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                       <i class="bx bx-reset d-block d-sm-none"></i>
                                       <span class="d-none d-sm-block">Reset</span>
                                    </button>
                                 </a>
                                 <p class="text-muted mb-0">Allowed JPG, JPEG, ICO, PNG, GIF, SVG, AVIF</p>
                              </div>
                           </div>
                        </div>
                        <div class="mb-3 col-md-4">
                           <div class="d-flex align-items-start align-items-sm-center gap-4">
                              <?php if($setting->site_favicon != ''){?>
                              <img src="<?=env('UPLOADS_URL').'/'.$setting->site_favicon?>" alt="<?=$setting->site_name?>" class="d-block rounded" height="100" width="100" style="border-radius: 50%;" id="uploadedAvatar" />
                              <?php } else {?>
                              <img src="<?=env('NO_USER_IMAGE')?>" alt="<?=$setting->site_name?>" class="d-block rounded" height="100" width="100" style="border-radius: 50%;" id="uploadedAvatar" />
                              <?php } ?>
                              <div class="button-wrapper">
                                 <label for="site_favicon" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Site Favicon</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="site_favicon" name="site_favicon" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                 </label>
                                 <a href="<?=url('admin/common-delete-image/'.Helper::encoded($current_url).'/general_settings/site_favicon/id/1')?>" title="Remove image" onclick="return confirm('Do You Want To Delete This Image ?');">
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                       <i class="bx bx-reset d-block d-sm-none"></i>
                                       <span class="d-none d-sm-block">Reset</span>
                                    </button>
                                 </a>
                                 <p class="text-muted mb-0">Allowed JPG, JPEG, ICO, PNG, GIF, SVG, AVIF</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <!-- <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                     </div>
                  </form>
               </div>
               <div class="tab-pane fade" id="tab3" role="tabpanel">
                  <form method="POST" action="<?=url('admin/change-password')?>" enctype="multipart/form-data">
                     @csrf
                     <h5>Change PIN</h5>
                     <div class="row">
                        <div class="mb-3 col-md-4">
                           <label class="form-label" for="old_password">Current PIN</label>
                           <div class="input-group input-group-merge">
                              <span class="input-group-text"><i class="fa fa-key"></i></span>
                              <input type="password" id="old_password" name="old_password" class="form-control" maxlength="4" minlength="4" required />
                           </div>
                        </div>
                        <div class="mb-3 col-md-4">
                           <label class="form-label" for="new_password">New PIN</label>
                           <div class="input-group input-group-merge">
                              <span class="input-group-text"><i class="fa fa-key"></i></span>
                              <input type="password" id="new_password" name="new_password" class="form-control" maxlength="4" minlength="4" required />
                           </div>
                        </div>
                        <div class="mb-3 col-md-4">
                           <label class="form-label" for="confirm_password">Confirm PIN</label>
                           <div class="input-group input-group-merge">
                              <span class="input-group-text"><i class="fa fa-key"></i></span>
                              <input type="password" id="confirm_password" name="confirm_password" class="form-control" maxlength="4" minlength="4" required />
                           </div>
                        </div>
                     </div>
                     <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <!-- <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                     </div>
                  </form>
               </div>
               <div class="tab-pane fade" id="tab4" role="tabpanel">
               </div>
               <div class="tab-pane fade" id="tab5" role="tabpanel">
                  <form method="POST" action="<?=url('admin/email-settings')?>" enctype="multipart/form-data">
                     @csrf
                     <h5>Email Settings</h5>
                     <div class="row">
                        <div class="mb-3 col-md-6">
                           <label for="from_email" class="form-label">From Email</label>
                           <input class="form-control" type="text" id="from_email" name="from_email" value="<?=$setting->from_email?>" required autofocus />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="from_name" class="form-label">From Name</label>
                           <input class="form-control" type="text" name="from_name" id="from_name" value="<?=$setting->from_name?>" required />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="smtp_host" class="form-label">SMTP Host</label>
                           <input class="form-control" type="text" id="smtp_host" name="smtp_host" value="<?=$setting->smtp_host?>" required />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label class="form-label" for="smtp_username">SMTP Username</label>
                           <input type="text" id="smtp_username" name="smtp_username" class="form-control" value="<?=$setting->smtp_username?>" required />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label class="form-label" for="smtp_password">SMTP Password</label>
                           <input type="text" id="smtp_password" name="smtp_password" class="form-control" value="<?=$setting->smtp_password?>" required />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label class="form-label" for="smtp_port">SMTP Port</label>
                           <input type="text" id="smtp_port" name="smtp_port" class="form-control" value="<?=$setting->smtp_port?>" required />
                        </div>
                     </div>
                     <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <!-- <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                     </div>
                  </form>
               </div>
               <div class="tab-pane fade" id="tab6" role="tabpanel">
                  <form method="POST" action="<?=url('admin/sms-settings')?>" enctype="multipart/form-data">
                     @csrf
                     <h5>SMS Settings</h5>
                     <div class="row">
                        <div class="mb-3 col-md-4">
                           <label for="sms_authentication_key" class="form-label">Authentication Key</label>
                           <input class="form-control" type="text" id="sms_authentication_key" name="sms_authentication_key" value="<?=$setting->sms_authentication_key?>" required autofocus />
                        </div>
                        <div class="mb-3 col-md-4">
                           <label for="sms_sender_id" class="form-label">Sender ID</label>
                           <input class="form-control" type="text" name="sms_sender_id" id="sms_sender_id" value="<?=$setting->sms_sender_id?>" required />
                        </div>
                        <div class="mb-3 col-md-4">
                           <label for="sms_base_url" class="form-label">Base Url</label>
                           <input class="form-control" type="text" id="sms_base_url" name="sms_base_url" value="<?=$setting->sms_base_url?>" required />
                        </div>
                     </div>
                     <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <!-- <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                     </div>
                  </form>
               </div>
               <div class="tab-pane fade" id="tab7" role="tabpanel">
                  <form method="POST" action="<?=url('admin/color-settings')?>" enctype="multipart/form-data">
                     @csrf
                     <h5>Color Settings</h5>
                     <div class="row">
                        <div class="mb-3 col-md-6">
                           <label for="header_color" class="form-label">Header Color</label>
                           <input class="form-control" type="color" id="header_color" name="header_color" value="<?=$setting->header_color?>" required autofocus />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="sidebar_color" class="form-label">Sidebar Color</label>
                           <input class="form-control" type="color" id="sidebar_color" name="sidebar_color" value="<?=$setting->sidebar_color?>" required autofocus />
                        </div>
                     </div>
                     <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <!-- <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                     </div>
                  </form>
               </div>
               <div class="tab-pane fade" id="tab8" role="tabpanel">
                  <form method="POST" action="<?=url('admin/seo-settings')?>" enctype="multipart/form-data">
                     @csrf
                     <h5>SEO Settings</h5>
                     <div class="row">
                        <div class="mb-3 col-md-6">
                           <label for="meta_title" class="form-label">Meta Title</label>
                           <textarea class="form-control" id="meta_title" name="meta_title" rows="10"><?=$setting->meta_title?></textarea>
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="meta_description" class="form-label">Meta Description</label>
                           <textarea class="form-control" id="meta_description" name="meta_description" rows="10"><?=$setting->meta_description?></textarea>
                        </div>
                     </div>
                     <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <!-- <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                     </div>
                  </form>
               </div>
               <div class="tab-pane fade" id="tab9" role="tabpanel">
                  <form method="POST" action="<?=url('admin/email-template')?>" enctype="multipart/form-data">
                     @csrf
                     <h5>SEO Settings</h5>
                     <div class="row">
                        <div class="mb-3 col-md-6">
                           <label for="email_template_user_signup_sender_name" class="form-label">Signup Sender Name</label>
                           <input class="form-control" type="text" id="email_template_user_signup_sender_name" name="email_template_user_signup_sender_name" value="<?=$setting->email_template_user_signup_sender_name?>" />
                        </div>
                        <div class="mb-3 col-md-6">
                           <label for="email_template_user_signup_subject" class="form-label">Signup Sender Subject</label>
                           <input class="form-control" type="text" id="email_template_user_signup_subject" name="email_template_user_signup_subject" value="<?=$setting->email_template_user_signup_subject?>" />
                        </div>
                        <div class="mb-3 col-md-12">
                           <label for="email_template_user_signup" class="form-label">User Signup</label>
                           <textarea class="form-control" id="ckeditor1" name="email_template_user_signup" rows="10"><?=$setting->email_template_user_signup?></textarea>
                        </div>
                        <div class="mb-3 col-md-12">
                           <label for="email_template_forgot_password" class="form-label">Forgot Password</label>
                           <textarea class="form-control" id="ckeditor2" name="email_template_forgot_password" rows="10"><?=$setting->email_template_forgot_password?></textarea>
                        </div>
                        <div class="mb-3 col-md-12">
                           <label for="email_template_change_password" class="form-label">Change Password</label>
                           <textarea class="form-control" id="ckeditor3" name="email_template_change_password" rows="10"><?=$setting->email_template_change_password?></textarea>
                        </div>
                        <div class="mb-3 col-md-12">
                           <label for="email_template_failed_login" class="form-label">Failed Login</label>
                           <textarea class="form-control" id="ckeditor4" name="email_template_failed_login" rows="10"><?=$setting->email_template_failed_login?></textarea>
                        </div>
                        <div class="mb-3 col-md-12">
                           <label for="email_template_contactus" class="form-label">Contact Us</label>
                           <textarea class="form-control" id="ckeditor5" name="email_template_contactus" rows="10"><?=$setting->email_template_contactus?></textarea>
                        </div>
                     </div>
                     <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <!-- <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>