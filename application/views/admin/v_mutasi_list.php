<!doctype html>
<html>
    <head>
        <title>Daftar Mutasi Jaga</title>
    </head>

    <body>
        <section class="content">
            <div class="row">
            <!-- left column -->
                <div class="col-md-12">
                <!-- general form elements -->
                    <div class="box box-success">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                    <div class="box-body">
                    <div class="form-group">
                    <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-12 text-center">
                            <h4 align="center">Daftar Mutasi Jaga Satuan Pengamanan<br>PT PLN (Persero) UPDL Makassar</h4>
                    </div>
                    <div class="col-md-4 text-center">
                    </div>
                    <div class="col-md-4 text-center">
                       <div style="margin-top: 4px"  id="message">
                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                        </div>
                     </div>
                    <div class="col-md-4 text-center">
                    </div>
                    <div class="col-md-12 text-center">
                    <br>
                             
                    <!-- <?php echo anchor(site_url('c_dataumkm/Cetak_List'), 'Cetak Data', 'class="btn btn-danger btn-flat"'); ?>
                
                    <?php echo anchor(site_url('c_dataumkm/create'), 'Tambah Data', 'class="btn btn-success btn-flat "'); ?>
                         -->
                    </div>
                </div>
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                  <th width="40px" >No</th>
		          <th>Tanggal Jaga</th>
		          <th>Shift</th>
    		      <th>Petugas Serah</th>
                  <th>Petugas Terima</th>
                  <th>Status</th>
    		      <!--<th>Dibuat pada</th> -->
    		      <th>Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($data_mutasi as $data)
            {
                ?>
                <tr>
		    <td><?php echo ++$start ?></td>
		    <!-- <td><?php echo $data->id_mutasi_jaga ?></td> -->
		    <td><?php echo $data->tanggal_jaga ?></td>
            <td><?php echo $data->shift ?></td>
            <td><?php echo $data->petugas_serah ?></td>
            <td><?php echo $data->petugas_terima ?></td>
            <td><?php echo $data->approver_1_at ?></td>
            <!--<td><?php echo $data->dibuat_pada ?></td> -->
		    
		    <td style="text-align:center" width="200px">
            <div class="btn-group">
			<?php 
			echo anchor(site_url('c_mutasi_jaga/read/'.$data->id_mutasi_jaga),'Detail','class="btn btn-sm btn-info btn-flat"'); 
	
			// echo anchor(site_url('c_dataumkm/update/'.$c_dataumkm->id_umkm),'Update','class="btn btn-sm btn-success btn-flat"'); 
		
		/*	echo anchor(site_url('c_dataumkm/delete/'.$c_dataumkm->id_umkm),'Delete','class="btn btn-sm btn-danger btn-flat"  onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); */
			?>
            </div>
	        </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

    </body>
</html>