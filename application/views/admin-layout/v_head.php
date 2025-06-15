<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>NEXUS</title>
    <link href="<?php echo base_url('/assets/admin-template/img/nexuslogolightclear.webp'); ?>" style="width: 5px; height: 5px;" rel="shorcut icon">

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>assets/admin-template/vendor/fontawesome-free-5.15.4-web/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>assets/admin-template/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="<?= base_url() ?>assets/admin-template/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Toggle -->
    <link href="<?= base_url() ?>assets/admin-template/vendor/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
    <!-- Leafletjs.com untuk menampilkan maps -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" /> -->
    <!-- teks animation -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.prinsh.com/NathanPrinsley-textstyle/nprinsh-stext.css"/> -->
    <link href="<?= base_url() ?>assets/admin-template/vendor/nprinsh-stext/nprinsh-stext.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/admin-template/vendor/jqueryui/css/jquery-ui.css" rel="stylesheet">
    <!-- selectpicker -->
    <link href="<?= base_url() ?>assets/admin-template/vendor/selectpicker/css/bootstrap-select.min.css" rel="stylesheet">

    <!-- Alokasi js di head untuk maps marker dapat muncul -->
    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>assets/admin-template/vendor/jquery/jquery.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>assets/admin-template/js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="<?= base_url() ?>assets/admin-template/vendor/chart.js/Chart.min.js"></script>
    <script src="<?= base_url() ?>assets/admin-template/vendor/chart.js/Chart.datalabels.min.js"></script>
    <!-- Leaflet -->
    <!-- <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script> -->
    <!-- untuk menghilangkan error saat tanda panah ke atas -->
    <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <!-- html2canvas -->
    <script src="<?= base_url() ?>assets/admin-template/vendor/html2canvas/html2canvas.js"></script>
    <!-- ckeditor -->
    <script src="<?= base_url() ?>assets/admin-template/vendor/ckeditor/ckeditor.js"></script>
    <script src="<?= base_url() ?>assets/admin-template/vendor/ckeditor/styles.js"></script>
    <!-- swiftalert -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="<?= base_url() ?>assets/admin-template/vendor/sweetalert/sweetalert2@11.js"></script>
    <!-- moment -->
    <script src="<?= base_url() ?>assets/admin-template/vendor/moment/moment-with-locales.min.js"></script>
    <!-- jqueryui -->
    <script src="<?= base_url() ?>assets/admin-template/vendor/jqueryui/js/jquery-3.3.1.js"></script>
    <script src="<?= base_url() ?>assets/admin-template/vendor/jqueryui/js/jquery-ui.js"></script>
    <!-- selectpicker -->
    <script src="<?= base_url() ?>assets/admin-template/vendor/selectpicker/js/bootstrap-select.min.js"></script>
    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- jqueryui -->
    <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->

    <!-- Re-captcha V2 -->
    <!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
    <!-- Re-captcha V3 -->
    <!-- https://www.ahmadsanusi.com/blog/cara-memasang-google-recaptcha-v3-di-website-beserta-contoh-kodenya -->
    <!-- <script src="https://www.google.com/recaptcha/api.js?render=6Lf39QoqAAAAAAJpzfkchVRSmHa4imccQhiSVzlz"></script>
    <script>
        // do request for recaptcha token
        // response is promise with passed token
        grecaptcha.ready(function() {
            grecaptcha.execute('6Lf39QoqAAAAAAJpzfkchVRSmHa4imccQhiSVzlz', {action:'validate_captcha'})
                    .then(function(token) {
                // add token value to form
                document.getElementById('g-recaptcha-response').value = token;
            });
        });
    </script> -->
    
</head>

<style>
/* Import Quicksand font */
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');

body {
    font-family: 'Quicksand', sans-serif !important;
    color: #848484 !important;
}
</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">