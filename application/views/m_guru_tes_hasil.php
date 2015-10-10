<div class="row col-md-12">
  <div class="panel panel-info">
    <div class="panel-heading">Daftar Hasil Tes
    </div>
    <div class="panel-body">


      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="20%">Nama Tes</th>
            <th width="25%">Nama Guru</th>
            <th width="20%">Mata Pelajaran</th>
            <th width="10%">Jumlah Soal</th>
            <th width="10%">Waktu</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>

        <tbody>
          <?php 
            if (!empty($data)) {
              $no = 1;
              foreach ($data as $d) {
                echo '<tr>
                      <td class="ctr">'.$no.'</td>
                      <td>'.$d->nama_ujian.'</td>
                      <td>'.$d->nama_guru.'</td>
                      <td>'.$d->mapel.'</td>
                      <td class="ctr">'.$d->jumlah_soal.'</td>
                      <td class="ctr">'.$d->waktu.' menit</td>
                      <td class="ctr">
                        <div class="btn-group">
                          <a href="'.base_url().'adm/h_ujian/det/'.$d->id.'" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-search" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Lihat Hasil</a>
                        </div>
                      </td>
                      </tr>
                      ';
              $no++;
              }
            } else {
              echo '<tr><td colspan="6">Belum ada data</td></tr>';
            }
          ?>
        </tbody>
      </table>
    
      </div>
    </div>
  </div>
</div>