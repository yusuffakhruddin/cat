<div class="row col-md-12">
  <div class="panel panel-info">
    <div class="panel-heading">Daftar Ujian / Tes
      <div class="tombol-kanan">
        <a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_ujian_e(0);"><i class="glyphicon glyphicon-plus"></i> &nbsp;&nbsp;Tambah</a>
      </div>
    </div>
    <div class="panel-body">


      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="25%">Nama Tes</th>
            <th width="20%">Mata Pelajaran</th>
            <th width="15%">Jumlah Soal</th>
            <th width="20%">Waktu</th>
            <!--<th width="15%">Jenis</th>-->
            <th width="15%">Aksi</th>
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
                      <td>'.$d->mapel.'</td>
                      <td class="ctr">'.$d->jumlah_soal.'</td>
                      <td class="ctr">'.$d->waktu.' menit</td>
                      <!--<td class="ctr">'.$d->jenis.'</td>-->
                      <td class="ctr">
                        <div class="btn-group">
                          <a href="#" onclick="return m_ujian_e('.$d->id.');" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
                          <a href="#" onclick="return m_ujian_h('.$d->id.');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
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
                    




<div class="modal fade" id="m_ujian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="myModalLabel">Buat Ujian</h4>
      </div>
      <div class="modal-body">
          <form name="f_ujian" id="f_ujian" onsubmit="return m_ujian_s();">
            <input type="hidden" name="id" id="id" value="0">
            <input type="hidden" name="jumlah_soal1" id="jumlah_soal1" value="0">
              <table class="table table-form">
                <tr><td style="width: 25%">Nama Ujian</td><td style="width: 75%"><input type="text" class="form-control" name="nama_ujian" id="nama_ujian" required></td></tr>
                <tr><td>Mata Pelajaran</td><td><?php echo form_dropdown('mapel', $p_mapel, '', 'onchange="return __ambil_jumlah_soal(this.value);" class="form-control"  id="mapel" required'); ?></td></tr>
                <tr><td>Jumlah soal</td><td><?php echo form_input('jumlah_soal', '', 'class="form-control"  id="jumlah_soal" required'); ?></td></tr>
                <tr><td>Waktu</td><td><?php echo form_input('waktu', '', 'class="form-control" id="waktu" placeholder="menit" required'); ?></td></tr>
              </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Simpan</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
      </div>
        </form>
    </div>
  </div>
</div>