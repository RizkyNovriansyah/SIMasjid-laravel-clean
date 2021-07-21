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
                    <h1><i class="fa fa-address-book"></i> Notulensi Musyawarah</h1>
                    <div></div>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <a href="{{ route('musyawarahCari') }}" style="margin: 1em auto;" class="btn btn-dark">
                    <i class="fa fa-filter"></i> Cari Musyawarah
                </a>
                <!-- <div class="col-12">
                    <div id="filter-box" class="collapse">
                        <div class="card-body">
                            <h6 style="text-align:center"><i class="fa fa-filter"></i> Filter Data</h6>
                            <div class="column-search"></div>
                        </div>
                    </div>
                </div> -->
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
                                <a href="{{ route('musyawarahAdd') }}" class="btn btn-danger">Tambah Notulensi <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="table_id" class="table table-striped table-bordered" style="padding-bottom:20px;">
                                <thead>
                                    <tr>
                                        <th class="dt-center">No</th>
                                        <th class="dt-center">Judul Musyawarah</th>
                                        <th class="dt-center">Status</th>
                                        <th class="dt-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notulensiGroup as $notulensi)
                                    <tr>
                                        <td class="dt-center">{{ $loop->iteration }}</td>
                                        <td>{{ $notulensi->judul_musyawarah }}</td>
                                        <td>{{ $notulensi->status }}</td>
                                        <td class="dt-center">
                                            <div class="btn-group mb-3" role="group" aria-label="Basic example" style="padding-left: 20px;">
                                                @if($notulensi->user_role)
                                                    @foreach ($notulensi->user_role as $user_role)
                                                        @if($notulensi->status == "Menunggu Persetujuan")
                                                            @if($user_role->role == "Notulen")
                                                                <a class="open-detail btn btn-icon btn-sm btn-warning" href="{{ route('musyawarahEdit',$notulensi->id) }}"><i class="fas fa-edit"></i> revisi</a>
                                                            @elseif($user_role->role == "Amir")
                                                                <a class="open-detail btn btn-icon btn-sm btn-primary" href="{{ route('musyawarahEdit',$notulensi->id) }}"><i class="far fa-check-circle"></i> Setujui</a>
                                                            @endif    
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <a href="#" class="open-detail btn btn-icon btn-sm btn-info" data-toggle="modal" data-id="{{ $notulensi->id }}" data-target="#detailModal"><i class="fas fa-id-badge"></i> Detail</a>
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
                <h5 class="modal-title">Detail Notulensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-body pb-0 pl-0 pt-0 pr-0">
                                <!-- Notulen list A -->
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                        <th>Pekerjaan</th>
                                        <th>Progress</th>
                                        <th>Keputusan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_progress_notulensi">                         
                                        
                                    </tbody>
                                    </table>
                                </div>
                                <!--  -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Komentar</h4>
                                <!-- <div class="card-header-action">
                                    <a href="#" data-toggle="modal" data-target="#addProgressModal" class="btn btn-primary tambah-progress">Tambah progress</a>
                                </div> -->
                            </div>
                            <div class="card-body">             
                            <ul id="detail-list-progress" class="list-unstyled list-unstyled-border">
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">Beri Komentar</div>
                                        <input id="isi_komentar" type="text" class="form-control">
                                        <input id="selected_detail" type="text" hidden>
                                        <div style="padding-top:10px;padding-bottom:10px;">
                                            <button id="send_komentar" onclick="send_komentar()" class="btn btn-primary btn-block">Submit</button>
                                        </div>
                                    </div>
                                </li>
                                <div id="komentar_user">
                                </div>
                                
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
    $(document).on("click", ".open-detail", function() {
        /* passing data dari view button detail ke modal */
        var thisDataNotulensi = $(this).data('id');
        
        $("#selected_detail").val(thisDataNotulensi)
        let url = "{{route('musyawarahGetNotulensi', 'id_notulensi')}}"
        url = url.replace("id_notulensi", thisDataNotulensi);
        // komentar_user list_progress_notulensi
        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {   
                $("#list_progress_notulensi").empty()
                data.forEach(element => {
                    let html_progress = '<tr><td><a href="#" class="font-weight-600">'+element.pekerjaan.nama+'</a></td><td><span>'+element.keterangan+'</span></td><td><span>'+element.keputusan+'</span></td></tr>'
                    $("#list_progress_notulensi").append(html_progress);

                    
                });
                
            }
        });  
        get_komentar(thisDataNotulensi)
    });

    function get_komentar(thisDataNotulensi) {
        $("#komentar_user").empty();
        url = "{{route('musyawarahGetKomentarNotulensi', 'id_notulensi')}}"
        url = url.replace("id_notulensi", thisDataNotulensi);
        // komentar_user list_progress_notulensi
        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {   
                data.forEach(element => {
                    $("#komentar_user").empty()
                    let html_progress = '<li class="media"><img class="mr-3 rounded-circle" src="'+element.anggota.link_foto+'" alt="avatar" width="50"><div class="media-body"><div class="float-right text-primary">'+element.updated_at+'</div><div class="media-title">'+element.anggota.nama+'</div><span class="text-small text-muted">'+element.keterangan+'</span></div></li>'
                    $("#komentar_user").append(html_progress);  
                });
                
            }
        });  
    }

    function send_komentar() {
        let selected_detail = $("#selected_detail").val()
        let isi_komentar = $("#isi_komentar").val()
        console.log("selected_detail", selected_detail)
        let url = "{{route('musyawarahStoreKomentarNotulensi')}}"
        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
            id_notulensi: selected_detail,
            isi_komentar: isi_komentar
            },
            success: function (data) {   
                console.log("data", data)
                get_komentar(selected_detail)
            }
        });   
    }

    $(document).ready(function() {
        //ganti ukuran show entries
        $('#menu_index').addClass('active');
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