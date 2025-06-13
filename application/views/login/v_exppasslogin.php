<style>
.particlejs {
    position: absolute;
    z-index: 1;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
}
.title {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}
.card-body {
    z-index: 2;
}
</style>
<div class="row justify-content-center">
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header" style="background-color:#191c24; height:200px">
                <div class="particlejs" id="particles-js"></div>
                <div class="title">
                    <center><img class="img-profile" src="<?= base_url() ?>/assets/admin-template/img/jlogob.png" width="50px"></img>
                    <h6 class="text m-0 mt-3 font-weight-bold text-light"><b>GO DESKTOP</b></h6></center>
                </div>
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

                // pesan data berhasil disimpan
                if ($this->session->flashdata('pesan')) {
                    echo '<div id="notif" class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>';
                    echo $this->session->flashdata('pesan');
                    echo '</div>';
                }

                echo form_open_multipart('exppasslogin/changepassword');
                ?>

                <div class="form-group">
                    <label class="control-label" for="password">Change Password</label>
                    <div class="input-group">
                        <input maxlength="8" name="password" value="<?= set_value('password'); ?>" class="form-control pwd" type="password" placeholder="" id="password" oninput="this.value = this.value.replace(/[^0-9\a-z\A-Z]/g, '')" required>
                        <div class="input-group-append">
                            <span class="input-group-text reveal"><i class="fa fa-eye" id="eye"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn" style="background-color:#191c24; color:#fff; width: 120px;"><i class="fa fa-arrow-circle-right"> Submit</i></button>
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

const eye = document.querySelector("#eye")
$(".reveal").on('click',function() {
    eye.classList.toggle("fa-eye-slash");
    var $pwd = $(".pwd");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
    } else {
        $pwd.attr('type', 'password');
    }
});
</script>

