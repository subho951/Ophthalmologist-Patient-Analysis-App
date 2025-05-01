<?php
use Illuminate\Support\Facades\Route;;
$routeName    = Route::current();
$pageName     = explode("/", $routeName->uri());
$pageSegment  = $pageName[1];
$pageFunction = ((count($pageName)>2)?$pageName[2]:'');

if(!empty($parameters)){
  if (array_key_exists("id1",$parameters)){
    $pId1 = Helper::decoded($parameters['id1']);
  } else {
    $pId1 = Helper::decoded($parameters['id']);
  }
  if(count($parameters) > 1){
    $pId2 = Helper::decoded($parameters['id2']);
  }
}
$user_type = session('type');
?>
<style type="text/css">
   .menu-sub .menu-item .menu-link{
      font-size: 13px;
   }
</style>
<div class="app-brand demo ">
   <a href="<?=url('admin/dashboard')?>" class="app-brand-link">
      <!-- <span class="app-brand-logo demo">
         <img src="<?=env('UPLOADS_URL')?><?=$generalSetting->site_logo?>">
      </span> -->
      <span class="app-brand-text demo menu-text fw-bold ms-2" style="text-transform: uppercase;font-size: 23px;"><?=$generalSetting->site_name?></span>
   </a>
   <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
   <i class="bx bx-chevron-left bx-sm align-middle"></i>
   </a>
</div>
<div class="menu-inner-shadow"></div>
<ul class="menu-inner py-1">
   <!-- Dashboards -->
   <li class="menu-item <?=(($pageSegment == 'dashboard')?'active':'')?>">
      <a href="<?=url('admin/dashboard')?>" class="menu-link">
         <i class="menu-icon tf-icons fa fa-home"></i>
         <div data-i18n="Dashboard">Dashboard</div>
      </a>
   </li>
   <!-- Access & Permission -->
   <!-- <li class="menu-item <?=(($pageSegment == 'modules' || $pageSegment == 'roles' || $pageSegment == 'sub-users' || $pageSegment == 'sale-operators')?'open':'')?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
         <i class="menu-icon tf-icons fa fa-lock"></i>
         <div data-i18n="Access & Permission">Access & Permission</div>
      </a>
      <ul class="menu-sub">
         <li class="menu-item <?=(($pageSegment == 'modules')?'active':'')?>">
            <a href="<?=url('admin/modules/list')?>" class="menu-link">
               <div data-i18n="Modules">Modules</div>
            </a>
         </li>
         <li class="menu-item <?=(($pageSegment == 'roles')?'active':'')?>">
            <a href="<?=url('admin/roles/list')?>" class="menu-link">
               <div data-i18n="Roles">Roles</div>
            </a>
         </li>
         <li class="menu-item <?=(($pageSegment == 'sub-users')?'active':'')?>">
            <a href="<?=url('admin/sub-users/list')?>" class="menu-link">
               <div data-i18n="Sub Users">Sub Users</div>
            </a>
         </li>
         <li class="menu-item <?=(($pageSegment == 'sale-operators')?'active':'')?>">
            <a href="<?=url('admin/sale-operators/list')?>" class="menu-link">
               <div data-i18n="Sale Operators">Sale Operators</div>
            </a>
         </li>
      </ul>
   </li> -->
   <!-- Masters -->
   <li class="menu-item <?=(($pageSegment == 'comorbidities' || $pageSegment == 'test-tabs' || $pageSegment == 'test-parameters')?'open':'')?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
         <i class="menu-icon tf-icons fa fa-database"></i>
         <div data-i18n="Masters">Masters</div>
      </a>
      <ul class="menu-sub">
         <li class="menu-item <?=(($pageSegment == 'comorbidities')?'active':'')?>">
            <a href="<?=url('admin/comorbidities/list')?>" class="menu-link">
               <div data-i18n="Co-morbidities">Co-morbidities</div>
            </a>
         </li>
         <li class="menu-item <?=(($pageSegment == 'test-tabs')?'active':'')?>">
            <a href="<?=url('admin/test-tabs/list')?>" class="menu-link">
               <div data-i18n="Test Tabs">Test Tabs</div>
            </a>
         </li>
         <li class="menu-item <?=(($pageSegment == 'test-parameters')?'active':'')?>">
            <a href="<?=url('admin/test-parameters/list')?>" class="menu-link">
               <div data-i18n="Test Parameters">Test Parameters</div>
            </a>
         </li>
      </ul>
   </li>
   <!-- Doctors -->
   <li class="menu-item <?=(($pageSegment == 'doctors')?'active':'')?>">
      <a href="<?=url('admin/doctors/list')?>" class="menu-link">
         <i class="menu-icon fas fa-user-md"></i>
         <div data-i18n="Doctors">Doctors</div>
      </a>
   </li>
   <!-- Patients -->
   <li class="menu-item <?=(($pageSegment == 'patients')?'active':'')?>">
      <a href="<?=url('admin/patients/list')?>" class="menu-link">
         <i class="menu-icon tf-icons fa fa-users"></i>
         <div data-i18n="Patients">Patients</div>
      </a>
   </li>
   <!-- Tests -->
   <li class="menu-item <?=(($pageSegment == 'tests')?'active':'')?>">
      <a href="<?=url('admin/tests/list')?>" class="menu-link">
         <i class="menu-icon fa-solid fa-eye"></i>
         <div data-i18n="Tests">Tests</div>
      </a>
   </li>
   <!-- Reports -->
   <li class="menu-item <?=(($pageSegment == 'report')?'open':'')?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
         <i class="menu-icon tf-icons fa fa-file"></i>
         <div data-i18n="Reports">Reports</div>
      </a>
      <ul class="menu-sub">
         <li class="menu-item <?=(($pageFunction == 'test-report')?'active':'')?>">
            <a href="<?=url('admin/report/test-report')?>" class="menu-link">
               <div data-i18n="Test Reports">Test Reports</div>
            </a>
         </li>
      </ul>
   </li>
   <!-- Login Logs -->
   <li class="menu-item <?=(($pageSegment == 'login-logs')?'active':'')?>">
      <a href="<?=url('admin/login-logs')?>" class="menu-link">
         <i class="menu-icon tf-icons fa fa-sign-in"></i>
         <div data-i18n="Login Logs">Login Logs</div>
      </a>
   </li>
   <!-- Email Logs -->
   <li class="menu-item <?=(($pageSegment == 'email-logs')?'active':'')?>">
      <a href="<?=url('admin/email-logs')?>" class="menu-link">
         <i class="menu-icon tf-icons fa fa-envelope"></i>
         <div data-i18n="Email Logs">Email Logs</div>
      </a>
   </li>
   <!-- Settings -->
   <li class="menu-item <?=(($pageSegment == 'settings')?'active':'')?>">
      <a href="<?=url('admin/settings')?>" class="menu-link">
         <i class="menu-icon fa-solid fa-gear"></i>
         <div data-i18n="Settings">Settings</div>
      </a>
   </li>
   <!-- Signout -->
   <li class="menu-item <?=(($pageSegment == 'logout')?'active':'')?>">
      <a href="<?=url('admin/logout')?>" class="menu-link">
         <i class="menu-icon fas fa-sign-out"></i>
         <div data-i18n="Sign Out">Sign Out</div>
      </a>
   </li>
</ul>