<?php
$this->load->View('include/header.php');

if ($set=="list") {
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data User ID
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> User ID</a></li>
        <li class="active">Data User ID</li>
      </ol>
    </section>

        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php echo "<br>"; echo $this->session->flashdata('pesan');?>
              <h1 class="box-title"></h1>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="t1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="text-align:center">No</th>
                  <th style="text-align:center">Face ID</th>
                  <th style="text-align:center">Nama</th>
                  <th style="text-align:center">Jabatan</th>
                  <th style="text-align:center">Alamat</th>
                  <th style="text-align:center">Telp</th>
                  <th style="text-align:center">#</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($face)){?>
                <tr>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                </tr>
                <?php } else{
                $no=0;
                foreach($face as $row){ 
                    $no++;?>
                <tr>
                  <td style="text-align:center"><?php echo $no;?></td>
                  <td style="text-align:center"><b class="text-success"><?php echo $row->face_id;?></b></td>
                  <td style="text-align:center"><?php echo $row->nama;?></td>
                  <td style="text-align:center"><?php echo $row->jabatan;?></td>
                  <td style="text-align:center"><?php echo $row->alamat;?></td>
                  <td style="text-align:center"><?php echo $row->telp;?></td>
                  <td style="text-align:center">
                  <?php
                    if ($row->del_face_id == 1) {
                      if ($row->del_face_id == 1) {
                        echo "<i class='text-danger'>Dihapus Setelah Train User</i> ";
                      }
                    }else{
                    ?>
                      <a href="<?=site_url()?>/admin/edit_face/<?=$row->id_face_table?>" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
                      <a href="<?=site_url()?>/admin/hapus_face/<?=$row->id_face_table?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda Yakin menghapus data ini?')"><i class="glyphicon glyphicon-trash"></i></a>
                  <?php } ?>
                  </td>
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
} else if ($set=="edit-face") {
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Data Face ID
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> Data Face ID</a></li>
        <li class="active">Edit Data Face ID</li>
      </ol>
    </section>

        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php echo $this->session->flashdata('pesan');?>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?=site_url();?>/admin/save_edit_face" method="post">              
              <div class="box-body">
                <div class="form-group">
                  <input type="hidden" name="id_face_table" value="<?php if(isset($id_face_table)){echo $id_face_table;}?>">
                  <!-- <label>ID Device</label>
                  <input type="number" name="id" class="form-control" placeholder="Enter id" required> -->
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control" placeholder="nama" value="<?php if(isset($nama)){echo $nama;}?>" required>
                </div>
                <div class="form-group">
                  <label>Jabatan</label>
                  <input type="text" name="jabatan" class="form-control" placeholder="jabatan" value="<?php if(isset($jabatan)){echo $jabatan;}?>" required>
                </div>
                <div class="form-group">
                  <label>Telp</label>
                  <input type="text" name="telp" class="form-control" placeholder="telp" value="<?php if(isset($telp)){echo $telp;}?>" required>
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" name="alamat" class="form-control" placeholder="alamat" value="<?php if(isset($alamat)){echo $alamat;}?>" required>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>              
            </form>
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
<!-- page script -->
<script>
  $(function () {
    $("#t1").DataTable();
  });
</script>

<script type="text/javascript">
    var ajax_call = function(){
      $.getJSON("<?=base_url();?>api/addrfid", function(result){
          //console.log(result);
          
          if (result.status == "1") {
            document.getElementById("rfid").value = result.rfid;
          }
      });
    };
    var interval = 1000; // where 1000 is 1 second

    setInterval(ajax_call, interval);
</script>

</body>
</html>