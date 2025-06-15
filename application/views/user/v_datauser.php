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
<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card shadow mb-4 mt-3">
            <div class="card-header py-3">
                <!-- <h6 class="m-0 font-weight-bold text-warning">Data User</h6> -->
                <a href="<?= base_url('user/input'); ?>" class="btn btn-warning btn-sm btn-icon-split" style="background-color: #F26522;">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add User</span>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Fullname</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Email</th>
                                <th>Station</th>
                                <th>Role Akses</th>
                                <th>Foto</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="white-space: nowrap;">
                            <?php
                            $no = 1;
                            foreach ($user as $key => $value) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $value->fullname ?></td>
                                    <td><?= $value->username ?></td>
                                    <td>********</td>
                                    <td><?= $value->email ?></td>
                                    <td><?= $value->code_station ?></td>
                                    <td><?= $value->code_role ?></td>
                                    <td style="text-align: center;"><img src=<?= base_url('assets/upload/foto-user/' . $value->foto) ?> alt="Foto" width="120px" height="80px"></img></td>
                                    <?php if ($value->is_active == 1) { ?>
                                        <td style='text-align:center; color:#0CAD19; font-weight: 600;'>Active</div></td>
                                    <?php } else { ?>
                                        <td style='text-align:center; color:#C31F1F; font-weight: 600;'>Deactive</td>
                                    <?php } ?>

                                    <td style="text-align: center; width: 80px;">
                                        <a href="<?= base_url('user/edit/' . $value->id_usr) ?>" class="btn btn-warning btn-sm mb-1" title="Edit Data" style="background-color: #F26522;">
                                            <i class="fas fa-pen" style="padding: 0px 1px 0px 1px;"></i>
                                        </a>

                                        <br>
                                        <?php if($value->is_active==0) { ?>
                                            <a href="<?= base_url('user/activate/' . $value->id_usr) ?>" class="btn btn-danger btn-sm" id="btn_activate" title="Activate Data">
                                                <i class="fas fa-eye-slash"></i>
                                            </a>
                                        <?php } else if ($value->is_active==1) { ?>
                                            <a href="<?= base_url('user/deactivate/' . $value->id_usr) ?>" class="btn btn-success btn-sm" id="btn_deactivate" title="Deactivate Data">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        <?php } ?>

                                        <br>
                                        <button type="button" class="btn btn-danger btn-sm mt-1" style="background-color: #F26522;" data-toggle="modal" data-target="#resetpasswordModal<?php echo $value->id_usr ?>" title="Reset Password">
                                            <i class="fas fa-lock" style="padding: 0px 2px 0px 2px;"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
 

<!-- reset password modal -->
<?php
foreach ($user as $key => $value) { ?>
    <div class="modal fade" id="resetpasswordModal<?php echo $value->id_usr ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLongTitle">Reset Password</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <?php echo form_open_multipart('user/resetpassword/' . $value->id_usr); ?>
            <div class="form-group">
                <label class="control-label" for="password">New Password</label>
                <input type="text" maxlength="8" name="password" value="" class="form-control" placeholder="" id="password" oninput="this.value = this.value.replace(/[^0-9\a-z\A-Z]/g, '')" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-warning">CONFIRM</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">CANCEL</button>
        </div>
        <?php echo form_close(); ?>
        </div>
    </div>
    </div>
<?php } ?>

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

<?php if ($this->session->flashdata('pesanerror')) { ?>
    Swal.fire({
        icon: 'error',
        title: '<?= $this->session->flashdata('pesanerror') ?>',
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