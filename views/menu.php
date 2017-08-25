<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
      <!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
                <?php
                //$photo = 'data:image/png;base64,'.$foto;
                //echo '<img src = '.$photo.' class="direct-chat-img" alt="User Image"/>';
                ?>
			</div>
			<div class="pull-left info">
				<p><?//=$username?></p>
				<!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
			</div>
		</div>
      	<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header" style="font-size:13px; color:#aaa"> ADMINISTRASI PEMINJAMAN RUANG </li>
            <li><a class="page" rel="<?=base_url()?>ppaa/ruang/formPeminjaman"><i class="fa fa-sticky-note-o text-white"></i> Form Peminjaman </a></li>
            <li><a class="page" rel="<?=base_url()?>ppaa/ruang/dataPeminjaman"><i class="fa fa-tasks text-yellow"></i> Data Peminjaman </a></li>
            <li><a class="page" rel="<?=base_url()?>ppaa/ruang/cekRuangKosong"><i class="fa fa-calendar text-aqua"></i> Cek Ruang Kelas </a></li>
<li><a class="page" rel="<?=base_url()?>ppaa/ruang/cekRuangNonKelas"><i class="fa fa-calendar text-aqua"></i> Cek Ruang AJS & Audit. Kom</a></li>
            <li><a class="page" rel="<?=base_url()?>ppaa/ruang/formUploadJadwalSiak"><i class="fa fa-upload text-white"></i> Upload Jadwal SIAK </a></li>
            <li><a class="page" rel="<?=base_url()?>ppaa/ldapLogin/logout"><i class="fa fa-sign-out text-red"></i> Logout </a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>