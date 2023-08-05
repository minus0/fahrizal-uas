<?php
echo $this->extend('tamplate/index');
echo $this->section('content');

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo $title_card; ?></h3>
            </div>
            <!-- /.card-header -->
            <form action="<?php echo $action; ?>" method="post">
                <div class="card-body">
                    <?php if (validation_errors()) {
                    ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            <?php echo validation_list_errors() ?>
                        </div>
                    <?php
                    }
                    ?>

                    <?php
                    if (session()->getFlashdata('error')) {
                    ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-warning"></i> error</h5>
                            <?php echo session()->getFlashdata('error'); ?>
                        </div>
                    <?php
                    }
                    ?>
                    <?php echo csrf_field() ?>
                    <?php
                    if(current_url(true)->getSegment(2) =='edit' ){
                        ?>
                            <input type="hidden" name="param" id="param" value="<?php echo $edit_data['id_mahasiswa'];?>"
                        <?php
                    }
                    ?>
                </div>
                    <div class="form-group">
                    <label for="id_mahasiswa">Id mahasiswa</label>
                        <div class = "col-sm-14">
                            <select name="id_mahasiswa" id="id_mahasiswa" class = "form-control">
                                <option value="">pilih ID Mahasiswa</option>
                                <?php
                    include "koneksi.php";
                    $query = mysqli_query($koneksi,"SELECT * FROM tb_mahasiswa") or die (mysqli_error($koneksi));
                    while($data = mysqli_fetch_array($query)){
                        echo "<option value=$data[id_mahasiswa]> $data[id_mahasiswa] </option";
                    }
                    ?>
                    </select>
                    </div>
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="nama_mahasiswa">Id mahasiswa</label>
                        <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" value="<?php echo empty(set_value('nama_mahasiswa')) ? (empty($edit_data['nama_mahasiswa']) ?"":$edit_data['nama_mahasiswa']) : set_value('nama_mahasiswa'); ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="prodi">Prodi</label>
                        <input type="text" name="prodi" id="prodi" value="<?php echo empty(set_value('prodi')) ? (empty($edit_data['prodi']) ?"":$edit_data['prodi']) : set_value('prodi'); ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <input type="text" name="semester" id="semester" value="<?php echo empty(set_value('semester')) ? (empty($edit_data['semester']) ?"":$edit_data['semester']) : set_value('semester'); ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="skor">Skor</label>
                        <input type="text" name="skor" id="skor" value="<?php echo empty(set_value('skor')) ? (empty($edit_data['skor']) ?"":$edit_data['skor']) : set_value('skor'); ?>" class="form-control">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
echo $this->endSection();
