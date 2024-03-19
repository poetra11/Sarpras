

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

<!-- Default box -->
      <div class="box" style="border-top:none; box-shadow:0 1px 5px 0px rgba(0,0,0,0.1);">
        <div class="box-header with-border">
        <div class="box-body">
          <h1> Riwayat Peminjaman</h1><hr>

           <button type="button" class="btn btn-xs btn-primary btn-flat" data-toggle="modal" data-target="#addAjuan"><i class="fa fa-send" ></i> Kirim Stock</button>
           <button type="button" class="btn btn-xs btn-warning btn-flat" data-toggle="modal" data-target="#addRiwayat">Verifikasi Riwayat</button>
           <br><br>

          <form class="form-inline" id="form-delete" method="post" action="">
                <div class="table-responsive">
                  <table id="tabel1" class="table table-bordered table-hover" style="font-size: 9pt">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tangal Peminjaman</th>
                        <th>Pemohon</th>
                        <th>Nama Barang</th>
                        <th>OTY</th>
                        <th>Keterangan</th>
                        <th>Approve</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      
<?php 


        $req = mysqli_query($conn, "SELECT * FROM tb_peminjaman WHERE acc='1' OR acc='2' ORDER BY tgl_ajuan DESC");

        $i = 1;
        while($d=mysqli_fetch_assoc($req)){
          $date = $d['tgl_ajuan'];
          $tgl  = date('d M y', strtotime($date));
          $id_items = $d['id_items'];
        ?>
                      <tr>
                        <td>
                         <?php echo $i; ?>
                        </td>
                        <td><?php echo $tgl ?></td>
                        <td><?php echo $d['nm_pemohon']; ?></td>
                        <td><?php echo $d['nm_items']; ?></td>
                        <td><?php echo number_format($d['qty']); ?> <?php echo $d['sat_unit']; ?></td>
                        <td><i><?php echo $d['status']; ?></i></td>
                        <td>
                          <?php 
                          $acc = $d['total_acc'];
                            if($d['acc']==0){
                              echo" <i> Sedang ditinjau </i>";
                            }elseif($d['acc']==2){
                              echo"
                              <b style='color:green;'> Aprove</b>
                              ";
                            }else{
                              echo" <b style='color:red;'><i> _Rejek </i></b> ";
                            }

                          ?>                            
                          </td>
                          <td>
                            <?php 
                            
                                  if($d['acc']==1){
                                    echo "<I>REJECK</I>";
                                  }elseif ($d['aksi']==0) {
                                    echo "Sedang diproses";
                                  }elseif ($d['aksi']==1) {
                                    echo "Sedang diproses";
                                  }elseif ($d['aksi']==2){
                                    echo "Belum Masuk Stock ";
                                  }else{
                                    echo "Telah Masuk Stock";
                                  }
                                ?>

                        </td>
                      </tr>
                     
<?php 
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
                      <h4 class="modal-title">Kirim Stock Peminjaman</h4>
                  </div>
                  <div class="modal-body">
                    <form class="form-inline" method="post" action="">
            <button type="submit" class="btn btn-xs btn-flat btn-success" name="proses"><i class="fa fa-database"></i> Masukkan Stock</button> <br><br>

                <div class="table-responsive">
                  <table id="tabel1" class="table table-bordered table-hover" style="font-size: 9pt">
                    <thead>
                      <tr>
                        <th>Pilih</th>
                        <th>ID Items</th>
                        <th>Tgl. Pengajuan</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>QTY</th>
                        <th>Satuan</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                  <tbody>
<?php
if(isset($_POST['proses'])){

  $jmldata  = count($_POST['id_items']);
  $check    = $_POST['id_items'];

  for($cek=0; $cek < $jmldata; $cek++){
    $cek_data = mysqli_query($conn,"SELECT * FROM tb_peminjaman WHERE id_items='$check[$cek]' ");
    $r = mysqli_fetch_assoc($cek_data);
    $total = $r['total_acc'];

    $oke = mysqli_query($conn, "INSERT INTO tb_stock (id_stock,total_stock) VALUES(
                                                       '$check[$cek]',
                                                       '$total' 
                                                   )");
    if ($oke){
      $info = mysqli_query($conn, "UPDATE tb_peminjaman SET aksi='3' WHERE id_items='$check[$cek]' ");
    }else{
      echo "Maaf! Terjadi kesalahan 404";
    }
  }
}
?>

<?php 
$stk = mysqli_query($conn, "SELECT id_stock FROM tb_stock ");
$o = mysqli_fetch_assoc($stk);

$req = mysqli_query($conn, "SELECT * FROM tb_peminjaman WHERE acc='2' AND aksi != '3' AND aksi !='0' ORDER BY aksi DESC");
while($d=mysqli_fetch_assoc($req)){
  $date = $d['tgl_ajuan'];
  $tgl  = date('d M y', strtotime($date));
  $id_items = $d['id_items'];

?>
                      <tr>
                        <td>
                        <?php if($d['aksi']=='3' OR $d['aksi']=='0'){ ?>
                          
                          <input type='checkbox' value='<?php echo $id_items ?>' disabled='disabled' Title='Telah masuk Stock Barang'>

                        <?php }elseif($d['aksi']=='1'){ ?>
                          <input type='checkbox' value='<?php echo $id_items ?>' disabled='disabled' Title='<?php if($d['aksi']==0){ echo "Belum diproses"; }elseif ($d['aksi']==1) {echo "Sedang diproses"; } ?>' >
                        <?php }else{ ?>
                          <input class='check-item' type='checkbox' name='id_items[]' value='<?php echo $id_items ?>' >
                        <?php } ?>
                        </td>
                        <td><?php echo $d['id_items']; ?></td>
                        <td><i class="fa fa-clock-o"></i> <?php echo $tgl ?> </td>
                        <td><?php echo $d['nm_items']; ?></td>
                        <td><?php echo $d['kategori']; ?></td>
                        <td><?php echo $d['total_acc']; ?></td>
                        <td><?php echo $d['sat_unit']; ?></td>
                        <td><?php echo $d['status']; ?></td>
                        <td>
                            <?php 
                            
                                  if ($d['aksi']==1) {
                                    echo "Sedang diproses";
                                  }elseif ($d['aksi']==2){
                                    echo " <i class='fa fa-check-circle'></i> Sukses ";
                                  }else{
                                    echo "Telah Masuk Stock";
                                  }
                                ?>

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
        <!-- /.box-body -->
      </div>


                </div>
              </div>




<!-- Small modal -->
            <div class="modal fade" id="addRiwayat" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Verifikasi Riwayat Peminjaman</h4>
                  </div>
                  <div class="modal-body">
                    <form class="form-inline" method="post" action="">
<?php
if(isset($_POST['proses'])){
  $a   = $_POST['proses'];
  $upd = mysqli_query($conn,"UPDATE tb_peminjaman SET aksi='2' WHERE id_items='$a' "); 

}
?>
                <div class="table-responsive">
                  <table id="tabel1" class="table table-bordered table-hover" style="font-size: 9pt">
                    <thead>
                      <tr>
                        <th>ID Items</th>
                        <th>Pemohon</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Oty</th>
                        <th>Satuan</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
<?php

$req = mysqli_query($conn, "SELECT * FROM tb_peminjaman WHERE acc='2' AND aksi='1' OR aksi='2' ");
while($d=mysqli_fetch_assoc($req)){
?>
                      <tr>
                        <td><?php echo $d['id_items']; ?></td>
                        <td><?php echo $d['nm_pemohon']; ?></td>
                        <td><?php echo $d['nm_items']; ?></td>
                        <td><?php echo $d['kategori']; ?></td>
                        <td><?php echo $d['total_acc']; ?></td>
                        <td><?php echo $d['sat_unit']; ?></td>
                        <td><?php echo $d['status']; ?></td>
                        <td>
                            <?php 
                             
                                  if($d['aksi']==0){
                                    echo "Belum diproses";
                                  }elseif ($d['aksi']==1) {
                                    echo "Sedang diproses";
                                  }else{
                                    echo "<i>Menunggu Konfirmasi</i>";
                                  }
                                ?>

                        </td>
                        <td>
                            <?php if($d['aksi']==0){ echo "Belum diproses";
                                  }elseif ($d['aksi']==2) { ?>
                                  <button type="submit" class="btn btn-xs btn-flat btn-success" disabled="disabled" title="Menunggu Konfirmasi"><i class="fa fa-tags"></i> Verifikasi </button>
                                  <?php }else{ ?>
                                  <button type="submit" class="btn btn-xs btn-flat btn-success" value='<?php echo $d['id_items'] ?>' name="proses" onClick="javascript: return confirm('Yakin Ingin Memverifikasi Ini?')"><i class="fa fa-tags"></i> Verifikasi </button>
                            <?php  } ?>

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
        <!-- /.box-body -->
      </div>


                </div>
              </div>