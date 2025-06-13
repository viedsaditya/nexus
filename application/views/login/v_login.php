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
/* Updated styles for full-screen background */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
}
body {
    position: relative;
    background-image: url('<?= base_url() ?>/assets/admin-template/img/bckr-lgn.png');
    background-size: cover;
    background-position: left center;
    background-repeat: no-repeat;
}
body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 0;
}
.content-wrapper {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}
.card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
    border: none;
    z-index: 20;
}
.card-header {
    background-color: #FFF0E8 !important;
    border-bottom: none;
}
.login-btn {
    background-color: #F26522;
    color: #FFF0E8 ;
    padding: 8px 20px;
    border-radius: 5px;
    border: none;
    font-weight: 500;
}
.input-group-text.reveal {
    background-color:rgb(255, 255, 255);
    border-color: #ced4da;
    color:rgb(183, 183, 183);
    /* background-color: #FDEBE2;
    border-color: #ced4da;
    color: #F26522; */
    cursor: pointer;
}
</style>
<div class="content-wrapper" style="margin-top: -20px;">
    <div class="row d-flex align-items-center justify-content-center w-100">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header" style="background-color:#FFF0E8; height:200px">
                    <div class="particlejs" id="particles-js"></div>
                    <div class="title">
                        <center><img class="img-profile" src="<?= base_url() ?>/assets/admin-template/img/nexuslogolightclear.webp" width="75%" ></img>
                        <!-- <h6 class="text m-0 mt-3 font-weight-bold" style="color: #F26522;"><b>N E X U S</b></h6>
                        <h9 class="text m-0 mt-3 font-weight-bold" style="color: #F26522;"><b>Centerlized of Flight Schedule</b></h9></center> -->
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

                    echo form_open_multipart('login/index');
                    ?>

                    <div class="form-group">
                        <label class="control-label" for="username">Username</label>
                        <input type="text" maxlength="50" name="username" value="<?= set_value('username'); ?>" class="form-control" placeholder="" id="username" oninput="this.value = this.value.replace(/[^0-9\a-z\A-Z\.\-\@]/g, '')">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password</label>
                        <div class="input-group">
                            <input class="form-control pwd" type="password" maxlength="10" name="password" value="<?= set_value('password'); ?>" placeholder="" id="password" oninput="this.value = this.value.replace(/[^0-9\a-z\A-Z]/g, '')">
                            <div class="input-group-append">
                                <span class="input-group-text reveal"><i class="fa fa-eye" id="eye"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn" style="background-color:#F26522; color:#FDEBE2; width: 100%;">Login</button>
                    </div>

                    <?php echo form_close(); ?>
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