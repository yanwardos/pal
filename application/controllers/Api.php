<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_admin');
        $this->load->model('m_api');
        date_default_timezone_set("Asia/Jakarta");
    }

	public function index()
	{
		$notif = array('status' => 'test', 'ket' => 'REST API for Device');
		echo json_encode($notif);
	}


	// menambahkan user baru
	public function addfaceid(){											// check apakah ada face id baru yang di input
		$nama = $this->input->post('nama');
		$face_id = $this->input->post('face_id');
		$jabatan = $this->input->post('jabatan');
		$alamat = $this->input->post('alamat');
		$hp = $this->input->post('hp');

		$data = array('nama' => $nama,
						'face_id' => $face_id,
						'jabatan' => $jabatan,
						'alamat' => $alamat,
						'telp' => $hp );

		$add = $this->m_admin->add_face_id($data);

		$notif = array('status' => 'success', 'ket' => 'berhasil');
		Header('Content-Type: application/json');
		echo json_encode($notif);
	}

	//menghapus user
	public function delfaceid(){														// check apakah da face id yang akan d hapus

		$face_id = 0;
		$id_face_table = 0;
		$nama = "";
		$image_name = "";
		$del = $this->m_api->getFIDdelete();
		if (isset($del)) {
			foreach ($del as $key => $value) {
				$face_id = $value->face_id;
				$id_face_table = $value->id_face_table;
				$nama = $value->nama;
			}
		}
		if ($face_id > 0) {
			$notif = array('status' => "DEL", 'ket' => 'Hapus Face ID', 'nama' => $nama, 'face_id' => $face_id);
			Header('Content-Type: application/json');
			echo json_encode($notif);
		}else{
			$notif = array('status' => '-', 'ket' => '-');
			Header('Content-Type: application/json');
			echo json_encode($notif);
		}
	}

	public function confirm(){													// konfirmasi penghapusan face id pada web
		if (isset($_POST['confirm_del'])) {

			$id = $this->input->post('confirm_del');
			$del = $this->m_api->getFIDdelete_by_face_id($id);

			$face_id = 0;
			$id_face_table = 0;
			$nama = "";

			if (isset($del)) {
				foreach ($del as $key => $value) {
					$face_id = $value->face_id;
					$id_face_table = $value->id_face_table;
					$nama = $value->nama;
				}
			}

			if ($face_id == $id) {
				$this->m_api->del_face_by_id_face_table($id_face_table);
				$this->m_api->del_log_by_id_face_table($id_face_table);

				$notif = array('status' => 'DEL', 'ket' => 'Confirm DEL Face ID', 'nama' => $nama, 'face_id' => $face_id);
				Header('Content-Type: application/json');
				echo json_encode($notif);
			}else{
				$notif = array('status' => '-', 'ket' => '-');
				Header('Content-Type: application/json');
				echo json_encode($notif);
			}
		}
	}


	// input log presensi
	public function presensi(){
		if (isset($_POST['face_id']) && isset($_POST['suhu']) && isset($_POST['mask'])) {			// cek variable data yang di kirim
			$faceid = $this->input->post('face_id');
			$suhu = $this->input->post('suhu');						// input dalam variable
			$masker = $this->input->post('mask');

			$cekface = $this->m_api->checkface($faceid);			// cek id wajah apakah terdaftar
			$countface = 0;
			$face_id = 0;
			$id_face_table = 0;
			$nama = "";
			$waktux = Date("H:i:s d-M-Y",time());

			if (isset($cekface)) {									// cek id wajah apakah terdaftar
				foreach ($cekface as $key => $value) {
					$countface++;
					$face_id = $value->face_id;
					$id_face_table = $value->id_face_table;
					$nama = $value->nama;
				}
			}

			if ($countface > 0) {									// bila id wajah terdaftar
				$waktu = $this->m_api->waktuoperasional();

				foreach ($waktu as $key => $value) {				// mengambil setting waktu masuk
					$masuk = $value->waktu_operasional;
				}

				$masuk = explode("-", $masuk);

				$masuk1 = strtotime($masuk[0]);
				$masuk2 = strtotime($masuk[1]);

				$today = strtotime("today");
				$tomorrow = strtotime("tomorrow");

				$checkStatusAbsensi = $this->m_api->get_absensi_by_employee_today($id_face_table,$today);		// check presensi masuk hari ini

				$id_log = 0;
				if (isset($checkStatusAbsensi)) {
					foreach ($checkStatusAbsensi as $key => $value) {
						$id_log = $value->id_log;
					}
				}

				if ($id_log > 0) {						// bila sudah presensi hari ini
					if (time() > $masuk2) {						// bila lebih dari waktu masuk akhir
						$stat = 'warning';
					}else{										// bila tepat waktu
						$stat = 'success';
					}
					$notif = array('status' => $stat, 'nama' => $nama, 'ket' => 'sudah presensi masuk');
					Header('Content-Type: application/json');
					echo json_encode($notif);
				}else{									// bila belum presensi hari ini maka input presensi

					if (time() >= $masuk1) {			// check waktu masuk awal absensi
						
						if (time() > $masuk2) {						// bila lebih dari waktu masuk akhir
							$ketPresensi = 'Presensi Terlambat';
							$stat = 'warning';
						}else{										// bila tepat waktu
							$ketPresensi = 'Berhasil';
							$stat = 'success';
						}

						$data = array('id_face_table' => $id_face_table, 'suhu' => $suhu, 'masker' => $masker,
										'log_masuk' => time(), 'presensi' => $ketPresensi);

						if ($this->m_api->insert_presensi($data)) {
							$notif = array('status' => $stat, 'nama' => $nama, 'waktu' => $waktux, 'ket' => $ketPresensi);
							Header('Content-Type: application/json');
							echo json_encode($notif);															// tampilkan / kirim data success ke raspi
						}else{
							$notif = array('status' => 'error', 'ket' => 'gagal insert presensi');
							Header('Content-Type: application/json');
							echo json_encode($notif);
						}
					}else{
						$notif = array('status' => 'error', 'ket' => 'belum masuk waktu presensi');
						Header('Content-Type: application/json');
						echo json_encode($notif);
					}
				}
			}else{
				$notif = array('status' => 'failed', 'ket' => 'face ID tidak ada');
				Header('Content-Type: application/json');
				echo json_encode($notif);
			}
		}else{
			$notif = array('status' => 'error', 'ket' => 'salah param');
			Header('Content-Type: application/json');
			echo json_encode($notif);
		}
	}


	public function listfaceid(){							// mendapatkan semua data id wajah untuk recognize raspi

		$listFace = $this->m_api->getFID();
		$FaceID = [];
		$namaID = [];
		$s = 0;
		if (isset($listFace)) {
			foreach ($listFace as $key => $value) {
				$FaceID[$s] = $value->face_id;
				$namaID[$s] = $value->nama;
				$s++;
			}
		}

		$dataList = array('id' => $FaceID, 'nama' => $namaID);
		Header('Content-Type: application/json');
		echo json_encode($dataList);
				
	}

}
