        <!-- <?php 
        // $data_session=$this->session->userdata('username');
        // if (empty($data_session)){
        // redirect(site_url('Admin'));
        // }
        ?> -->

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Dinkop Surakarta</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Bootstrap 3.3.6 -->  
  <!-- <?php
      echo link_tag('bootstrap/css/bootstrap.min.css');
  ?> -->

 <link rel="stylesheet" href="<?php echo base_url('bootstrap/css/bootstrap.min.css') ?>"/>

  <!-- Font Awesome -->
  <?php
      echo link_tag('dist/font_awesome/css/font-awesome.min.css');
  ?>
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">-->
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- Theme style -->
  <!-- <?php
      echo link_tag('dist/css/AdminLTE.min.css');
  ?> -->

  <link rel="stylesheet" href="<?php echo base_url('dist/css/AdminLTE.min.css') ?>"/>
  
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <?php
      echo link_tag('dist/css/skins/skin-blue.min.css');
  ?>

    <link rel="stylesheet" href="<?php echo base_url('dist/css/skins/skin-blue.min.css') ?>"/>
  
  <?php
      echo link_tag('plugins/iCheck/flat/blue.css');
  ?>
  
  <?php
      echo link_tag('dist/css/skins/_all-skins.min.css');
  ?>
  
  <!-- bootstrap wysihtml5 - text editor -->
  <?php
      echo link_tag('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');
  ?>
  	
	<!-- data table -->

  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
  <link rel="stylesheet" href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css') ?>"/>

	<link rel="stylesheet" href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css') ?>"/>

  <link rel="stylesheet" href="<?= base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css'); ?>">
	
	<!-- webcam -->
	<script type="text/javascript" src="<?php echo base_url('dist/js/webcam.js') ?>"></script>
	
	<!-- Presensi -->
	<script type="text/javascript" src="<?php echo base_url('dist/js/presensi.js') ?>"></script>
	
	<script src=<?php echo base_url('plugins/jQuery/jquery-2.2.3.min.js'); ?>></script>
  

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">
        <!-- Logo -->
        <a href="<?=base_url('#');?>" class="logo"><span class="logo-mini"><b>UMKM</b></span><span class="logo-lg"><b>Admin Dinkop</b></span></a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- Notifications: style can be found in dropdown.less -->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">Admin</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?=base_url('assets/dist/img/pemkot.jpg');?>" class="img-circle" alt="User Image" />
                    <p>
                      Dinas Koperasi & UMKM Kota Surakarta
                      <small></small>
                    </p>
                  </li>
                  <!-- Menu Body 
                  <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li>
                   Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                    <!-- <?php 
                      echo anchor(site_url('Admin/logout'),'Logout','class="btn btn-sm btn-success btn-flat"'); 
                    ?> -->
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" >

      <!-- Sidebar user panel (optional) -->
      

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <!-- Optionally, you can add icons to the links -->
		<?php echo $_sidebar; ?>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <?php //echo $_section; ?>


    <!-- Main content -->
    <section class="content">

     
                <?php echo $_content; ?>
            
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
        <div class="pull-right hidden-xs">
          Halaman ini dimuat dalam {elapsed_time} detik, Penggunaan memory {memory_usage}
        </div>
        <strong>Copyright &copy; 2016 <a href="http://d3ti.mipa.uns.ac.id/" target="_blank">D3 Teknik Informatika UNS</a>.</strong> All rights reserved.
      </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->

<!-- Bootstrap 3.3.6 -->
<script src=<?php echo base_url('bootstrap/js/bootstrap.min.js'); ?>></script>

<!-- AdminLTE App -->
<script src=<?php echo base_url('dist/js/app.min.js'); ?>></script>
<!-- <script src="dist/js/app.min.js"></script>-->

<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>

<!-- iCheck -->
<script src="<?php echo base_url('plugins/iCheck/icheck.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<!-- <script type="text/javascript">
   $(document).ready(function () {
        //Datatable
		$("#mytable").dataTable();
		//Event Datatable
		$("#mytable").on( 'draw.dt', function () {
			//Enable iCheck plugin for checkboxes
			//iCheck for checkbox and radio inputs
			$('.mailbox-messages input[type="checkbox"]').iCheck({
			  checkboxClass: 'icheckbox_flat-blue',
			  radioClass: 'iradio_flat-blue'
			});
		});
		
		
		//Enable iCheck plugin for checkboxes
		//iCheck for checkbox and radio inputs
		$('.mailbox-messages input[type="checkbox"]').iCheck({
		  checkboxClass: 'icheckbox_flat-blue',
		  radioClass: 'iradio_flat-blue'
		});
		
		//Enable check and uncheck all functionality
		$(".checkbox-toggle").click(function () {
		  var clicks = $(this).data('clicks');
		  if (clicks) {
			//Uncheck all checkboxes
			$(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
			$(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
		  } else {
			//Check all checkboxes
			$(".mailbox-messages input[type='checkbox']").iCheck("check");
			$(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
		  }
		  $(this).data("clicks", !clicks);
		});
		
		//Add text editor
		$("#compose-textarea").wysihtml5();
		
		//set_url untuk dropdown bulan
		var url="<?php echo site_url('absensi/get_bulan'); ?>";
		set_url_bulan(url);
		
	   });



function formatCurrency(num) {
num = num.toString().replace(/\$|\,/g,'');
if(isNaN(num))
num = "0";
sign = (num == (num = Math.abs(num)));
num = Math.floor(num*100+0.50000000001);
cents = num%100;
num = Math.floor(num/100).toString();
if(cents<10)
cents = "0" + cents;
for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
num = num.substring(0,num.length-(4*i+3))+'.'+
num.substring(num.length-(4*i+3));
return (((sign)?'':'-') + ' Rp ' + num + ',' + cents);
}
</script> -->
</body>
</html>
