<style>
/* Import Quicksand font */
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');

/* Make navigation text more visible */
.sidebar .nav-item .nav-link {
    color: #848484 !important;
    font-weight: 500;
    font-family: 'Quicksand', sans-serif;
    position: relative;
    z-index: 1001; /* Make sure navigation links are above the user info div */
}

/* Add this new style for the sidebar */
.navbar-nav.sidebar {
    position: relative;
    z-index: 1001; /* Make sure the entire sidebar is above the user info div */
}

/* Add this new style for the user info div */
.user-info-container {
    position: absolute;
    bottom: 0;
    width: inherit;
    max-width: inherit;
    z-index: 1000;
    pointer-events: none; /* This makes the div "click-through" except for its contents */
}

.user-info-container .nav-item {
    pointer-events: auto; /* Re-enable pointer events for the actual user info content */
}

.sidebar .nav-item .nav-link i {
    color: #848484 !important;
}

.sidebar .nav-item .nav-link span {
    font-family: 'Quicksand', sans-serif;
}

.sidebar .sidebar-brand {
    color: #848484 !important;
    font-weight: bold;
    font-family: 'Quicksand', sans-serif;
}

.sidebar .sidebar-heading {
    color: #848484 !important;
    font-weight: bold;
    font-family: 'Quicksand', sans-serif;
}

.sidebar hr.sidebar-divider {
    border-color: rgba(0,0,0,0.2);
}

/* Change collapse arrow color */
.sidebar .nav-item .nav-link[data-toggle="collapse"]::after {
    color: #F26522 !important;
}

.sidebar .nav-item .nav-link.collapsed::after {
    color: #F26522 !important;
}

.sidebar .fas {
    color: #F26522 !important;
}

/* Change submenu font */
.collapse-inner .collapse-item {
    font-family: 'Quicksand', sans-serif;
    color: #848484 !important;
}
</style>

    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: linear-gradient(rgba(255, 255, 255, 0.88), rgba(255, 255, 255, 0.88)), url('<?= base_url("assets/admin-template/img/nav.webp") ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">

        <!-- Sidebar - Brand -->
        <div class="d-flex align-items-center justify-content-between">
            <a class="sidebar-brand d-flex align-items-center" href="<?= base_url('seasonpairing'); ?>" style="width: auto; padding: 0;">
                <div class="sidebar-brand-icon">
                    <img class="img-fluid" src="<?php echo base_url('/assets/admin-template/img/nexuslogolightclear.webp'); ?>" style="margin-top:50px;">
                </div>
            </a>
            <!-- <button class="btn rounded-circle border-0" id="sidebarToggle" style="background: none; margin-top: 50px; padding: 8px;">
                <i class="fas fa-bars" style="color: #F26522; font-size: 18px;"></i>
            </button> -->
        </div>

        <!-- Divider -->
        <!-- <hr class="sidebar-divider my-0"> -->

        <?php
        // validasi menu dengan semua role dan is_active=1
        if ($this->session->userdata('is_active')==1) { ?>

            <li class="nav-item mt-5">
                <a class="nav-link pb-0" href="<?= base_url('seasonpairing'); ?>">
                    <!-- <i class="fas fa-fw fa-plane"></i> -->
                    <span>Paired Flight</span></a>
            </li>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider mt-3 my-0"> -->

        <?php } ?>

            <!-- Heading -->
            <!-- <div class="sidebar-heading mt-4" style="font-size:12px;">
                    Main Menu
            </div> -->

        <?php
        // validasi menu dengan role akses=jcc dan is_active=1
        // if (($this->session->userdata('id_role')==2) && ($this->session->userdata('is_active')==1)) { ?>
            <li class="nav-item mt-3">
                <a class="nav-link collapsed pb-0" href="#" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                    <!-- <i class="fas fa-fw fa-plane"></i> -->
                    <span>View Schedule</span>
                </a>
                <div id="collapse3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 mt-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('arrival'); ?>"><i class="fas fa-fw fa-plane-arrival"></i><span> Arrival</span></a>
                        <a class="collapse-item" href="<?= base_url('departure'); ?>"><i class="fas fa-fw fa-plane-departure"></i><span> Departure</span></a>
                        <!-- <a class="collapse-item" href="<?= base_url('seasonpairing'); ?>"><i class="fas fa-fw fa-plane"></i><span> Pairing</span></a> -->
                    </div>
                </div>
            </li> 

            <!-- <hr class="sidebar-divider mt-3"> -->

            <li class="nav-item mt-3">
                <a class="nav-link collapsed pb-0" href="#" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                    <!-- <i class="fas fa-fw fa-plane"></i> -->
                    <span>Create Daily Schedule</span>
                </a>
                <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 mt-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('dailyarrival'); ?>"><i class="fas fa-fw fa-plane-arrival"></i><span> Arrival Input</span></a>
                        <a class="collapse-item" href="<?= base_url('dailydeparture'); ?>"><i class="fas fa-fw fa-plane-departure"></i><span> Departure Input</span></a>
                    </div>
                </div>
            </li> 

            <!-- <hr class="sidebar-divider mt-3 my-0"> -->
            
            <li class="nav-item mt-3">
                <a class="nav-link collapsed pb-0" href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                    <!-- <i class="fas fa-fw fa-plane"></i> -->
                    <span>Create Season Schedule</span>
                </a>
                <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 mt-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('seasonarrival'); ?>"><i class="fas fa-fw fa-plane-arrival"></i><span> Arrival Input</span></a>
                        <a class="collapse-item" href="<?= base_url('seasondeparture'); ?>"><i class="fas fa-fw fa-plane-departure"></i><span> Departure Input</span></a>
                    </div>
                </div>
            </li> 

            <!-- <hr class="sidebar-divider mt-3 my-0"> -->

        <?php //} ?>

            <!-- Heading -->
            <!-- <div class="sidebar-heading mt-4" style="font-size:12px;">
                    Report
            </div> -->

            <li class="nav-item mt-3">
                <a class="nav-link collapsed pb-0" href="#" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                    <!-- <i class="fas fa-fw fa-file"></i> -->
                    <span>Generate Report</span>
                </a>
                <div id="collapse4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 mt-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('report/arrival'); ?>"><i class="fas fa-fw fa-plane-arrival"></i><span> Arrival</span></a>
                        <a class="collapse-item" href="<?= base_url('report/departure'); ?>"><i class="fas fa-fw fa-plane-departure"></i><span> Departure</span></a>
                        <a class="collapse-item" href="<?= base_url('report'); ?>"><i class="fas fa-fw fa-plane"></i><span> Pairing</span></a>
                    </div>
                </div>
            </li> 

            <!-- <hr class="sidebar-divider mt-3"> -->

            <li class="nav-item mt-3">
                <a class="nav-link collapsed pb-0" href="#" data-toggle="collapse" data-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                    <!-- <i class="fas fa-fw fa-file"></i> -->
                    <span>Master Data</span>
                </a>
                <div id="collapse5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 mt-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('airline'); ?>"><i class="fas fa-fw fa-plane"></i><span> Airline</span></a>
                        <a class="collapse-item" href="<?= base_url('aircraft'); ?>"><i class="fas fa-fw fa-plane"></i><span> Aircraft</span></a>
                        <?php 
                        // validasi menu dengan role akses=jcc dan is_active=1
                        if (($this->session->userdata('id_role')!=3) && ($this->session->userdata('is_active')==1)) { ?>
                            <a class="collapse-item" href="<?= base_url('station'); ?>"><i class="fas fa-fw fa-map"></i><span> Station</span></a>
                            <a class="collapse-item" href="<?= base_url('user'); ?>"><i class="fas fa-fw fa-user"></i><span> User</span></a>
                        <?php } ?>
                    </div>
                </div>
            </li> 

            <!-- <hr class="sidebar-divider mt-3"> -->

            <!-- Heading -->
            <!-- <div class="sidebar-heading mt-4" style="font-size:12px;">
                    Master Data
            </div> -->

            <!-- <li class="nav-item">
                <a class="nav-link pb-0" href="<?= base_url('user'); ?>">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Data User</span></a>
            </li> -->

            <!-- <hr class="sidebar-divider mt-3 my-0"> -->

            <!-- <li class="nav-item">
                <a class="nav-link pb-0" href="<?= base_url('station'); ?>">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Data Station</span></a>
            </li> -->

            <!-- <hr class="sidebar-divider mt-3 my-0"> -->

            <!-- <li class="nav-item">
                <a class="nav-link pb-0" href="<?= base_url('airline'); ?>">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Data Airline</span></a>
            </li> -->

            <!-- <hr class="sidebar-divider mt-3 my-0"> -->

            <!-- <li class="nav-item">
                <a class="nav-link pb-0" href="<?= base_url('aircraft'); ?>">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Data Aircraft</span></a>
            </li> -->
        
        <!-- Divider -->
        <!-- <hr class="sidebar-divider mt-3"> -->

        <!-- Heading -->
        <!-- <div class="sidebar-heading">
            Interface
        </div> -->

        <!-- Nav Item - Pages Collapse Menu -->
        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Settings</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Components:</h6>
                    <a class="collapse-item" href="buttons.html">Buttons</a>
                    <a class="collapse-item" href="cards.html">Cards</a>
                </div>
            </div>
        </li> -->

        <!-- Divider -->
        <!-- <hr class="sidebar-divider d-none d-md-block"> -->

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        <!-- Divider -->
        <!-- <hr class="sidebar-divider mt-3"> -->

        <!-- User Info -->
        <div class="user-info-container">
            <div class="mt-auto" style="background-color: #FDEBE2; margin: 10px; border-radius: 10px; opacity: 1;">
                <li class="nav-item dropdown no-arrow d-flex align-items-center justify-content-between">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if (!empty($this->session->userdata('foto'))) { ?>
                            <img class="img-profile rounded-circle" src="<?= base_url() ?>assets/upload/foto-user/<?= $this->session->userdata('foto') ?>">
                        <?php } else { ?>
                            <img class="img-profile rounded-circle" src="<?= base_url() ?>assets/admin-template/img/default.jpg">
                        <?php } ?>
                        <?php
                            $id_role = $this->session->userdata('id_role');
                            $sqlrole = "SELECT * FROM tb_role WHERE `id_role`=$id_role";
                            $queryrole = $this->db->query($sqlrole)->row()->code_role;   

                            $id_sts = $this->session->userdata('id_sts');
                            $sqlsts = "SELECT * FROM tb_station WHERE `id_sts`=$id_sts";
                            $querysts = $this->db->query($sqlsts)->row()->code_station;   
                        ?>
                    
                        <span style="font-family: 'Quicksand', sans-serif; font-size: 11px; opacity: 1; color: #F26522;" class="mr-2 d-none d-lg-inline small"><?= $this->session->userdata('fullname') ?> | <?= $querysts ?></span>
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        
                        <img class="img-profile rounded-circle mx-auto d-block" style="width:3vw; height:3vw;" src="<?= base_url() ?>assets/upload/foto-user/<?= $this->session->userdata('foto') ?>">
                        <?php
                            $id_role = $this->session->userdata('id_role');
                            $sqlrole = "SELECT * FROM tb_role WHERE `id_role`=$id_role";
                            $queryrole = $this->db->query($sqlrole)->row()->code_role;   

                            $id_sts = $this->session->userdata('id_sts');
                            $sqlsts = "SELECT * FROM tb_station WHERE `id_sts`=$id_sts";
                            $querysts = $this->db->query($sqlsts)->row()->code_station;   
                        ?>
                        <span class="text-gray-600 small d-flex justify-content-center"><?= $queryrole ?> | <?= $querysts ?></span>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="<?= base_url('user/changepassword') ?>">
                            <i class="fas fa-unlock-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Change Password
                        </a>
                        <div class="dropdown-divider"></div>

                        <?php
                            // jika belum ada session=user belum login
                            if ($this->session->userdata('username')=="") { ?>
                                <a class="dropdown-item" href="<?= base_url('login') ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Login
                                </a>  
                            <?php } else { ?>
                                <a class="dropdown-item" href="<?= base_url('login/logout') ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            <?php } ?>
                        
                    </div>
                </li>
            </class=>
        </div>

    </ul>
    <!-- End of Sidebar -->