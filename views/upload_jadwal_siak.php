<div id="progress" style="width:500px;border:1px solid #ccc;"></div>
<div id="information" style="width"></div>
<?php
if(!session_id()) session_start();
date_default_timezone_set('Asia/Jakarta');
include ('conn.php');
error_reporting(E_ALL ^E_NOTICE);
require_once 'excel_reader2.php';

//$data = new Spreadsheet_Excel_Reader('data_test.xls');
$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
$jmlBaris = $data -> rowcount(0);
$dataExcel = array();

//hapus jadwal siak
$sql = "DELETE FROM kegiatan WHERE nomor LIKE 'siak%'";
//$result = mysql_query($sql);
$sql = "DELETE FROM waktu WHERE nomor LIKE 'siak%'";
//$result = mysql_query($sql);

// nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
$sukses = 0;
$gagal = 0;
$j = 0;

/*print  '<div id="progress-bar" class="all-rounded">\n
		<div id="information">tes</div>';*/
	$tgl_awal = $this->session->userdata['tgl_awal'];	
echo '<table border="1" style="border-collapse:collapse">';

for($i=2; $i<=$jmlBaris; $i++)
{
	//if($data->val($i,15,0) != '0' and ($data->val($i,18,0) != 'x') or $data->val($i,18,0) == '0'){
	if($data->val($i,15,0) != '0'){  //jika hari tidak sama dengan 0
		$kd_mk		= $data -> val($i,5,0);
		$kd_kur		= $data -> val($i,6,0);
		$nama_mk	= $data -> val($i,7,0);
		$namaRuang 	= $data -> val($i,13,0);
		$hari 		= $data -> val($i,14,0);
		$start 		= $data -> val($i,15,0);
		$durasi 	= $data -> val($i,17,0);
		$kodeRuang 	= $data -> val($i,18,0);
		//$kodeRuang 	= ($data -> val($i,18,0) == 'x') ? 100 : $data->val($i, 18, 0);
		$mataKuliah = addslashes($data -> val($i,19,0));
		$prodi		= $data -> val($i,11,0);
		$time		= $data -> val($i,9,0);
		$waktu_arr	= explode(", ",$time);
		$waktu		= $waktu_arr[1];
		$kode		= trim($kd_kur).trim($kd_mk).trim($kelas);
		
		if($kodeRuang != 'x' or $kodeRuang == '0'){
			$kodeRuang = $data -> val($i,18,0);
		} else {
			$kodeRuang = '100';
		}
		
		//prepare insert tabel kegiatan
		$event_name = $nama_mk;

		//prepare insert tabel waktu
		//kode untuk mendapatkan tanggal melalui hari dengan interval tanggal awal dan akhir kuliah
		//$tgl_awal = $_SESSION['tgl_awal'];
		//$tgl_awal = $this->session->userdata['tgl_awal'];
		//$tgl_awal = '2017-08-28';
		$pecahTgl = explode("-", $tgl_awal);
		$tgl = $pecahTgl[2];
		$bln = $pecahTgl[1];
		$thn = $pecahTgl[0];
		
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
		$end_date 	= $tgl_kuliah.' '.$end_time;

		$nomor = 'siak'.getToken(20);

		/*//$sql = "INSERT INTO jadwal (start, lama, html, ruang, hari) VALUES ('$start', '$durasi', '$mataKuliah', '$kodeRuang', '$hari')";
		$sql = "INSERT INTO jadwal (start, lama, html, ruang, hari, ruang_siak, waktu, prodi, kode) 
				VALUES ('$start', '$durasi', '$mataKuliah', '$kodeRuang', '$hari', '$namaRuang', '$waktu', '$prodi', '$kode')";*/
		//$result = mysql_query($sql) or die (mysql_error());
		#echo $result;

		//insert tabel kegiatan
		$sql = "INSERT INTO kegiatan (event_name, prodi, nomor, flag_ppaa, status) 
				VALUES ('$mataKuliah', '$prodi', '$nomor', 1, 3)";
		//$result = mysql_query($sql) or die (mysql_error());

		//insert tabel waktu
		$sql = "INSERT INTO waktu (ruang, start_date, end_date, nomor) 
				VALUES ('$kodeRuang', '$start_date', '$end_date', '$nomor')";
		//$result = mysql_query($sql) or die (mysql_error());

		/*$percent = intval($i/$jmlBaris * 100)."%";  // Calculate the percentation
		$percentage = intval($i/$jmlBaris * 100);
		
		if ($percentage <= 100)
		{
			print '<script language="javascript">
					document.getElementById("progress-bar-percentage").innerHTML="<div style=\"width:\"'.$percentage.'"%></div>"
					document.getElementById("information").innerHTML="'.$j.' row(s) processed."</script>';
			#print "$percentage%";
		} 
		else
		{
			#print "<div class=\"spacer\">&nbsp;</div>";
		}*/

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
		echo '<tr><td>'.$event_name.'</td><td>'.$prodi.'</td><td></td><td></td><td>'.$hari.', '.$tgl_kuliah.'</td><td>'.$id_nomor.'</td></tr>';
		echo '<tr><td>'.$kodeRuang.'</td><td>'.$namaRuang.'</td><td>'.$start_date.'</td><td>'.$end_date.'</td><td>'.$mataKuliah.'</td><td>'.$id_nomor.'</td><td>'.$tgl_kuliah.'</td></tr>';
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

	#print "</div>";

echo '<br/><a href="index.php" class="uploadify-button">kembali</a>';
/*
function progressBar($percentage) {
	print "<div id=\"progress-bar\" class=\"all-rounded\">\n";
	print "<div id=\"progress-bar-percentage\" class=\"all-rounded\" style=\"width: $percentage%\">";
		if ($percentage < 100) {print "$percentage%";} else {print "<div class=\"spacer\">&nbsp;</div>";}
	print "</div></div>";
}
*/
#$html.= '</table>';
#print $html;
#echo '<script language="javascript">document.getElementById("information").innerHTML="Process completed"</script>';

//generate token untuk membedakan data dari setiap record
function getToken($length){
     $token = "";
     $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
     $codeAlphabet.= "0123456789";
     $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[rand(0, $max-1)];
    }

    return $token;
}
?>

<style>
.all-rounded {
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
}
 
.spacer {
	display: block;
}
 
#progress-bar {
	width: 300px;
	margin: 0 auto;
	background: #cccccc;
	border: 3px solid #f2f2f2;
}
 
#progress-bar-percentage {
	background: #3063A5;
	padding: 5px 0px;
 	color: #FFF;
 	font-weight: bold;
 	text-align: center;
}

.uploadify-button {
	background-color: #505050;
	background-image: linear-gradient(bottom, #505050 0%, #707070 100%);
	background-image: -o-linear-gradient(bottom, #505050 0%, #707070 100%);
	background-image: -moz-linear-gradient(bottom, #505050 0%, #707070 100%);
	background-image: -webkit-linear-gradient(bottom, #505050 0%, #707070 100%);
	background-image: -ms-linear-gradient(bottom, #505050 0%, #707070 100%);
	background-image: -webkit-gradient(
		linear,
		left bottom,
		left top,
		color-stop(0, #505050),
		color-stop(1, #707070)
	);
	background-position: center top;
	background-repeat: no-repeat;
	-webkit-border-radius: 2px;
	-moz-border-radius: 2px;
	border-radius: 2px;
	border: 2px solid #808080;
	color: #FFF;
	font: bold 12px Arial, Helvetica, sans-serif;
	text-align: center;
	text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
	width: 100%;
	padding:5px;
}

.uploadify-button:hover {
	background-color: #606060;
	background-image: linear-gradient(top, #606060 0%, #808080 100%);
	background-image: -o-linear-gradient(top, #606060 0%, #808080 100%);
	background-image: -moz-linear-gradient(top, #606060 0%, #808080 100%);
	background-image: -webkit-linear-gradient(top, #606060 0%, #808080 100%);
	background-image: -ms-linear-gradient(top, #606060 0%, #808080 100%);
	background-image: -webkit-gradient(
		linear,
		left bottom,
		left top,
		color-stop(0, #606060),
		color-stop(1, #808080)
	);
	background-position: center bottom;
	padding:5px;
}
</style>