<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Term extends CI_Controller 
{
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('ppaa/model');
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('session');
	}

	/*public function sessionUser()
	{
		$this->session->userdata['logged_in']['username'] = 'mnurulamri';
		$this->session->userdata['logged_in']['hak_akses'] = 1;		
	}*/

	public function index(){
		$this->load->view('ppaa/term');
	}

	public function prosesTerm(){
		//$this->sessionUser();			
		
		$ta = (int) $this->input->post('ta');
		$ta2 = $ta+1;
		$term = $this->input->post('smt');
		$thsmt = (int) $ta.$term;

		if($term=='1'){
			$semester='Gasal';
		} else {
			$semester='Genap';
		}

		$tgl_kuliah = $this->model->getTanggalKuliah($thsmt);
		foreach ($tgl_kuliah as $key => $row) {
			$this->session->set_userdata('tgl_awal', $row->tgl_awal);
			$this->session->set_userdata('tgl_akhir', $row->tgl_akhir);
		}
		
		$term_berjalan = 'Tahun Akademik '.$ta.'/'.$ta2.' Semester '.$semester;
		$this->session->set_userdata('term_berjalan', $term_berjalan);

		$url = 'ppaa/ruang';
		echo'
		<script>
			window.location.href = "'.base_url().$url.'";
		</script>
		';	

		/*
		$url = 'http://localhost:8080/backend/ppaa/ruang';
		header("location: http://localhost:8080/backend/ppaa/ruang");

		$data['tgl_awal'] = $this->session->userdata['tgl_awal'];
		$data['tgl_akhir'] = $this->session->userdata['tgl_akhir'];
		$data['term_berjalan'] = $this->session->userdata['term_berjalan'];
		$this->load->view('ppaa/test', $data);*/
	}	
}