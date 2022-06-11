<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Data Pengaduan &mdash; Welcome Admin</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Pengaduan</h1>
        <div class="section-header-button">
            <a href="<?= site_url('pengaduan/add') ?>" class="btn btn-primary">Tambah Data</a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">X</button>
                <b>Success !</b>
                <?= session()->getFlashdata('success') ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">X</button>
                <b>Success !</b>
                <?= session()->getFlashdata('error') ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Data Pengajuan</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-md display nowrap dataTable dtr-inline" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Jenis Aduan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($pengaduan as $key => $value) : ?>

                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $value['nama'] ?></td>
                                <td><?= $value['nik'] ?></td>
                                <td><?= $value['keterangan'] ?></td>
                                <td><?= date('d/m/Y', strtotime($value['tgl_pengaduan'])) ?></td>
                                <td> <a class="btn btn-warning btn-sm"><?= ($value['status'] == 0) ? 'pending' : 'terverifikasi' ?></a>
                                <td> <a class="btn btn-danger btn-sm" id="btn-modaldetail" onclick="lihatdetail(<?= $value['id']; ?>)">Lihat Detail</a>
                                </td>
                                <td class="text-center" style="width:15%">
                                    <?php if ($value['status'] == 0) { ?>
                                        <a href="<?= site_url('pengaduan/addverifikasi/' . $value['id']) ?>" class="btn btn-warning btn-info btn-sm"><i class="fas fa-user-check"></i></a>
                                    <?php } ?>
                                    <a href="<?= site_url('pengaduan/edit/' . $value['id']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i> </a>
                                    <!-- <form onsubmit="return false" method="post" class="d-inline"> -->
                                    <!-- <input type="hidden" name="_method" value="DELETE"> -->
                                    <button type="button" value="<?= $value['id'] ?>" onclick="remove(<?= $value['id']; ?>)" class="btn btn-danger remove btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <!-- </form> -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>





        <!-- Modal -->

</section>
<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Pengaduan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="nama_p"></p>
                <p id="nik_p"></p>
                <p id="no_hp_p"></p>
                <p id="keterangan_p"></p>
                <p id="sasaran_p"></p>
                <p id="status_p"></p>
                <p id="waktu_p"></p>
                <p id="tanggal_p"> </p>
                <p id="kecamatan_p"></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    // fungsi untuk hapus data
    //pilih selector dari table id pengaduan dengan class .delete
    $(document).ready(function() {
        $('#table1').DataTable();
        // $(".remove").click(function() {
        //   var id_pengaduan = $(this).val();
        //   console.log(id_pengaduan);
        //   alert(id_pengaduan);


        // });
    });

    function lihatdetail(id) {
        $.ajax({
            url: "<?php echo site_url('pengaduan/detail') ?>/" + id,
            type: "GET",
            dataType: "json",

            success: function(response) {
                console.log(response);
                $('#nama_p').html(response.data.nama);
                $('#nik_p').html(response.data.nik);
                $('#no_hp_p').html(response.data.no_hp);
                $('#keterangan_p').html(response.data.keterangan);
                $('#sasaran_p').html(response.data.sasaran);
                $('#status_p').html(response.data.status);
                $('#waktu_p').html(response.data.waktu);
                $('#tanggal_p').html(response.data.tgl_pengaduan);
                $('#kecamatan_p').html(response.data.kecamatan);

            }
        });
        $('#modaldetail').modal('show');
    }

    function remove(id) {
        Swal.fire({
                title: "Apakah anda yakin?",
                text: "Apabila terhapus anda tidak akan mendapatkan datanya kembali",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!',
            })
            .then((result) => {
                console.log(result.isConfirmed);
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo site_url('pengaduan/delete') ?>/" + id,
                        type: "DELETE",
                        data: $('#form').serialize(),

                        success: function(response) {
                            if (response) {
                                Swal.fire({
                                    title: 'Terhapus!',
                                    text: 'Data anda telah terhapus',
                                    icon: 'success',
                                    showCancelButton: false,
                                    showConfirmButton: true
                                }).then(
                                    (confirmed) => {
                                        window.location.href = "<?php echo site_url('pengaduan') ?>";
                                    }
                                );

                            }
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Data tidak jadi dihapus!',
                        text: 'Mantap!',
                        type: 'error'
                    })
                }
            });
    }
</script>
<div class="modal fade" id="modal-id_pengaduan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masukkan Data Verifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="Temuan">Temuan *</label>
                        <textarea class="form-control" id="temuan" placeholder="Masukan Temuan" name="temuan" required></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Tolong isi temuan terlebih dahulu.</div>
                    </div>

                    <div class="form-group">
                        <label for="Tindakan">Tindakan *</label>
                        <textarea class="form-control" id="tindakan" placeholder="Masukkan Tindakan" name="tindakan" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="Keterangan">Keterangan *</label>
                        <textarea class="form-control" id="keterangan" placeholder="Masukkan Keterangan" name="keterangan" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="Upload Foto">Upload Foto *</label>
                        <div class="col-sm-2">
                            <img src="/img/default.jpg" class="img-thumbnail img-preview">
                        </div>
                        <input type="file" class="form-control" id="sampul" name="sampul" onchange="previewImg()" multiple>
                    </div>


                    <div>
                        <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane mb-2">Verifikasi</i></button>
                        <button type="reset" class="btn btn-secondary">Batal</i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // $("#simpan").click(function() {

            //     var nama = $('#nama').val();
            //     var nik = $('#nik').val();
            //     var nomor_hp = $('#nomor_hp').val();
            //     var jenis_aduan = $('#jenis_aduan').val();
            //     var sasaran = $('#sasaran').val();
            //     var waktu = $('#waktu').val();
            //     var tgl_pengaduan = $('#tgl_pengaduan').val();
            //     var lokasi = $('#lokasi').val();
            //     var status = $('#status').val();

            //     $.ajax({

            //         url: "<?php echo site_url('pengaduan') ?>",
            //         type: "POST",
            //         data: $('#form').serialize(),

            //         success: function(response) {
            //             if (response) {
            //                 Swal.fire({
            //                         icon: 'success',
            //                         title: 'Data Berhasil disimpan!',
            //                         text: 'Anda akan di arahkan dalam 3 Detik',
            //                         timer: 3000,
            //                         showCancelButton: false,
            //                         showConfirmButton: false
            //                     })
            //                     .then(function() {
            //                         window.location.href = "<?php echo site_url('pengaduan') ?>";
            //                     });
            //             } else {
            //                 console.log(response);
            //                 $("#nama").attr("required", "required");
            //                 $("#nik").attr("required", "required");

            //                 $("#nama_error").text("Nama Harus diisi terlebih dahulu !");
            //                 $("#nik_error").text("NIK Harus diisi terlebih dahulu !");
            //                 $("#no_hp_error").text("Nomor HP Harus diisi terlebih dahulu !");
            //                 $("#waktu_error").text("Waktu Harus diisi terlebih dahulu !");
            //                 $("#sasaran_error").text("Sasaran Harus diisi terlebih dahulu !");
            //                 $("#tanggal_error").text("Tanggal Harus diisi terlebih dahulu !");
            //                 $("#lokasi_error").text("Lokasi Harus diisi terlebih dahulu !");

            //                 Swal.fire({
            //                     icon: 'error',
            //                     title: 'Data belum berhasil disimpan!',
            //                     text: 'silahkan coba lagi!'
            //                 });
            //             }

            //             // console.log(response);

            //         },
            //         error: function(response) {
            //             Swal.fire({
            //                 icon: 'error',
            //                 title: 'Data error!',
            //                 text: 'silahkan coba lagi!'
            //             });
            //         }
            //     });



            // });

            validator = $("#form").validate({
                submitHandler: function(form) {
                    $('#notloading').attr('hidden', true);

                    $('.loading-icon').removeAttr('hidden');
                    $('#btn-submit').attr('disabled', 'disabled');
                    $('.btn-text').html('Loading . . .');

                    // var toast_text;
                    var url = "<?php echo site_url('pengaduan') ?>";
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $(form).serialize(),
                        success: function(response) {
                            $('[name=<?= csrf_token() ?>]').val(response.csrf);
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Data Berhasil disimpan!',
                                    text: 'Anda akan di arahkan dalam 3 Detik',
                                    timer: 3000,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                })
                                .then(function() {
                                    window.location.href = "<?php echo site_url('pengaduan') ?>";
                                });
                        }
                    });
                    return false;
                },
                rules: {
                    //Form User
                    nama: {
                        required: true,
                        minlength: 3

                    },
                    nik: {
                        required: true,
                        number: true
                    },
                    no_hp: {
                        required: true,
                        rangelength: [10, 13]
                    },
                    sasaran: {
                        required: true
                    },
                    waktu: {
                        required: true
                    },
                    tgl_pengaduan: {
                        required: true
                    },
                    id_kecamatan: {
                        required: true
                    },
                },
                messages: {
                    //user
                    nama: {
                        required: "Nama tidak boleh kosong",
                        minlength: "Nama minimal 3 karakter"
                    },
                    nik: {
                        required: "NIK tidak boleh kosong",
                        number: "Nik harus berupa angka"
                    },
                    no_hp: {
                        required: "Nomor Handphone tidak boleh kosong",
                        rangelength: "Panjang minimal angka 10 karakter maksimal 13 karakter"
                    },
                    sasaran: {
                        required: "Sasaran tidak boleh kosong"
                    },
                    waktu: {
                        required: "Waktu tidak boleh kosong"
                    },
                    tgl_pengaduan: {
                        required: "Isi tanggal pengaduan"
                    },
                    id_kecamatan: {
                        required: "Pilih Kecamatan"
                    },
                },
                highlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                }
            });



        });
    </script>


    <?= $this->endSection() ?>