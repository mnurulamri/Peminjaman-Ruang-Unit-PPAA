<?php 
//session_start();

//jika session username belum dibuat, atau session username kosong
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
	//redirect ke halaman login
	//header('location:login.php');
}

//include('conn.php');
//include('ruang.php');
?>

<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>

<!-- Horizontal Form -->
<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">Form Permohonan Pemakaian Ruang</h3>
	</div>
	<!-- /.box-header -->
	
	<!-- form start -->
	<form id="formInput" method="post" name="form" class="form-horizontal" >
		<div class="box-body">
	        <br>
		<div class="form-group">
				<label class="col-sm-2 control-label">Nama Kuliah :</label>
				<div class="col-sm-10">
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="glyphicon glyphicon-credit-card"></i>
						</div>
						<input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control pull-right"/>
					</div>
				</div>
			</div>
            <div class="form-group">
                <label for="jml_peserta" class="col-sm-2 control-label" style="text-align:right">Jumlah Peserta :  </label>
                <div class="col-sm-2"> 
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="glyphicon glyphicon-pushpin"></i>
						</div>
                    	<input id="jml_peserta" name="jml_peserta" placeholder="Jumlah Peserta" class="form-control input-md" required="" type="text">						
					</div>
                </div>                        
            </div>
            <div class="form-group">
				<label class="col-sm-2 control-label">Jadwal</label>
				<div class="col-sm-10 form-inline">
					<table>
						<tr>
							<td>Nama Ruang</td><td>&nbsp;</td>
							<td>Tanggal</td><td>&nbsp;</td>
							<td style="text-align:center">Mulai</td>
							<td></td>
							<td style="text-align:center">Selesai</td>
						</tr>
						<tr>
							<td><?=$ruang?></td><td>&nbsp;</td>
							<td><input id="tgl_kegiatan" name="tgl_kegiatan" class="tgl_kegiatan form-control pull-right" value="<?php echo $tanggal?>"/></td><td>&nbsp;</td>
							<td><?=$start_time?></td>
							<td>&nbsp;s/d&nbsp;</td>
							<td><?=$end_time?></td>
						</tr>
					</table>
				</div>
			</div>

			<div style="border-top:1px solid #ddd">&nbsp;</div>

			<div class="form-group">
				<label for="tgl_permohonan" class="col-sm-2 control-label" style="text-align:right">Tanggal Permohonan: </label>
				<div class="col-sm-3">
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input id="tgl_permohonan" name="tgl_permohonan" class="tgl_permohonan form-control" value="<?php echo $tanggal?>"/>
					</div>
				</div>
			</div>   
			<div class="form-group">
				<label class="col-sm-2 control-label">Program Studi/Unit :</label>
				<div class="col-sm-10">  
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="glyphicon glyphicon-briefcase"></i>
						</div>
						<input type="text" name="prodi" id="prodi" class="form-control pull-right"/>
					</div>	
				</div>
			</div>
            <div class="form-group">
                <label for="nama_peminjam" class="col-sm-2 control-label" style="text-align:right">Penanggung Jawab : </label>              
                <div class="col-sm-9">
 					<div class="input-group date">
						<div class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</div>
						<input id="nama_peminjam" name="nama_peminjam" placeholder="nama peminjam" class="form-control input-md" required="" type="text">
					</div>                     
                </div>
            </div> 
            <div class="form-group">
                <label for="id_peminjam" class="col-sm-2 control-label" style="text-align:right">NPM/NIP/NUP : </label>
                <div class="col-sm-9">
 					<div class="input-group date">
						<div class="input-group-addon">
							<i class="glyphicon glyphicon-tag"></i>
						</div>
                    	<input id="id_peminjam" name="id_peminjam" placeholder="NPM/NIP/NUP" class="form-control input-md" required="" type="text">
					</div>
                </div>
            </div>   
            <div class="form-group">
                <label for="no_telp" class="col-sm-2 control-label" style="text-align:right">No. Telepon : </label>
                 <div class="col-sm-9">
 					<div class="input-group date">
						<div class="input-group-addon">
							<i class="glyphicon glyphicon-phone-alt"></i>
						</div>
                     	<input id="no_telp" name="no_telp" placeholder="Nomor Telepon" class="form-control input-md" required="" type="text">
					</div>              	
                 </div>                        
            </div>
            <div class="form-group">  
                <label for="email" class="col-sm-2 control-label" style="text-align:right">E-mail :</label>
                <div class="col-sm-9">
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="glyphicon glyphicon-envelope"></i>
						</div>
						<input id="email" name="email" placeholder="e-mail" class="form-control input-md" required="" type="text">
					</div>
                    
                </div>                        
            </div>  
		</div>
	</form>	
		<!-- /.box-body -->
		<div class="box-footer">
			<div class="pesan" style="display:none"></div>
			<!--<div class="pesan-bentrok alert alert-warning" role="alert" style="display:none"></div>
			<div id="process-info" style="display:none; text-align:center"><img src="<?=base_url();?>assets/images/spinner.gif"/></div>
			<span id="alert-simpan" class="alert alert-success" role="alert" role="alert" style="display:none">Data sudah disimpan..</span>-->
			<span><button class="test btn btn-info pull-right">Save</button></span>
		</div>
		<!-- /.box-footer -->
</div>

<script>
$(document).ready(function() {
    $('#tgl_kegiatan, #tgl_permohonan').datepicker({
      autoclose: true,
      language: "id"
    });	
});
</script>