<div class="form-group mr-5" style="display: flex; justify-content: left; align-items: left; height: 55px;">
        <h1 class="h4 text-gray-800 m-0"><?= $title; ?></h1>
    </div>
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-secondary">Flight Report</h6>
            </div>
            <div class="card-body">
                <form id="fna" method="post" action="<?= base_url('report/generatereportarrival'); ?>">
                    <div class="form-group">
                        <label class="control-label" for="date_a">From</label>
                        <input type="date" class="form-control" name="date_a" id="date_a" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="date_b">To</label>
                        <input type="date" class="form-control" name="date_b" id="date_b">
                    </div>

                    <div class="from-group ml-auto">
                        <label class="control-label" for="flightno">Flight</label>
                        <input type="text" name="flightno" class="form-control" id="flightno">
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-warning" style="background-color: #F26522;">Print</button>
                    </div>
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
    
    $("#date_a").click(function(){
        $("#date_b").prop('required',true);
    });

    // $("form").submit(function() {
    //     $(this).submit(function() {
    //         return false;
    //     });
    //     return true;
    // }); 
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
</script>