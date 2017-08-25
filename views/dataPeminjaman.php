<!--<link rel="stylesheet" type="text/css" href="css/table.css"/>
<link href="../icon/css/font-awesome.min.css" rel="stylesheet">-->
<?php
//session_start();

//jika session username belum dibuat, atau session username kosong
//if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
	//redirect ke halaman login
	//header('location:login.php');
//}

//set array komponen array bulan
$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
                      '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );

echo '
<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading">Data Peminjaman</div>
		<table id="dg" class="table table-bordered">
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
				</tbody>
			</table>
</div>';
?>

<!-- Large modal
<button type="button" class="btn btn-primary edit-data-peminjaman" data-toggle="modal" data-target=".bs-example-modal-lg">Edit Data Peminjaman</button> -->

<div class="modal fade modal-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<!--<div class="modal-content"style="padding:5px">-->
			<!-- Edit Form Peminjaman -->
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Form Permohonan Pemakaian Ruang</h3>
				</div>
				<!-- /.box-header -->
				
				<!-- form start -->
				<form id="formInput" method="post" name="form" class="form-horizontal" >
					<div class="box-body">
				    <br>
				    <div><input type="text" name="nomor" id="nomor"/></div>
				     <div><input type="text" name="event_id" id="event_id"/></div>
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
										<td id="ruangan"></td><td>&nbsp;</td>
										<td>
											<div class="input-group date">
												<div class="input-group-addon">
													<i class="fa fa-calendar view-tanggalan"></i>
												</div>
												<input type="text" id="tgl_kegiatan" name="tgl_kegiatan" class="tgl_kegiatan form-control" data-provide="datepicker"/>
											</div>
										</td><td>&nbsp;</td>
										<td id="mulai"></td>
										<td>&nbsp;s/d&nbsp;</td>
										<td id="selesai"></td>
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
									<input type="text" id="tgl_permohonan" name="tgl_permohonan" class="tgl_permohonan form-control"/>
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
						<div class="pesan"></div>
						<!--<div id="process-info" style="display:none; text-align:center">Data sudah disimpan..<img src="<?=base_url();?>assets/images/spinner.gif"/></div>
						<span id="alert-pesan" class="alert alert-success" role="alert" style="display:none">Data sudah disimpan..</span>-->				
						<span><button class="edit-data btn btn-success pull-right">Simpan</button></span>
						<span class="pull-right" style="color:#fff">xx</span>
						<span><button class="btn btn-danger pull-right" data-dismiss="modal">Tutup</button></span>
					</div>
					<!-- /.box-footer -->
			</div>
		<!--</div>-->
	</div>
</div>

<script>
$(document).ready(function() {	
	$('#tgl_kegiatan, #tgl_permohonan').datepicker({
		autoclose: true,
		language: "id"
	});

    $('.modal').on('hidden.bs.modal', function(){
    	$.post("<?php echo base_url()?>ppaa/ruang/dataTabel", function(data){
    		$('#dg').html(data);
    	});
    });
});
</script>
<style>
.datepicker{
	z-index:1600 !important;
}
</style>
