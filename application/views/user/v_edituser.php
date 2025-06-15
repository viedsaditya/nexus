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
                <h6 class="m-0 font-weight-bold text-secondary">Data User</h6>
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

                echo form_open_multipart('user/edit/' . $user->id_usr);
                ?>

                <!-- inputan data -->
                <div class="form-group">
                    <label class="control-label" for="fullname">Fullname</label>
                    <input type="text" name="fullname" value="<?= $user->fullname ?>" class="form-control" placeholder="" id="fullname">
                </div>
                <div class="form-group">
                    <label class="control-label" for="username">Username</label>
                    <input type="text" name="username" value="<?= $user->username ?>" class="form-control" placeholder="" id="username">
                </div>
                <div class="form-group" style="display:none">
                    <label class="control-label" for="password">Password</label>
                    <input type="text" maxlength="8" name="password" value="<?= $user->password ?>" class="form-control" placeholder="" id="password" oninput="this.value = this.value.replace(/[^0-9\a-z\A-Z]/g, '')">
                </div>
                <div class="form-group">
                    <label class="control-label" for="email">Email</label>
                    <input type="email" name="email" value="<?= $user->email ?>" class="form-control" placeholder="" id="email">
                </div>
                <div class="form-group" style="display:none">
                    <label class="control-label" for="id_sts">Station</label>
                    <select name="id_sts" class="form-control" id="id_sts">
                    <?php 
                        foreach ($sts as $l){
                            echo "<option value='$l->id_sts' ".((int)$user->id_sts === (int)$l->id_sts ? 'selected':'').">$l->code_station ($l->name_station)</option>";    
                        }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="id_role">Role Akses</label>
                    <select name="id_role" class="form-control" id="id_role">
                    <?php 
                        foreach ($roleakses as $l){
                            echo "<option value='$l->id_role' ".((int)$user->id_role === (int)$l->id_role ? 'selected':'').">$l->code_role</option>";    
                        }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="foto">Foto</label>
                    <input type="file" name="foto" class="form-control-file" id="foto">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-warning" style="background-color: #F26522;">Submit</button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <!-- Foto -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-secondary">Foto</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img id="fotopreview" src="<?= base_url('assets/upload/foto-user/' . $user->foto) ?>" alt="Foto Preview" width="100%" height="313px"></img>
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

    function readUrl(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#fotopreview').attr('src', e.target.result);
            }
                reader.readAsDataURL(input.files[0]);
        }
    }
    
    $('#foto').change(function() {
        readUrl(this);
    });
</script>