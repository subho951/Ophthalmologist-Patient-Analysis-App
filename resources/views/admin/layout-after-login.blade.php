<?php
   use Illuminate\Support\Facades\Route;;
   $routeName    = Route::current();
   $pageName     = explode("/", $routeName->uri());
   $pageSegment  = $pageName[1];
   $pageFunction = ((count($pageName)>2)?$pageName[2]:'');
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact " dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
   <head>
      <?=$head?>
      <style type="text/css">
          #simpletable_filter{
            float: right;
          }
          .simpletable_length label {
            display: inline-flex;
            padding: 10px;
          }
          .dt-buttons button{
            padding: 2px 20px;
            background-color: #04163d;
            color: #FFF;
            border-radius: 50px;
            border:2px solid #04163d;
            transition: all .3s ease-in-out;
            box-shadow: 0 9px 20px -10px #a5a5a5;
          }
          .dt-buttons button:hover{
            background: transparent;
            color: #FFF;
            border:2px solid #04163d;
          }
          .dataTables_length label,
          .dataTables_filter label{
            display: inline-flex;
            align-items: center;
            margin-bottom: 10px;
          }
          .dataTables_length label select{
            margin: 0 10px;
          }
          .dataTables_filter label input{
            margin-left: 10px;
          }
          .pagination{
            justify-content: end;
          }
          .sidebar-nav .nav-content a:hover, .sidebar-nav .nav-content a.active{
            color: #dc3545
          }
          .passeye {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translate(0, -50%);
          }
      </style>
   </head>
   <body>
      <!-- Layout wrapper -->
      <div class="layout-wrapper layout-content-navbar">
         <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="background-color: <?=$generalSetting->sidebar_color?> !important;">
               <?=$sidebar?>
            </aside>
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
               <!-- Navbar -->
               <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar" style="background-color: <?=$generalSetting->header_color?> !important;">
                  <?=$header?>
               </nav>
               <!-- / Navbar -->
               <!-- Content wrapper -->
               <div class="content-wrapper">
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
                  <!-- Content -->
                  <?=$maincontent?>
                  <!-- / Content -->
                  <!-- Footer -->
                  <footer class="content-footer footer bg-footer-theme">
                     <?=$footer?>
                  </footer>
                  <!-- / Footer -->
                  <div class="content-backdrop fade"></div>
               </div>
               <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
         </div>
         <!-- Overlay -->
         <div class="layout-overlay layout-menu-toggle"></div>
      </div>
      <!-- / Layout wrapper -->
      <!-- Core JS -->
      <!-- build:js assets/vendor/js/core.js -->
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/libs/jquery/jquery.js"></script>
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/libs/popper/popper.js"></script>
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/js/bootstrap.js"></script>
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/js/menu.js"></script>
      <!-- endbuild -->
      <!-- Vendors JS -->
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/libs/apex-charts/apexcharts.js"></script>
      <!-- Main JS -->
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/js/main.js"></script>
      <!-- Page JS -->
      <script src="<?=env('ADMIN_ASSETS_URL')?>/assets/js/dashboards-analytics.js"></script>
      <!-- Place this tag in your head or just before your close body tag. -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script src="<?=env('ADMIN_ASSETS_URL')?>assets/js/pages/data-basic-custom.js"></script>

      <link href="https://cdn.datatables.net/v/dt/dt-2.0.3/datatables.min.css" rel="stylesheet">
      <script src="https://cdn.datatables.net/v/dt/dt-2.0.3/datatables.min.js"></script>
      <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
      <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
      <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
  
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
      <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.1.0/ckeditor5.css" />
      <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.1.0/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.1.0/"
            }
        }
      </script>
      <script type="module">
        import {
            ClassicEditor,
            Essentials,
            Bold,
            Italic,
            Strikethrough,
            Subscript,
            Superscript,
            CodeBlock,
            Font,
            Link,
            List,
            Paragraph,
            Image,
            ImageCaption,
            ImageResize,
            ImageStyle,
            ImageToolbar,
            LinkImage,
            PictureEditing,
            ImageUpload,
            CloudServices,
            CKBox,
            CKBoxImageEdit,
            SourceEditing,
            ImageInsert
        } from 'ckeditor5';

        for (let i = 0; i <= 15; i++) {
          ClassicEditor
            .create( document.querySelector( '#ckeditor' + i ), {
              plugins: [ Essentials, Bold, Italic, Strikethrough, Subscript, Superscript, CodeBlock, Font, Link, List, Paragraph, Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, LinkImage, PictureEditing, ImageUpload, CloudServices, CKBox, CKBoxImageEdit, SourceEditing, ImageInsert ],
              toolbar: {
                items: [
                  'undo', 'redo',
                  '|',
                  'heading',
                  '|',
                  'sourceEditing',
                  '|',
                  'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor', 'formatPainter',
                  '|',
                  'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',
                  '|',
                  'link', 'uploadImage', 'blockQuote', 'codeBlock',
                  '|',
                  'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent',
                  '|',
                  'ckbox', 'ckboxImageEdit', 'toggleImageCaption', 'imageTextAlternative', 'ckboxImageEdit',
                  '|',
                  'imageStyle:block',
                  'imageStyle:side',
                  '|',
                  'toggleImageCaption',
                  'imageTextAlternative',
                  '|',
                  'linkImage', 'insertImage', 'insertImageViaUrl'
                ]
              },
              menuBar: {
                isVisible: true
              }
            })
            .then( /* ... */ )
            .catch( /* ... */ );
        }
      </script>
   </body>
</html>
<!-- beautify ignore:end -->