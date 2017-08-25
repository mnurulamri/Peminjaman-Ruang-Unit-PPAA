<?
if(!session_id()) session_start();
//include('menu.php');
?>
<style>
body {
	/*background: url(<?=base_url()?>assets/images/logo-ui-profile.png); background-size:cover*/
    background:  url(<?=base_url()?>assets/images/logo-ui-profile.png);
    background-size: cover;
    background-repeat: no-repeat;
    box-shadow: inset 0 0 0 1000px rgba(0,0,0,.5);
}
.ul {
	margin:auto; text-align:center; width:600px; font:bold 12px verdana; color:#555;  background:rgba(15,112,147,1); -moz-border-radius: 5px; border-radius: 5px;box-shadow:0px 1px 3px rgba(000,000,000,0.5),inset 0px 0px 2px rgba(255,255,255,1); -moz-box-shadow:0px 1px 3px rgba(000,000,000,0.5), inset 0px 0px 2px rgba(255,255,255,1);
}
</style>
<body>

<div class="img">
	<!--<img src="../images/Quiet.jpg" alt="Klematis" width="100%" height="100%">-->
	
	<ul class="">
		<form name="fTerm" method="post" action="<?=base_url()?>ppaa/term/prosesTerm/">
			<table style="margin-left:70%; margin-top:10%; border-collapse:collapse;">
				<tr>
					<td style="height:10px; font:bold 14px arial; color:white">Silahkan Pilih Term:</td>
				</tr>
				<tr style="text-align:center; font:bold 14px arial; color:#fff; background:rgba(15,112,147,1)">					
					<td style="width:150px">Tahun Akademik</td>
					<td style="width:100px">Semester</td>
				</tr>
				<tr>
					<td style="height:10px"></td>
				</tr>				
				<tr style="text-align:center">
					<td>
						<select style="font:bold 14px arial; color:#555" name="ta" class="form-control">								
							<?php
							$current_year = date('Y');
							$next_year = date('Y')+1;
							$prev_year = date('Y')-1;
							echo '
							<option value="'.$current_year.'"> '.$current_year.'/' .$next_year. ' </option>
							<option value="'.$prev_year.'"> '.$prev_year.'/' .$current_year. ' </option>';
							?>
						</select>					
					</td>
					<td>
						<select style="font:bold 14px arial; color:#555" name="smt" class="form-control">
							<option style="color:magenta" value="1">Gasal</option>
							<option style="color:blue" value="2">Genap</option>
						</select>						
					</td>
				</tr>
				<tr>
					<td style="height:10px"></td>
				</tr>
				<tr>
					<td style="text-align:right; border-top:1px solid #fa0" colspan="3">
						<input type="submit" value="generate" name="submit" style="font:bold 11px verdana; height: 2.5em; :hover" class="btn btn-primary"/>
					</td>
				</tr>
			</table>
			</br>
		</form>
	</ul>
</div>
</body>