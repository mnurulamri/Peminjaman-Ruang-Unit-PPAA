<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ruang extends CI_Controller 
{
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('service');
		$this->load->model('ppaa/model');
		date_default_timezone_set('Asia/Jakarta');

	}

	/*public function sessionUser()
	{
		$this->session->userdata['logged_in']['username'] = 'mnurulamri';
		$this->session->userdata['logged_in']['hak_akses'] = 1;		
	}*/	

	public function template()
	{
		//$this->sessionUser();
		$data['userlogin'] 	= ($this->session->userdata['logged_in']['username']);
		$data['hakakses'] 	= ($this->session->userdata['logged_in']['hak_akses']);
		$data['foto'] 		= $this->service->getFoto($this->session->userdata['logged_in']['username']);
		$data['nama'] 		= $this->service->getNama($this->session->userdata['logged_in']['username']);
		$data['menu'] 		= $this->load->view('ppaa/menu', $data, true);
		$data['script']		= $this->load->view('ppaa/script', null, true);
		return $data;
	}

	public function index()
	{	
		$data = $this->template();
		$data['term_berjalan'] = $this->session->userdata['term_berjalan'];
		$data['content'] 	= $this->load->view('ppaa/main', null, true);
		$this->load->view('ppaa/template', $data);
	}

	public function formPeminjaman()
	{
		//$this->sessionUser();
		$tanggal 			= $this->today();
        $nosurat 			= $this->getToken();
		$data['tanggal']	= $tanggal;
		$data['nomor'] 		= $nosurat;
		$data['ruang'] 		= $this->getRuang();
		$data['start_time']	= $this->waktuMulai();
		$data['end_time']	= $this->waktuSelesai();
		$this->load->view('ppaa/formPeminjamanKelas', $data);
	}

	public function simpanData()
	{
		//set variabel
		$tgl_permohonan 	= $this->input->post('tgl_permohonan');
		$tgl_kegiatan 		= $this->input->post('tgl_kegiatan');
		$event_name 		= $this->input->post('nama_kegiatan');
		$prodi 				= $this->input->post('prodi');
		$nama_peminjam 		= $this->input->post('nama_peminjam');
		$id_peminjam 		= $this->input->post('id_peminjam');
		$ruang 				= $this->input->post('ruang');
		$jam_mulai 			= $this->input->post('jam_mulai');
		$menit_mulai 		= $this->input->post('menit_mulai');
		$jam_selesai		= $this->input->post('jam_selesai');
		$menit_selesai 		= $this->input->post('menit_selesai');
		$no_telp 			= $this->input->post('no_telp');
		$email 				= $this->input->post('email');
		$jml_peserta 		= $this->input->post('jml_peserta');
		$nomor 				= 'ppaa'.$this->getToken();

		//set tanggal
		$tgl_kegiatan 	= $this->tanggalToDb($tgl_kegiatan);
		$tgl_permohonan = $this->tanggalToDb($tgl_permohonan);

		$start_date = $tgl_kegiatan.' '.$jam_mulai.":".$menit_mulai;
		$end_date = $tgl_kegiatan.' '.$jam_selesai.":".$menit_selesai;

		//cek jadwal bentrok
		$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                    '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );
		$jadwal_bentrok = $this->model->cekJadwalBentrok( $start_date, $end_date, $ruang);  //untuk data baru

		if ($jadwal_bentrok) {	
			foreach ($jadwal_bentrok as $key => $value) {
				//tentukan jadwal yang bentrok
				$event_name	= $value->event_name;
				$ruang 		= $value->nm_ruang;
				$d 			= date('D', strtotime($value->start_date));
				$waktu_awal = date('H:i', strtotime($value->start_date));
				$waktu_akhir= date('H:i', strtotime($value->end_date));
				$nama_hari 	= $array_hari[$d];
				$tgl 		= $value->tgl;
				$bulan 		= $array_bulan[$value->bulan];
				$tahun 		= $value->tahun;
				$tanggal 	= $tgl.' '.$bulan.' '.$tahun;

				//tampilkan pesan bentrok
				$ket = '<div class="alert alert-warning">Bentrok Dengan Kegiatan '.$event_name.', Hari '.$nama_hari.' Tanggal '.$tanggal.' Jam '.$waktu_awal.'-'.$waktu_akhir.' Ruang '.$ruang.'</div>';
				$pesan = array(
					'flag' => '1',
					'pesan'=> $ket
				);
				echo json_encode($pesan);
			}
		} else {
			//prepare simpan data
			$data_kegiatan = array(			
				'event_name' => $event_name, 
				'prodi' => $prodi,
				'jml_peserta' => $jml_peserta,
				'tgl_permohonan' => $tgl_permohonan,
				'nama_peminjam' => $nama_peminjam, 
				'id_peminjam' => $id_peminjam, 
				'no_telp' => $no_telp, 
				'email' => $email, 
				'status' => 3, 
				'flag' => 1, 
				'nomor' => $nomor, 
				'flag_ppaa' => 1
			);

			$data_jadwal = array(
				'start_date' => $start_date, 
				'end_date' => $end_date, 
				'ruang' => $ruang, 
				'nomor' => $nomor
			);

			//eksekusi simpan data
			$this->model->insertKegiatan($data_kegiatan);
			$this->model->insertJadwal($data_jadwal);

			//tampilkan pesan
			$ket = '<div class="alert alert-success">Data Sudah Disimpan</div>';
			$pesan = array(
				'flag' => '2',
				'pesan'=> $ket
			);
			echo json_encode($pesan);
		}
	}

	public function formEdit()
	{  //menampilkan isian data pada edit form peminjaman
		//$nomor = $this->uri->segment(4);
		$nomor = $this->input->post('nomor');
		$data = $this->model->getDataFormEdit($nomor);
		
		$data_ruang = $this->model->getRuang();
		foreach ($data_ruang as $k => $v) {
			$select_ruang[$v->kd_ruang] = $v->nm_ruang;
		}

		//set array komponen array bulan
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                      '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );

		//set data variabel
		foreach ($data as $k => $v) {
			$event_id 		= $v->event_id;
			$nomor 			= $v->nomor;
			$nama_kegiatan 	= $v->event_name;
			$prodi 			= $v->prodi;
			$jml_peserta	= $v->jml_peserta;
			$ruang 			= $v->kd_ruang;
			$nama_peminjam 	= $v->nama_peminjam;
			$id_peminjam 	= $v->id_peminjam;
			$no_telp 		= $v->no_telp;
			$email 			= $v->email;

			//manipulasi tanggal permohonan
			$hari_permohonan	= $v->hari_permohonan;
			$day_permohonan		= $v->day_permohonan;
			$bulan_permohonan	= $array_bulan[$v->bulan_permohonan];
			$tahun_permohonan	= $v->tahun_permohonan;
			$tgl_permohonan		= $hari_permohonan.', '.$day_permohonan.' '.$bulan_permohonan.' '.$tahun_permohonan;			

			//manipulasi tanggal kegiatan
			$d 			 	= date('D', strtotime($v->start_date));
			$jam_mulai 	 	= date('H', strtotime($v->start_date));
			$menit_mulai 	= date('i', strtotime($v->start_date));
			$jam_selesai 	= date('H', strtotime($v->end_date));
			$menit_selesai 	= date('i', strtotime($v->end_date));
			$hari 			= $v->hari;
			$tgl 		 	= $v->tgl;
			$bulan 		 	= $array_bulan[$v->bulan];
			$tahun		 	= $v->tahun;
			$tgl_kegiatan 	= $hari.', '.$tgl.' '.$bulan.' '.$tahun;
		}			
		
		//untuk ngisi komponen field form edit
		$array = array(
			'event_id' 		=> $event_id,
			'nomor' 		=> $nomor,
			'nama_kegiatan' => $nama_kegiatan,
			'prodi' 		=> $prodi,
			'jml_peserta'	=> $jml_peserta,
			'nama_peminjam' => $nama_peminjam,
			'id_peminjam' 	=> $id_peminjam,
			'no_telp' 		=> $no_telp, 
			'email' 		=> $email, 
			'ruang' 		=> $ruang,
			'select_ruang' 	=> $select_ruang,
			'tgl_permohonan'=> $tgl_permohonan,
			'tgl_kegiatan' 	=> $tgl_kegiatan,
			'jam_mulai' 	=> $jam_mulai,
			'menit_mulai' 	=> $menit_mulai,
			'jam_selesai' 	=> $jam_selesai,
			'menit_selesai' => $menit_selesai
		);

		//print_r($array) ;
		echo json_encode($array);
	}

	public function editData()
	{
		//set variabel
		$event_id			= $this->input->post('event_id');
		$nomor				= $this->input->post('nomor');
		$tgl_permohonan 	= $this->input->post('tgl_permohonan');
		$tgl_kegiatan 		= $this->input->post('tgl_kegiatan');
		$event_name 		= $this->input->post('nama_kegiatan');
		$prodi 				= $this->input->post('prodi');
		$nama_peminjam 		= $this->input->post('nama_peminjam');
		$id_peminjam 		= $this->input->post('id_peminjam');
		$ruang 				= $this->input->post('ruang');
		$jam_mulai 			= $this->input->post('jam_mulai');
		$menit_mulai 		= $this->input->post('menit_mulai');
		$jam_selesai		= $this->input->post('jam_selesai');
		$menit_selesai 		= $this->input->post('menit_selesai');
		$no_telp 			= $this->input->post('no_telp');
		$email 				= $this->input->post('email');
		$jml_peserta 		= $this->input->post('jml_peserta');

		//set tanggal
		$tgl_kegiatan 	= $this->tanggalToDb($tgl_kegiatan);
		$tgl_permohonan = $this->tanggalToDb($tgl_permohonan);

		$start_date = $tgl_kegiatan.' '.$jam_mulai.":".$menit_mulai;
		$end_date = $tgl_kegiatan.' '.$jam_selesai.":".$menit_selesai;

		//cek jadwal bentrok
		$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                    '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );
		$jadwal_bentrok = $this->model->jadwalBentrok($event_id, $start_date, $end_date, $ruang);  //cek bentrok tapi tidak memeriksa dirinya sendiri

		
		if (count($jadwal_bentrok)>0) {			
			foreach ($jadwal_bentrok as $key => $value) {
				//tentukan jadwal yang bentrok
				$event_name	= $value->event_name;
				$ruang 		= $value->nm_ruang;
				$d 			= date('D', strtotime($value->start_date));
				$waktu_awal = date('H:i', strtotime($value->start_date));
				$waktu_akhir= date('H:i', strtotime($value->end_date));
				$nama_hari 	= $array_hari[$d];
				$tgl 		= $value->tgl;
				$bulan 		= $array_bulan[$value->bulan];
				$tahun 		= $value->tahun;
				$tanggal 	= $tgl.' '.$bulan.' '.$tahun;

				//tampilkan pesan bentrok
				$ket = '<div class="alert alert-warning">Bentrok Dengan Kegiatan '.$event_name.', Hari '.$nama_hari.' Tanggal '.$tanggal.' Jam '.$waktu_awal.'-'.$waktu_akhir.' Ruang '.$ruang.'</div>';
				$pesan = array(
					'flag' => '1',
					'pesan'=> $ket
				);
				echo json_encode($pesan);
			}
		} else {
			//prepare simpan data
			$data_kegiatan = array(		
				'event_name' => $event_name, 
				'prodi' => $prodi,
				'jml_peserta' => $jml_peserta,
				'tgl_permohonan' => $tgl_permohonan,
				'nama_peminjam' => $nama_peminjam, 
				'id_peminjam' => $id_peminjam, 
				'no_telp' => $no_telp, 
				'email' => $email, 
				'status' => 3, 
				'flag' => 1, 
				'flag_ppaa' => 1
			);

			$data_jadwal = array(
				'start_date' => $start_date, 
				'end_date' => $end_date, 
				'ruang' => $ruang
			);

			//eksekusi edit data
			$this->model->editKegiatan($data_kegiatan, $nomor);
			$this->model->editJadwal($data_jadwal, $nomor);	

			//tampilkan pesan
			$ket = '<div class="alert alert-success">Data Sudah Disimpan</div>';
			$pesan = array(
				'flag' => '2',
				'pesan'=> $ket
			);
			echo json_encode($pesan);
		}
		
	}

	public function deleteData()
	{  //hapus data peminjaman
		$nomor = $this->input->post('nomor');
		$this->model->deleteData($nomor);
		$data = $this->model->getDataPeminjaman();
		echo '
			<thead><th>No</th><th>Hari, Tanggal</th><th>Waktu</th><th>Nama Mata Kuliah</th><th>Program Studi</th><th>Nama Pemohon</th><th>No. Telepon</th><th>Alamat e-Mail</th><th>Ruang</th><th colspan="2">Action</th>
			</thead
			<tbody>';

			$no = 1;
			foreach ($data as $key => $rows) {
				//manipulasi tanggal
			    $d = date('D', strtotime($rows->start_date));
			    $waktu_awal = date('H:i', strtotime($rows->start_date));
			    $waktu_akhir = date('H:i', strtotime($rows->end_date));
			    $tgl = $rows->tgl;
			    $bulan = $array_bulan[$rows->bulan];
			    $tahun = $rows->tahun;

				echo '
				<tr>
					<td>'.$no.'</td>
					<td>'.$rows->hari.', '.$tgl.' '.$bulan.' '.$tahun.'</td>
					<td>'.date('H:i', strtotime($rows->start_date)).'-'.date('H:i', strtotime($rows->end_date)).'</td>
					<td class="event-name">'.$rows->event_name.'</td>
					<td>'.$rows->prodi.'</td>
					<td>'.$rows->nama_peminjam.'</td>
					<td>'.$rows->no_telp.'</td>
					<td>'.$rows->email.'</td>
					<td>'.$rows->nm_ruang.'</td>
					<td id="'.$rows->nomor.'" class="form-edit" data-toggle="modal" data-target=".bs-example-modal-lg"><a class="fa fa-pencil" plain="true"></a></td>
					<td id="'.$rows->nomor.'" class="del" ><a class="fa fa-times-circle" plain="true"></a></td>
				</tr>
				';
				$no++;
			}
			echo '
			</tbody>';
	}

	public function dataTabel()
	{
		$data = $this->model->getDataPeminjaman();

		//set array komponen array bulan
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                      '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );
		echo'
			<thead><th>No</th><th>Hari, Tanggal</th><th>Waktu</th><th>Nama Mata Kuliah</th><th>Program Studi</th><th>Nama Pemohon</th><th>No. Telepon</th><th>Alamat e-Mail</th><th>Ruang</th><th colspan="2">Action</th>
			</thead
			<tbody>';

			$no = 1;
			foreach ($data as $key => $rows) {
				//manipulasi tanggal
			    $d = date('D', strtotime($rows->start_date));
			    $waktu_awal = date('H:i', strtotime($rows->start_date));
			    $waktu_akhir = date('H:i', strtotime($rows->end_date));
			    $tgl = $rows->tgl;
			    $bulan = $array_bulan[$rows->bulan];
			    $tahun = $rows->tahun;

				echo '
				<tr>
					<td>'.$no.'</td>
					<td>'.$rows->hari.', '.$tgl.' '.$bulan.' '.$tahun.'</td>
					<td>'.date('H:i', strtotime($rows->start_date)).'-'.date('H:i', strtotime($rows->end_date)).'</td>
					<td class="event-name">'.$rows->event_name.'</td>
					<td>'.$rows->prodi.'</td>
					<td>'.$rows->nama_peminjam.'</td>
					<td>'.$rows->no_telp.'</td>
					<td>'.$rows->email.'</td>
					<td>'.$rows->nm_ruang.'</td>
					<td id="'.$rows->nomor.'" class="form-edit" onmouseout="this.style.background=\'#FFF\'; this.style.color=\'#333333\'" onmouseover="this.style.background=\'#336600\'; this.style.color=\'#FFFFFF\'"" data-toggle="modal" data-target=".modal-edit">
						<a class="fa fa-pencil" plain="true"></a>
					</td>
					<td id="'.$rows->nomor.'" class="del" onmouseout="this.style.background=\'#FFF\'; this.style.color=\'#333333\'" onmouseover="this.style.background=\'#FF0000\'; this.style.color=\'#FFFFFF\'""><a class="fa fa-times-circle" plain="true"></a></td>
				</tr>
				';
				$no++;
			}
				echo '
				</tbody>';
	}

	public function dataPeminjaman()
	{
		//$this->sessionUser();
		$data['data'] = $this->model->getDataPeminjaman();
		$this->load->view('ppaa/dataPeminjaman', $data);
	}

    public function cekRuangKosong()
    {
		//$this->sessionUser();
		$this->load->model('peminjaman/schedulerRuangRapatModel');
		$data['nama_ruang'] = $nama_ruang['nm_ruang'] = '1';	 //test
		$this->load->view('ppaa/kalenderKelas', $data);
	}
	
	public function cekRuangNonKelas(){
		$this->load->model('peminjaman/schedulerRuangRapatModel');
		$this->load->view('ppaa/kalenderNonKelas');
	}
	public function formUploadJadwalSiak()
	{
		//$this->sessionUser();
		//$data['data'] = $this->model->getDataPeminjaman();
		$this->load->view('ppaa/upload_jadwal_siak_form');
		echo 'testing';
	}

	public function uploadJadwalSiak()
	{
		//$this->sessionUser();
		error_reporting(E_ALL ^E_NOTICE);
		include_once(APPPATH.'libraries/excel_reader2.php');
		$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
		$jmlBaris = $data -> rowcount(0);
		$dataExcel = array();

		//hapus jadwal siak
		$sql = "DELETE FROM kegiatan where nomor like 'siak%'";
		$result = mysql_query($sql);
		$sql = "DELETE FROM waktu where nomor like 'siak%'";
		$result = mysql_query($sql);

		// nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
		$sukses = 0;
		$gagal = 0;
		$j = 0;

		//prepare insert tabel waktu
		//kode untuk mendapatkan tanggal melalui hari dengan interval tanggal awal dan akhir kuliah
		$tgl_awal = $this->session->userdata['tgl_awal'];
		$pecahTgl = explode("-", $tgl_awal);
		$tgl = $pecahTgl[2];
		$bln = $pecahTgl[1];
		$thn = $pecahTgl[0];
				
		echo '<table border="1" style="border-collapse:collapse; padding:2px; font-size:11px; font-family:tahoma">';

		for($i=2; $i<=$jmlBaris; $i++)
		{
			//if($data->val($i,15,0) != '0' and ($data->val($i,18,0) != 'x') or $data->val($i,18,0) == '0'){
			if($data->val($i,15,0) != '0'){ //jika hari tidak sama dengan 0
				$kd_mk		= $data -> val($i,5,0);
				$kd_kur		= $data -> val($i,6,0);
				$nama_mk	= $data -> val($i,7,0);
				$namaRuang 	= $data -> val($i,13,0);
				$hari 		= $data -> val($i,14,0);
				$start 		= $data -> val($i,15,0);
				$durasi 	= $data -> val($i,17,0);
				$kodeRuang 	= $data -> val($i,18,0);
				$mataKuliah = addslashes($data -> val($i,19,0));
				$prodi		= $data -> val($i,11,0);
				$time		= $data -> val($i,9,0);
				$waktu_arr	= explode(", ",$time);
				$waktu		= $waktu_arr[1];
				$kode		= trim($kd_kur).trim($kd_mk).trim($kelas);
				
				//prepare insert tabel kegiatan
				$event_name = $nama_mk;
				
				//tentukan tanggal melalui hari
				switch ($hari) {
					case 'Senin':
						$tgl_kuliah = date("Y-m-d", mktime(0, 0, 0, $bln, $tgl, $thn));
						break;
					case 'Selasa':
						$tgl_kuliah = date("Y-m-d", mktime(0, 0, 0, $bln, $tgl+1, $thn));
						break;
					case 'Rabu':
						$tgl_kuliah = date("Y-m-d", mktime(0, 0, 0, $bln, $tgl+2, $thn));
						break;
					case 'Kamis':
						$tgl_kuliah = date("Y-m-d", mktime(0, 0, 0, $bln, $tgl+3, $thn));
						break;
					case 'Jumat':
						$tgl_kuliah = date("Y-m-d", mktime(0, 0, 0, $bln, $tgl+4, $thn));
						break;
					case 'Sabtu':
						$tgl_kuliah = date("Y-m-d", mktime(0, 0, 0, $bln, $tgl+5, $thn));
						break;
				}

				$time = explode('-', $waktu);
				$start_time = str_replace('.', ':', trim($time[0]));
				$end_time 	= str_replace('.', ':', trim($time[1]));
				$start_date = $tgl_kuliah.' '.$start_time;
				$end_date 	= $this->session->userdata['tgl_akhir'].' '.$end_time;

				$nomor = 'siak'.$this->getToken();

				//insert tabel kegiatan
				$sql = "INSERT INTO kegiatan (event_name, prodi, nomor, flag_ppaa, status) 
						VALUES ('$mataKuliah', '$prodi', '$nomor', 1, 3)";
				$result = mysql_query($sql) or die (mysql_error());

				//insert tabel waktu
				$sql = "INSERT INTO waktu (ruang, start_date, end_date, nomor) 
						VALUES ('$kodeRuang', '$start_date', '$end_date', '$nomor')";
				$result = mysql_query($sql) or die (mysql_error());

				$percent = intval($i/$jmlBaris * 100)."%";  // Calculate the percentation
				$percentage = intval($i/$jmlBaris * 100);
				
				if ($percentage <= 100)
				{
					/*print '<script language="javascript">
							document.getElementById("progress-bar-percentage").innerHTML="<div style=\"width:\"'.$percentage.'"%></div>"
							document.getElementById("information").innerHTML="'.$j.' row(s) processed."</script>';*/
					#print "$percentage%";
				} 
				else
				{
					#print "<div class=\"spacer\">&nbsp;</div>";
				}

				if ($result){
					$sukses++;
				} else {
					$gagal++;
					echo "<div style='padding-left:10px; vertical-align:middle; font: 11px verdana; border-top:1px solid orange;'>
							<span style='color:blue; width:100px;'>".$namaRuang."</span>
							<span style='color:blue; width:100px;'>".$hari."</span>
							<span style='color:blue; width:100px;'>".$start."</span>
							<span style='color:blue; width:100px;'>".$durasi."</span>
							<span style='color:blue; width:100px;'>".$kodeRuang."</span>
							<span style='color:blue; width:100px;'>".$mataKuliah."</span>
							<span style='color:red; width:100px;'>gagal </span>
							<span></span>
						  </div>";
				}		
				#print "</div>";
				if($kodeRuang<>'x'){
					echo '<tr><td>'.$kodeRuang.'</td><td>'.$namaRuang.'</td><td>'.$hari.', '.$tgl_kuliah.'</td><td>'.$start_time.'-'.$end_time.'</td><td>'.$mataKuliah.'</td></tr>';
				}
			}

			// Javascript for updating the progress bar and information
			/*echo '<script language="javascript">
			document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
			document.getElementById("information").innerHTML="'.$i.' row(s) processed.";
			</script>';*/
			#echo str_repeat(' ',1024*100);// This is for the buffer achieve the minimum size in order to flush data	
			#flush();// Send output to browser immediately	
			#usleep(1);// Sleep one second so we can see the delay
		}

		echo '</table>';

		echo 
			'<p><b>Proses import data selesai<b></br>
			Jumlah data yang sukses diimport : '.$sukses.' records<br>
			Jumlah data yang gagal diimport : '.$gagal.' records</p>';	
	}
	
	public function cekJadwalBentrok()
	{

		$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                    '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );

		$event_id 		= $this->input->post('event_id');
		$ruang 			= $this->input->post('ruang');
		$_tgl_kegiatan 	= $this->input->post('tgl_kegiatan');
		$tgl_kegiatan 	= $this->format_tanggal($_tgl_kegiatan);
		$jam_awal 		= $this->input->post('jam_mulai');
		$menit_awal 	= $this->input->post('menit_mulai');
		$jam_akhir 		= $this->input->post('jam_selesai');
		$menit_akhir 	= $this->input->post('menit_selesai');

		$start_date 	= $tgl_kegiatan.' '.$jam_awal.':'.$menit_awal;
		$end_date 		= $tgl_kegiatan.' '.$jam_akhir.':'.$menit_akhir;

		//tentukan jadwal bentrok berdasarkan data yang sudah masuk sebelumnya dengan data yang baru diinput
		if ($event_id == 0) {
			$jadwal_bentrok = $this->model->cekJadwalBentrok( $start_date, $end_date, $ruang);  //untuk data baru
		} else {
			$jadwal_bentrok = $this->model->jadwalBentrok($event_id, $start_date, $end_date, $ruang);  //untuk data yang sudah ada sebelumnya
		}		
		
		//tampilkan informasi jadwal yang bentrok
		if ($jadwal_bentrok) {			
			foreach ($jadwal_bentrok as $key => $value) {
				//tentukan jadwal yang bentrok
				$event_name	= $value->event_name;
				$ruang 		= $value->nm_ruang;
				$d 			= date('D', strtotime($value->start_date));
				$waktu_awal = date('H:i', strtotime($value->start_date));
				$waktu_akhir= date('H:i', strtotime($value->end_date));
				$nama_hari 	= $array_hari[$d];
				$tgl 		= $value->tgl;
				$bulan 		= $array_bulan[$value->bulan];
				$tahun 		= $value->tahun;
				$tanggal 	= $tgl.' '.$bulan.' '.$tahun;

				//tampilkan pesan bentrok
				echo '
				<div>&nbsp;</div>
				<pre style="text-align:center">Bentrok Dengan Kegiatan '.$event_name.', Hari '.$nama_hari.' Tanggal '.$tanggal.' Jam '.$waktu_awal.'-'.$waktu_akhir.' Ruang '.$ruang.'</pre>';	
			}		
		}
	}

	public function downloadExcel(){
		$this->load->helper('download');
		$filename = 'template_upload_penggunaan_ruang.xls';
		$data = file_get_contents("http://ppf.fisip.ui.ac.id/backend/assets/download/data_test.xls");
		force_download($filename, $data);
	}
	
	public function getToken()
	{
	     $token = "";
	     $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	     $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	     $codeAlphabet.= "0123456789";
	     $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < 20; $i++) {
	        $token .= $codeAlphabet[rand(0, $max-1)];
	    }

	    return $token;
	}

	public function getFieldRuang($nm_ruang='')
	{
		$ruang = $this->model->getRuang();

		$html='<select id="ruang" name="ruang" class="ruang form-control" style="width: 100px">';
		foreach ($ruang as $k => $v) {
			if($v->nm_ruang == $nm_ruang){
				$html.= '<option value="'.$v->kd_ruang.'" selected >'.$v->nm_ruang.'</option>';
			} else {
				$html.= '<option value="'.$v->kd_ruang.'">'.$v->nm_ruang.'</option>';
			}			
		}
		$html.='</select>';
		return $html;
	}

	public function getRuang()
	{  //form select ruang
		$ruang = $this->model->getRuang();

		$html='<select id="ruang" name="ruang" class="ruang form-control pull-right">';
		foreach ($ruang as $k => $v) {
			$html.= '<option value="'.$v->kd_ruang.'">'.$v->nm_ruang.'</option>';
		}
		$html.='</select>';
		return $html;		
	}

	public function tanggalToDb($tgl_kegiatan)
	{
		$bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
		$tgl_array = explode(" ", $tgl_kegiatan);
		$d = $tgl_array[1]; 
		$month = array_search($tgl_array[2], $bulan)+1;
		$m = (strlen($month)==2) ? $month : '0'.$month; 
		$y = $tgl_array[3];
		$tgl = $y."-".$m."-".$d;
		$tgl_kegiatan = $tgl;
		return $tgl;
	}

	public function waktuMulai()
	{
		$jam_mulai = '08';
		$start = '<select name="jam_mulai" id="jam_mulai" class="jam_mulai form-control">';
		for ($i=8; $i<24; $i++) {
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$jam_mulai) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$start.= $option;
		}
		$start.= '</select>';
		$menit_mulai = '00';
		$start.= '<select name="menit_mulai" id="menit_mulai" class="menit_mulai form-control">'; //menit awal
		for ($i=0; $i<61; $i+=5) { 
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$menit_mulai) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$start.= $option;
		}
		$start.= '</select>';
		return $start;
	}

	public function waktuSelesai()
	{
		$end = '<select name="jam_selesai" id="jam_selesai" class="jam_selesai form-control">';
		$jam_akhir = '09';
		for ($i=8; $i<24; $i++) {
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$jam_akhir) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$end.= $option;
		}
		$end.= '</select>';
		$menit_akhir = '00';
		$end.= '<select name="menit_selesai" id="menit_selesai" class="menit_selesai form-control">'; //menit akhir
		for ($i=0; $i<61; $i+=5) { 
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$menit_akhir) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$end.= $option;
		}
		$end.= '</select>';
		return $end;
	}

	public function today()
	{
		//set tanggal
        $d = date('d');
        $m = date('n');
        $y = date('Y');
		//set hari
		$nama_hari = array( '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu' );
		$kd_hari = date("w", mktime(0, 0, 0, $m, $d, $y));
		$hari = $nama_hari[$kd_hari];
		//set bulan
		$nama_bulan = array(' ','Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
		$bulan = $nama_bulan[$m];
        $tanggal = $hari.', '.$d.' '.$bulan.' '.$y;
        return $tanggal;
	}
	
function validasiEmail($email=NULL) {
    return (preg_match("/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/",$email) ? "$email adalah email yang valid" : "$email adalah email yang tidak valid");
}
	
	public function test(){
		$this->load->view('ppaa/test');
	}

}