<?php
defined('BASEPATH') OR exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_admin');
        $this->load->model('m_api');
        $this->load->library('bcrypt');
        date_default_timezone_set("Asia/Jakarta");
    }

	
	public function index()
	{
		redirect(site_url().'/admin/dashboard');
	}

	public function dashboard(){
		$data['set'] = "dashboard";
		$data['face'] = $this->m_admin->get_face_all();

		$today = strtotime("today");
		$tomorrow = strtotime("tomorrow");

		$data['logdata'] = $this->m_admin->get_log($today,$tomorrow);

		$this->load->view('v_dashboard', $data);
	}


	public function face_id(){

		$data['set'] = "list";
		$data['face'] = $this->m_admin->get_face_all();	

		$this->load->view('v_face_id', $data);

	}


	public function edit_face($id=null){
		if (isset($id)) {
			$face = $this->m_admin->get_face_byid($id);
			if (isset($face)) {
				foreach ($face as $key => $value) {
					//print_r($value);
					$data['id_face_table'] = $value->id_face_table;
					$data['nama'] = $value->nama;
					$data['face_id'] = $value->face_id;
					$data['jabatan'] = $value->jabatan;
					$data['alamat'] = $value->alamat;
					$data['telp'] = $value->telp;
				}
				$data['set'] = "edit-face";
				$this->load->view('v_face_id', $data);
			}else{
				redirect(site_url().'/admin/dashboard');
			}
		}
	}

	public function save_edit_face(){
		if (isset($_POST['id_face_table']) && isset($_POST['nama'])) {
			$id = $this->input->post('id_face_table');
			$nama = $this->input->post('nama');
			$jabatan = $this->input->post('jabatan');
			$telp = $this->input->post('telp');
			$alamat = $this->input->post('alamat');

			$data = array('nama' => $nama,
							'telp' => $telp,
							'jabatan' => $jabatan,
							'alamat' => $alamat,
		 				);
			//echo $id;
			//print_r($data);

			if ($this->m_admin->updateFace($id,$data)) {
				$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di update</div>");
			}else{
				$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di update</div>");
			}
			redirect(site_url().'/admin/face_id');
		}else{
			redirect(site_url().'/admin/dashboard');
		}
	}

	public function hapus_face($id=null){

		if (isset($id)) {
			$del_fp = array('del_face_id' => 1);
			if ($this->m_admin->del_face_id($id,$del_fp)) {
				$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data Face ID di hapus (menuggu train data user)</div>");
			}
		}
		redirect(site_url().'/admin/face_id');

	}

	public function log(){
			$today = strtotime("today");
			$tomorrow = strtotime("tomorrow");

			$data['set'] = "log";

			$data['log'] = $this->m_admin->get_log($today,$tomorrow);

			$this->load->view('v_log', $data);

	}

	public function lastlog(){
			if (isset($_POST['tanggal'])) {
				$tgl = $this->input->post('tanggal');
				//echo $tgl;
				$split1 = explode("-", $tgl);
				$x = 0;
				foreach ($split1 as $key => $value) {
					$date[$x] = $value;
					$x++;
				}

				$ts1 = strtotime($date[0]);
				$ts2 = strtotime($date[1]);

				$tgl1 = date("d-M-Y",$ts1);
				$tgl2 = date("d-M-Y",$ts2);

				$ts2 += 86400;	// tambah 1 hari (hitungan detik)

				// $data['tgl1'] = $tgl1;
				// $data['tgl2'] = $tgl2;

				if ($x==2) {		
					$data['log'] = $this->m_admin->get_log($ts1,$ts2);
					$data['tanggal'] = $tgl1 . " - " . $tgl2;
					$data['waktuabsensi'] = $tgl1 . "_" . $tgl2;

					$data['set'] = "last-log";
					$this->load->view('v_log', $data);
				}else{
					redirect(site_url().'/admin/log');
				}				
			}else{
				redirect(site_url().'/admin/log');
			}
	}


	public function export2excel(){
			if (isset($_GET['tanggal'])) {
				$tanggal = $this->input->get('tanggal');
				//echo $tanggal;

				$split = explode("_", $tanggal);
				$x = 0;
				foreach ($split as $key => $value) {
					$date[$x] = $value;
					$x++;
				}

				$ts1 = strtotime($date[0]);
				$ts2 = strtotime($date[1]);

				$ts2 += 86400;	// tambah 1 hari (hitungan detik)

				$dataPresensi = $this->m_admin->get_log($ts1,$ts2);

				$spreadsheet = new Spreadsheet;

				$baris = 1;

				$spreadsheet->setActiveSheetIndex(0)
				          ->setCellValue('A1', 'No')
				          ->setCellValue('B1', 'Nama')
				          ->setCellValue('C1', 'Jabatan')
				          ->setCellValue('D1', 'Waktu')
				          ->setCellValue('E1', 'Suhu')
				          ->setCellValue('F1', 'Masker')
				          ->setCellValue('G1', 'Presensi');

				$baris++;
				$nomor = 1;
				
				if (isset($dataPresensi)){
					foreach($dataPresensi as $values) {

						$tgl = date("d M Y / H:i:s", $values->log_masuk);

						$spreadsheet->setActiveSheetIndex(0)
								   ->setCellValue('A' . $baris, $nomor)
								   ->setCellValue('B' . $baris, $values->nama)
								   ->setCellValue('C' . $baris, $values->jabatan)
								   ->setCellValue('D' . $baris, $tgl)
								   ->setCellValue('E' . $baris, $values->suhu."C")
								   ->setCellValue('F' . $baris, $values->masker)
								   ->setCellValue('G' . $baris, $values->presensi);

					   $baris++;
					   $nomor++;

					}
				}
				
				$writer = new Xlsx($spreadsheet);

				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="Log'.$tanggal.'.xlsx"');
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
			}else{
				redirect(site_url().'/admin/log');
			}
				
    }

    public function setting()
	{

		$data['set'] = "setting";
		$data['waktuoperasional'] = $this->m_admin->waktuoperasional();
		$this->load->view('v_setting', $data);

	}

	public function setwaktuoperasional(){
			if (isset($_POST['waktu_masuk_1']) && isset($_POST['waktu_masuk_2'])) {
				$waktu_masuk_1 = $this->input->post('waktu_masuk_1');
				$waktu_masuk_2 = $this->input->post('waktu_masuk_2');

				if (strlen($waktu_masuk_1) == 5 && strlen($waktu_masuk_2) == 5){
					$datamasuk = array('waktu_operasional' => $waktu_masuk_1."-".$waktu_masuk_2);

					if ($this->m_admin->updateWaktuOperasional(1,$datamasuk)) {
						$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di update</div>");
					}else{
						$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di update</div>");
					}

				}else{
					$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Salah format waktu, contoh 07:00</div>");
				}
				redirect(site_url().'/admin/setting');
			}
	}
	
}