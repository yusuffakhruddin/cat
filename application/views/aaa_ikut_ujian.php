<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Dashboard - Aplikasi Ujian Online</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo base_url(); ?>___/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>___/css/style.css" rel="stylesheet">
<!--<link href="<?php echo base_url(); ?>___/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>___/css/font-awesome.css" rel="stylesheet">
<!--<link href="<?php echo base_url(); ?>___/css/style.css" rel="stylesheet">-->
<!--<link href="<?php echo base_url(); ?>___/css/pages/dashboard.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>

<nav class="navbar navbar-findcond navbar-fixed-top">
    <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand">Aplikasi Ujian Online</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav navbar-right">
        <!--<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-fw fa-bell-o"></i> Bildirimler <span class="badge">0</span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#"><i class="fa fa-fw fa-tag"></i> <span class="badge">Music</span> sayfası <span class="badge">Video</span> sayfasında etiketlendi</a></li>
            <li><a href="#"><i class="fa fa-fw fa-thumbs-o-up"></i> <span class="badge">Music</span> sayfasında iletiniz beğenildi</a></li>
            <li><a href="#"><i class="fa fa-fw fa-thumbs-o-up"></i> <span class="badge">Video</span> sayfasında iletiniz beğenildi</a></li>
            <li><a href="#"><i class="fa fa-fw fa-thumbs-o-up"></i> <span class="badge">Game</span> sayfasında iletiniz beğenildi</a></li>
          </ul>
        </li>
        <li class="active"><a href="#">Ana Sayfa <span class="sr-only">(current)</span></a></li>
        -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->session->userdata('admin_nama')." (".$this->session->userdata('admin_user').")"; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#" onclick="return rubah_password();">Ubah Password</a></li>
            <li><a href="<?php echo base_url(); ?>adm/logout" onclick="return confirm('keluar..?');">Logout</a></li>
          </ul>
        </li>
      </ul>
      <!--
      <form class="navbar-form navbar-right search-form" role="search">
        <input type="text" class="form-control" placeholder="Search" />
      </form>
      -->
    </div>
  </div>
</nav>

<?php 
/*
$sess_level = $this->session->userdata('admin_level');
$uri2 = $this->uri->segment(2);

$menu = array();

if ($sess_level == "guru") {
  $menu = array(
            array("icon"=>"dashboard", "url"=>"", "text"=>"Dashboard"),
            array("icon"=>"list-alt", "url"=>"m_soal", "text"=>"Soal"),
            array("icon"=>"file", "url"=>"m_ujian", "text"=>"Ujian"),
          );
} else if ($sess_level == "siswa") {
  $menu = array(
            array("icon"=>"dashboard", "url"=>"", "text"=>"Dashboard"),
            array("icon"=>"file", "url"=>"ikuti_ujian", "text"=>"Ujian"),
          );
} else if ($sess_level == "admin") {
  $menu = array(
            array("icon"=>"dashboard", "url"=>"", "text"=>"Dashboard"),
            array("icon"=>"list-alt", "url"=>"m_soal", "text"=>"Soal"),
            array("icon"=>"file", "url"=>"ujian", "text"=>"Ujian"),
          );
} else {
  $menu = array(
            array("icon"=>"dashboard", "url"=>"", "text"=>"Dashboard")
          );
}
*/

$jam_mulai_pc = explode(" ", $detiltes->tgl_mulai);
$jam_selesai_pc = explode(" ", $detiltes->tgl_selesai);
?>


<div class="container" style="margin-top: 70px">

<div class="col-lg-12 row">
  <div class="alert alert-warning col-md-5">
      <table class="table table-bordered" style="margin-bottom: 0px">
        <tr><td width="30%">Nama Peserta</td><td width="70%"><?php echo $detil_user->nama; ?></td></tr>
        <tr><td>Pembuat Soal</td><td><?php echo $detil_soal->namaGuru; ?></td></tr>
        <tr><td>Mata Kuliah</td><td><?php echo $detil_soal->namaMapel; ?></td></tr>
      </table>
  </div>
  <div class="col-md-2"></div>
  <div class="alert alert-warning col-md-5">
      <table class="table table-bordered" style="margin-bottom: 0px">
        <tr><td width="30%">Nama Ujian</td><td width="70%"><?php echo $detil_soal->nama_ujian; ?></td></tr>
        <tr><td>Jumlah Soal</td><td><?php echo $detil_soal->jumlah_soal; ?></td></tr>
        <tr><td>Waktu</td><td><?php echo $detil_soal->waktu; ?> menit (<?php echo $jam_mulai_pc[1]." s.d. ".$jam_selesai_pc[1]; ?>)</td></tr>
      </table>
  </div>
</div>
<!--
<div class="col-lg-12 row">
  <div class="panel panel-default">
    <div class="panel-body">
    <?php 
    foreach ($menu as $m) {
        if ($uri2 == $m['url']) {
          echo '<a href="'.base_url().'adm/'.$m['url'].'" class="btn btn-sq btn-warning"><i class="glyphicon glyphicon-'.$m['icon'].' g3x"></i><br><br/>'.$m['text'].' </a>';
        } else {
          echo '<a href="'.base_url().'adm/'.$m['url'].'" class="btn btn-sq btn-primary"><i class="glyphicon glyphicon-'.$m['icon'].' g3x"></i><br><br/>'.$m['text'].' </a>';
        }
    }
    ?>
    </div>
  </div>
</div>
-->

<div class="row col-md-12">
      <div class="alert alert-danger">
        Waktu mengerjakan tinggal : <div id="clock" style="display: inline; font-weight: bold"></div>
      </div>
      <form role="form" name="_form" method="post" id="_form">
      <?php 
      $no = 1;
      $jawaban = array("A","B","C","D","E");
      if (!empty($data)) {
        foreach ($data as $d) { 
            echo '<input type="hidden" name="id_soal_'.$no.'" value="'.$d->id.'">';
            echo '<div class="step well">';
        
            if ($d->gambar == "") {
                echo '<table class="table table-form" style="font-size: 16px">
                <tr><td style="v-align: top">'.$no.'</td><td colspan="2">'.$d->soal.'</td></tr>';
                for ($j=0; $j<sizeof($jawaban);$j++) {
                  $kecil_jawaban = strtolower($jawaban[$j]);
                  $opsyen = "opsi_".$kecil_jawaban;
                  $opsyens = $d->$opsyen;

                  if ($jawaban[$j] == $d->jawaban) {
                    echo '<tr><td width="3%">'.$jawaban[$j].'</td><td width="3%"><input checked type="radio" id="opsi_'.$jawaban[$j].'_'.$d->id.'" name="opsi_'.$no.'" value="'.$jawaban[$j].'"></td><td><label for="opsi_'.$jawaban[$j].'_'.$d->id.'">'.$opsyens.'</label></td></label></tr>';
                  } else {
                    echo '<tr><td width="3%">'.$jawaban[$j].'</td><td width="3%"><input type="radio" id="opsi_'.$jawaban[$j].'_'.$d->id.'" name="opsi_'.$no.'" value="'.$jawaban[$j].'"></td><td><label for="opsi_'.$jawaban[$j].'_'.$d->id.'">'.$opsyens.'</label></td></label></tr>';
                  }
                }
                echo '</table></div>';
            } else {
                echo '<table class="table table-form" style="font-size: 16px">
                <tr><td rowspan="6" width="25%"><img src="'.base_url().'upload/gambar_soal/'.$d->gambar.'" class="polaroid" style="width: 300px; height: 250px"></td>
                <td style="v-align: top">'.$no.'</td><td colspan="2">'.$d->soal.'</td></tr>';
                for ($j=0; $j<sizeof($jawaban);$j++) {
                  $kecil_jawaban = strtolower($jawaban[$j]);
                  $opsyen = "opsi_".$kecil_jawaban;
                  $opsyens = $d->$opsyen;

                  if ($jawaban[$j] == $d->jawaban) {
                    echo '<tr><td width="3%">'.$jawaban[$j].'</td><td width="3%"><input checked type="radio" id="opsi_'.$jawaban[$j].'_'.$d->id.'" name="opsi_'.$no.'" value="'.$jawaban[$j].'"></td><td><label for="opsi_'.$jawaban[$j].'_'.$d->id.'">'.$opsyens.'</label></td></label></tr>';
                  } else {
                    echo '<tr><td width="3%">'.$jawaban[$j].'</td><td width="3%"><input type="radio" id="opsi_'.$jawaban[$j].'_'.$d->id.'" name="opsi_'.$no.'" value="'.$jawaban[$j].'"></td><td><label for="opsi_'.$jawaban[$j].'_'.$d->id.'">'.$opsyens.'</label></td></label></tr>';
                  }
                }
                echo '</table></div>';
            }


            $no++;
        }
      }

      ?>

      <a class="action back btn btn-info btn-lg">Back</a>
      <a class="action next btn btn-info btn-lg">Berikutnya</a>
      <a class="action submit btn btn-success btn-lg">Selesai Ujian</a>
      <input type="hidden" name="jml_soal" value="<?php echo $no; ?>">
      </form>
    </div>

<div class="col-md-12" style="border-top: solid 1px #eee; padding-top: 10px; margin-top: 50px; margin-bottom: 20px">
  <div class="span12"> &copy; 2015 <a href="<?php echo base_url(); ?>adm">Aplikasi Ujian Online</a>. </div>
</div>




<script src="<?php echo base_url(); ?>___/js/jquery-1.11.3.min.js"></script> 
<script src="<?php echo base_url(); ?>___/js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>___/js/jquery.countdown.min.js"></script> 
<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url(); ?>___/js/aplikasi.js"></script> 
<script type="text/javascript">     

    $(document).ready(function(){
         var jam_selesai = '<?php echo $detiltes->tgl_selesai; ?>';
         
         $('div#clock').countdown(jam_selesai)
          .on('update.countdown', function (event) { 
            $(this).html(event.strftime('%H:%M:%S'));
          })
          .on('finish.countdown', function (event) {
              alert('Waktu telah selesai....!')
              var f_asal  = $("#_form");
              var form  = getFormData(f_asal);
              simpan_akhir(<?php echo $detiltes->id_tes; ?>);
              window.location.assign("<?php echo base_url(); ?>adm/sudah_selesai_ujian/<?php echo $detiltes->id_tes; ?>"); 
              
              return false;
          });

        var current = 1;
        
        widget      = $(".step");
        btnnext     = $(".next");
        btnback     = $(".back"); 
        btnsubmit   = $(".submit");

        // Init buttons and UI
        widget.not(':eq(0)').hide();
        hideButtons(current);
        
        // Next button click action
        btnnext.click(function(){
          if(current < widget.length){
            widget.show();
            widget.not(':eq('+(current++)+')').hide();
            //console.log(current);
            simpan(<?php echo $detiltes->id_tes; ?>);
          }
          hideButtons(current);
        })

        // Back button click action
        btnback.click(function(){
          if(current > 1){
            current = current - 2;
            if(current < widget.length){
              widget.show();
              widget.not(':eq('+(current++)+')').hide();
            }
            hideButtons(current);
          }
          hideButtons(current);
        })  

        btnsubmit.click(function() {
          simpan_akhir(<?php echo $detiltes->id_tes; ?>);
        });

      });

      simpan = function(id){
        var f_asal  = $("#_form");
        var form  = getFormData(f_asal);

        $.ajax({    
          type: "POST",
          url: base_url+"adm/ikut_ujian/simpan_satu/"+id,
          data: JSON.stringify(form),
          dataType: 'json',
          contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
         
        });
        return false;
      }

      simpan_akhir = function(id) {
        if (confirm('Anda yakin akan mengakhiri tes ini..?')) {
          var f_asal  = $("#_form");
          var form  = getFormData(f_asal);

          $.ajax({    
            type: "POST",
            url: base_url+"adm/ikut_ujian/simpan_akhir/"+id,
            data: JSON.stringify(form),
            dataType: 'json',
            contentType: 'application/json; charset=utf-8'
          }).done(function(response) {
            if(response.status == "ok") {
              window.location.assign("<?php echo base_url(); ?>adm/sudah_selesai_ujian/"+id); 
            }
          });

          return false;
        }
      }

      // Hide buttons according to the current step
      hideButtons = function(current){
        var limit = parseInt(widget.length); 

        $(".action").hide();

        if(current < limit) btnnext.show();
        if(current > 1) btnback.show();
        if (current == limit) { btnnext.hide(); btnsubmit.show(); }
      }

    </script> 


</body>
</html>
