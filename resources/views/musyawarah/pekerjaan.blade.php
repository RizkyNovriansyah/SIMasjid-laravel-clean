@include('layouts.header')
@include('layouts.navbar')

<?php
/* PHP UNTUK PENGATURAN VIEW */
//anggota terautentikasi
$authUser = Auth::user();
//hide untuk selain sekretaris dan ketua
$sekretaris = array(1, 2);
$inside_sekretaris = in_array($authUser->id_jabatan, $sekretaris);
?>

<div class="main-content">
    <section class="section">
        <div class="row">
            <ol class="breadcrumb float-sm-left" style="margin-bottom: 10px; margin-left: 15px;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-mosque"></i> Home</a></li>
                <li class="breadcrumb-item active">Musyawarah</li>
            </ol>
        </div>
        @include('musyawarah.menu_musyawarah')
        <div class="section-header">
            <div class="row" style="margin:auto;">
                <div class="col-12">
                    <h1><i class="fa fa-address-book"></i> Data Pekerjaan</h1>
                    <div></div>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <button style="margin: 1em auto;" class="btn btn-dark" data-toggle="collapse" data-target="#filter-box">
                    <i class="fa fa-filter"></i> Show/Close Filter Data
                </button>
                <div class="col-12">
                    <div id="filter-box" class="collapse">
                        <div class="card-body">
                            <h6 style="text-align:center"><i class="fa fa-filter"></i> Filter Data</h6>
                            <div class="column-search"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-action">
                                <a href="#" data-toggle="modal" data-target="#addModal" class="btn btn-danger">Tambah Pekerjaan <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="table_id" class="table table-striped table-bordered" style="padding-bottom:20px;">
                            <thead>
                                <tr>
                                    <th class="dt-center">No</th>
                                    <th class="dt-center">Nama</th>
                                    <th class="dt-center">Deskripsi</th>
                                    <th class="dt-center">PJ</th>
                                    <th class="dt-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pekerjaanGroup as $pekerjaan)
                                <tr>
                                    <td class="dt-center">{{ $loop->iteration }}</td>
                                    <td>{{ $pekerjaan->nama }}</td>
                                    <td>{{ $pekerjaan->deskripsi }}</td>
                                    <td>{{ $pekerjaan->penanggung_jawab->nama }}</td>
                                    <td class="dt-center">
                                        <div class="btn-group mb-3" role="group" aria-label="Basic example" style="padding-left: 20px;">
                                            <a href="#" class="open-detail btn btn-icon btn-sm btn-info" data-toggle="modal" data-id="{{ $pekerjaan->id }}" data-target="#detailModal"><i class="fas fa-id-badge"></i> Detail</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Detail -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="detailModal">
    <div class="modal-dialog custom-modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="detail-title-pekerjaan" class="modal-title">Pekerjaan 1 </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                        <form method="post" class="needs-validation" novalidate="">
                            <div class="card">
                            <!-- <div class="card-header">
                                <h4>Pekerjaan 1</h4>
                            </div> -->
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label><div id="detail-status" class="badge badge-pill badge-warning mb-1 float-right">Completed</div></label><br>
                                    <span id="detail-keterangan"></span>
                                </div>
                            </div>
                            <div class="card-footer pt-0">
                                <input style="display:none" id="id_modal_selected"/>
                                <div onclick="ubah_status_pekerjaan(1)" class="btn btn-danger">Ditolak</div>
                                <div onclick="ubah_status_pekerjaan(2)" class="btn btn-info">Aktifkan</div>
                                <!-- <div onclick="ubah_status_pekerjaan(3)" class="btn btn-primary">Batal</div> -->
                                <div onclick="ubah_status_pekerjaan(4)" class="btn btn-success">Selesai</div>
                                <script>
                                    function ubah_status_pekerjaan(tipe_status) {
                                        let id_modal_selected = $("#id_modal_selected").val()
                                        var linkDetail = "{{ route('home') }}/musyawarah/pekerjaan/update_status/" + id_modal_selected+"/"+tipe_status;
                                        console.log("linkDetail",linkDetail)
                                        $.get(linkDetail, function(data) {
                                            //deklarasi var obj JSON data detail anggota
                                            var obj = data;
                                            console.log("obj", obj)
                                            $("#id_modal_selected").val(id_modal_selected)
                                            set_detail_modal(obj)
                                        });
                                    }
                                </script>
                            </div>
                            </div>
                        </form>
                        </div>
                    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Aktivitas Terakhir</h4>
                                <div class="card-header-action">
                                    <a href="#" data-toggle="modal" data-target="#addProgressModal" class="btn btn-primary tambah-progress">Tambah progress</a>
                                </div>
                            </div>
                            <div class="card-body">             
                            <ul id="detail-list-progress" class="list-unstyled list-unstyled-border">
                                <li class="media">
                                    <img class="mr-3 rounded-circle" src="assets/img/avatar/avatar-1.png" alt="avatar" width="50">
                                    <div class="media-body">
                                        <div class="float-right text-primary">Now</div>
                                        <div class="media-title">Farhan A Mujib</div>
                                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                                    </div>
                                </li>
                                
                            </ul>
                            <div class="text-center pt-1 pb-1">
                                <!-- <a href="#" class="btn btn-primary btn-lg btn-round">
                                View All
                                </a> -->
                            </div>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="addProgressModal">
    <div class="modal-dialog" role="document">
        <!-- Modal Tambah Pekerjaan -->
        <div class="modal-content">
            <form id="addFormPekerjaanPekerjaan" action="{{ route('musyawarahAddProgressPekerjaan') }}" method="post">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Progress Pekerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless" style="width:100%; margin: auto;">
                        <tbody>
                            <tr>
                                <td><input name="progress" id="progress" class="form-control" required /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <input type="text" id="id_progress_pekerjaan" name="id_progress_pekerjaan" value="" hidden />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                    <input type="submit" value="Simpan" class="btn btn-primary submit-btn" />
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog" role="document">
        <form id="addPekerjaan" action="{{ route('musyawarahAddPekerjaan') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Pekerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless" style="width:90%; margin: auto;">
                        <tbody>
                            <tr>
                                <th scope="row">Nama Pekerjaan</th>
                                <td><input name="nama_pekerjaan" id="nama_pekerjaan" class="form-control" required /></td>
                            </tr>
                            <tr>
                                <th scope="row">Deskripsi</th>
                                <td><input name="deskripsi_pekerjaan" id="deskripsi_pekerjaan" class="form-control" required /></td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td><select class="form-control select" required>
                                        <option value="Menunggu Persetujuan">Menunggu Persetujuan</option>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Penanggung Jawab</th>
                                <td><select id="penanggung_jawab" name="penanggung_jawab" class="form-control select" required>
                                        @foreach ($anggotaGroup as $anggota)
                                        <option value="{{ $anggota->id }}">{{ $anggota->nama }}</option>
                                        @endforeach
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                    <input type="submit" value="Simpan" class="btn btn-primary submit-btn" />
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Delete -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Akun Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ route('home') }}/public/dist/assets/img/svg/trash.svg" id="detailFoto" class="mx-auto d-block" alt="hapus image" style="width:150px; height:150px;overflow: hidden;">

                <h5 align="center">Apakah Anda yakin ingin menghapus akun anggota ini?</h5>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ route('anggotaDelete') }}" method="post">
                    @csrf
                    <input type="text" id="id_delete" name="id" value="" hidden />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak, Batalkan</button>
                    <input type="submit" value="Ya, Hapus" class="btn btn-danger submit-btn submit-btn" />
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update -->
<div class="modal fade" tabindex="-1" role="dialog" id="updateModal">
    <div class="modal-dialog" role="document">
        <form action="{{ route('anggotaUpdate') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless" style="width:90%; margin: auto;">
                        <tbody>
                            <tr>
                                <th scope="row">Nama</th>
                                <td><input name="nama" id="updateNama" class="form-control" required /></td>
                            </tr>
                            <tr>
                                <th scope="row">Jabatan</th>
                                <td><select id="updateJabatan" name="id_jabatan" class="form-control select" required>
                                        <option value=5>Remaja Masjid</option>
                                        <option value=4>Takmir Masjid</option>
                                        <option value=3>Bendahara Takmir</option>
                                        <option value=2>Sekretaris Takmir</option>
                                        <option value=1>Ketua Takmir</option>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td><select id="updateStatus" name="id_status" class="form-control select" required>
                                        <option value=1>Aktif</option>
                                        <option value=2>Non-Aktif</option>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Username</th>
                                <td><input name="username" id="updateUsername" class="form-control" required /></td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td><input type="email" name="email" id="updateEmail" class="form-control" required /></td>
                            </tr>
                            <tr>
                                <th scope="row">Alamat</th>
                                <td><textarea name="alamat" id="updateAlamat" class="form-control" style="height: 82px;"></textarea></td>
                            </tr>
                            <tr>
                                <th scope="row">Telp/HP</th>
                                <td><input name="telp" id="updateTelp" class="form-control" required /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <input type="text" id="id_update" name="id" value="" hidden required />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                    <input type="submit" value="Simpan" class="btn btn-primary submit-btn" />
                </div>
            </div>
        </form>
    </div>
</div>
<!-- SCRIPT -->
<script type="text/javascript">
    //JQuery Pencarian Berdasarkan Kriteria
    $(document).ready(function() {
        $scroll_table = false;
        if ($(window).width() <= 480) {
            $scroll_table = true;
        }
        $('#table_id').DataTable({
            scrollX: $scroll_table,
            pageLength: 25,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf"></i> PDF',
                    messageTop: 'Data Anggota',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    messageTop: 'Data Anggota',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
            ],
            lengthChange: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Kata Kunci Pencarian...",
                zeroRecords: "Data tidak tersedia",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
            },
            //kriteria column 0 nama tipe input
            initComplete: function() {
                this.api().columns([1]).every(function() {
                    var column = this;
                    var input = $('<input class="form-control select" placeholder="Nama..." style="margin-bottom:10px;"></input>')
                        .appendTo($(".column-search"))
                        .on('keyup change clear', function() {
                            if (column.search() !== this.value) {
                                column
                                    .search(this.value)
                                    .draw();
                            }
                        });
                });
                //kriteria column 0 nama tipe select
                this.api().columns([2]).every(function() {
                    var column = this;
                    var select = $('<select class="form-control select" style="margin-bottom:10px;"><option value="">Jabatan...</option></select>')
                        // .appendTo($(column.header()).empty())
                        .appendTo($(".column-search"))
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
                this.api().columns([3]).every(function() {
                    var column = this;
                    var select = $('<select class="form-control select" style="margin-bottom:10px;"><option value="">Status...</option></select>')
                        // .appendTo($(column.header()).empty())
                        .appendTo($(".column-search"))
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });
    });
    //form prevent double input
    $('form').submit(function() {
        $('.submit-btn').prop( "disabled", true );
    });

    // onclick btn delete, show modal
    $(document).on("click", ".open-delete", function() {
        /* passing data dari view button detail ke modal */
        var thisDataAnggota = $(this).data('id');
        $(".modal-footer #id_delete").val(thisDataAnggota);
    });
    // onclick btn update, show modal
    $(document).on("click", ".open-update", function() {
        /* passing data dari view button detail ke modal */
        var thisDataAnggota = $(this).data('id');
        $(".modal-footer #id_update").val(thisDataAnggota);
        var linkDetail = "{{ route('home') }}/anggota/detail/" + thisDataAnggota;
        $.get(linkDetail, function(data) {
            //deklarasi var obj JSON data detail anggota
            var obj = data;
            // ganti elemen pada dokumen html dengan hasil data json dari jquery
            $(".modal-body #updateNama").val(obj.nama);
            $(".modal-body #updateJabatan").val(obj.id_jabatan);
            $(".modal-body #updateStatus").val(obj.id_status);
            $(".modal-body #updateUsername").val(obj.username);
            $(".modal-body #updateEmail").val(obj.email);
            $(".modal-body #updateAlamat").val(obj.alamat);
            $(".modal-body #updateTelp").val(obj.telp);
            //base root project url + url dari db
            // var link_foto = "{{ route('home') }}/" + obj.link_foto;
            // document.getElementById("detailFoto").src = link_foto;
        });
    });
    // onclick btn detail, show modal
    let data_index = "";
    $(document).on("click", ".tambah-progress", function() {
        console.log("data_index 1", data_index);
        $("#id_progress_pekerjaan").val(data_index);
    });

    function set_detail_modal(obj) {
        $("#detail-status").html(obj.status)
        $("#detail-title-pekerjaan").html(obj.nama+" ")
        $("#detail-keterangan").html(obj.deskripsi+" ")
        
        data_index = obj.id;
        console.log("data_index", data_index)
        let progress = obj.progress;
        let html_progress = ""
        
        for (let index = 0; index < progress.length; index++) {
            const element = progress[index];
            let link_foto = "{{ route('home') }}/" + element.pembuat_progress.link_foto;
            let text_html = '<li class="media">'+
            '<img class="mr-3 rounded-circle" src="'+link_foto+'" alt="avatar" width="50">'+
            '<div class="media-body">'+
            '<div class="float-right text-primary">'+element.created_at+'</div>'+
            '<div class="media-title">'+element.pembuat_progress.nama+'</div>'+
            '<span class="text-small text-muted">'+element.keterangan+'</span>'+
            '</div>'+
            '</li>'
            html_progress += text_html;
        }
        $("#detail-list-progress").html(html_progress)
        
        $("#detail-status").removeClass();
        let default_class = "badge badge-pill mb-1 float-right ";
        let add_class = ""
        if (obj.status == "Proses"){
            add_class = "badge-info"
        } else if (obj.status == "Menunggu Persetujuan"){
            add_class = "badge-warning"
        } else if (obj.status == "Ditolak"){
            add_class = "badge-danger"
        } else if (obj.status == "Batal"){
            add_class = "badge-danger"
        } else if (obj.status == "Selesai"){
            add_class = "badge-success"
        }
        $("#detail-status").addClass(default_class+add_class);
    }
    $(document).on("click", ".open-detail", function() {
        /* passing data dari view button detail ke modal */
        var thisDataAnggota = $(this).data('id');
        // $(".modal-body #id").val(thisDataAnggota);
        var linkDetail = "{{ route('home') }}/musyawarah/pekerjaan/detail/" + thisDataAnggota;
        $.get(linkDetail, function(data) {
            //deklarasi var obj JSON data detail anggota
            var obj = data;
            console.log("obj", obj)
            $("#id_modal_selected").val(thisDataAnggota)
            set_detail_modal(obj)
        });
    });
    $(document).ready(function() {
        //ganti ukuran show entries
        $('#menu_pekerjaan').addClass('active');
        $(".custom-select").css('width', '82px');
        status_colorized()
    });

    function status_colorized() {
        //status aktif bold
        $(".font-status").css('font-weight', 'bold');
        /* ganti warna sesuai status */
        //status aktif ubah warna hijau
        $(".font-status").filter(function() {
            return $(this).text() === 'Aktif';
        }).css('color', 'green');
        //status non-aktif ubah warna merah
        $(".font-status").filter(function() {
            return $(this).text() === 'Non-Aktif';
        }).css('color', 'red');
        //status belum verifikasi ubah warna abu2
        $(".font-status").filter(function() {
            return $(this).text() === 'Belum Verifikasi';
        }).css('color', '#dbcb18');
    }
</script>
@include('layouts.footer')