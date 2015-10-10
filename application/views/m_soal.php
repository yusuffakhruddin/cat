<?php 
$uri4 = $this->uri->segment(4);
?>

<div class="row col-md-12">
  <div class="panel panel-info">
    <div class="panel-heading">Data Soal
      <div class="tombol-kanan">
        <a class="btn btn-success btn-sm" onclick="return m_soal_e(0);"><i class="glyphicon glyphicon-plus" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tambah Data</a>
        <a href='<?php echo base_url(); ?>adm/m_soal/cetak/<?php echo $uri4; ?>' class='btn btn-info btn-sm' target='_blank'><i class='glyphicon glyphicon-print'></i> Cetak</a>
      </div>
    </div>
    <div class="panel-body">
        
        <!-- accordion -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        
        <?php 
        echo form_dropdown("pilih_mapel", $p_mapel, $uri4, "id='pilih_mapel' class='form-control col-md-12'")."<br><br>";

        if (!empty($data)) {
          $no = 1;
          foreach ($data as $d) {
        ?>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $no; ?>" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo $no." : ".substr($d->soal, 0, 100); ?>
              </a>
              
              <div class="btn-group tombol-kanan">
                <a class="btn btn-default btn-xs">Pembuat: <?php echo $d->nama_guru; ?></a>
                <a class="btn btn-info btn-xs" onclick="return m_soal_e('<?php echo $d->id; ?>');"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
                <a class="btn btn-warning btn-xs" onclick="return m_soal_h('<?php echo $d->id; ?>');"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
              </div>
            </div>
            <div id="collapse<?php echo $no; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

            <?php 
            if ($d->gambar != "") {
            ?>
            <img src="<?php echo base_url(); ?>upload/gambar_soal/<?php echo $d->gambar; ?>" class="thumbnail" style="width: 300px; height: 280px; display: inline; float: left">
            <a href="<?php echo base_url(); ?>adm/m_soal/hapus_gambar/<?php echo $this->uri->segment(4); ?>/<?php echo $d->id; ?>" style="display: inline; margin-left: 20px" onclick="return confirm('Anda yakin..?');">Hapus Gambar</a>
            <table class="table table-bordered"><tbody>
              <?php 
              $arra = array("a","b","c","d","e");
              for ($i=0; $i<sizeof($arra);$i++) {
                $opsi = "opsi_".$arra[$i];
                
                if ($d->jawaban == strtoupper($arra[$i])) {
                  echo "<tr style='background: #dff0d8'><td width='2%'>".$arra[$i]."</td><td width='98%'>".$d->$opsi."</td></tr>";
                } else {
                  echo "<tr><td width='2%'>".$arra[$i]."</td><td width='98%'>".$d->$opsi."</td></tr>";
                }
              }
              ?>
              </tbody>
            </table>
            <?php } else { ?>
            <table class="table table-bordered"><tbody>
              <?php 
              $arra = array("a","b","c","d","e");
              for ($i=0; $i<sizeof($arra);$i++) {
                $opsi = "opsi_".$arra[$i];
                
                if ($d->jawaban == strtoupper($arra[$i])) {
                  echo "<tr style='background: #dff0d8'><td width='2%'>".$arra[$i]."</td><td width='98%'>".$d->$opsi."</td></tr>";
                } else {
                  echo "<tr><td width='2%'>".$arra[$i]."</td><td width='98%'>".$d->$opsi."</td></tr>";
                }
              }
              ?>
              </tbody>
            </table>
            <?php } ?>
              </div>
            </div>
          </div>
          
         <?php 
          $no++;
          }
         } else {
            echo '<div class="alert alert-danger">Belum ada soal untuk mata pelajaran tersebut. Silakan pilih mata pelajaran..</div>';
         }
         ?>
      </div>
    </div>
  </div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="m_soal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Soal</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="" name="f_soal" id="f_soal" onsubmit="return m_soal_s();">
        <input type="hidden" name="id" id="id" value="0">
          <div id="konfirmasi"></div>
          <table class="table table-form">
            <tr><td class="" colspan="2" style="width: 20%">Mapel</td>
            <td style="width: 80%">
            <?php echo form_dropdown('id_mapel', $p_mapel, '', 'class="form-control" id="id_mapel" required'); ?>
            </td></tr>
            <tr><td class="" colspan="2">Guru</td>
            <td>
            <?php echo form_dropdown('id_guru', $p_guru, '', 'class="form-control" id="id_guru" required'); ?>
            </td></tr>
            <tr><td class="" colspan="2" style="width: 20%">Gambar Soal</td><td style="width: 80%">
            <input type="file" name="gambar_soal" id="gambar_soal" class="form-control"></td></tr>
            <tr><td class="" colspan="2" style="width: 20%">Bobot</td><td style="width: 80%">
            <?php echo form_input('bobot', '1', 'class="form-control" id="bobot" required'); ?>
            </td></tr>
            <tr><td class="" colspan="2" style="width: 20%">Soal</td><td style="width: 80%"><textarea autofocus class="form-control" style="height: 70px" name="soal" id="soal" required></textarea></td></tr>
            <tr><td style="width: 4%" class="ctr">A</td><td style="width: 96%" colspan="2"><input type="text" class="form-control" name="opsi_a" id="opsi_a" required></td></tr>
            <tr><td class="ctr">B</td><td colspan="2"><input type="text" class="form-control" name="opsi_b" id="opsi_b" required></td></tr>
            <tr><td class="ctr">C</td><td colspan="2"><input type="text" class="form-control" name="opsi_c" id="opsi_c" required></td></tr>
            <tr><td class="ctr">D</td><td colspan="2"><input type="text" class="form-control" name="opsi_d" id="opsi_d" required></td></tr>
            <tr><td class="ctr">E</td><td colspan="2"><input type="text" class="form-control" name="opsi_e" id="opsi_e" required></td></tr>
            <tr><td class="" colspan="2" style="width: 20%">Jawaban</td><td style="width: 80%">
              <select class="form-control" name="jawaban" id="jawaban" required>
              <option value="">-Jawaban-</option>
              <option value="A"> A</option>
              <option value="B"> B</option>
              <option value="C"> C</option>
              <option value="D"> D</option>
              <option value="E"> E</option>
              </select>
            </td></tr>
          </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Simpan</button>
        <button class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
        </form>
    </div>
  </div>
</div>

<script type="text/javascript">
<?php 
$xid_guru = "";
if ($sess_level == "guru" && $sess_konid != "") {
  $xid_guru = $sess_konid;
} 
?>
var id_guru_ = "<?php echo $xid_guru; ?>";
var id_mapel_ = "<?php echo $this->uri->segment(4); ?>";
</script>