<!DOCTYPE html>
<html lang="en" class="light-style layout-wide  customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?=env('ADMIN_ASSETS_URL')?>/assets/" data-template="vertical-menu-template-free">
   <head>
      <?=$head?>
   </head>
   <body>
      <!-- Content -->
      <?=$maincontent?>
      <!-- / Content -->
      <!-- Core JS -->
      <!-- build:js assets/vendor/js/core.js -->
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/libs/jquery/jquery.js"></script>
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/libs/popper/popper.js"></script>
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/js/bootstrap.js"></script>
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/js/menu.js"></script>
      <!-- endbuild -->
      <!-- Vendors JS -->
      <!-- Main JS -->
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/js/main.js"></script>
      <!-- Page JS -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script>
          $(function(){
            $('.autohide').delay(5000).fadeOut('slow');
          })
          function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
          }
      </script>
      <script>
         function moveToNext(currentBox, nextBoxId) {
             if (currentBox.value.length === currentBox.maxLength) {
                 document.getElementById(nextBoxId).focus();
             }
         }
      </script>
   </body>
</html>
<!-- beautify ignore:end -->