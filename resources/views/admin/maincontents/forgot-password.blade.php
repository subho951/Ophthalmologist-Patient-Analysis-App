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
               <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
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
                  <div class="mb-3">
                     <label for="email" class="form-label">Username</label>
                     <input type="text" class="form-control" id="email" name="username" placeholder="Enter your username" required autofocus>
                  </div>
                  <div class="mb-3">
                     <button class="btn btn-primary d-grid w-100" type="submit">Submit</button>
                  </div>
                  <div class="text-center">
                    <p>Already Have Account? <a href="<?=url('admin/')?>">Click Here</a></p>
                  </div>
               </form>
            </div>
         </div>
         <!-- /Register -->
      </div>
   </div>
</div>