<?php 
$uri4 = $this->uri->segment(4);
?>

<div class="row col-md-12">
  <div class="panel panel-info">
    <div class="panel-heading">Daftar Hasil Tes
     <div class="tombol-kanan">
        <a href='<?php echo base_url(); ?>adm/hasil_ujian_cetak/<?php echo $uri4; ?>' class='btn btn-info btn-sm' target='_blank'><i class='glyphicon glyphicon-print'></i> Cetak</a>
      </div>
    </div>
    <div class="panel-body">

      <div class="col-lg-12 alert alert-warning" style="margin-bottom: 20px">
        <div class="col-md-6">
            <table class="table table-bordered" style="margin-bottom: 0px">
              <tr><td>Mata Kuliah</td><td><?php echo $detil_tes->namaMapel; ?></td></tr>
              <tr><td>Nama Guru</td><td><?php echo $detil_tes->nama_guru; ?></td></tr>
              <tr><td width="30%">Nama Ujian</td><td width="70%"><?php echo $detil_tes->nama_ujian; ?></td></tr>
              <tr><td>Waktu</td><td><?php echo $detil_tes->waktu; ?> menit</td></tr>
            </table>
        </div>
        <!--<div class="col-md-2"></div>-->
        <div class="col-md-6">
            <table class="table table-bordered" style="margin-bottom: 0px">
              <tr><td width="30%">Jumlah Soal</td><td><?php echo $detil_tes->jumlah_soal; ?></td></tr>
              <tr><td>Tertinggi</td><td><?php echo $statistik->max_; ?></td></tr>
              <tr><td>Terendah</td><td><?php echo $statistik->min_; ?></td></tr>
              <tr><td>Rata-rata</td><td><?php echo number_format($statistik->avg_); ?></td></tr>
            </table>
        </div>
      </div>


      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="50%">Nama Peserta</th>
            <th width="15%">Jumlah Benar</th>
            <th width="15%">Nilai</th>
            <th width="15%">Nilai Bobot</th>
          </tr>
        </thead>

        <tbody>
          <?php 
            if (!empty($hasil)) {
              $no = 1;
              foreach ($hasil as $d) {
                echo '<tr>
                      <td class="ctr">'.$no.'</td>
                      <td>'.$d->nama.'</td>
                      <td class="ctr">'.$d->jml_benar.'</td>
                      <td class="ctr">'.$d->nilai.'</td>
                      <td class="ctr">'.$d->nilai_bobot.'</td>
                      </tr>
                      ';
              $no++;
              }
            } else {
              echo '<tr><td colspan="5">Belum ada data</td></tr>';
            }
          ?>
        </tbody>
      </table>
    
      </div>
    </div>
  </div>
</div>