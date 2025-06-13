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

/* Custom Select2 Styling */
.select2-container--default .select2-selection--single {
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    border: 1px solid #d1d3e2;
    border-radius: 0.35rem;
    text-align: center;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 1.5;
    padding-left: 0;
    padding-right: 0;
    color: #6e707e;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100%;
}

.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #d1d3e2;
    border-radius: 0.35rem;
}

.select2-dropdown {
    border: 1px solid #d1d3e2;
    border-radius: 0.35rem;
}

.select2-results__option {
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #f6c23e;
}

/* Fix for Select2 inside modal */
.modal .select2-container {
    width: 100% !important;
    text-align: center;
}

.select2-container--default .select2-selection--single {
    background-color: #fff;
    text-align: center;
}

input { 
    text-align: center; 
}

.form-control {
    text-align: center;
}
</style>
<div class="row">
    <div class="col-lg-6">
        <!-- Data -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-secondary">Flight</h6>
            </div>
            <div class="card-body">
                <?php
                // pesan file foto gagal diupload
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

                echo form_open_multipart('dailydeparture/generate_daily');
                ?>

                <!-- inputan data -->
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label class="control-label" for="dep_flightno">FLIGHT NO</label>
                            <input type="text" name="dep_flightno" value="<?= set_value('dep_flightno'); ?>" class="form-control" placeholder="" id="dep_flightno" required>
                        </div>
                        <!-- <div class="col">
                            <label class="control-label" for="dep_actype">ACTYPE</label>
                            <input type="text" name="dep_actype" value="<?= set_value('dep_actype'); ?>" class="form-control" placeholder="" id="dep_actype" required>
                        </div>
                        <div class="col">
                            <label class="control-label" for="dep_acreg">ACREG</label>
                            <input type="text" name="dep_acreg" value="<?= set_value('dep_acreg'); ?>" class="form-control" placeholder="" id="dep_acreg" required>
                        </div> -->
                        <div class="col">
                            <label class="control-label" for="dep_actype">ACTYPE</label>
                            <input type="text" name="dep_actype" value="<?= set_value('dep_actype'); ?>" class="form-control" placeholder="" id="dep_actype_new" readonly>
                        </div>
                        <div class="col">
                            <label class="control-label" for="dep_acreg">ACREG</label>
                            <select name="dep_acreg" class="form-control select2-acreg" id="dep_acreg_new" required>
                                <option value="">Select ACREG</option>
                                <?php foreach($aircraft as $ac): ?>
                                    <option value="<?= $ac->acreg ?>" data-actype="<?= $ac->actype ?>"><?= $ac->acreg ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label class="control-label" for="dep_origin">ORIGIN</label>
                            <input type="text" name="dep_origin" value="<?= set_value('dep_origin'); ?>" class="form-control" placeholder="" id="dep_origin" required>
                        </div>
                        <div class="col">
                            <label class="control-label" for="dep_destination">DESTINATION</label>
                            <input type="text" name="dep_destination" value="<?= set_value('dep_destination'); ?>" class="form-control" placeholder="" id="dep_destination" required>
                        </div>
                        <div class="col">
                            <label class="control-label" for="dep_bay">BAY</label>
                            <input type="text" name="dep_bay" value="<?= set_value('dep_bay'); ?>" class="form-control" placeholder="" id="dep_bay">
                        </div>
                        <div class="col">
                            <label class="control-label" for="dep_gate">GATE</label>
                            <input type="text" name="dep_gate" value="<?= set_value('dep_gate'); ?>" class="form-control" placeholder="" id="dep_gate">
                        </div>
                    </div>
                </div>
                <div class="row">  
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label" for="dep_std">STD</label>
                            <input type="datetime-local" name="dep_std" value="<?= set_value('dep_std') ?>" class="form-control" placeholder="" id="dep_std" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label" for="dep_etd">ETD</label>
                            <input type="datetime-local" name="dep_etd" value="<?= set_value('dep_etd') ?>" class="form-control" placeholder="" id="dep_etd" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">  
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label" for="dep_atd">ATA</label>
                            <input type="datetime-local" name="dep_atd" value="<?= set_value('dep_atd') ?>" class="form-control" placeholder="" id="dep_atd" readonly>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label" for="dep_airborne">AIRBORNE</label>
                            <input type="datetime-local" name="dep_airborne" value="<?= set_value('dep_airborne') ?>" class="form-control" placeholder="" id="dep_airborne" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="dep_status">STATUS</label>
                    <select name="dep_status" class="form-control" id="dep_status" required>
                        <option value="OPERATED">OPERATED</option>
                        <option value="NON-OPERATED">NON-OPERATED</option>
                    </select>
                </div> 

                <!-- <?php
                    echo "<pre>";
                    print_r($date);
                    echo "</pre>";
                ?> -->
            
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
                                
                <form action="<?= base_url('dailydeparture/generate_daily_excel'); ?>" method="POST" enctype="multipart/form-data">
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

        // Auto uppercase for text inputs
        $('input[type="text"]').on('input', function() {
            $(this).val($(this).val().toUpperCase());
        });

        // Initialize select2 for the input form
        $('.select2-acreg').select2({
            placeholder: 'Select ACREG',
            width: '100%'
        });

        // Handle change event for ACREG
        $('#dep_acreg_new').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var actype = selectedOption.data('actype');
            $('#dep_actype_new').val(actype);
        });
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