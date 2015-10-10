<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adm extends CI_Controller {

	public function cek_aktif() {
		if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
			redirect('adm/login');
		} 
	}
	
	public function index() {
		$this->cek_aktif();
		
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		
		$a['p']			= "v_main";

		if ($a['sess_level'] == "siswa") {
			$a['p_mapel']	= $this->db->query("SELECT m_mapel.nama FROM tr_siswa_mapel INNER JOIN m_mapel ON tr_siswa_mapel.id_mapel = m_mapel.id WHERE tr_siswa_mapel.id_siswa = '".$a['sess_konid']."'")->result();
		}
		
		$this->load->view('aaa', $a);
	}
	

	/* == ADMIN == */
	public function m_siswa() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();

		$a['data'] = $this->db->query("SELECT m_siswa.*,
									(SELECT COUNT(id) FROM m_admin WHERE level = 'siswa' AND kon_id = m_siswa.id) AS ada
									FROM m_siswa")->result();

		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_siswa WHERE id = '$uri4'")->row();
			$this->j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_siswa SET nama = '".bersih($p,"nama")."', nim = '".bersih($p,"nim")."', jurusan = '".bersih($p,"jurusan")."'	WHERE id = '".bersih($p,"id")."'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_siswa VALUES (null, '".bersih($p,"nama")."', '".bersih($p,"nim")."', '".bersih($p,"jurusan")."')");
			}
			
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_siswa WHERE id = '".$uri4."'");
			$this->db->query("DELETE FROM m_admin WHERE level = 'siswa' AND kon_id = '".$uri4."'");			
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "user") {
			$det_user = $this->db->query("SELECT id FROM m_siswa WHERE id = '$uri4'")->row();

			if (!empty($det_user)) {
				$this->db->query("INSERT INTO m_admin VALUES (null, 'siswa".$det_user->id."', md5('admin'), 'siswa', '".$det_user->id."')");
				$ret_arr['status'] 	= "ok";
				$ret_arr['caption']	= "tambah user sukses";
				$this->j($ret_arr);
			} else {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "tambah user gagal";
				$this->j($ret_arr);
			}
			exit();
		} else if ($uri3 == "ambil_matkul") {

			$matkul = $this->db->query("SELECT m_mapel.*,
										(SELECT COUNT(id) FROM tr_siswa_mapel WHERE id_siswa = ".$uri4." AND id_mapel = m_mapel.id) AS ok
										FROM m_mapel
										")->result();
			$ret_arr['status'] = "ok";
			$ret_arr['data'] = $matkul;
			$this->j($ret_arr);
			exit;
		} else if ($uri3 == "simpan_matkul") {
			$ket 	= "";
			//echo var_dump($p);

			$ambil_matkul = $this->db->query("SELECT id FROM m_mapel ORDER BY id ASC")->result();
			if (!empty($ambil_matkul)) {
				foreach ($ambil_matkul as $a) {
					$p_sub = "id_mapel_".$a->id;

					if (!empty($p->$p_sub)) {
						
						$cek_sudah_ada = $this->db->query("SELECT id FROM tr_siswa_mapel WHERE  id_siswa = '".$p->id_mhs."' AND id_mapel = '".$a->id."'")->num_rows();
						

						if ($cek_sudah_ada < 1) {
							$this->db->query("INSERT INTO tr_siswa_mapel VALUES (null, '".$p->id_mhs."', '".$a->id."')");
						} else {
							$this->db->query("UPDATE tr_siswa_mapel SET id_mapel = '".$p->$p_sub."' WHERE id_siswa = '".$p->id_mhs."' AND id_mapel = '".$a->id."'");
						}
					} else {
						//echo "0<br>";
						$this->db->query("DELETE FROM tr_siswa_mapel WHERE id_siswa = '".$p->id_mhs."' AND id_mapel = '".$a->id."'");
					}
				}
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		} else {
			$a['p']	= "m_siswa";
		}

		$this->load->view('aaa', $a);
	}

	public function m_guru() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();

		$a['data'] = $this->db->query("SELECT m_guru.*,
									(SELECT COUNT(id) FROM m_admin WHERE level = 'guru' AND kon_id = m_guru.id) AS ada
									FROM m_guru")->result();

		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_guru WHERE id = '$uri4'")->row();
			$this->j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_guru SET nama = '".bersih($p,"nama")."'
								WHERE id = '".bersih($p,"id")."'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_guru VALUES (null, '".bersih($p,"nama")."')");
			}
			
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_guru WHERE id = '".$uri4."'");
			$this->db->query("DELETE FROM m_admin WHERE level = 'guru' AND kon_id = '".$uri4."'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "user") {
			$det_user = $this->db->query("SELECT id FROM m_guru WHERE id = '$uri4'")->row();

			if (!empty($det_user)) {
				$this->db->query("INSERT INTO m_admin VALUES (null, 'guru".$det_user->id."', md5('admin'), 'guru', '".$det_user->id."')");
				$ret_arr['status'] 	= "ok";
				$ret_arr['caption']	= "tambah user sukses";
				$this->j($ret_arr);
			} else {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "tambah user gagal";
				$this->j($ret_arr);
			}
			exit();
		} else if ($uri3 == "ambil_matkul") {

			$matkul = $this->db->query("SELECT m_mapel.*,
										(SELECT COUNT(id) FROM tr_guru_mapel WHERE id_guru = ".$uri4." AND id_mapel = m_mapel.id) AS ok
										FROM m_mapel
										")->result();
			$ret_arr['status'] = "ok";
			$ret_arr['data'] = $matkul;
			$this->j($ret_arr);
			exit;
		} else if ($uri3 == "simpan_matkul") {
			$ket 	= "";
			//echo var_dump($p);

			$ambil_matkul = $this->db->query("SELECT id FROM m_mapel ORDER BY id ASC")->result();
			if (!empty($ambil_matkul)) {
				foreach ($ambil_matkul as $a) {
					$p_sub = "id_mapel_".$a->id;

					if (!empty($p->$p_sub)) {
						
						$cek_sudah_ada = $this->db->query("SELECT id FROM tr_guru_mapel WHERE  id_guru = '".$p->id_mhs."' AND id_mapel = '".$a->id."'")->num_rows();
						

						if ($cek_sudah_ada < 1) {
							$this->db->query("INSERT INTO tr_guru_mapel VALUES (null, '".$p->id_mhs."', '".$a->id."')");
						} else {
							$this->db->query("UPDATE tr_guru_mapel SET id_mapel = '".$p->$p_sub."' WHERE id_guru = '".$p->id_mhs."' AND id_mapel = '".$a->id."'");
						}
					} else {
						//echo "0<br>";
						$this->db->query("DELETE FROM tr_guru_mapel WHERE id_guru = '".$p->id_mhs."' AND id_mapel = '".$a->id."'");
					}
				}
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		} else {
			$a['p']	= "m_guru";
		}

		$this->load->view('aaa', $a);
	}

	public function m_mapel() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();

		$a['data'] = $this->db->query("SELECT m_mapel.* FROM m_mapel")->result();

		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_mapel WHERE id = '$uri4'")->row();
			$this->j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_mapel SET nama = '".bersih($p,"nama")."'
								WHERE id = '".bersih($p,"id")."'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_mapel VALUES (null, '".bersih($p,"nama")."')");
			}
			
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_mapel WHERE id = '".$uri4."'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			$this->j($ret_arr);
			exit();
		} else {
			$a['p']	= "m_mapel";
		}

		$this->load->view('aaa', $a);
	}

	/* == GURU == */
	public function m_soal() {
		$this->cek_aktif();
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));
		$uri5 = mysql_real_escape_string($this->uri->segment(5));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();

		if ($a['sess_level'] == "guru") {
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT * FROM m_mapel WHERE id IN (SELECT id_mapel FROM tr_guru_mapel WHERE id_guru = '".$a['sess_konid']."')")->result(), "id,nama");
		} else if ($a['sess_level'] == "admin") {
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT * FROM m_mapel ORDER BY id ASC")->result(), "id,nama");
		}

		$a['p_guru'] = obj_to_array($this->db->query("SELECT * FROM m_guru")->result(), "id,nama");

		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_soal WHERE id = '$uri4'")->row();
			$this->j($a);
			exit();
		} else if ($uri3 == "hapus_gambar") {
			$nama_gambar = $this->db->query("SELECT gambar FROM m_soal WHERE id = '".$uri5."'")->row();
			$this->db->query("UPDATE m_soal SET gambar = '' WHERE id = '".$uri5."'");
			@unlink("./upload/gambar_soal/".$nama_gambar->gambar);
			redirect('adm/m_soal/pilih_mapel/'.$uri4);
		} else if ($uri3 == "pilih_mapel") {
			if ($a['sess_level'] == "guru") {
				$a['data'] = $this->db->query("SELECT m_soal.*, m_guru.nama AS nama_guru FROM m_soal INNER JOIN m_guru ON m_soal.id_guru = m_guru.id WHERE m_soal.id_guru = '".$a['sess_konid']."' AND m_soal.id_mapel = '$uri4'")->result();
			} else {
				$a['data'] = $this->db->query("SELECT m_soal.*, m_guru.nama AS nama_guru FROM m_soal INNER JOIN m_guru ON m_soal.id_guru = m_guru.id WHERE m_soal.id_mapel = '$uri4'")->result();
			}
			//echo $this->db->last_query();
			$a['p']	= "m_soal";
		} else if ($uri3 == "simpan") {
			$status = "";
			$msg = "";
			$file_element_name = 'gambar_soal';

			//echo var_dump($_POST);

			$pembuat_soal = ($a['sess_level'] == "admin") ? $_POST['id_guru'] : $a['sess_konid'];
			$pembuat_soal_u = ($a['sess_level'] == "admin") ? ", id_guru = '".$_POST['id_guru']."'" : "";

			if ($status != "error") {
				$config['upload_path'] = './upload/gambar_soal/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = 1024 * 8;
				$config['encrypt_name'] = FALSE;

				$this->load->library('upload', $config);
				
				//echo var_dump($this->input->post);				
				//$this->upload->do_upload($file_element_name);

				//$data = $this->upload->data();
				//$msg = $this->upload->display_errors('', '');
				
				//echo var_dump($p);

				if (!$this->upload->do_upload($file_element_name)) {
					$status = 'ok';
					$msg = $this->upload->display_errors('', '');

					if ($_POST['id'] != "") {
						$this->db->query("UPDATE m_soal SET id_mapel = '".$_POST['id_mapel']."', 
										bobot = '".$_POST['bobot']."',
										soal = '".$_POST['soal']."', 
										opsi_a = '".$_POST['opsi_a']."', opsi_b = '".$_POST['opsi_b']."', 
										opsi_c = '".$_POST['opsi_c']."', opsi_d = '".$_POST['opsi_d']."', 
										opsi_e = '".$_POST['opsi_e']."', jawaban = '".$_POST['jawaban']."'".$pembuat_soal_u."
										WHERE id = '".$_POST['id']."'");
					} else {
						$this->db->query("INSERT INTO m_soal VALUES (null, '".$pembuat_soal."', 
										'".$_POST['id_mapel']."', '".$_POST['bobot']."', '', 
										'".$_POST['soal']."',
										'".$_POST['opsi_a']."', '".$_POST['opsi_b']."', '".$_POST['opsi_c']."', 
										'".$_POST['opsi_d']."', '".$_POST['opsi_e']."', '".$_POST['jawaban']."', 
										NOW())");
					}
				} else {
					$data = $this->upload->data();
					$image_path = $data['full_path'];
					if(file_exists($image_path)) {
						$status = "ok";
						$msg = "Upload gambar berhasil";
					} else {
						$status = "ok";
						$msg = "Terjadi kesalahan. Ulangi lagi.";
					}
					$ambil_gambar = $this->db->query("SELECT gambar FROM m_soal WHERE id = '".$_POST['id']."'")->row();
					if ($_POST['id'] != "") {
						$this->db->query("UPDATE m_soal SET id_mapel = '".$_POST['id_mapel']."', 
										bobot = '".$_POST['bobot']."', gambar = '".$data['file_name']."', 
										soal = '".$_POST['soal']."', 
										opsi_a = '".$_POST['opsi_a']."', opsi_b = '".$_POST['opsi_b']."', 
										opsi_c = '".$_POST['opsi_c']."', opsi_d = '".$_POST['opsi_d']."', 
										opsi_e = '".$_POST['opsi_e']."', jawaban = '".$_POST['jawaban']."'".$pembuat_soal_u."
										WHERE id = '".$_POST['id']."'");
					} else {
						$this->db->query("INSERT INTO m_soal VALUES (null, '".$pembuat_soal."', 
										'".$_POST['id_mapel']."', '".$_POST['bobot']."', '".$data['file_name']."', 
										'".$_POST['soal']."',
										'".$_POST['opsi_a']."', '".$_POST['opsi_b']."', '".$_POST['opsi_c']."', 
										'".$_POST['opsi_d']."', '".$_POST['opsi_e']."', '".$_POST['jawaban']."', 
										NOW())");
					}
					@unlink("./upload/gambar_soal/".$ambil_gambar->gambar);
				}
				//@unlink($_FILES[$file_element_name]);
			}
			$jeson['status'] = $status;
			$jeson['id_mapel'] = $_POST['id_mapel'];
			$jeson['msg'] = "Soal berhasil disimpan. ".$msg;
			header('Content-Type: text/html');
			echo json_encode($jeson);
			exit;
			/*
			$ret_arr['status'] = "simpan aksi";
			$this->j($ret_arr);
			exit;
			/*

			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_soal SET id_mapel = '".bersih($p,"id_mapel")."', soal = '".bersih($p,"soal")."', 
								opsi_a = '".bersih($p,"opsi_a")."', opsi_b = '".bersih($p,"opsi_b")."', 
								opsi_c = '".bersih($p,"opsi_c")."', opsi_d = '".bersih($p,"opsi_d")."', 
								opsi_e = '".bersih($p,"opsi_e")."', jawaban = '".bersih($p,"jawaban")."'
								WHERE id = '".bersih($p,"id")."'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_soal VALUES (null, '".$a['sess_konid']."', '".bersih($p,"id_mapel")."', '".bersih($p,"soal")."',
								'".bersih($p,"opsi_a")."', '".bersih($p,"opsi_b")."', '".bersih($p,"opsi_c")."', 
								'".bersih($p,"opsi_d")."', '".bersih($p,"opsi_e")."', '".bersih($p,"jawaban")."', 
								NOW())");
			}
			
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
			*/
		} else if ($uri3 == "hapus") {
			$nama_gambar = $this->db->query("SELECT gambar FROM m_soal WHERE id = '".$uri4."'")->row();
			$this->db->query("DELETE FROM m_soal WHERE id = '".$uri4."'");
			@unlink("./upload/gambar_soal/".$nama_gambar->gambar);
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "cetak") {
			$html = "<link href='".base_url()."___/css/style_print.css' rel='stylesheet' media='' type='text/css'/>";

			if ($a['sess_level'] == "admin") {
				$data = $this->db->query("SELECT * FROM m_soal WHERE id_mapel = '$uri4'")->result();
			} else {
				$data = $this->db->query("SELECT * FROM m_soal WHERE id_guru = '".$a['sess_konid']."' AND id_mapel = '$uri4'")->result();
			}
			$mapel = $this->db->query("SELECT nama FROM m_mapel WHERE id = '".$uri4."'")->row();

			if (!empty($data)) {
				$html .= "<h3>Mata Pelajaran : ".$mapel->nama."</h3><hr style='border: solid 1px #000'>";
				$no = 1;
				$jawaban = array("A","B","C","D","E");
				foreach ($data as $d) {
					if ($d->gambar == "") {
		                $html .= '<table>
		                <tr><td style="v-align: top">'.$no.'</td><td colspan="2"><b>'.$d->soal.'</b></td></tr>';
		                for ($j=0; $j<sizeof($jawaban);$j++) {
		                  $kecil_jawaban = strtolower($jawaban[$j]);
		                  $opsyen = "opsi_".$kecil_jawaban;
		                  $opsyens = $d->$opsyen;

		                  if ($jawaban[$j] == $d->jawaban) {
		                    $html .= '<tr><td width="2%">'.$jawaban[$j].'</td><td><label for="opsi_'.$jawaban[$j].'_'.$d->id.'">'.$opsyens.'</label></td></label></tr>';
		                  } else {
		                    $html .= '<tr><td width="2%">'.$jawaban[$j].'</td><td><label for="opsi_'.$jawaban[$j].'_'.$d->id.'">'.$opsyens.'</label></td></label></tr>';
		                  }
		                }
		                $html .= '</table></div>';
		            } else {
		                $html .= '<table>
		                <tr><td rowspan="6" width="10%"><img src="'.base_url().'upload/gambar_soal/'.$d->gambar.'" class="polaroid" style="width: 100px; height: 75px"></td>
		                <td style="v-align: top">'.$no.'</td><td colspan="1"><b>'.$d->soal.'</b></td></tr>';
		                for ($j=0; $j<sizeof($jawaban);$j++) {
		                  $kecil_jawaban = strtolower($jawaban[$j]);
		                  $opsyen = "opsi_".$kecil_jawaban;
		                  $opsyens = $d->$opsyen;

		                  if ($jawaban[$j] == $d->jawaban) {
		                    $html .= '<tr><td width="2%">'.$jawaban[$j].'</td><td><label for="opsi_'.$jawaban[$j].'_'.$d->id.'">'.$opsyens.'</label></td></label></tr>';
		                  } else {
		                    $html .= '<tr><td width="2%">'.$jawaban[$j].'</td><td><label for="opsi_'.$jawaban[$j].'_'.$d->id.'">'.$opsyens.'</label></td></label></tr>';
		                  }
		                }
		                $html .= '</table></div>';
		            }
		            $no++;
				}
			} else {
				$html .= "belum ada data";
			}

			echo $html;
			exit();

		} else {
			$a['p']	= "m_soal";
		}

		$this->load->view('aaa', $a);
	}

	public function m_ujian() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();

		$a['data'] = $this->db->query("SELECT tr_guru_tes.*, m_mapel.nama AS mapel FROM tr_guru_tes INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id WHERE tr_guru_tes.id_guru = '".$a['sess_konid']."'")->result();
		$a['p_mapel'] = obj_to_array($this->db->query("SELECT * FROM m_mapel WHERE id IN (SELECT id_mapel FROM tr_guru_mapel WHERE id_guru = '".$a['sess_konid']."')")->result(), "id,nama");
		
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM tr_guru_tes WHERE id = '$uri4'")->row();
			$this->j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE tr_guru_tes SET id_mapel = '".bersih($p,"mapel")."', 
								nama_ujian = '".bersih($p,"nama_ujian")."', jumlah_soal = '".bersih($p,"jumlah_soal")."', 
								waktu = '".bersih($p,"waktu")."'
								WHERE id = '".bersih($p,"id")."'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO tr_guru_tes VALUES (null, '".$a['sess_konid']."', '".bersih($p,"mapel")."',
								'".bersih($p,"nama_ujian")."', '".bersih($p,"jumlah_soal")."', '".bersih($p,"waktu")."', 
								'acak', '')");
			}
			
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM tr_guru_tes WHERE id = '".$uri4."'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "jumlah_soal") {
			$ambil_data = $this->db->query("SELECT id FROM m_soal WHERE id_mapel = '$uri4' AND id_guru = '".$a['sess_konid']."'")->num_rows();
			$ret_arr['jumlah'] = $ambil_data;
			$this->j($ret_arr);
			exit();			
		} else {
			$a['p']	= "m_guru_tes";
		}

		$this->load->view('aaa', $a);
	}

	public function h_ujian() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();

		$wh_1 = $a['sess_level'] == "admin" ? "SELECT tr_guru_tes.*, m_mapel.nama AS mapel, m_guru.nama AS nama_guru FROM tr_guru_tes INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id INNER JOIN m_guru ON tr_guru_tes.id_guru = m_guru.id" : "SELECT tr_guru_tes.*, m_mapel.nama AS mapel, m_guru.nama AS nama_guru FROM tr_guru_tes INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id INNER JOIN m_guru ON tr_guru_tes.id_guru = m_guru.id WHERE tr_guru_tes.id_guru = '".$a['sess_konid']."'";


		$a['data'] = $this->db->query($wh_1)->result();
		$a['p_mapel'] = obj_to_array($this->db->query("SELECT * FROM m_mapel")->result(), "id,nama");

		if ($uri3 == "det") {
			$a['detil_tes'] = $this->db->query("SELECT m_mapel.nama AS namaMapel, m_guru.nama AS nama_guru, 
												tr_guru_tes.* 
												FROM tr_guru_tes 
												INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id
												INNER JOIN m_guru ON tr_guru_tes.id_guru = m_guru.id
												WHERE tr_guru_tes.id = '$uri4'")->row();
			$a['statistik'] = $this->db->query("SELECT MAX(nilai) AS max_, MIN(nilai) AS min_, AVG(nilai) AS avg_ 
											FROM tr_ikut_ujian
											WHERE tr_ikut_ujian.id_tes = '$uri4'")->row();

			$a['hasil'] = $this->db->query("SELECT m_siswa.nama, tr_ikut_ujian.nilai, tr_ikut_ujian.jml_benar, tr_ikut_ujian.nilai_bobot
											FROM tr_ikut_ujian
											INNER JOIN m_siswa ON tr_ikut_ujian.id_user = m_siswa.id
											WHERE tr_ikut_ujian.id_tes = '$uri4'")->result();
			$a['p'] = "m_guru_tes_hasil_detil";
			//echo $this->db->last_query();
		} else {
			$a['p']	= "m_guru_tes_hasil";
		}

		$this->load->view('aaa', $a);
	}

	public function hasil_ujian_cetak() {
		$this->cek_aktif();
		
		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		$a['detil_tes'] = $this->db->query("SELECT m_mapel.nama AS namaMapel, m_guru.nama AS nama_guru, 
												tr_guru_tes.* 
												FROM tr_guru_tes 
												INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id
												INNER JOIN m_guru ON tr_guru_tes.id_guru = m_guru.id
												WHERE tr_guru_tes.id = '$uri3'")->row();
		
		$a['statistik'] = $this->db->query("SELECT MAX(nilai) AS max_, MIN(nilai) AS min_, AVG(nilai) AS avg_ 
										FROM tr_ikut_ujian
										WHERE tr_ikut_ujian.id_tes = '$uri3'")->row();

		$a['hasil'] = $this->db->query("SELECT m_siswa.nama, tr_ikut_ujian.nilai, tr_ikut_ujian.jml_benar, tr_ikut_ujian.nilai_bobot
										FROM tr_ikut_ujian
										INNER JOIN m_siswa ON tr_ikut_ujian.id_user = m_siswa.id
										WHERE tr_ikut_ujian.id_tes = '$uri3'")->result();
		$this->load->view("m_guru_tes_hasil_detil_cetak", $a);
	}

	/* == SISWA == */
	public function ikuti_ujian() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();

		$a['data'] = $this->db->query("SELECT tr_guru_tes.*, m_mapel.nama AS mapel,
										(SELECT COUNT(id) FROM tr_ikut_ujian WHERE tr_ikut_ujian.id_user = ".$a['sess_konid']." AND tr_ikut_ujian.id_tes = tr_guru_tes.id) AS sudah_ikut,
										(SELECT nilai FROM tr_ikut_ujian WHERE tr_ikut_ujian.id_user = ".$a['sess_konid']." AND tr_ikut_ujian.id_tes = tr_guru_tes.id) AS nilai
										FROM tr_guru_tes
										INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id
										WHERE id_mapel IN (SELECT id_mapel FROM tr_siswa_mapel WHERE id_siswa = ".$a['sess_konid'].")
										ORDER BY tr_guru_tes.id ASC")->result();
		//echo $this->db->last_query();
		$a['p']	= "m_ikut_ujian";
		$this->load->view('aaa', $a);
	}

	public function ikut_ujian() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		$a['detil_user'] = $this->db->query("SELECT * FROM m_siswa WHERE id = '".$a['sess_konid']."'")->row();

		if ($uri3 == "simpan_satu") {
			$p			= json_decode(file_get_contents('php://input'));
			
			$update_ 	= "";
			for ($i = 1; $i < $p->jml_soal; $i++) {
				$_tjawab 	= "opsi_".$i;
				$_tidsoal 	= "id_soal_".$i;

				$jawaban_ 	= empty($p->$_tjawab) ? "" : $p->$_tjawab;

				$update_	.= "".$p->$_tidsoal.":".$jawaban_.",";
			}
			$update_		= substr($update_, 0, -1);


			$this->db->query("UPDATE tr_ikut_ujian SET list_jawaban = '".$update_."' WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'");
			echo $this->db->last_query();
			exit;			
		} else if ($uri3 == "simpan_akhir") {
			$p			= json_decode(file_get_contents('php://input'));
			
			$jumlah_soal = $p->jml_soal;
			$jumlah_benar = 0;
			$jumlah_bobot = 0;
			$update_ = "";

			for ($i = 1; $i < $p->jml_soal; $i++) {
				$_tjawab 	= "opsi_".$i;
				$_tidsoal 	= "id_soal_".$i;

				$jawaban_ 	= empty($p->$_tjawab) ? "" : $p->$_tjawab;

				$cek_jwb 	= $this->db->query("SELECT bobot, jawaban FROM m_soal WHERE id = '".$p->$_tidsoal."'")->row();
				if ($cek_jwb->jawaban == $jawaban_) {
					$jumlah_benar++;
					$jumlah_bobot += $cek_jwb->bobot;
				}
				$update_	.= "".$p->$_tidsoal.":".$jawaban_.",";
			}
			$update_		= substr($update_, 0, -1);

			$nilai = ($jumlah_benar/($jumlah_soal-1)) * 100;
			$this->db->query("UPDATE tr_ikut_ujian SET jml_benar = ".$jumlah_benar.", nilai_bobot = ".$jumlah_bobot.", nilai = '".$nilai."', list_jawaban = '".$update_."', status = 'N' WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'");
			$a['status'] = "ok";
			$this->j($a);
			exit;		
		} else {
			$cek_sdh_selesai= $this->db->query("SELECT id FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."' AND status = 'N'")->num_rows();
			//sekalian validasi waktu sudah berlalu...

			if ($cek_sdh_selesai < 1) {
				//ambil detil soal
				$cek_detil_tes = $this->db->query("SELECT * FROM tr_guru_tes WHERE id = '$uri4'")->row();

				$q_cek_sdh_ujian= $this->db->query("SELECT id FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'");
				$d_cek_sdh_ujian= $q_cek_sdh_ujian->row();
				$cek_sdh_ujian	= $q_cek_sdh_ujian->num_rows();

				if ($cek_sdh_ujian < 1)	{		
					$soal_urut_ok = array();
					$q_soal			= $this->db->query("SELECT id, gambar, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e, '' AS jawaban FROM m_soal WHERE id_mapel = '".$cek_detil_tes->id_mapel."' ORDER BY RAND() LIMIT ".$cek_detil_tes->jumlah_soal)->result();
					$i = 0;
					foreach ($q_soal as $s) {
						$soal_per = new stdClass();
						$soal_per->id = $s->id;
						$soal_per->soal = $s->soal;
						$soal_per->gambar = $s->gambar;
						$soal_per->opsi_a = $s->opsi_a;
						$soal_per->opsi_b = $s->opsi_b;
						$soal_per->opsi_c = $s->opsi_c;
						$soal_per->opsi_d = $s->opsi_d;
						$soal_per->opsi_e = $s->opsi_e;
						$soal_per->jawaban = $s->jawaban;

						$soal_urut_ok[$i] = $soal_per;
						$i++;
					}
					$soal_urut_ok = $soal_urut_ok;

					$list_id_soal	= "";
					$list_jw_soal 	= "";
					if (!empty($q_soal)) {
						foreach ($q_soal as $d) {
							$list_id_soal .= $d->id.",";
							$list_jw_soal .= $d->id.":,";
						}
					}
					$list_id_soal = substr($list_id_soal, 0, -1);
					$list_jw_soal = substr($list_jw_soal, 0, -1);
					$waktu_selesai = tambah_jam_sql($cek_detil_tes->waktu);

					$this->db->query("INSERT INTO tr_ikut_ujian VALUES (null, '$uri4', '".$a['sess_konid']."', '$list_id_soal', '$list_jw_soal', 0, 0, 0, NOW(), ADDTIME(NOW(), '$waktu_selesai'), 'Y')");
					
					$a['detil_soal'] = $this->db->query("SELECT tr_guru_tes.*, m_guru.nama AS namaGuru, m_mapel.nama AS namaMapel 
														FROM tr_guru_tes 
														INNER JOIN m_guru ON tr_guru_tes.id_guru = m_guru.id
														INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id
														WHERE tr_guru_tes.id = '$uri4'")->row();

					$a['detiltes'] = $this->db->query("SELECT * FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'")->row();
					$a['data']= $soal_urut_ok;
				} else {
					$q_ambil_soal 	= $this->db->query("SELECT * FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'")->row();
					$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);

					$soal_urut_ok	= array();

					for ($i = 0; $i < sizeof($urut_soal); $i++) {
						$pc_urut_soal = explode(":",$urut_soal[$i]);
						$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'".$pc_urut_soal[1]."'";

						$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal WHERE id = '".$pc_urut_soal[0]."'")->row();
						$soal_urut_ok[] = $ambil_soal; 
					}

					$a['detil_soal'] = $this->db->query("SELECT tr_guru_tes.*, m_guru.nama AS namaGuru, m_mapel.nama AS namaMapel 
														FROM tr_guru_tes 
														INNER JOIN m_guru ON tr_guru_tes.id_guru = m_guru.id
														INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id
														WHERE tr_guru_tes.id = '$uri4'")->row();
					//$soal_urut_ok = $this->db->query("SELECT * FROM m_soal ORDER BY RAND()")->result();
					$a['detiltes'] = $q_ambil_soal;
					$a['data'] = $soal_urut_ok;
				}
			} else {
				redirect('adm/sudah_selesai_ujian/'.$uri4);
			}
			//echo var_dump($a); 
			$this->load->view('aaa_ikut_ujian', $a);
		}
	}

	public function jvs() {
		$this->cek_aktif();
		
		$data_soal 		= $this->db->query("SELECT id, gambar, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal ORDER BY RAND()")->result();
		
		$this->j($data_soal);
		exit;
	}

	public function rubah_password() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_admin_id'] = $this->session->userdata('admin_id');
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		$ret = array();
		if ($uri3 == "simpan") {
			$p1_md5 = md5($p->p1);
			$p2_md5 = md5($p->p2);
			$p3_md5 = md5($p->p3);

			$cek_pass_lama = $this->db->query("SELECT password FROM m_admin WHERE id = '".$a['sess_admin_id']."'")->row();

			if ($cek_pass_lama->password != $p1_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password lama tidak sama...";
			} else if ($p2_md5 != $p3_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru konfirmasinya tidak sama...";
			} else if (strlen($p->p2) < 6) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru minimal terdiri dari 6 huruf..";
 			} else {
				$this->db->query("UPDATE m_admin SET password = '".$p3_md5."' WHERE id = '".$a['sess_admin_id']."'");
				$ret['status'] = "ok";
				$ret['msg'] = "Password berhasil diubah...";
			}
			$this->j($ret);
			exit;
		} else {
			$data = $this->db->query("SELECT id, kon_id, level, username FROM m_admin WHERE id = '".$a['sess_admin_id']."'")->row();
			$this->j($data);
			exit;
		}
	}

	public function sudah_selesai_ujian() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		
		$q_nilai = $this->db->query("SELECT nilai, tgl_selesai FROM tr_ikut_ujian WHERE id_tes = $uri3 AND id_user = '".$a['sess_konid']."' AND status = 'N'")->row();
		if (empty($q_nilai)) {
			redirect('adm/ikut_ujian/_/'.$uri3);
		} else {
			$a['p'] = "v_selesai_ujian";
			$a['data'] = "<div class='alert alert-danger'>Anda telah selesai mengikuti ujian ini pada : <strong style='font-size: 16px'>".tjs($q_nilai->tgl_selesai, "l")."</strong>, dan mendapatkan nilai : <strong style='font-size: 16px'>".$q_nilai->nilai."</strong></div>";
		}

		$this->load->view('aaa', $a);
	}


	/* Login Logout */

	public function login() {
		$this->load->view('aaa_login');
	}
	
	public function act_login() {
		
		$username	= $this->bersih($_POST['username']);
		$password	= $this->bersih($_POST['password']);
		
		$password2	= md5($password);
		
		$q_data		= $this->db->query("SELECT * FROM m_admin WHERE username = '".$username."' AND password = '$password2'");
		$j_data		= $q_data->num_rows();
		$a_data		= $q_data->row();
		
		$_log		= array();
		if ($j_data === 1) {

			$sess_nama_user = "";

			if ($a_data->level == "siswa") {
				$det_user = $this->db->query("SELECT nama FROM m_siswa WHERE id = '".$a_data->kon_id."'")->row();
				if (!empty($det_user)) {
					$sess_nama_user = $det_user->nama;
				}
			} else if ($a_data->level == "guru") {
				$det_user = $this->db->query("SELECT nama FROM m_guru WHERE id = '".$a_data->kon_id."'")->row();
				if (!empty($det_user)) {
					$sess_nama_user = $det_user->nama;
				}
			} else {
				$sess_nama_user = "Administrator Pusat";
			}

			$data = array(
                    'admin_id' => $a_data->id,
                    'admin_user' => $a_data->username,
                    'admin_level' => $a_data->level,
                    'admin_konid' => $a_data->kon_id,
                    'admin_nama' => $sess_nama_user,
					'admin_valid' => true
                    );
            $this->session->set_userdata($data);
			$_log['log']['status']			= "1";
			$_log['log']['keterangan']		= "Login berhasil";
			$_log['log']['detil_admin']		= $this->session->userdata;
		} else {
			$_log['log']['status']			= "0";
			$_log['log']['keterangan']		= "Maaf, username dan password tidak ditemukan";
			$_log['log']['detil_admin']		= null;
		}
		
		$this->j($_log);
	}
	
	public function logout() {
		$data = array(
                    'admin_id' 		=> "",
                    'admin_user' 	=> "",
                    'admin_level' 	=> "",
                    'admin_konid' 	=> "",
                    'admin_nama' 	=> "",
					'admin_valid' 	=> false
                    );
        $this->session->set_userdata($data);
		redirect('adm');
	}


	//fungsi tambahan
	public function get_akhir($tabel, $field, $kode_awal, $pad) {
		$get_akhir	= $this->db->query("SELECT MAX($field) AS max FROM $tabel LIMIT 1")->row();
		$data		= (intval($get_akhir->max)) + 1;
		$last		= $kode_awal.str_pad($data, $pad, '0', STR_PAD_LEFT);
	
		return $last;
	}

	
	public function bersih($teks) {
		return mysql_real_escape_string($teks);
	}
	
	public function j($data) {
		header('Content-Type: application/json');
		echo json_encode($data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */