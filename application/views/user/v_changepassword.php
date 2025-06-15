<div class="form-group mr-5" style="display: flex; justify-content: left; align-items: left; height: 55px;">
        <h1 class="h4 text-gray-800 m-0"><?= $title; ?></h1>
    </div>
<div class="row">
    <div class="col-lg-6">
        <!-- Data -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-secondary">Change Password</h6>
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

                echo form_open_multipart('user/changepassword/' . $user->id_usr);
                ?>

                <!-- inputan data -->
                <div class="form-group">
                    <label class="control-label" for="password">New Password</label>
                    <input type="text" maxlength="8" name="password" value="" class="form-control" placeholder="" id="password" oninput="this.value = this.value.replace(/[^0-9\a-z\A-Z]/g, '')">
                </div>
                <div class="form-group">
                    <label class="control-label" for="confirm_password">Confirm Password</label>
                    <input type="text" maxlength="8" name="confirm_password" value="" class="form-control" placeholder="" id="confirm_password" oninput="this.value = this.value.replace(/[^0-9\a-z\A-Z]/g, '')">
                    <span id='message' style="font-style:italic;"></span>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-warning" style="background-color: #F26522;">Submit</button>
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

        $(':button[type="submit"]').prop('disabled', true);
    });

    $('#password, #confirm_password').on('keyup', function () {
        if ($('#password').val() == $('#confirm_password').val()) {
            $('#message').html('*Password matching').css('color', 'green');
            $(':button[type="submit"]').prop('disabled', false);
        } else {
            $('#message').html('*Password not matching').css('color', 'red');
            $(':button[type="submit"]').prop('disabled', true);
        }
    });
</script>