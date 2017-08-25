<?php
if (isset($this->session->userdata['logged_in'])) {
  $username = ($this->session->userdata['logged_in']['username']);
  $term_berjalan = ($this->session->userdata['term_berjalan']);
} else {
  header("location: http://ppf.fisip.ui.ac.id/backend/ppaa/ldapLogin/loginForm");
}
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PPAA Peminjaman Ruang</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/AdminLTE/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url();?>assets/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="<?=base_url();?>assets/AdminLTE/dist/css/skins/skin-blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="<?=base_url()?>ppaa/ruang" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>PP</b>AA</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
            <font style="color:rgb(255,217,97)">PPAA</font>&nbsp;FISIP&nbsp;
            <font style="color:yellow"></font>
            <img src="<?=base_url();?>assets/images/logo_UI-Horizontal_frameyelow.png" height="30%" width="30%" />
      </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less
            <li class="dropdown messages-menu">
            </li>-->
            <!-- Notifications: style can be found in dropdown.less
            <li class="dropdown notifications-menu">
            </li> -->
            <!-- Tasks: style can be found in dropdown.less
            <li class="dropdown tasks-menu">
            </li> -->
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- <img src="<?=base_url();?>assets/AdminLTE/dist/img/avatar2.png" class="user-image" alt="User Image"> -->
                    <?php
                    $photo = 'data:image/png;base64,'.$foto;
                    echo '<img src = '.$photo.' class="user-image" alt="User Image"/>';
                    ?>
                    <span class="hidden-xs"><?=$nama?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                    <li class="user-header">
                <?php
                $photo = 'data:image/png;base64,'.$foto;
                        echo '<img src = '.$photo.' class="img-image" alt="User Image" style="width:80px"/>';
                ?>
                        <p>
                            <?=$nama?>
                            <small>FISIP UI</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                        </div>
                        <div class="pull-right">
                            <a href="<?=base_url()?>ppaa/ldapLogin/logout" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
          <!-- Control Sidebar Toggle Button -->
                <li>
                    <!--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
                </li>
            </ul>
        </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <!-- search form (Optional) -->
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <?=$menu?>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <section class="content-header">
      <!-- 
      <h1>
        Page Header
        <small>Optional description</small>
      </h1>
      -->
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?=$term_berjalan?></a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" id="content">
      <link rel="stylesheet" href="<?=base_url()?>/assets/bootstrap-iso/bootstrap-iso.css">
      <script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_units.js" type="text/javascript" charset="utf-8"></script>
      <link rel="stylesheet" href="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/dhtmlxscheduler.css" type="text/css" title="no title" charset="utf-8">
      <!--<link rel="stylesheet" href="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/dhtmlxscheduler_glossy.css" type="text/css"  title="no title" charset="utf-8">-->
      <script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/sources/locale/locale_id.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_minical.js" type="text/javascript" charset="utf-8"></script>
      <!-- <script src="<?=base_url()?>/assets/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js"></script> untuk crud otomatis
      <script src="<?=base_url()?>/assets/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor_debug.js"></script>
      <script src="<?=base_url()?>/assets/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxscheduler_recurring.js"></script> -->
      <!-- Your Page Content Here -->
      <?=$content?>
      <script src="<?=base_url();?>assets/js/jquery-1.11.2.min.js"></script>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
       <font style="font-family:century gothic; font-size:12px">Fakultas Ilmu Sosial dan Ilmu Politik Universitas Indonesia</font>
    </div>
    <div>
      <font style="font-family:century gothic; font-size:12px">Pusat Pelayanan Administrasi Akademik</font>
    </div>    
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="<?=base_url();?>assets/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=base_url();?>assets/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url();?>assets/AdminLTE/dist/js/app.min.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>/assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>/assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?=base_url();?>assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?=base_url();?>assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.id.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<?=$script?>


</body>
</html>
