<div class="wrapper col-md-8 col-md-offset-2" style="margin-top: 30px">
      <div id="clock"></div>
      <form role="form" name="_form" method="post" id="_form">
      <?php 
      $no = 1;
      $jawaban = array("A","B","C","D","E");
      if (!empty($data)) {
        foreach ($data as $d) { 
            echo '<input type="hidden" name="id_soal_'.$no.'" value="'.$d->id.'">';
            echo '<div class="step well"><table class="table table-form" style="font-size: 25px">';
            echo '<tr><td>'.$no.'</td><td colspan="2">'.$d->soal.'</td></tr>';
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
            $no++;
        }
      }

      ?>

      <a class="action back btn btn-info btn-lg">Back</a>
      <a class="action next btn btn-info btn-lg">Next</a>
      <a class="action submit btn btn-success btn-lg">Submit</a>
      <input type="hidden" name="jml_soal" value="<?php echo $no; ?>">
      </form>
    </div>

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

              $.ajax({    
                type: "POST",
                url: b+"adm/ikut_ujian/simpan_akhir",
                data: JSON.stringify(form),
                dataType: 'json',
                contentType: 'application/json; charset=utf-8'
              }).done(function(response) {
                if(response.status == "ok") {
                  window.location.assign("<?php echo base_url(); ?>adm/sudah_selesai_ujian"); 
                }
              });
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
            simpan();
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
          simpan_akhir();
        });

      });

      simpan = function(){
        /*
        var minsatu = parseInt(currstep) - 1;

        var jawaban = $("input[type='radio'][name='opsi_"+minsatu+"']:checked").val();
        var id_soal = $("input[type='hidden'][name='id_soal_"+minsatu+"']").val();

        jawaban     = jawaban == undefined ? '-' : jawaban;

        var data    = {'jawab': jawaban, 'id_soal': id_soal};

        console.log(data);
        
        */
        

        var f_asal  = $("#_form");
        var form  = getFormData(f_asal);

        $.ajax({    
          type: "POST",
          url: b+"adm/ikut_ujian/simpan_satu",
          data: JSON.stringify(form),
          dataType: 'json',
          contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
         
        });

        return false;
      }

      simpan_akhir = function() {
        if (confirm('Anda yakin akan mengakhiri tes ini..?')) {
          var f_asal  = $("#_form");
          var form  = getFormData(f_asal);

          $.ajax({    
            type: "POST",
            url: b+"adm/ikut_ujian/simpan_akhir",
            data: JSON.stringify(form),
            dataType: 'json',
            contentType: 'application/json; charset=utf-8'
          }).done(function(response) {
            if(response.status == "ok") {
              window.location.assign("<?php echo base_url(); ?>adm/sudah_selesai_ujian"); 
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