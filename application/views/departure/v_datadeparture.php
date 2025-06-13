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

<!-- <a href="<?= base_url('airlines/input'); ?>" class="btn btn-warning btn-sm btn-icon-split">
    <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
    </span>
    <span class="text">Add Airlines</span>
</a> -->

<!-- <a data-toggle="modal" data-target="#inputModal" class="btn btn-warning btn-sm btn-icon-split">
    <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
    </span>
    <span class="text text-white">Add Flight</span>
</a> -->

<form class="form-inline mb-3 justify-content-end" id="fna" method="post" action="<?= base_url('departure/filter'); ?>">
    <!-- <div class="form-group">    
        <a data-toggle="modal" data-target="#inputModal" class="btn btn-warning btn-sm btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text text-white">Add Flight</span>
        </a>
    </div>   -->

    <div class="form-group mr-5" style="display: flex; justify-content: center; align-items: center; height: 55px;">
        <h1 class="h4 text-gray-800 m-0"><?= $title; ?></h1>
    </div>

    <div class="row">
        <div class="col">
            <div style="background-image: url('<?= base_url('assets/admin-template/img/CARD-01.png') ?>'); 
                        background-size: 100% 100%;
                        background-position: center;
                        background-repeat: no-repeat;
                        height: 40px;
                        width: 110px;
                        border-radius: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: left;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <span class="font-weight-bold text-white" style="font-size: 16px; margin-left: 10px; margin-top: 10px;"><?= $total ?></span>
            </div>
        </div>
        <div class="col" style="margin-left: -10px;">
            <div style="background-image: url('<?= base_url('assets/admin-template/img/CARD-02.png') ?>'); 
                        background-size: 100% 100%;
                        background-position: center;
                        background-repeat: no-repeat;
                        height: 40px;
                        width: 110px;
                        border-radius: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: left;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <span class="font-weight-bold text-white" style="font-size: 16px; margin-left: 10px; margin-top: 10px;"><?= $totalpair ?></span>
            </div>
        </div>
        <div class="col" style="margin-left: -10px;">
            <div style="background-image: url('<?= base_url('assets/admin-template/img/CARD-03.png') ?>'); 
                        background-size: 100% 100%;
                        background-position: center;
                        background-repeat: no-repeat;
                        height: 40px;
                        width: 110px;
                        border-radius: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: left;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <span class="font-weight-bold text-white" style="font-size: 16px; margin-left: 10px; margin-top: 10px;"><?= $totalnotpair ?></span>
            </div>
        </div>
        <div class="col" style="margin-left: -10px;">
            <div style="background-image: url('<?= base_url('assets/admin-template/img/CARD-04.png') ?>'); 
                        background-size: 100% 100%;
                        background-position: center;
                        background-repeat: no-repeat;
                        height: 40px;
                        width: 110px;
                        border-radius: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: left;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <span class="font-weight-bold text-white" style="font-size: 16px; margin-left: 10px; margin-top: 10px;"><?= $totalcancel ?></span>
            </div>
        </div>
    </div>

  <div class="form-group ml-auto">
        <label class="control-label mr-1" for="date_a"></label>
        <input type="date" class="form-control form-control-sm" name="date_a" id="date_a" required value="<?php echo isset($_POST['date_a']) ? $_POST['date_a'] : (isset($date_a) ? $date_a : ''); ?>">
    </div>
    <div class="form-group ml-2">
        <label class="control-label mr-1" for="date_a"></label>
        <input type="date" class="form-control form-control-sm" name="date_b" id="date_b" required value="<?php echo isset($_POST['date_b']) ? $_POST['date_b'] : (isset($date_b) ? $date_b : ''); ?>">
    </div>
    
    <div class="form-group ml-2">
        <button type="submit" class="btn btn-sm btn-warning" style="background-color: #F26522;"><i class="fas fa-search"></i></button>
    </div>
</form>
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
<!-- DataTales Example -->
<form id="fnb" method="post" action="<?= base_url('departure/cancelflight'); ?>">
    <div class="card shadow mb-4 mt-3">
        <!-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-secondary">Season Schedule Pairing</h6>
        </div> -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning"></h6>
            <div class="row">
                <div class="col-sm-12">   
                    <a data-toggle="modal" data-target="#inputModal" class="btn btn-warning btn-sm btn-icon-split" style="display:none">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text text-white">Add Flight</span>
                    </a>
                    
                    <button type="submit" name="btnCancelFlight" class="btn btn-danger btn-sm btn-icon-split ml-1">
                        <span class="icon text-white-50">
                            <i class="fas fa-times"></i>
                        </span>
                        <span class="text text-white">Cancel Flight</span>
                    </button>

                    <button type="submit" name="btnSoftDeleteFlight" class="btn btn-dark btn-sm btn-icon-split ml-1" formaction="<?= base_url('departure/softdeleteflight'); ?>">
                        <span class="icon text-white-50">
                            <i class="fas fa-ban"></i>
                        </span>
                        <span class="text text-white">Delete Flight</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>NO</th>
                            <th>DEP FLIGHT</th>
                            <th>PAIR STATUS</th>
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
                    <tbody style="white-space: nowrap;">
                        <?php
                        $no = 1;
                        foreach ($departure as $key => $value) { ?>
                            <tr>
                                <td class="text-center">
                                    <!-- <input type="checkbox" name="check_flight_arr[]" value="<?= $value->arr_id ?>" onclick="syncSiblingCheckbox(this)"> -->
                                    <input type="checkbox" name="check_flight_dep[]" value="<?= $value->dep_id ?>" onclick="syncSiblingCheckbox(this)">
                                </td>
                                <td><?= $no++; ?></td>
                                <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->dep_flightno ?></td>
                                <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"><?= $value->paired ?></td>
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
                                    <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>"  style='text-align:center; color:#0CAD19; font-weight: 600;'><?= $value->dep_status ?></div></td>
                                <?php } else { ?>
                                    <td data-toggle="modal" data-target="#updateModal<?php echo $value->dep_id ?>" style='text-align:center; color:#0CAD19; font-weight: 600;'><?= $value->dep_status ?></td>
                                <?php } ?>
                                
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<!-- update modal -->
<?php
foreach ($departure as $key => $value) { ?>
    <div class="modal fade bd-example-modal-lg" id="updateModal<?php echo $value->dep_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center" id="exampleModalLongTitle">Detail Flight</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <?php echo form_open_multipart('departure/edit'); ?>
                    <div class="row">     
                        <div class="col">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 float-left"><b>DEPARTURE</b></h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">  
                                        <div class="col" style="display:none">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_id">DEP ID</label>
                                                <input type="text" name="dep_id" value="<?= $value->dep_id ?>" class="form-control" placeholder="" id="dep_id">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_flightno">DEP FLIGHT NO</label>
                                                <input type="text" name="dep_flightno" value="<?= $value->dep_flightno ?>" class="form-control" placeholder="" id="dep_flightno_<?= $value->dep_id ?>">
                                                <input type="hidden" name="dep_flightkey" id="dep_flightkey_<?= $value->dep_id ?>">
                                            </div>
                                        </div>
                                        <!-- <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_actype">ACTYPE</label>
                                                <input type="text" name="dep_actype" value="<?= $value->dep_actype ?>" class="form-control" placeholder="" id="dep_actype">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_acreg">ACREG</label>
                                                <input type="text" name="dep_acreg" value="<?= $value->dep_acreg ?>" class="form-control" placeholder="" id="dep_acreg">
                                            </div>
                                        </div> -->
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_actype">ACTYPE</label>
                                                <input type="text" name="dep_actype" value="<?= $value->dep_actype ?>" class="form-control" placeholder="" id="dep_actype_<?= $value->dep_id ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_acreg">ACREG</label>
                                                <input type="text" name="dep_acreg" value="<?= $value->dep_acreg ?>" class="form-control" placeholder="Enter Aircraft Registration" id="dep_acreg_<?= $value->dep_id ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">  
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_origin">ORI</label>
                                                <input type="text" name="dep_origin" value="<?= $value->dep_origin ?>" class="form-control" placeholder="" id="dep_origin">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_destination">DES</label>
                                                <input type="text" name="dep_destination" value="<?= $value->dep_destination ?>" class="form-control" placeholder="" id="dep_destination">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_bay">BAY</label>
                                                <input type="text" name="dep_bay" value="<?= $value->dep_bay ?>" class="form-control" placeholder="" id="dep_bay">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_gate">GATE</label>
                                                <input type="text" name="dep_gate" value="<?= $value->dep_gate ?>" class="form-control" placeholder="" id="dep_gate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">  
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_std">STD</label>
                                                <input type="datetime-local" name="dep_std" value="<?= $value->dep_std ?>" class="form-control" placeholder="" id="dep_std">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_etd">ETD</label>
                                                <input type="datetime-local" name="dep_etd" value="<?= $value->dep_etd ?>" class="form-control" placeholder="" id="dep_etd">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">  
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_atd">ATD</label>
                                                <input type="datetime-local" name="dep_atd" value="<?= $value->dep_atd ?>" class="form-control" placeholder="" id="dep_atd">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="control-label" for="dep_airborne">AIRBORNE</label>
                                                <input type="datetime-local" name="dep_airborne" value="<?= $value->dep_airborne ?>" class="form-control" placeholder="" id="dep_airborne">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="dep_status">STATUS</label>
                                        <select name="dep_status" class="form-control" id="dep_status">
                                            <option hidden value="<?= $value->dep_status ?>"><?= $value->dep_status ?></option>
                                            <option value="OPERATED">OPERATED</option>
                                            <option value="NON-OPERATED">NON-OPERATED</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning" id="btn_submit">SUBMIT</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
<?php } ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
$(document).ready(function() {
    window.setTimeout(function() {
        $("#notif").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 4000); 

    // Auto uppercase for text inputs
    $('input[type="text"]').on('input', function() {
        var value = $(this).val();
        value = value.trim().toUpperCase();
        $(this).val(value);
    });

    // Update flight key when flight number or origin changes
    function updateFlightKey(flightId) {
        var flightNo = $('#dep_flightno_' + flightId).val() || '';
        var origin = $('#dep_origin').val() || '';
        
        // Trim and uppercase
        flightNo = flightNo.trim().toUpperCase();
        origin = origin.trim().toUpperCase();
        
        // Get first 2 chars of flight number
        var prefix = flightNo.substr(0, 2);
        
        // Generate flight key like in Seasonarrival.php
        var flightKey = prefix + origin;
        flightKey = flightKey.replace(/[^A-Za-z0-9]/g, '');
        
        $('#dep_flightkey_' + flightId).val(flightKey);
    }

    // Handle flight number input
    $('input[id^="dep_flightno_"]').on('input', function() {
        var value = $(this).val();
        // Trim first
        value = value.trim();
        // Then uppercase and clean
        value = value.toUpperCase();
        value = value.replace(/[^A-Z0-9]/g, '');
        $(this).val(value);
        
        var flightId = $(this).attr('id').replace('dep_flightno_', '');
        updateFlightKey(flightId);
    });

    // Handle origin input
    $('input[id="dep_origin"]').on('input', function() {
        var value = $(this).val();
        // Trim first
        value = value.trim();
        // Then uppercase
        value = value.toUpperCase();
        $(this).val(value);
        
        // Update flight key for all flight numbers in this form
        $(this).closest('form').find('input[id^="dep_flightno_"]').each(function() {
            var flightId = $(this).attr('id').replace('dep_flightno_', '');
            updateFlightKey(flightId);
        });
    });

    $("form").submit(function() {
        // Final trim of all text inputs before submit
        $(this).find('input[type="text"]').each(function() {
            var value = $(this).val().trim();
            $(this).val(value);
        });
        
        // Update all flight keys one final time
        $(this).find('input[id^="dep_flightno_"]').each(function() {
            var flightId = $(this).attr('id').replace('dep_flightno_', '');
            updateFlightKey(flightId);
        });
        
        $(this).submit(function() {
            return false;
        });
        return true;
    }); 

    // Function to initialize autocomplete for ACREG inputs
    function initializeAcregAutocomplete(inputSelector, actypeSelector) {
        $(inputSelector).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '<?= base_url('arrival/get_aircraft_autocomplete') ?>',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    },
                    error: function() {
                        response([]);
                    }
                });
            },
            minLength: 1,
            delay: 300,
            select: function(event, ui) {
                if (ui.item) {
                    $(this).val(ui.item.value);
                    $(actypeSelector).val(ui.item.actype);
                }
                return false;
            },
            change: function(event, ui) {
                if (!ui.item) {
                    $(this).val('');
                    $(actypeSelector).val('');
                }
            }
        }).autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<div class='ui-menu-item-wrapper'><strong>" + item.value + "</strong><br><small>" + item.actype + "</small></div>")
                .appendTo(ul);
        };

        // Clear ACTYPE when ACREG is cleared
        $(inputSelector).on('change', function() {
            if (!$(this).val()) {
                $(actypeSelector).val('');
            }
        });
    }

    // Initialize autocomplete for all ACREG inputs in update modals
    $('.modal[id^="updateModal"]').each(function() {
        var modalId = $(this).attr('id');
        var flightId = modalId.replace('updateModal', '');
        
        // Initialize departure ACREG
        initializeAcregAutocomplete(
            '#dep_acreg_' + flightId,
            '#dep_actype_' + flightId
        );
    });

    // Add custom styles for autocomplete
    $('<style>').appendTo('head').text(`
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 99999 !important;
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .ui-autocomplete .ui-menu-item {
            padding: 5px 8px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
        }
        .ui-autocomplete .ui-menu-item:last-child {
            border-bottom: none;
        }
        .ui-autocomplete .ui-menu-item-wrapper {
            padding: 2px 0;
        }
        .ui-autocomplete .ui-menu-item strong {
            color: #333;
            font-size: 13px;
            display: inline-block;
            margin-right: 5px;
        }
        .ui-autocomplete .ui-menu-item small {
            color: #666;
            font-size: 12px;
        }
        .ui-autocomplete .ui-menu-item:hover,
        .ui-autocomplete .ui-menu-item .ui-state-active {
            background: #f5f5f5;
            border-color: #f5f5f5;
        }
        .ui-helper-hidden-accessible {
            display: none;
        }
    `);
}); 

// sync checkboxarr dan checkboxdep
function syncSiblingCheckbox(clicked) {
    const td = clicked.parentElement; 
    const checkboxes = td.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(cb => cb.checked = clicked.checked);
}

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