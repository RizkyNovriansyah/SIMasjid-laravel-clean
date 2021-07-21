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
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i
                            class="fas fa-mosque"></i> Home</a></li>
                <li class="breadcrumb-item active">Cari Notulensi Musyawarah</li>
            </ol>
        </div>
        <!-- @include('musyawarah.menu_musyawarah') -->
        <div class="section-header">
            <div class="row" style="margin:auto;">
                <div class="col-12">
                    <h1><i class="fa fa-address-book"></i> Cari Notulensi Musyawarah</h1>
                    <div></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" id="judul_musyawarah" class="form-control" required=""
                                value="{{ $notulensi->judul_musyawarah ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Kata Kunci</label>
                            <input type="text" id="kata_kunci" class="form-control" required="" value="">
                        </div>
                    </div>

                    <div class="card-footer pt-0">
                        <button onclick="search()" id="cari-notulensi" class="btn btn-primary">Cari</button>
                    </div>
                </div>

            </div>
            <div class="col-lg-7 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Notulensi</h4>
                    </div>
                    <div class="card-body">
                        <ul id="list_notulensi" class="list-unstyled list-unstyled-border">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

        </div>
    </section>
</div>

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
                                                <button id="send_komentar" onclick="send_komentar()"
                                                    class="btn btn-primary btn-block">Submit</button>
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

<script>
    function search() {
        let judul_musyawarah = $("#judul_musyawarah").val()
        let kata_kunci = $("#kata_kunci").val()
        console.log("judul_musyawarah", judul_musyawarah)
        let url = "{{ route('musyawarahCariQuery') }}"
        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                judul_musyawarah: judul_musyawarah,
                kata_kunci: kata_kunci
            },
            success: function (data) {
                $("#list_notulensi").html("");
                console.log("data", data)

                data.forEach(element => {
                    let html_tag =
                        '<li class="media"><div class="media-body"><div class="float-right text-primary">' +
                        element.created_at +
                        '</div><div class="media-title open-detail" data-toggle="modal" data-id="' +
                        element.id + '" data-target="#detailModal">' + element.judul_musyawarah +
                        '</div><span class="text-small text-muted">' + element.msg_pp[0]
                        .keterangan + '</span></div></li>'
                    $("#list_notulensi").html(html_tag);
                });

            }
        });
    }

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

</script>
@include('layouts.footer')
