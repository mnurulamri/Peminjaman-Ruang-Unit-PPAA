<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start(); //we need to start session in order to access it through CI

Class LdapLogin  extends CI_Controller {

	private $ci; 	
	private $server; 
	private $port; 	
	private $admin; 	
	private $password; 	
	private $conn; 	
	private $bind; 
	private $basedn;	
	private $filter;	
	private $username;

	public function __construct(){	
		parent::__construct();	
  		$this->server		= "ldap://152.118.39.37"; 		
  		$this->port			= "389"; 
  		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('form_validation');	
		$this->load->model('autentikasi/login_database');	
	} 

	public function loginForm(){
		$this->load->view('ppaa/ldapLoginView');
	}

	public function koneksi(){

	    $this->conn = ldap_connect($this->server,$this->port) or die("Tidak dapat terhubung ke server"); 		
		if($this->conn){ 	

			// Check validation for user input in SignUp form
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				if(isset($this->session->userdata['logged_in'])){
					//redirect ke halaman utama
					$url = 'ppaa/ruang';
					echo'
					<script>
						window.location.href = "'.base_url().$url.'";
					</script>';
					
				}else{
					$url = 'ppaa/ldapLogin/loginForm';
					echo'
					<script>
						window.location.href = "'.base_url().$url.'";
					</script>';
				}
			} else {

				$this->username = $this->input->post('username');
				$this->password = $this->input->post('password');				

				$this->filter = "uid=" . $this->username;
				$this->base_dn = "o=Universitas Indonesia,c=ID";
				$result = @ldap_search($this->conn, $this->base_dn, $this->filter);
				if (!$result) {
					//echo 'error_gagal_konek';
				} else {
					//$_SESSION['username'] = $username;
					//header("location:ldap_login_cek.php");
				}

				//$result = ldap_search($conn, "o=Universitas Indonesia,c=ID", $filter);
				$info = ldap_get_entries($this->conn, $result);

				/*--------------- asli ------------------------------*/
				if($info['count'] == 0) {
					ldap_close($this->conn);
					//error username -> redirect ke halaman index
					$url = 'ppaa/ldapLogin/loginForm';
					echo'
					<script>
						window.location.href = "'.base_url().$url.'";
					</script>
					';	
					//exit;
				}

				$this->DN = $info[0]["dn"];
				$ret = @ldap_bind($this->conn, $this->DN, $this->password);
				
				//echo '$nip_ppf = '.$info[0]['kodeidentitas'][0];
				$uid = $info[0]['uid'][0];
				
				if(!$ret) {
					//error password -> redirect ke halaman index
					$url = 'ppaa/ldapLogin/loginForm';
					echo'
					<script>
						window.location.href = "'.base_url().$url.'";
					</script>
					';	
				} else {
					//masuk berdasarkan hak akses
					$hak_akses = 0;
					$username = $this->username;

					$data = $this->login_database->ldapLogin($uid);

					if (count($data) > 0) {
						foreach ($data as $k => $v) {
							$hak_akses 	= $v->hak_akses;
						}
					} else {
							$hak_akses = 0;
					}

					$session_data = array(
						'username' 	=> $username,
						'hak_akses' => $hak_akses
					);

					// Add user data in session
					$this->session->set_userdata('logged_in', $session_data);

					//redirect ke halaman utama
					$url = 'ppaa/term/term';
					echo'
					<script>
						window.location.href = "'.base_url().$url.'";
					</script>
					';
				}

			}  // end of form validation
		} 	// end of conn 
	} 
	public function logout() {

		// Removing session data
		$sess_array = array(
			'username' => ''
		);

		$sess_array2 = array(
			'term_berjalan' =>'',
			'tgl_awal' => '',
			'tgl_akhir' => ''
		);

		$this->session->unset_userdata('logged_in', $sess_array);
		$this->session->unset_userdata($sess_array2);
		
		$data['message_display'] = 'Successfully Logout';
		$url = 'ppaa/ldapLogin/loginForm';
		echo'
		<script>
		window.location.href = "'.base_url().$url.'";
		</script>';	
	}
}
