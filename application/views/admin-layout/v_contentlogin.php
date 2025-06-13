<!-- Begin Page Content -->
<div class="container-fluid" id="htmlimgdash">

    <!-- Page Heading -->
    <h1 class="h4 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php
    if ($isi) {
        $this->load->view($isi);
    }
    
