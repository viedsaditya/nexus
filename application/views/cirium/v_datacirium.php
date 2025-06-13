<style>
.pagination .page-item.active .page-link { 
    background-color: #f6c23e; 
    border-color: #f6c23e; 
}

div.dataTables_wrapper div.dataTables_paginate ul.pagination .page-item.active .page-link:focus {
    background-color: #f6c23e;
    border-color: #f6c23e; 
}

.pagination .page-item.active .page-link:hover {
    background-color: #f6c23e;
    border-color: #f6c23e; 
}

.nav-link a { 
    color: #f6c23e; 
}

input { 
    text-align: center; 
}
</style>

<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs justify-content-start">
            <li class="nav-link active">
                <a data-toggle="tab" href="#arrival">ARRIVAL</a>
            </li>
            <li class="nav-link">
                <a data-toggle="tab" href="#departure">DEPARTURE</a>
            </li>
        </ul>
    </div>
</div>

<div>
    <p></p>
</div>
<?php
// pesan data berhasil diedit / dihapus
// if ($this->session->flashdata('pesan')) {
//     echo '<div id="notif" class="alert alert-success alert-dismissible fade show" role="alert">
//             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//                 <span aria-hidden="true">&times;</span>
//             </button>';
//     echo $this->session->flashdata('pesan');
//     echo '</div>';
// }
?>

<div class="tab-content">
    <div id="arrival" class="tab-pane active">
        <!-- arrival -->
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card shadow mb-4 mt-3">
                    <div class="card-header py-3">
                        <!-- <h6 class="m-0 font-weight-bold text-warning">Data User</h6> -->
                        <!-- <a href="<?= base_url('user/input'); ?>" class="btn btn-warning btn-sm btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Add Flight</span>
                        </a> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <!-- <th class="text-center">#</th> -->
                                        <th>NO</th>
                                        <th>ARR FLIGHT</th>
                                        <th>ACTYPE</th>
                                        <th>ACREG</th>
                                        <th>ORI</th>
                                        <th>DES</th>
                                        <th>BAY</th>
                                        <th>GATE</th>
                                        <th>STA</th>
                                        <th>ETA</th>
                                        <th>ATA</th>
                                        <th>LANDING</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($arrival as $key => $value) { ?>
                                        <tr>
                                            <!-- <td class="text-center">
                                                <input type="checkbox" name="check_flight_arr[]" value="<?= $value->arr_id ?>" onclick="syncSiblingCheckbox(this)">
                                                <input type="checkbox" name="check_flight_dep[]" value="<?= $value->dep_id ?>" onclick="syncSiblingCheckbox(this)">
                                            </td> -->
                                            <td><?= $no++; ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>"><?= $value->arr_flightno ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>"><?= $value->arr_actype ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>"><?= $value->arr_acreg ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>"><?= $value->arr_origin ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>"><?= $value->arr_destination ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>"><?= $value->arr_bay ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>"><?= $value->arr_gate ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>"><?= $value->arr_sta == NULL ? NULL:strtoupper(date('d M H:i', strtotime($value->arr_sta))) ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>"><?= $value->arr_eta == NULL ? NULL:strtoupper(date('d M H:i', strtotime($value->arr_eta))) ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>"><?= $value->arr_ata == NULL ? NULL:strtoupper(date('d M H:i', strtotime($value->arr_ata))) ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>"><?= $value->arr_landing ?></td>
                                            <?php if ($value->arr_status == 'OPERATED') { ?>
                                                <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>" class="bg-success" style='text-align:center; color:#fff; padding: 40px 0;'><div class="nprinsley-detaxt"><?= $value->arr_status ?></div></td>
                                            <?php } else { ?>
                                                <td data-toggle="modal" data-target="#updateModal<?php echo $value->arr_id ?>" class="bg-danger" style='text-align:center; color:#fff; padding: 40px 0;'><?= $value->arr_status ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="departure" class="tab-pane">
        <!-- departure -->
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card shadow mb-4 mt-3">
                    <div class="card-header py-3">
                        <!-- <h6 class="m-0 font-weight-bold text-warning">Data User</h6> -->
                        <!-- <a href="<?= base_url('user/inputgf'); ?>" class="btn btn-warning btn-sm btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Add Flight</span>
                        </a> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="dataTable2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <!-- <th class="text-center">#</th> -->
                                        <th>NO</th>
                                        <th>DEP FLIGHT</th>
                                        <th>ACTYPE</th>
                                        <th>ACREG</th>
                                        <th>ORI</th>
                                        <th>DES</th>
                                        <th>BAY</th>
                                        <th>GATE</th>
                                        <th>STD</th>
                                        <th>ETD</th>
                                        <th>ATD</th>
                                        <th>AIRBORNE</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($departure as $key => $value) { ?>
                                        <tr>
                                            <!-- <td class="text-center">
                                                <input type="checkbox" name="check_flight_arr[]" value="<?= $value->arr_id ?>" onclick="syncSiblingCheckbox(this)">
                                                <input type="checkbox" name="check_flight_dep[]" value="<?= $value->dep_id ?>" onclick="syncSiblingCheckbox(this)">
                                            </td> -->
                                            <td><?= $no++; ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->dep_flightno ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->dep_actype ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->dep_acreg ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->dep_origin ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->dep_destination ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->dep_bay ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->dep_gate ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->dep_std == NULL ? NULL:strtoupper(date('d M H:i', strtotime($value->dep_std))) ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->dep_etd == NULL ? NULL:strtoupper(date('d M H:i', strtotime($value->dep_etd))) ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->dep_atd == NULL ? NULL:strtoupper(date('d M H:i', strtotime($value->dep_atd))) ?></td>
                                            <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->dep_airborne ?></td>
                                            <?php if ($value->dep_status == 'OPERATED') { ?>
                                                <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>" class="bg-success" style='text-align:center; color:#fff; padding: 40px 0;'><div class="nprinsley-detaxt"><?= $value->dep_status ?></div></td>
                                            <?php } else { ?>
                                                <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>" class="bg-danger" style='text-align:center; color:#fff; padding: 40px 0;'><?= $value->dep_status ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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

    $("form").submit(function() {
        $(this).submit(function() {
            return false;
        });
        return true;
    }); 

    // datatable
    $('#dataTable2').DataTable({
        "ordering": true
    });
}); 

$('.nav li').on('click', function(){
    $('.nav li').removeClass('active');
    $(this).addClass('active');
});

// set min value date_b > date_a
document.getElementById("date_a").onchange = function () {
    var input = document.getElementById("date_b");
    input.min = this.value;
}

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

// activate flasdata swiftalert
$(document).on('click', '#btn_activate', function(e) {
    e.preventDefault();
    var link = $(this).attr('href');
    Swal.fire({
        title: 'Are you sure will this data be activated?',
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#e74a3b',
        cancelButtonText: 'CANCEL',
        confirmButtonColor: '#4e73df',
        confirmButtonText: 'CONFIRM'
        }).then((result) => {
        if (result.isConfirmed) {
            if (result.isConfirmed) {
                window.location = link;
            }
        }
    })
})

// deactivate flasdata swiftalert
$(document).on('click', '#btn_deactivate', function(e) {
    e.preventDefault();
    var link = $(this).attr('href');
    Swal.fire({
        title: 'Are you sure will this data be deactivated?',
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#e74a3b',
        cancelButtonText: 'CANCEL',
        confirmButtonColor: '#4e73df',
        confirmButtonText: 'CONFIRM'
        }).then((result) => {
        if (result.isConfirmed) {
            if (result.isConfirmed) {
                window.location = link;
            }
        }
    })
})
</script>