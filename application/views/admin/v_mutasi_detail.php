<section class="content-header">

</section>

    <div class="col-md-12">
        <div class="nav-tabs-custom">
          <div class="tab-content">
                <body>
                  <h4 align="center"> Catatan Mutasi Jaga Satuan Pengamanan <br>PT PLN (Persero) UPDL Makassar </h4>                
                </body>
            </div>
          </div>
      </div>

  <!-- Main content -->
<section class="content" style="font-size:11pt">
  <div class="row">

    <div class="col-md-12">
      <div class="box box-success">
                  <table class="table" border="0">
                    <tr><td width="50"></td><td width="250">Unit</td><td><?php echo ": ".$nama_unit; ?></td>
              	    <tr><td width="50"></td><td width="250">Tanggal jaga</td><td><?php echo ": ".$tanggal_jaga; ?></td>
              	    <tr><td><td>Shift</td><td><?php echo ": ".$shift; ?></td></tr>
              	    <tr><td></td><td>Petugas serah</td><td><?php echo ": ".$petugas_serah; ?></td></tr>
                    <tr><td></td><td>Petugas terima</td><td><?php echo ": ".$petugas_terima; ?></td></tr>
              	    <tr><td></td><td>Catatan mutasi</td><td><?php echo ": ".$catatan_mutasi; ?></td></tr>
                    <tr><td></td><td>Peralatan Keamanan</td><td> 
                      <table class="table table-bordered table-striped" id="mytable">
                        <thead>
                            <tr>
                              <th width="4px" >No</th>
                              <th>Peralatan</th>
                              <th>Jumlah</th>
                              <th>Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                          $start = 0;
                          foreach ($mutasi_peralatan as $peralatan)
                          {
                          ?>
                          <tr>
                            <td><?php echo ++$start ?></td>
                            <td><?php echo $peralatan->nama_peralatan ?></td><td><?php echo $peralatan->jumlah ?></td><td><?php echo $peralatan->kondisi ?></td>
                          </tr>

                          <?php
                          }
                          ?>
                        </tbody>
                      </table>  
                      <tr><td></td><td>Dibuat pada</td><td><?php echo ": ".$dibuat_pada; ?></td></tr>
                      <tr><td></td><td>Diserahkan oleh</td><td><?php echo ": ".$diserahkan_oleh.", tanggal : ".$dibuat_pada; ?></td></tr>
                      <tr><td></td><td>Diterima oleh</td><td><?php echo ": ".$diterima_oleh.", tanggal : ".$dibuat_pada; ?></td></tr>
                      <tr><td></td><td>Disetujui oleh</td><td><?php echo ": ".$approver_1.", status : ".$approval_1_status; ?></td></tr>
                      <tr><td></td><td>Disetujui Oleh</td><td><?php echo ": ".$approver_2.", status : ".$approval_2_status; ?></td></tr>
                      </td></tr>
                      
              	  </table>   
      </div>
      <?php echo anchor(site_url('c_mutasi_jaga'), 'Kembali', 'class="btn btn-warning btn-flat"'); ?>
      <?php echo anchor(site_url(''), 'Download PDF', 'class="btn btn-success btn-flat disabled"'); ?>
    </div>
        
    
    <!-- <p align="center"><input type="button" class="btn btn-warning btn-flat" value="Kembali" onclick="history.back(-1)" /></p> -->