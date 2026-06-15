<div class="row">

  <!-- Box 2 -->
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-check-square-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-number"><b>Ceklist Pekerjaan<b></span>
        <!-- <span class="">90<small>%</small></span> -->
        <br>
        <span class="info-box-number">
            <a href="<?= site_url('C_user/list_lokasi_user/'.$username) ?>" 
            class="btn btn-flat btn-block bg-green"
            style="font-size: 11pt; display: flex; align-items: center; justify-content: center; gap: 6px;">
            
            <span>Lihat detail</span><i class="fa fa-chevron-circle-right"></i>
            </a>
        </span>
      </div>
      
    </div>
  </div>

  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-orange"><i class="fa fa-bullhorn"></i></span>
      <div class="info-box-content">
        <span class="info-box-number"><b>Lapor Keluhan<b></span>
        <!-- <span class="">90<small>%</small></span> -->
        <br>
        <span class="info-box-number">
            <a href="<?= site_url('keluhan/C_keluhan/input_keluhan') ?>" 
            class="btn btn-flat btn-block bg-orange"
            style="font-size: 11pt; display: flex; align-items: center; justify-content: center; gap: 6px;">
            
            <span>Lihat detail</span><i class="fa fa-chevron-circle-right"></i>
            </a>
        </span>
      </div>
      
    </div>
  </div>

  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-orange"><i class="fa fa-bullhorn"></i></span>
      <div class="info-box-content">
        <span class="info-box-number"><b>Ceklist APAR<b></span>
        <!-- <span class="">90<small>%</small></span> -->
        <br>
        <span class="info-box-number">
            <a href="<?= site_url('C_apar') ?>" 
            class="btn btn-flat btn-block bg-red"
            style="font-size: 11pt; display: flex; align-items: center; justify-content: center; gap: 6px;">
            
            <span>Lihat detail</span><i class="fa fa-chevron-circle-right"></i>
            </a>
        </span>
      </div>
      
    </div>
  </div>

  <!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-purple"><i class="fa fa-exchange"></i></span>
      <div class="info-box-content">
        <span class="info-box-number"><b>Mutasi Jaga<b></span>
        <span class="">90<small>%</small></span>
        <span class="info-box-number">
            <a href="<?= site_url('C_mutasi_jaga') ?>" 
            class="btn btn-flat btn-block bg-purple"
            style="font-size: 11pt; display: flex; align-items: center; justify-content: center; gap: 6px;">
            
            <span>Detail Tamu</span><i class="fa fa-chevron-circle-right"></i>
            </a>
        </span>
      </div>
    </div>
  </div> -->


  <!-- Box 4 -->
  
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>


<script>
$(document).ready(function() {
    // Cek apakah ada flashdata bernama 'swal_success'
    var pesan = "<?php echo $this->session->flashdata('swal_success'); ?>";

    if (pesan) {
        Swal.fire({
            title: 'Berhasil!',
            text: pesan,
            icon: 'success',
            showConfirmButton: false,
            timer: 2500, // Akan hilang sendiri dalam 2.5 detik
            showClass: {
                popup: 'animate__animated animate__bounceIn'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    }
});
</script>