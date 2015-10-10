/* FUNGSI BERSAMA */
function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

/* 
=======================================
=======================================
*/

function m_soal_e(id) {
	$("#m_soal").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"adm/m_soal/det/"+id,
		success: function(data) {
			$("#id").val(data.id);
			//$("#id_mapel").val(data.id_mapel);
			$("#soal").val(data.soal);
			$("#opsi_a").val(data.opsi_a);
			$("#opsi_b").val(data.opsi_b);
			$("#opsi_c").val(data.opsi_c);
			$("#opsi_d").val(data.opsi_d);
			$("#opsi_e").val(data.opsi_e);
			$("#jawaban").val(data.jawaban);
			$("#id_mapel").val(id_mapel_);
			$("#soal").focus();
		}
	});
	
	return false;
}

function m_soal_s() {
	//e.preventDefault();
	var f_asal	= $("#f_soal");
	var form	= getFormData(f_asal);
	$.ajaxFileUpload({
		url             : base_url + 'adm/m_soal/simpan/', 
		secureuri       : false,
		fileElementId   : 'gambar_soal',
		data 			: form,
		dataType		: 'jsonp',
		contentType		: 'text/javascript',
		success : function (data) {
			var d = JSON.parse(data);
			
			if(d.status == 'ok') {
				$('#konfirmasi').html('<div class="alert alert-success">'+d.msg+'</div>');			
				window.location.assign(base_url+"adm/m_soal/pilih_mapel/"+d.id_mapel);
			} else {
				$('#konfirmasi').html('<div class="alert alert-danger">gagal</div>');
			}
		}
	});
	return false;

	/*

	var f_asal	= $("#f_soal");
	var form	= getFormData(f_asal);

	$.ajax({		
		type: "POST",
		url: base_url+"adm/m_soal/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			window.location.assign(base_url+"adm/m_soal"); 
		} else {
			console.log('gagal');
		}
	});
	return false;

	*/
}

function m_soal_h(id) {
	if (confirm('Anda yakin..?')) {
		$.ajax({
			type: "GET",
			url: base_url+"adm/m_soal/hapus/"+id,
			success: function(response) {
				if (response.status == "ok") {
					window.location.assign(base_url+"adm/m_soal"); 
				} else {
					console.log('gagal');
				}
			}
		});
	}
	
	return false;
}


//ujian
function m_ujian_e(id) {
	$("#m_ujian").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"adm/m_ujian/det/"+id,
		success: function(data) {
			$("#id").val(data.id);
			$("#nama_ujian").val(data.nama_ujian);
			$("#mapel").val(data.id_mapel);
			$("#jumlah_soal").val(data.jumlah_soal);
			$("#waktu").val(data.waktu);
			$("#nama_ujian").focus();
			__ambil_jumlah_soal(data.id_mapel);
		}
	});
	
	return false;
}

function m_ujian_s() {
	var f_asal	= $("#f_ujian");
	var form	= getFormData(f_asal);

	if (form.jumlah_soal > form.jumlah_soal1) {
		alert('Jumlah soal pada mata pelajaran ini belum mencukupi..!');
	} else {
		$.ajax({		
			type: "POST",
			url: base_url+"adm/m_ujian/simpan",
			data: JSON.stringify(form),
			dataType: 'json',
			contentType: 'application/json; charset=utf-8'
		}).done(function(response) {
			if (response.status == "ok") {
				window.location.assign(base_url+"adm/m_ujian"); 
			} else {
				console.log('gagal');
			}
		});
	}
	return false;
}

function m_ujian_h(id) {
	if (confirm('Anda yakin..?')) {
		$.ajax({
			type: "GET",
			url: base_url+"adm/m_ujian/hapus/"+id,
			success: function(response) {
				if (response.status == "ok") {
					window.location.assign(base_url+"adm/m_ujian"); 
				} else {
					console.log('gagal');
				}
			}
		});
	}
	
	return false;
}


/* admindos las puerta conos il grande partite */

//siswa
function m_siswa_e(id) {
	$("#m_siswa").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"adm/m_siswa/det/"+id,
		success: function(data) {
			$("#id").val(data.id);
			$("#nama").val(data.nama);
			$("#nim").val(data.nim);
			$("#jurusan").val(data.jurusan);
			$("#nama").focus();
		}
	});
	return false;
}

function m_siswa_s() {
	var f_asal	= $("#f_siswa");
	var form	= getFormData(f_asal);

	$.ajax({		
		type: "POST",
		url: base_url+"adm/m_siswa/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			window.location.assign(base_url+"adm/m_siswa"); 
		} else {
			console.log('gagal');
		}
	});
	return false;
}

function m_siswa_h(id) {
	if (confirm('Anda yakin..?')) {
		$.ajax({
			type: "GET",
			url: base_url+"adm/m_siswa/hapus/"+id,
			success: function(response) {
				if (response.status == "ok") {
					window.location.assign(base_url+"adm/m_siswa"); 
				} else {
					console.log('gagal');
				}
			}
		});
	}
	return false;
}

function m_siswa_u(id) {
	if (confirm('Anda yakin..? Username otomatis adalah "siswa'+id+'", dan Password otomatis adalah "admin"')) {
		$.ajax({
			type: "GET",
			url: base_url+"adm/m_siswa/user/"+id,
			success: function(response) {
				if (response.status == "ok") {
					window.location.assign(base_url+"adm/m_siswa"); 
				} else {
					console.log('gagal');
				}
			}
		});
	}
	return false;
}

function m_siswa_matkul(id) {
	$.ajax({
		type: "GET",
		url: base_url+"adm/m_siswa/ambil_matkul/"+id,
		success: function(data) {
			if (data.status == "ok") {
				var jml_data	= Object.keys(data.data).length;
				var hate 	= '<div class="modal fade" id="m_siswa_matkul" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 id="myModalLabel">Setting Mata Kuliah</h4></div><div class="modal-body"><form name="f_siswa_matkul" id="f_siswa_matkul" method="post" onsubmit="return m_siswa_matkul_s();"><input type="hidden" name="id_mhs" id="id_mhs" value="'+id+'"><div id="konfirmasi"></div>';
				
				if (jml_data > 0) {
					$.each(data.data, function(i, item) {
						if (item.ok == "1") {
							hate += '<label><input type="checkbox" value="'+item.id+'" name="id_mapel_'+item.id+'" checked> &nbsp;'+item.nama+'</label> &nbsp;&nbsp; ';
						} else {
							hate += '<label><input type="checkbox" value="'+item.id+'" name="id_mapel_'+item.id+'"> &nbsp;'+item.nama+'</label> &nbsp;&nbsp; ';
						}
					});				
				} else {
					hate += 'Belum ada data..';
				}
				hate += '<div class="modal-footer"><button class="btn btn-primary" type="submit">Simpan</button><button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button></div></form></div></div></div>';
				$("#tampilkan_modal").html(hate);
				$("#m_siswa_matkul").modal('show');
			} else {
				console.log('gagal');
			}
		}
	});

	return false;
}

function m_siswa_matkul_s() {
	var f_asal	= $("#f_siswa_matkul");
	var form	= getFormData(f_asal);

	$.ajax({		
		type: "POST",
		url: base_url+"adm/m_siswa/simpan_matkul",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			window.location.assign(base_url+"adm/m_siswa"); 
		} else {
			console.log('gagal');
		}
	});
	
	return false;
}

//guru
function m_guru_e(id) {
	$("#m_guru").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"adm/m_guru/det/"+id,
		success: function(data) {
			$("#id").val(data.id);
			$("#nama").val(data.nama);
			$("#nama").focus();
		}
	});
	return false;
}

function m_guru_s() {
	var f_asal	= $("#f_guru");
	var form	= getFormData(f_asal);

	$.ajax({		
		type: "POST",
		url: base_url+"adm/m_guru/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			window.location.assign(base_url+"adm/m_guru"); 
		} else {
			console.log('gagal');
		}
	});
	return false;
}

function m_guru_h(id) {
	if (confirm('Anda yakin..?')) {
		$.ajax({
			type: "GET",
			url: base_url+"adm/m_guru/hapus/"+id,
			success: function(response) {
				if (response.status == "ok") {
					window.location.assign(base_url+"adm/m_guru"); 
				} else {
					console.log('gagal');
				}
			}
		});
	}
	return false;
}

function m_guru_u(id) {
	if (confirm('Anda yakin..? Username otomatis adalah "guru'+id+'", dan Password otomatis adalah "admin"')) {
		$.ajax({
			type: "GET",
			url: base_url+"adm/m_guru/user/"+id,
			success: function(response) {
				if (response.status == "ok") {
					window.location.assign(base_url+"adm/m_guru"); 
				} else {
					console.log('gagal');
				}
			}
		});
	}
	return false;
}
function m_guru_matkul(id) {
	$.ajax({
		type: "GET",
		url: base_url+"adm/m_guru/ambil_matkul/"+id,
		success: function(data) {
			if (data.status == "ok") {
				var jml_data	= Object.keys(data.data).length;
				var hate 	= '<div class="modal fade" id="m_siswa_matkul" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 id="myModalLabel">Setting Mata Kuliah</h4></div><div class="modal-body"><form name="f_siswa_matkul" id="f_siswa_matkul" method="post" onsubmit="return m_guru_matkul_s();"><input type="hidden" name="id_mhs" id="id_mhs" value="'+id+'"><div id="konfirmasi"></div>';
				
				if (jml_data > 0) {
					$.each(data.data, function(i, item) {
						if (item.ok == "1") {
							hate += '<label><input type="checkbox" value="'+item.id+'" name="id_mapel_'+item.id+'" checked> &nbsp;'+item.nama+'</label> &nbsp;&nbsp; ';
						} else {
							hate += '<label><input type="checkbox" value="'+item.id+'" name="id_mapel_'+item.id+'"> &nbsp;'+item.nama+'</label> &nbsp;&nbsp; ';
						}
					});				
				} else {
					hate += 'Belum ada data..';
				}
				hate += '<div class="modal-footer"><button class="btn btn-primary" type="submit">Simpan</button><button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button></div></form></div></div></div>';
				$("#tampilkan_modal").html(hate);
				$("#m_siswa_matkul").modal('show');
			} else {
				console.log('gagal');
			}
		}
	});

	return false;
}

function m_guru_matkul_s() {
	var f_asal	= $("#f_siswa_matkul");
	var form	= getFormData(f_asal);

	$.ajax({		
		type: "POST",
		url: base_url+"adm/m_guru/simpan_matkul",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			window.location.assign(base_url+"adm/m_guru"); 
		} else {
			console.log('gagal');
		}
	});
	
	return false;
}


//mapel
function m_mapel_e(id) {
	$("#m_mapel").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"adm/m_mapel/det/"+id,
		success: function(data) {
			$("#id").val(data.id);
			$("#nama").val(data.nama);
			$("#nama").focus();
		}
	});
	return false;
}

function m_mapel_s() {
	var f_asal	= $("#f_mapel");
	var form	= getFormData(f_asal);

	$.ajax({		
		type: "POST",
		url: base_url+"adm/m_mapel/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			window.location.assign(base_url+"adm/m_mapel"); 
		} else {
			console.log('gagal');
		}
	});
	return false;
}

function m_mapel_h(id) {
	if (confirm('Anda yakin..?')) {
		$.ajax({
			type: "GET",
			url: base_url+"adm/m_mapel/hapus/"+id,
			success: function(response) {
				if (response.status == "ok") {
					window.location.assign(base_url+"adm/m_mapel"); 
				} else {
					console.log('gagal');
				}
			}
		});
	}
	return false;
}

function __ambil_jumlah_soal(id_mapel) {
	$.ajax({
		type: "GET",
		url: base_url+"adm/m_ujian/jumlah_soal/"+id_mapel,
		success: function(response) {
			$("#jumlah_soal1").val(response.jumlah);	
		}
	});
	return false;
}

function rubah_password() {
	$.ajax({
		type: "GET",
		url: base_url+"adm/rubah_password/",
		success: function(response) {
			var teks_modal = '<div class="modal fade" id="m_ubah_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 id="myModalLabel">Update password</h4></div><div class="modal-body"><form name="f_ubah_password" id="f_ubah_password" onsubmit="return rubah_password_s();" method="post"><input type="hidden" name="id" id="id" value="'+response.id+'"><div id="konfirmasi"></div><table class="table table-form"><tr><td style="width: 25%">Username</td><td style="width: 75%"><input type="text" class="form-control" name="u1" id="u1" required value="'+response.username+'" readonly></td></tr><tr><td style="width: 25%">Password lama</td><td style="width: 75%"><input type="password" class="form-control" name="p1" id="p1" required></td></tr><tr><td style="width: 25%">Password Baru</td><td style="width: 75%"><input type="password" class="form-control" name="p2" id="p2" required></td></tr><tr><td style="width: 25%">Ulangi Password</td><td style="width: 75%"><input type="password" class="form-control" name="p3" id="p3" required></td></tr></table></div><div class="modal-footer"><button class="btn btn-primary" onclick="return rubah_password_s();">Simpan</button><button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button></div></form></div></div></div>';

			$("#tampilkan_modal").html(teks_modal);
			$("#m_ubah_password").modal('show');
			$("#p1").focus();
		}
	});
	return false;
}

function rubah_password_s() {
	var f_asal	= $("#f_ubah_password");
	var form	= getFormData(f_asal);

	$.ajax({		
		type: "POST",
		url: base_url+"adm/rubah_password/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			$("#konfirmasi").html('<div class="alert alert-success">'+response.msg+'</div>');
			$("#m_ubah_password").modal('hide');
		} else {
			$("#konfirmasi").html('<div class="alert alert-danger">'+response.msg+'</div>');
		}
	});
	return false;
}

$("#pilih_mapel").change(function() {
	var id_mapel = this.value;
	window.location.assign(base_url+"adm/m_soal/pilih_mapel/"+id_mapel); 
});


$("#id_guru").val(id_guru_);
//$("#id_guru").attr("readonly", true);