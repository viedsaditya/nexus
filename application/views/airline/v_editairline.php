<div class="form-group mr-5" style="display: flex; justify-content: left; align-items: left; height: 55px;">
        <h1 class="h4 text-gray-800 m-0"><?= $title; ?></h1>
    </div>
<div class="row">
    <div class="col-lg-6">
        <!-- Data -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-secondary">Data Airline</h6>
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

                echo form_open_multipart('airline/edit/' . $airline->id_air);
                ?>

                <!-- inputan data -->
                <div class="form-group">
                    <label class="control-label" for="airline_code">Airline Code</label>
                    <input type="text" name="airline_code" value="<?= $airline->airline_code ?>" class="form-control" placeholder="" id="airline_code">
                </div>
                <div class="form-group">
                    <label class="control-label" for="airline_name">Airline Name</label>
                    <input type="text" name="airline_name" value="<?= $airline->airline_name ?>" class="form-control" placeholder="" id="airline_name">
                </div>
                <div class="form-group">
                    <label class="control-label" for="airline_terminal">Airline Terminal</label>
                    <input type="text" name="airline_terminal" value="<?= $airline->airline_terminal ?>" class="form-control" placeholder="" id="airline_terminal">
                </div>
                <div class="form-group">
                    <label class="control-label" for="airline_station">Airline Station</label>
                    <select name="airline_station" class="form-control" id="airline_station">
                    <?php 
                        foreach ($station as $l){
                            echo "<option value='$l->code_station' ".($airline->airline_station === $l->code_station ? 'selected':'').">$l->code_station ($l->name_station)</option>";    
                        }
                    ?>
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