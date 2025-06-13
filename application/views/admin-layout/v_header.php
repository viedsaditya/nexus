<style>
.topbar {
    height: 0rem !important;
}
</style>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column" style="background-color: #FDEBE2 !important;">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light topbar">

            <!-- Sidebar Toggle (Topbar) -->
            <!-- <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button> -->

            <!-- Topbar Search -->
            <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form> -->

            <!-- Topbar Navbar -->
            <!-- <ul class="navbar-nav ml-auto">

                
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a> 
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" onclick="openFullscreen();" ondblclick="closeFullscreen();" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->session->userdata('fullname') ?></span>
                        <?php if (!empty($this->session->userdata('foto'))) { ?>
                            <img class="img-profile rounded-circle" src="<?= base_url() ?>assets/upload/foto-user/<?= $this->session->userdata('foto') ?>">
                        <?php } else { ?>
                            <img class="img-profile rounded-circle" src="<?= base_url() ?>assets/admin-template/img/default.jpg">
                        <?php } ?>
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        
                        <img class="img-profile rounded-circle mx-auto d-block" style="width:50px; height:50px;" src="<?= base_url() ?>assets/upload/foto-user/<?= $this->session->userdata('foto') ?>">
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

            </ul> -->

        </nav>
        <!-- End of Topbar -->

