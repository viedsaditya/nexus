<!-- Begin Page Content -->
<div class="container-fluid" id="htmlimgdash">

    <!-- Page Heading -->
    <form class="form-inline mb-3 justify-content-start">
        <!-- <div class="form-group mt-3">
            <h1 class="h4 text-gray-800"><?= $title; ?></h1>
        </div> -->
        <!-- <div class="form-group ml-auto mt-1">
            <img src="<?php echo base_url('/assets/admin-template/img/jlogo.png'); ?>" style="width:160px">
        </div> -->
    </form>

    <?php
    if ($isi) {
        $this->load->view($isi);
    }
    
