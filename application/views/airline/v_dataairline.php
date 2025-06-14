<style>
.pagination .page-item.active .page-link { 
    background-color: #F26522; 
    border-color: #F26522; 
}

div.dataTables_wrapper div.dataTables_paginate ul.pagination .page-item.active .page-link:focus {
    background-color: #F26522;
    border-color: #F26522; 
}

.pagination .page-item.active .page-link:hover {
    background-color: #F26522;
    border-color: #F26522; 
}

.nav-link a { 
    color: #F26522; 
}

input { 
    text-align: center; 
}
/* Border antar kolom, tanpa border kiri & kanan tabel */
#dataTable th, #dataTable td {
    border-top: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;
    border-right: 1px solid #dee2e6;
}
#dataTable th:first-child, #dataTable td:first-child {
    border-left: none !important;
}
#dataTable th:last-child, #dataTable td:last-child {
    border-right: none !important;
}

/* Border antar kolom DataTable, tanpa border kiri & kanan, dan border atas */
#dataTable th, #dataTable td {
    border-right: 1px solid #dee2e6 !important;
    border-bottom: 1px solid #dee2e6 !important;
    border-top: 1px solid #dee2e6 !important;
    border-left: none !important;
}
#dataTable th:last-child, #dataTable td:last-child {
    border-right: none !important;
}
#dataTable tr {
    border-left: none !important;
    border-right: none !important;
}
#dataTable {
    border-left: none !important;
    border-right: none !important;
    border-top: none !important;
}
</style>
<!-- <a href="<?= base_url('station/input'); ?>" class="btn btn-warning btn-sm btn-icon-split">
    <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
    </span>
    <span class="text">New Data</span>
</a> -->
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
<div class="form-group mr-5" style="display: flex; justify-content: left; align-items: left; height: 55px;">
        <h1 class="h4 text-gray-800 m-0"><?= $title; ?></h1>
    </div>
<!-- DataTales Example -->
<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3">
        <!-- <h6 class="m-0 font-weight-bold text-secondary">Data Station</h6> -->
        <a href="<?= base_url('airline/input'); ?>" class="btn btn-warning btn-sm btn-icon-split" style="background-color: #F26522;">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Add Airline</span>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>AIRLINE CODE</th>
                        <th>AIRLINE NAME</th>
                        <th>AIRLINE TERMINAL</th>
                        <th>AIRLINE STATION</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="white-space: nowrap;">
                    <?php
                    $no = 1;
                    foreach ($airline as $key => $value) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $value->airline_code ?></td>
                            <td><?= $value->airline_name ?></td>
                            <td><?= $value->airline_terminal ?></td>
                            <td><?= $value->airline_station ?></td>
                            <td style="text-align: center;">
                                <a href="<?= base_url('airline/edit/' . $value->id_air) ?>" class="btn btn-warning btn-sm" style="background-color: #F26522;">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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
        confirmButtonColor: '#F26522',
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
        confirmButtonColor: '#F26522',
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
        confirmButtonColor: '#F26522',
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