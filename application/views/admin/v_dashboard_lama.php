<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>


 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <!-- <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <p>Anggota Satpam Aktif</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $jumlah_visitor_bulan_ini; ?></h3>
              <p>Tamu masuk bulan ini</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?= base_url('visitor'); ?>" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- ./col -->
       <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><?= $jumlah_pekerja_bulan_ini; ?></h3>
            <p>Pekerja Masuk Bulan Ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
          <a href="<?= base_url('pekerja'); ?>" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
        <!-- ./col -->
        <!-- <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> -->
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
          <!-- ===== VISITOR ===== -->
          <div class="col-md-6">
            <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">Statistik Visitor Hari Ini</h3>
              </div>
              <div class="box-body chart-responsive text-center">
                <div id="visitor-chart" style="height: 300px;"></div>

                <!-- Keterangan Warna -->
                <div style="margin-top: 10px;">
                  <span style="display:inline-block;width:20px;height:20px;background-color:#f39c12;border-radius:3px;margin-right:6px;"></span> Dalam Kantor
                  <span style="display:inline-block;width:20px;height:20px;background-color:#00a65a;border-radius:3px;margin-left:15px;margin-right:6px;"></span> Sudah Keluar
                </div>

                <!-- Total -->
                <div style="margin-top:10px;font-weight:bold;">
                  Total Visitor Hari Ini: <?= $jumlah_visitor_hari_ini; ?> orang
                </div>
              </div>
            </div>
          </div>

          <!-- ===== PEKERJA ===== -->
          <div class="col-md-6">
            <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">Statistik Pekerja Hari Ini</h3>
              </div>
              <div class="box-body chart-responsive text-center">
                <div id="pekerja-chart" style="height: 300px;"></div>

                <!-- Keterangan Warna -->
                <div style="margin-top: 10px;">
                  <span style="display:inline-block;width:20px;height:20px;background-color:#f39c12;border-radius:3px;margin-right:6px;"></span> Dalam Kantor
                  <span style="display:inline-block;width:20px;height:20px;background-color:#00a65a;border-radius:3px;margin-left:15px;margin-right:6px;"></span> Sudah Keluar
                </div>

                <!-- Total -->
                <div style="margin-top:10px;font-weight:bold;">
                  Total Pekerja Hari Ini: <?= $jumlah_pekerja_hari_ini; ?> orang
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- ====== SCRIPT AREA ====== -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

        <script>
          $(function () {
            // ==== VISITOR CHART ====
            new Morris.Donut({
              element: 'visitor-chart',
              resize: true,
              colors: ["#f39c12", "#00a65a"], // oranye, hijau
              data: [
                { label: "Dalam Kantor", value: <?= $jumlah_visitor_dalam_kantor; ?> },
                { label: "Sudah Keluar", value: <?= $jumlah_visitor_keluar_hari_ini; ?> }
              ],
              formatter: function (y) { return y + " orang" },
              hideHover: 'auto'
            });

            // ==== PEKERJA CHART ====
            new Morris.Donut({
              element: 'pekerja-chart',
              resize: true,
              colors: ["#f39c12", "#00a65a"], // oranye, hijau
              data: [
                { label: "Dalam Kantor", value: <?= $jumlah_pekerja_dalam_kantor; ?> },
                { label: "Sudah Keluar", value: <?= $jumlah_pekerja_hari_ini - $jumlah_pekerja_dalam_kantor; ?> }
              ],
              formatter: function (y) { return y + " orang" },
              hideHover: 'auto'
            });
          });
        </script>


<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
