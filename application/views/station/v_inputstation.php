<div class="form-group mr-5" style="display: flex; justify-content: left; align-items: left; height: 55px;">
        <h1 class="h4 text-gray-800 m-0"><?= $title; ?></h1>
    </div>
<div class="row">
    <div class="col-lg-6">
        <!-- Data -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-secondary">Data Station</h6>
            </div>
            <div class="card-body">
                <?php
                // pesan file foto gagal diupload
                if (isset($error_upload)) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                ' . $error_upload . '</div>';
                }

                // validasi inputan data tidak boleh kosong
                echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                ', '</div>'); // tulisan alert nanti setelah tanda koma

                // pesan data berhasil disimpan
                if ($this->session->flashdata('pesan')) {
                    echo '<div id="notif" class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>';
                    echo $this->session->flashdata('pesan');
                    echo '</div>';
                }

                echo form_open_multipart('station/input');
                ?>

                <!-- inputan data -->
                <div class="form-group">
                    <label class="control-label" for="code_station">Code Station</label>
                    <input type="text" name="code_station" value="<?= set_value('code_station'); ?>" class="form-control" placeholder="" id="code_station">
                </div>
                <div class="form-group">
                    <label class="control-label" for="name_station">Name Station</label>
                    <input type="text" name="name_station" value="<?= set_value('name_station'); ?>" class="form-control" placeholder="" id="name_station">
                </div>
                <div class="form-group">
                    <label class="control-label" for="country">Country</label>
                    <input type="text" name="country" value="<?= set_value('country'); ?>" class="form-control" placeholder="" id="country">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-warning" style="background-color: #F26522;">Simpan</button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    window.setTimeout(function() {
        $("#notif").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 4000); 
}); 
</script>