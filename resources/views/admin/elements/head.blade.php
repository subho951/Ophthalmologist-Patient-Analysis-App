<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<title><?=$title?></title>
<meta name="description" content="<?=$generalSetting->meta_description?>" />
<meta name="keywords" content="<?=$generalSetting->meta_title?>">
<!-- Canonical SEO -->
<!-- <link rel="canonical" href="https://themeselection.com/item/sneat-dashboard-pro-bootstrap/"> -->
<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="<?=env('UPLOADS_URL')?><?=$generalSetting->site_favicon?>" />
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/fonts/boxicons.css" />
<!-- Core CSS -->
<link rel="stylesheet" href="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/css/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="<?=env('ADMIN_ASSETS_URL')?>/assets/css/demo.css" />
<!-- Vendors CSS -->
<link rel="stylesheet" href="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/libs/apex-charts/apex-charts.css" />
<!-- Page CSS -->
<!-- Helpers -->
<script src="<?=env('ADMIN_ASSETS_URL')?>/assets/vendor/js/helpers.js"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="<?=env('ADMIN_ASSETS_URL')?>/assets/js/config.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<style type="text/css">
	.toast-success {
	  background-color: #000;
	  color: #28a745 !important;
	}
	.toast-error {
	  background-color: #000;
	  color: #dc3545 !important;
	}
	.toast-warning {
	  background-color: #000;
	  color: #ffc107 !important;
	}
	.toast-info {
	  background-color: #000;
	  color: #007bff !important;
	}
    table.dataTable>tbody>tr>th, table.dataTable>tbody>tr>td {
        padding: 1px 5px !important;
        font-size: 12px !important;
    }
    /* Loader Styling */
    #loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #ccc;
        border-top: 5px solid #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<!-- Main jQuery -->
<script src="https://market.ecoex.market/inc/js/jquery-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script type="text/javascript">
    function toastAlert(type, message, redirectStatus = false, redirectUrl = ''){
        toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-left",
            "preventDuplicates": false,
            "showDuration": "3000",
            "hideDuration": "1000000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr[type](message);
        if(redirectStatus){        
            setTimeout(function(){ window.location = redirectUrl; }, 3000);
        }
    }
</script>