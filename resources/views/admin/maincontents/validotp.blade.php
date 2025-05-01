<?php
use App\Helpers\Helper;
?>
<div class="container-xxl">
   <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
         <!-- Register -->
         <div class="card">
            <div class="card-body">
               <!-- Logo -->
               <!-- <div class="app-brand justify-content-center">
                  <a href="index-2.html" class="app-brand-link gap-2">
                     <span class="app-brand-logo demo">
                        <img src="<?=env('UPLOADS_URL')?><?=$generalSetting->site_logo?>">   
                     </span>
                     <span class="app-brand-text demo text-body fw-bold"><?=$generalSetting->site_name?></span>
                  </a>
               </div> -->
               <!-- /Logo -->
               <h4 class="mb-2"><?=$page_header?> 🔒</h4>
               <p class="mb-4">We sent a verification code to your email.</p>
               <p>Enter the code from the email in the field below.</p>
               <?php if(session('success_message')){?>
                  <div class="alert alert-success alert-dismissible autohide" role="alert">
                     <?=session('success_message')?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
               <?php }?>
               <?php if(session('error_message')){?>
                  <div class="alert alert-danger alert-dismissible autohide" role="alert">
                     <?=session('error_message')?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
               <?php }?>
               <form id="formAuthentication" class="mb-3" action="" method="POST">
                  @csrf
                  <div class="row gx-2 gx-sm-3">
                    <div class="col">
                      <!-- Form -->
                      <div class="mb-4">
                        <input type="text" class="form-control" name="otp1" id="box1" aria-label="" maxlength="1" autocomplete="off" autocapitalize="off" spellcheck="false" autofocus onkeypress="return isNumber(event)" oninput="moveToNext(this, 'box2')" required>
                      </div>
                      <!-- End Form -->
                    </div>

                    <div class="col">
                      <!-- Form -->
                      <div class="mb-4">
                        <input type="text" class="form-control" name="otp2" id="box2" aria-label="" maxlength="1" autocomplete="off" autocapitalize="off" spellcheck="false" onkeypress="return isNumber(event)" oninput="moveToNext(this, 'box3')" required>
                      </div>
                      <!-- End Form -->
                    </div>

                    <div class="col">
                      <!-- Form -->
                      <div class="mb-4">
                        <input type="text" class="form-control" name="otp3" id="box3" aria-label="" maxlength="1" autocomplete="off" autocapitalize="off" spellcheck="false" onkeypress="return isNumber(event)" oninput="moveToNext(this, 'box4')" required>
                      </div>
                      <!-- End Form -->
                    </div>

                    <div class="col">
                      <!-- Form -->
                      <div class="mb-4">
                        <input type="text" class="form-control" name="otp4" id="box4" aria-label="" maxlength="1" autocomplete="off" autocapitalize="off" spellcheck="false" onkeypress="return isNumber(event)" required>
                      </div>
                      <!-- End Form -->
                    </div>
                  </div>
                  <div class="mb-3 form-password-toggle">
                     <div class="d-flex justify-content-between">
                        <a href="<?=url('admin/')?>"><small>Sign In?</small></a>
                     </div>
                  </div>
                  <div class="mb-3">
                     <button class="btn btn-primary d-grid w-100" type="submit">Verify My Account</button>
                  </div>
                  <div class="text-center">
                    <p>Haven't received it? <a href="<?=url('admin/resendOtp/' . Helper::encoded($email))?>">Resend a new code.</a></p>
                  </div>
               </form>
            </div>
         </div>
         <!-- /Register -->
      </div>
   </div>
</div>