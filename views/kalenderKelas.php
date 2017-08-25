<!doctype html>

<link rel="stylesheet" href="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/dhtmlxscheduler.css" type="text/css" title="no title" charset="utf-8">
<!--<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_units.js" type="text/javascript" charset="utf-8"></script>-->
<!--<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/sources/locale/locale_id.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_minical.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js"></script>    <!-- untuk crud otomatis --
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor_debug.js"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxscheduler_recurring.js"></script>-->

<style type="text/css" media="screen">
  #scheduler_here{
    position:absolute;
    margin: 0px;
    padding: 0px;
    height: 100%;
	width:100%;
  }

*,*:before, *:after{
	box-sizing:content-box;
	-webkit-box-sizing:content-box;
	-moz-box-sizing:content-box;
}

.jumbotron {
	line-height:normal;
}

#my_form {
	position: absolute;
	top: 100px;
	left: 200px;
	z-index: 10001;
	display: none;
	background-color: white;
	border: 2px outset gray;
	padding: 20px;
	font-family: Tahoma;
	font-size: 10pt;
}

#my_form label {
	width: 200px;
}

/*event in day or week view*/
.dhx_cal_event.event_1 div{
	background-color: #ED4337 !important;
	color: white !important;
}

.dhx_cal_event.event_2 div{
	background-color: #808000 !important;
	color: white !important;
}

.dhx_cal_event.event_3 div{
	background-color: #009966 !important;
	color: white !important;
}

.dhx_cal_event.event_kp div{
	background-color: #C85EC7 !important;
	color: white !important;
}

.dhx_cal_header {
	height:100px;
}
</style>

<script type="text/javascript" charset="utf-8">


	//fungsi untuk disable double click pada kotak scheduler
	var createEvent = scheduler.addEventNow;
	scheduler.addEventNow = function(){
		return null;
	};

function show_minical(){
	if (scheduler.isCalendarVisible())
		scheduler.destroyCalendar();
	else
		scheduler.renderCalendar({
			position:"dhx_minical_icon",
			date:scheduler._date,
			navigation:true,
			handler:function(date,calendar){
				scheduler.setCurrentView(date);
				scheduler.destroyCalendar()
			}
		});
}
</script>
</head>
<body>

<div style="width:100%; height:600px; overflow-x:scroll; overflow-y:hidden; position: relative;">
	<div id="scheduler_here" class="dhx_cal_container">
		<div class="dhx_cal_navline">
			<div class="dhx_cal_tab dhx_cal_tab_first" name="unit_tab" style="left: 50px;"></div>
			<div class="dhx_cal_tab dhx_cal_tab_last" name="month_tab" style="left: 111px;"></div>

			<div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>					
			<div class="dhx_cal_prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button">&nbsp;</div>
			<div class="dhx_cal_today_button"></div>
			<div class="dhx_cal_date"></div>
		</div>
		<div class="dhx_cal_header">
		</div>
		<div class="dhx_cal_data">
		</div>
	</div>	
</div>



<div id="my_form">
		<div class="box-body">
			<div class="form-group">
				<label class="col-sm-2 control-label">Hari</label>
				<div class="col-sm-2">
					<select name="hari" id="hari" class="form-control pull-right">
					<option style="color:magenta;" value="Senin">Senin</option>
					<option style="color:blue;" value="Selasa">Selasa</option>
					<option style="color:green;" value="Rabu">Rabu</option>
					<option style="color:purple;" value="Kamis">Kamis</option>
					<option style="color:red;" value="Jumat">Jumat</option>
					<option style="color:magenta;" value="Sabtu">Sabtu</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Tanggal Kegiatan :</label>
				<div class="col-sm-2">
					<input id="tgl_kegiatan" name="tgl_kegiatan" class="form-control pull-right" data-provide="datepicker"></input>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Ruang :</label>
				<div class="col-sm-2">
					<select class="form-control pull-right" name="ruang" id="ruang">
					<?php
					foreach ($ruang as $key => $value) {
					echo '<option value="'.$value->kd_ruang.'">'.$value->nm_ruang.'</option>';
					}
					?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Nama Kuliah/Kegiatan :</label>
				<div class="col-sm-10">
					<input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control pull-right"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Program Studi/Unit :</label>
				<div class="col-sm-10">
					<input type="text" name="prodi" id="prodi" class="form-control pull-right"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Jam Mulai:</label>
					<div class="col-sm-1">
						<select name="jam_mulai" id="jam_mulai" class="form-control">
						<option value="16" selected >16</option>
						<option value="17"  >17</option>
						<option value="18"  >18</option>
						<option value="19"  >19</option>
						<option value="20"  >20</option>
						<option value="21"  >21</option>
						</select>
					</div>
					<div class="col-sm-1">
						<select name="menit_mulai" id="menit_mulai" class="form-control pull-right">
							<option value="00"  >00</option>
							<option value="05"  >05</option>
							<option value="10"  >10</option>
							<option value="15"  >15</option>
							<option value="20"  >20</option>
							<option value="25"  >25</option>
							<option value="30"  selected  >30</option>
							<option value="35"  >35</option>
							<option value="40"  >40</option>
							<option value="45"  >45</option>
							<option value="50"  >50</option>
							<option value="55"  >55</option>
						</select>
					</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Jam Selesai:</label>
					<div class="col-sm-1">
						<select name="jam_selesai" id="jam_selesai" class="form-control pull-right">
							<option value="17"  >17</option>
							<option value="18"  >18</option>
							<option value="19"  >19</option>
							<option value="20"  >20</option>
							<option value="21"  >21</option>
						</select>
					</div>
				<div class="col-sm-1">
					<select name="menit_selesai" id="menit_selesai" class="form-control">
						<option value="00"  >00</option>
						<option value="05"  >05</option>
						<option value="10"  >10</option>
						<option value="15"  >15</option>
						<option value="20"  >20</option>
						<option value="25"  >25</option>
						<option value="30"  selected  >30</option>
						<option value="35"  >35</option>
						<option value="40"  >40</option>
						<option value="45"  >45</option>
						<option value="50"  >50</option>
						<option value="55"  >55</option>
					</select>
				</div>
			</div>
		</div>

	<input type="button" name="save" value="Save" id="save" style='width:100px;' onclick="save_form()">
	<input type="button" name="close" value="Close" id="close" style='width:100px;' onclick="close_form()">
	<input type="button" name="delete" value="Delete" id="delete" style='width:100px;' onclick="delete_event()">
</div>


</body>
