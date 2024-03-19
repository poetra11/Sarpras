<?php
if ($_SESSION['level_user'] != 3) {
  echo"<script>alert('Upss!!! Ngga boleh jail ya :) ')</script>";
  echo"<script>location='./'</script>";
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

<!-- Default box -->
      <div class="box" style="border-top:none; box-shadow:0 1px 5px 0px rgba(0,0,0,0.1);">
        <div class="box-header with-border">
        <div class="box-body">
          <h1>Persetujuan</h1><hr>

          <button type="button" class="btn btn-xs btn-primary btn-flat" data-toggle="modal" data-target="#addAjuan"><i class="fa fa-eye" ></i> Riwayat Peminjaman</button><br><br>

          <form class="form-inline" method="POST" action="">
<?php
if(isset($_POST['rejek'])){
  $id   = $_POST['id'];


  $update = mysqli_query($conn,"UPDATE tb_peminjaman SET acc='1' WHERE id_items='$id' ");
  echo("<meta http-equiv='refresh' content='0'>"); //Refresh by HTTP 'meta'
  if($update){
    echo"
    
    <div class='alert alert-success' style='padding:6px; font-size: 9pt'>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
      </button>
      <b>Data BERHASIL Rejeck</b>
    </div>

    "; 
  }else{
    echo"
    <div class='alert alert-warning' style='padding:6px; font-size: 9pt'>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
      </button>
      <b>MAAFA TERJADI KESALAHAN </b>
    </div>
    "; 
  }
}

if(isset($_POST['aprov'])){
  $id   = $_POST['id'];
  $qty  = $_POST['qty'];

  $update = mysqli_query($conn,"UPDATE tb_peminjaman SET acc='2',total_acc='$qty' WHERE id_items='$id' ");

  //echo("<meta http-equiv='refresh' content='0'>"); //Refresh by HTTP 'meta'
  if($update){
    $sts = 0;
    $add = mysqli_query($conn,"INSERT INTO tb_keranjang VALUE( '','$id','$sts' )");

    echo"
    <div class='alert alert-success' style='padding:6px; font-size: 9pt'>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
      </button>
      <b>Data BERHASIL Approval </b>
    </div>

    "; 
  }else{
    echo"
    <div class='alert alert-success' style='padding:6px; font-size: 9pt'>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
      </button>
     <b> MAAF TERJADI KESALAHAN </b>
    </div>
    "; 
  }
}

?>

                <div class="table-responsive">
                  <table id="tabel1" class="table table-bordered table-hover" style="font-size: 9pt">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Pemohon</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>OTY</th>
                        <th>Satuan</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
<?php 
$req = mysqli_query($conn, "SELECT * FROM tb_peminjaman ORDER BY tgl_ajuan ASC");
while($d=mysqli_fetch_assoc($req)){
  $date = $d['tgl_ajuan'];
  $tgl  = date('d M y', strtotime($date));

  $i = 1;

if($d['acc']==3){
?>
                      <tr>
                        <input type="hidden" name="id" value="<?php echo $d['id_items']; ?>">
                        <td><?php echo $i ?></td>
                        <td><?php echo $d['nm_pemohon']; ?> <br><font style='font-size: 8pt'><i class="fa fa-clock-o"></i> <?php echo $tgl ?></font> </td>
                        <td><?php echo $d['nm_items']; ?></td>
                        <td><?php echo $d['kategori']; ?></td>
                        <td>
                          <select class="form-control" type="text" name="qty">
                            <?php 
                              $a = $d['qty'];
                              for ($u=1; $u <= $a; $u++) { 
                            ?>
                                <option value="<?php echo $u ?>" <?php if($a) { echo "selected='selected'";} ?> >
                                  <?php echo $u ?>
                                </option>
                                
                            <?php } ?>
                            
                          </select>
                        </td>
                        <td><?php echo $d['sat_unit']; ?></td>
                        <td><?php echo $d['status']; ?></td>
                        <td>
                          <button type="submit" class="btn btn-xs btn-flat btn-danger" name="rejek"><i class="fa fa-close"></i> REJECT</button>

                          <button type="submit" class="btn btn-xs btn-flat btn-success" name="aprov"><i class="fa fa-check"></i> APPROVE</button>
                        </td>
                      </tr>
<?php 
}
$i++; 
 

}
?>
                    </tbody>
                </table>
              </div>
          </form>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

<!-- Small modal -->
            <div class="modal fade" id="addAjuan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Kirim Riwayat Peminjaman</h4>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="">
                      <?php
if(isset($_POST['proses'])){
  $ids   = $_POST['proses'];
  $upd = mysqli_query($conn,"UPDATE tb_peminjaman SET aksi='1' WHERE id_items='$ids' ");
}
?>
                      <div class="table-responsive">
                  <table id="tabel1" class="table table-bordered table-hover" style="font-size: 9pt">
                    <thead>
                      <tr>
                        <th>ID Items</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Oty</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
<?php 
$req = mysqli_query($conn, "SELECT * FROM tb_peminjaman WHERE acc='2' AND aksi='0' ORDER BY status ASC");
while($d=mysqli_fetch_assoc($req)){
  // $date = $d['tgl_ajuan'];
  // $tgl  = date('d M y', strtotime($date));

?>
                      <tr>
                        <td><?php echo $d['id_items']; ?></td>
                        <td><?php echo $d['nm_items']; ?></td>
                        <td><?php echo $d['kategori']; ?></td>
                        <td><?php echo $d['total_acc']; ?> <?php echo $d['sat_unit']; ?></td>
                        <td><?php echo $d['status']; ?></td>
                        <td>
                            <?php 
                            
                                  if($d['aksi']==0){
                                    echo "Belum diproses";
                                  }elseif ($d['aksi']==1) {
                                    echo "Sedang diproses";
                                  }else{
                                    echo "Sukses";
                                  }
                                ?>
                        </td>
                        <td>
                            <?php  if($d['aksi']==0){ ?>
                                <button type="submit" class="btn btn-xs btn-flat btn-info" value='<?php echo $d['id_items'] ?>' name="proses" onClick="javascript: return confirm('Yakin Ingin Mengirim Riwat Sekarang?')"><i class="fa fa-send"></i></button>
                              <?php }elseif ($d['aksi']==1) { ?>
                                      Sedang diproses
                              <?php }else{ ?>
                                      Sukses
                                 <?php } ?>
                        </td>
                      </tr>
<?php

}
?>
                    </tbody>
                </table>
              </div>
          </form>
        </div>
        <!-- /.box-body -->
      </div>


                </div>
              </div>
