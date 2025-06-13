</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Jasa Angkasa Semesta 2025</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Alokasi semua js di footer untuk menjalankan animasi nav/sidebar dapat diperkecil/diperbesar -->
<!-- Bootstrap core JavaScript-->
<!-- <script src="<?= base_url() ?>assets/admin-template/vendor/jquery/jquery.min.js"></script> -->
<script src="<?= base_url() ?>assets/admin-template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<!-- <script src="<?= base_url() ?>assets/admin-template/vendor/jquery-easing/jquery.easing.min.js"></script> -->
<!-- Custom scripts for all pages-->
<script src="<?= base_url() ?>assets/admin-template/js/sb-admin-2.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url() ?>assets/admin-template/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/admin-template/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/admin-template/js/demo/datatables-demo.js"></script>
<!-- Chart -->
<script src="<?= base_url() ?>assets/admin-template/vendor/chart.js/Chart.min.js"></script>
<script src="<?= base_url() ?>assets/admin-template/vendor/chart.js/Chart.datalabels.min.js"></script>
<script src="<?= base_url() ?>assets/admin-template/vendor/toggle/js/bootstrap-toggle.min.js"></script>
<!-- Swiftalert -->
<script src="<?= base_url() ?>assets/admin-template/vendor/sweetalert/sweetalert2.all.min.js"></script>
<!-- untuk menghilangkan error saat tanda panah ke atas -->
<!-- <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script> -->
<!-- html2canvas -->
<script src="<?= base_url() ?>assets/admin-template/vendor/html2canvas/html2canvas.js"></script>
<!-- ckeditor -->
<!-- <script src="<?= base_url() ?>assets/admin-template/vendor/ckeditor/ckeditor.js"></script> -->
<!-- <script src="<?= base_url() ?>assets/admin-template/vendor/ckeditor/styles.js"></script> -->
<!-- jqueryui -->
<!-- <script src="<?= base_url() ?>assets/admin-template/vendor/jqueryui/js/jquery-3.3.1.js"></script>
<script src="<?= base_url() ?>assets/admin-template/vendor/jqueryui/js/jquery-ui.js"></script> -->
<!-- particlejs -->
<script src="<?= base_url() ?>assets/admin-template/vendor/particles.js-master/particles.js"></script> 
<script src="<?= base_url() ?>assets/admin-template/vendor/particles.js-master/demo/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> 
<!-- Fullscreen -->
<script>
    var elem = document.documentElement;
    function openFullscreen() {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) { /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE11 */
            elem.msRequestFullscreen();
        }
    }

    function closeFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) { /* Safari */
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { /* IE11 */
            document.msExitFullscreen();
        }
    }
</script>

</body>

</html>