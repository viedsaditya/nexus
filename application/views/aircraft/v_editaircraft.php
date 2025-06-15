<div class="form-group mr-5" style="display: flex; justify-content: left; align-items: left; height: 55px;">
        <h1 class="h4 text-gray-800 m-0"><?= $title; ?></h1>
    </div>
<div class="row">
    <div class="col-lg-6">
        <!-- Data -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-secondary">Data Aircraft</h6>
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

                // pesan data berhasil diedit
                if ($this->session->flashdata('pesan')) {
                    echo '<div id="notif" class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>';
                    echo $this->session->flashdata('pesan');
                    echo '</div>';
                }

                echo form_open_multipart('aircraft/edit/' . $aircraft->id_ac);
                ?>

                <!-- inputan data -->
                <div class="form-group">
                    <label class="control-label" for="acreg">Aircraft Registration</label>
                    <input type="text" name="acreg" value="<?= $aircraft->acreg ?>" class="form-control" placeholder="" id="acreg">
                </div>
                <div class="form-group">
                    <label class="control-label" for="actype">Aircraft Type</label>
                    <input type="text" name="actype" value="<?= $aircraft->actype ?>" class="form-control" placeholder="" id="actype">
                </div>
                <div class="form-group">
                    <label class="control-label" for="acsize">Aircraft Size</label>
                    <select name="acsize" class="form-control" id="acsize" required>
                        <option hidden value="<?= $aircraft->acsize ?>"><?= $aircraft->acsize ?></option>
                        <option value="Narrow">Narrow</option>
                        <option value="Wide">Wide</option>
                    </select>
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