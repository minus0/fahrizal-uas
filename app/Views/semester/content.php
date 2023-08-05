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
            <div class="card-body">
                <?php
                if (session()->getFlashdata('success')) {
                ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> success</h5>
                        <?php echo session()->getFlashdata('success'); ?>
                    </div>
                <?php
                }
                ?>

                <a class="btn btn-sm btn-primary" href="<?php echo base_url(); ?>/semester/tambah"><i class="fa-solid fa-plus"></i>Tambah semester</a>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th style="width: 10px">No</th>
                            <th>ID Mahasiswa</th>
                            <th>Nama Mahasiswa</th>
                            <th>Prodi</th>
                            <th>Semester</th>
                            <th>Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_semester as $r) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $r['id_mahasiswa'] ?></td>
                                <td><?php echo $r['nama_mahasiswa'] ?></td>
                                <td><?php echo $r['prodi'] ?></td>
                                <td><?php echo $r['semester'] ?></td>
                                <td><?php echo $r['skor'] ?></td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="<?php echo base_url(); ?>/semester/edit/<?php echo $r['id_mahasiswa']; ?>"><i class="fa fa-solid fa-edit"></i></a>
                                    <a class="btn btn-xs btn-danger" href="#" onclick="return hapusconfig(<?php echo $r['id_mahasiswa'];?>);"><i class="fa fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<script>
    function hapusconfig(id) {
        Swal.fire({
            title: 'Anda yakin ingin menghapus data ini?',
            text: "Data akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href='<?php echo base_url();?>/semester/hapus/' +id;
            }
        })
    }
</script>
<?php
echo $this->endSection();
?>