<?php
$this->load->View('include/header.php');

if ($set=="log") {
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Presensi
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>index.php"><i class="fa fa-book"></i> Presensi</a></li>
        <!-- <li class="active">Lihat Histori Device</li> -->
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <form action="<?=base_url();?>index.php/admin/lastlog" method="post">
                <div class="col-md-2">
                </div>
                <div class="form-group col-md-6">
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="tanggal" class="form-control pull-right" id="reservation">
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="col-md-4">
                  <button type="submit" class="btn btn-danger">Ambil Data Presensi</button>
                </div>
              </form>
            </div>
            <div class="box-header">
              <?php echo "<br>"; echo $this->session->flashdata('pesan');?>
              <h1 class="box-title"><b>Presensi Hari ini</b> <b class="text-danger"><?php echo date("d M Y",time());?></b></h1>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="t1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="text-align:center">No</th>
                  <th style="text-align:center">Nama</th>
                  <th style="text-align:center">Jabatan</th>
                  <th style="text-align:center">Suhu</th>
                  <th style="text-align:center">Jam</th>
                  <th style="text-align:center">Tanggal</th>
                  <th style="text-align:center">Masker</th>
                  <th style="text-align:center">Presensi</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($log)){?>
                <tr>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                </tr>
                <?php } else{
                $no = 0;
                foreach($log as $row){ $no++;?>
                <tr>
                  <td style="text-align:center"><b class="text-success"><?php echo $no;?></b></td>
                  <td style="text-align:center"><?php echo $row->nama;?></td>
                  <td style="text-align:center"><?php echo $row->jabatan;?></td>
                  <td style="text-align:center"><?php echo $row->suhu;?>C</td>
                  <td style="text-align:center"><?php echo date("H:i:s",$row->log_masuk);?></td>
                  <td style="text-align:center"><?php echo date("d M Y",$row->log_masuk);?></td>
                  <td style="text-align:center"><?php echo $row->masker;?></td>
                  <td style="text-align:center"><?php echo $row->presensi;?></td>
                </tr>
                <?php }}?>
                
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

  </div>
<?php
} else if ($set=="last-log") {
  if (!isset($tanggal)) {
    $tanggal = "";
  }

  if (!isset($waktuabsensi)) {
    $waktuabsensi = "";
  }
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Presensi <?php echo $tanggal;?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>index.php"><i class="fa fa-book"></i> Presensi</a></li>
        <li class="active">Ambil Data Presensi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <div class="col-md-12">
                <div style="text-align:center;">
                  <a href="<?=base_url()?>index.php/admin/export2excel?tanggal=<?=$waktuabsensi;?>"><button class="btn btn-success">Download Presensi Excel</button></a>
                </div>
              </div>
            </div>
            <div class="box-header">
              <?php echo "<br>"; echo $this->session->flashdata('pesan');?>
              <h1 class="box-title"><b>Presensi </b> <b class="text-danger"><?php echo $tanggal;?></b></h1>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="t1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="text-align:center">No</th>
                  <th style="text-align:center">Nama</th>
                  <th style="text-align:center">Jabatan</th>
                  <th style="text-align:center">Suhu</th>
                  <th style="text-align:center">Jam</th>
                  <th style="text-align:center">Tanggal</th>
                  <th style="text-align:center">Masker</th>
                  <th style="text-align:center">Presensi</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($log)){?>
                <tr>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                </tr>
                <?php } else{
                $no = 0;
                foreach($log as $row){ $no++;?>
                <tr>
                  <td style="text-align:center"><b class="text-success"><?php echo $no;?></b></td>
                  <td style="text-align:center"><?php echo $row->nama;?></td>
                  <td style="text-align:center"><?php echo $row->jabatan;?></td>
                  <td style="text-align:center"><?php echo $row->suhu;?>C</td>
                  <td style="text-align:center"><?php echo date("H:i:s",$row->log_masuk);?></td>
                  <td style="text-align:center"><?php echo date("d M Y",$row->log_masuk);?></td>
                  <td style="text-align:center"><?php echo $row->masker;?></td>
                  <td style="text-align:center"><?php echo $row->presensi;?></td>
                </tr>
                <?php }}?>
                
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

  </div>
<?php
} 

$this->load->view('include/footer.php');
?>

</div>  <!-- penutup header -->

<!-- jQuery 3 -->
<script src="<?=base_url();?>components/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url();?>components/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url();?>components/dist/js/adminlte.min.js"></script>

<!-- DataTables -->
<script src="<?=base_url();?>components/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>components/plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- date-range-picker -->
<script src="<?=base_url();?>components/bower_components/moment/min/moment.min.js"></script>
<script src="<?=base_url();?>components/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- page script -->
<script>
  $(function () {
    $("#t1").DataTable();
    $('#t2').DataTable();
  });

  $(function () {
    //Date range picker
    $('#reservation').daterangepicker()

  })
</script>

</body>
</html>