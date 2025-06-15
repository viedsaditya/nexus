<style>
.form-group {
    position: relative;
    margin-bottom: 1.5rem;
}

input[type="file"] {
    display: block;
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    font-size: 1rem;
}

input[type="file"]:focus {
    outline: none;
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
}
</style>
<div class="form-group mr-5" style="display: flex; justify-content: left; align-items: left; height: 55px;">
        <h1 class="h4 text-gray-800 m-0"><?= $title; ?></h1>
    </div>
<div class="row">
    <div class="col-lg-6">
        <!-- Data -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-secondary">Airline</h6>
            </div>
            <div class="card-body">
                <?php
                // // pesan file foto gagal diupload
                // if (isset($error_upload)) {
                //     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                // <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                //     <span aria-hidden="true">&times;</span>
                // </button>
                // ' . $error_upload . '</div>';
                // }

                // // validasi inputan data tidak boleh kosong
                // echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">
                // <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                //     <span aria-hidden="true">&times;</span>
                // </button>
                // ', '</div>'); // tulisan alert nanti setelah tanda koma

                // // pesan data berhasil disimpan
                // if ($this->session->flashdata('pesan')) {
                //     echo '<div id="notif" class="alert alert-success alert-dismissible fade show" role="alert">
                //     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                //         <span aria-hidden="true">&times;</span>
                //     </button>';
                //     echo $this->session->flashdata('pesan');
                //     echo '</div>';
                // }

                echo form_open_multipart('airline/generate_airline');
                ?>

                <!-- inputan data -->
                <div class="form-group">
                    <label class="control-label" for="airline_code">Airline Code</label>
                    <input type="text" name="airline_code" value="<?= set_value('airline_code'); ?>" class="form-control" placeholder="" id="airline_code" required>
                </div>
                <div class="form-group">
                    <label class="control-label" for="airline_name">Airline Name</label>
                    <input type="text" name="airline_name" value="<?= set_value('airline_name'); ?>" class="form-control" placeholder="" id="airline_name" required>
                </div>
                <div class="form-group">
                    <label class="control-label" for="airline_terminal">Airline Terminal</label>
                    <input type="text" name="airline_terminal" value="<?= set_value('airline_terminal'); ?>" class="form-control" placeholder="" id="airline_terminal" required>
                </div>
                <div class="form-group">
                    <label class="control-label" for="airline_station">Airline Station</label>
                    <select name="airline_station" class="form-control" id="airline_station">
                        <option value="">--Select Station--</option>
                        <?php foreach ($station as $key => $value) { ?>
                        <option value="<?= $value->code_station ?>"><?= $value->code_station ?> (<?= $value->name_station ?>)</option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-warning" style="background-color: #F26522;">Submit</button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-secondary">Upload File</h6>
            </div>
            <div class="card-body">
                                
                <form action="<?= base_url('airline/generate_airline_excel'); ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="mr-2">Upload File</label>
                        <!-- <input type="file" name="file"> -->
                        <input type="file" class="form-control-file" id="file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                    </div>
                    <button type="submit" class="btn btn-warning" style="background-color: #F26522;">Submit</button>
                </form>

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

    // flasdata swiftalert
    <?php if ($this->session->flashdata('pesan')) { ?>
        Swal.fire({
            icon: 'success',
            title: '<?= $this->session->flashdata('pesan') ?>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4e73df',
        })
    <?php } ?>

    <?php if ($this->session->flashdata('pesanerror')) { ?>
        Swal.fire({
            icon: 'error',
            title: '<?= $this->session->flashdata('pesanerror') ?>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4e73df',
        })
    <?php } ?>
</script>