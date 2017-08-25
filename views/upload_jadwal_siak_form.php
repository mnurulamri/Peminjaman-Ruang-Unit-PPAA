<?php 
if(!session_id()) session_start();
echo $this->session->userdata['tgl_awal'];
//jika session username belum dibuat, atau session username kosong
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
	//redirect ke halaman login
	//header('location:logout.php');
	//exit;
}
?>

<script>
	$(document).ready(function() {

		$().ajaxStart(function() {
			$('#loading').show();
			$('#result').hide();
		}).ajaxStop(function() {
			$('#loading').hide();
			$('#result').fadeIn('slow');
		});

		$('#f1').submit(function() {
			$('#loading').show();
			var form_load = $('#f1')[0];
			var formData = new FormData(form_load);

			$.ajax({
				url: "http://ppf.fisip.ui.ac.id/backend/ppaa/ruang/uploadJadwalSiak", // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: formData, //  -> Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{							
					$('#loading').hide();
					$("#hasilProses").html(data);
					//$('#tabel').load('test1.php');
					//
				}
			});	
			return false;
		});
	})
</script>
<!-- ----------------------------------------------------------------------------------------------- -->
	<br/>
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Upload Penggunaan Ruang - (Data SIAK)</h3>
			<div class='inset'>
				<b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
					<div class='boxcontent'>
						<p>
							<form name="f1" id="f1" method="post" enctype="multipart/form-data">
								Silahkan Pilih File Excel: <input name="userfile" type="file" class="form-control"/>
								<input name="upload" type="submit" class="btn btn-success" value="upload"/>						
							</form>
						</p>
					</div>
					
				<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
			</div>
			<br/>
			<div style="text-align:center;">
				<a href="http://ppf.fisip.ui.ac.id/backend/ppaa/ruang/downloadExcel">
					<input name="download" type="button" class="btn btn-primary" value="download template">
				</a>
			</div>
			<br>
			<div class='inset'>
				<b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
					<div class='boxcontent'>
						<div class="alert alert-info">
							<p>
								<u>Cara penggunaan:</u><br>
								- File yang akan di upload dalam format Excel 97-2003<br>
								- Source data di-download dari data penggunaan ruang SIAK NG<br>
							</p>
						</div>
					</div>
				<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
			</div>
			<div id="hasilProses"></div>
			<div id="loading" style="display:none;"><img src="<?=base_url();?>assets/images/spinner.gif" /></div>			
		</div>
	</div>
