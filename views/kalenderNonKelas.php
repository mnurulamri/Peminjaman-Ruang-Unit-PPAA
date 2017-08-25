<!--<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_units.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/sources/locale/locale_id.js" type="text/javascript" charset="utf-8"></script>-->
<link rel="stylesheet" href="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/dhtmlxscheduler.css" type="text/css" title="no title" charset="utf-8">
<!--<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_minical.js" type="text/javascript" charset="utf-8"></script>-->
	
<style type="text/css" media="screen">
        #scheduler_here{
          position:absolute;
          margin: 0px;
          padding: 0px;
          overflow: hidden;
          width:90%;
          height:70%; 
          background:#eee
        }

        *,*:before, *:after {
          box-sizing:content-box;
          -moz-box-sizing:content-box;
          -webkit-box-sizing:content-box;
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
	//function init() {

		var sections=[
			{key:"AJS", label:"AJS"},
			{key:"Audit Kom", label:"Audit Kom"}
		];
		
		//color event
		scheduler.templates.event_class = function(start_date, end_date, event) {
			if(event.flag == "1" && event.level == "0") // if event has subject property then special class should be assigned
                return "event_kp";
			if(event.flag == "1" && event.level == "1") // if event has subject property then special class should be assigned
                return "event_1";
			if(event.flag == "1" && event.level == "2") // if event has subject property then special class should be assigned
                return "event_2";
			if(event.flag == "1" && event.level == "3") // if event has subject property then special class should be assigned
                return "event_3";
			return ""; // default return
		};		
		
		scheduler.xy.scale_height = 35;		
		scheduler.locale.labels.unit_tab = "Ruang"
		scheduler.locale.labels.section_custom="Section";
		scheduler.config.details_on_create=false;
		scheduler.config.details_on_dblclick=false;
		scheduler.config.xml_date="%Y-%m-%d %H:%i";
		scheduler.config.first_hour = 8;
		scheduler.locale.labels.icon_custom = "Info";
		scheduler.config.icons_select = false;
		scheduler.config.fix_tab_position = false;
		
		/*scheduler.attachEvent("onClick", function(id){
			scheduler.config.icons_select = ["icon_details"]; 
			return true;
		});

		scheduler.config.icons_select = [
		   "icon_custom"
		];

		scheduler.config.icons_edit = [
		   "icon_custom"
		];*/
		
		scheduler.createUnitsView({
			name:"unit",
			property:"section_id",
			list:sections,
			size:15,
			step:15
		});

		scheduler.config.multi_day = true;

		var date = new Date();
		var tahun = date.getFullYear();
		var bulan = date.getMonth();
		var hari = date.getDate();

	scheduler.clearAll();
		scheduler.init('scheduler_here',new Date(tahun, bulan, hari),"unit");

		scheduler.load("<?=base_url()?>peminjaman/schedulerRuangRapat/dataUnitPPAAView");

		//fungsi untuk disable double click pada kotak event 
		scheduler.attachEvent("onDblClick", function(){
		    return false;
		});

		scheduler.addEventNow = function(){
			return null;
		};
	//}

	//fungsi untuk disable double click pada kotak scheduler
	var createEvent = scheduler.addEventNow;
	scheduler.addEventNow = function(){
	  /*if(confirm("really add?")){
	     return createEvent.apply(scheduler, arguments);
	  }*/
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
<script src="../lib/js/datetimepicker.js"></script>
<script type="text/javascript" charset="utf-8">
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
<body onload="init();">
<div style="width:100%; height:600px; overflow-x:scroll; overflow-y:hidden; position: relative;">
	<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>		
		<div class="dhx_cal_navline">
			<div class="dhx_cal_prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button">&nbsp;</div>
			<div class="dhx_cal_today_button"></div>
			<div class="dhx_cal_date"></div>
			<div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>			
			<div class="dhx_cal_tab dhx_cal_tab_first" name="unit_tab" style="left: 50px;"></div>
			<div class="dhx_cal_tab dhx_cal_tab_last" name="month_tab" style="left: 111px;"></div>			
		</div>
		<div class="dhx_cal_header">
		</div>
		<div class="dhx_cal_data">
		</div>		
	</div>
	</div>
</body>