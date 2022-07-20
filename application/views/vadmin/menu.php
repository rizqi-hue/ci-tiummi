<ul id="tt1" class="easyui-tree" data-options="animate:true,dnd:true" style="font-family:Trebuchet MS;">
    <li data-options="iconCls:'icon-home'">
        <span><a href="<?php echo base_url(); ?>index.php/c_kec/home">Home</a></span>
    </li>
    <li data-options="iconCls:'icon-profil'"><a href="<?php echo base_url(); ?>index.php/c_kec/profil">Profil</a></li>
	<li data-options="iconCls:'icon-users'"><a href="<?php echo base_url(); ?>index.php/c_kec/password">Password</a></li>
	<li data-options="iconCls:'icon-menu'">
        <span>RPJMDesa</span>
        <ul>
			<li data-options="iconCls:'icon-lap'"><a href="<?php echo base_url(); ?>index.php/c_kec/laporan/rpjmdes">Lap RPJMDesa</a></li>
			<li data-options="iconCls:'icon-lap'"><a href="<?php echo base_url(); ?>index.php/c_kec/laporan/review_rpjmdes">Lap Review RPJMDesa</a></li>
        </ul>
    </li>
	<li data-options="iconCls:'icon-menu'">
        <span>RKPDesa</span>
        <ul>
			<li data-options="iconCls:'icon-lap'"><a href="<?php echo base_url(); ?>index.php/c_kec/laporan/rkpdes">Lap RKP Desa</a></li>
			<li data-options="iconCls:'icon-lap'"><a href="<?php echo base_url(); ?>index.php/c_kec/laporan/pelaksanaan_rkpdes">Lap Pelaksanaan RKP Desa</a></li>
			<li data-options="iconCls:'icon-lap'"><a href="<?php echo base_url(); ?>index.php/c_kec/laporan/durkp">Lap DURKP Desa</a></li>
        </ul>
    </li>
	
	<li data-options="iconCls:'icon-menu'">
        <span>APBDesa</span>
        <ul>
            <li data-options="iconCls:'icon-lap'"><a href="<?php echo base_url(); ?>index.php/c_kec/laporan/apbdes">Lap APBDesa</a></li>
        </ul>
    </li>
	<li data-options="iconCls:'icon-menu'">
        <span>Desa</span>
        <ul>
            <li data-options="iconCls:'icon-lap'"><a href="<?php echo base_url(); ?>index.php/c_kec/laporan/desa">Daftar Desa</a></li>
        </ul>
    </li>
	<li data-options="iconCls:'icon-out'">
        <span><a href="<?php echo base_url(); ?>index.php/c_kec/home/logout">Keluar</a></span>
    </li>
</ul>