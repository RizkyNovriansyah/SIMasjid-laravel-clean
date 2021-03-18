@include('layouts.header')
@include('layouts.navbar')
<div class="main-content">
    <section class="section">
        <div class="row">
            <ol class="breadcrumb float-sm-left" style="margin-bottom: 10px; margin-left: 15px;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-mosque"></i> Home</a></li>
                <li class="breadcrumb-item active">Manajemen Aset</li>
            </ol>
        </div>
        @include('aset.menu_aset')
        <div class="section-header">
            <h1 style="margin:auto;"><i class="fa fa-table"></i> Data Aset</h1>
            <div></div>
        </div>
        <div class="section-body" style="min-height: 800px;">
            @include('aset.data_tab')
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    </br>
                    <div id="tanggal">
                        Tanggal Laporan: {{ now()->isoFormat('LLLL') }}
                    </div>
                    </br>
                    <table id="table_aset" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th id="no">No</th>
                                <th id="th_kondisi_aset">Kondisi Aset</th>
                                <th id="th_jumlah_aset">Jumlah</th>
                                <th id="th_nilai_aset">Total Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><a href="https://beta2.simasjid.my.id/aset/status/baik">Baik</a></td>
                                <td>{{ $aset_baik[0]->jumlah }}</td>
                                @if( $aset_baik[0]->nilai == NULL)
                                <td class="td_nilai_aset">0</td>
                                @else
                                <td class="td_nilai_aset">{{ $aset_baik[0]->nilai }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><a href="https://beta2.simasjid.my.id/aset/status/rusak">Rusak</a></td>
                                <td>{{ $aset_rusak[0]->jumlah }}</td>
                                @if( $aset_rusak[0]->nilai == NULL)
                                <td class="td_nilai_aset">0</td>
                                @else
                                <td class="td_nilai_aset">{{ $aset_rusak[0]->nilai }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><a href="https://beta2.simasjid.my.id/aset/status/diperbaiki">Diperbaiki</a></td>
                                <td>{{ $aset_diperbaiki[0]->jumlah }}</td>
                                @if( $aset_diperbaiki[0]->nilai == NULL)
                                <td class="td_nilai_aset">0</td>
                                @else
                                <td class="td_nilai_aset">{{ $aset_diperbaiki[0]->nilai }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><a href="https://beta2.simasjid.my.id/aset/status/dipinjam">Dipinjam</a></td>
                                <td>{{ $aset_dipinjam[0]->jumlah }}</td>
                                @if( $aset_dipinjam[0]->nilai == NULL)
                                <td class="td_nilai_aset">0</td>
                                @else
                                <td class="td_nilai_aset">{{ $aset_dipinjam[0]->nilai }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><a href="https://beta2.simasjid.my.id/aset/status/dilepas">Dilepas</a></td>
                                <td>{{ $aset_dilepas[0]->jumlah }}</td>
                                @if( $aset_dilepas[0]->nilai == NULL)
                                <td class="td_nilai_aset">0</td>
                                @else
                                <td class="td_nilai_aset">{{ $aset_dilepas[0]->nilai }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><b>Total Aset Aktif (tidak termasuk aset yang dilepas)</b></td>
                                <td>{{ $aset_aktif[0]->jumlah }}</td>
                                @if( $aset_aktif[0]->nilai == NULL)
                                <td class="td_nilai_aset">0</td>
                                @else
                                <td class="td_nilai_aset">{{ $aset_aktif[0]->nilai }}</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- SCRIPT -->
<script type="text/javascript">
    //JS halaman aktif
    document.getElementById("aset-link").classList.add("active");
</script>

<script type="text/javascript">
    function printDiv(id) {
        var div_id = "qr-label-" + id;
        var input_print = "print-input-qr-" + id;
        var num = document.getElementById(input_print).value;
        if (num == null || num == 0 || num < 0) {
            num = 1;
        }
        var divToPrint = document.getElementById(div_id);
        var newWin = window.open('', 'Print-window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">');
        for (i = 0; i < num; i++) {
            newWin.document.write(divToPrint.innerHTML);
        }
        newWin.document.write('</body></html>');

        newWin.document.close();
        setTimeout(function() {
            newWIn.close();
        }, 10);
    }

    //document function
    $(document).ready(function() {
        $("#menu_index").addClass("active");
        $("#laporan-tab").addClass("active");
        $(".custom-select").css('width', '82px');

        $('form').submit(function() {
            var form = $(this);
            $('input').each(function(i) {
                var self = $(this);
                try {
                    var v = self.autoNumeric('get');
                    self.autoNumeric('destroy');
                    self.val(v);
                } catch (err) {
                    console.log("Not an autonumeric field: " + self.attr("name"));
                }
            });
            return true;
        });

        //JQuery Pencarian Berdasarkan Kriteria


        //init table dynamic 
        //mobile and desktop
        var scroll_table = false;
        if ($(window).width() <= 760) {
            scroll_table = true;
        }
        var table = $('#table_aset').DataTable({
            pageLength: 50,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf"></i> PDF',
                    messageTop: 'Laporan Data Aset',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    messageTop: 'Laporan Data Aset',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
                    customize: function(win) {

                        var last = null;
                        var current = null;
                        var bod = [];

                        var css = '@page { size: potrait; }',
                            head = win.document.head || win.document.getElementsByTagName('head')[0],
                            style = win.document.createElement('style');

                        style.type = 'text/css';
                        style.media = 'print';

                        if (style.styleSheet) {
                            style.styleSheet.cssText = css;
                        } else {
                            style.appendChild(win.document.createTextNode(css));
                        }

                        head.appendChild(style);
                    }
                },
            ],
            "scrollX": scroll_table,
            "lengthChange": false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Kata Kunci Pencarian...",
                zeroRecords: "Data tidak tersedia",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
            },
            //kriteria column 0 nama tipe input
            initComplete: function() {
                //kriteria column 0 nama tipe select
                this.api().columns([1]).every(function() {
                    var column = this;
                    var select = $('<select class="form-control select2" id="select2-nama-barang" style="margin: 5px; width:100%;"><option value="">Nama Barang</option></select>')
                        .appendTo($("#filter-nama"))
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
                this.api().columns([2]).every(function() {
                    var column = this;
                    var select = $('<select class="form-control select2" id="select2-kategori" style="margin: 5px; width:100%;"><option value="">Kategori Aset</option></select>')
                        // .appendTo($(column.header()).empty())
                        .appendTo($("#filter-kategori"))
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
                    var input = $('<input class="form-control" placeholder="Jumlah" style="margin-bottom:10px;"></input>')
                        .appendTo($("#filter-jumlah"))
                        .on('keyup change clear', function() {
                            if (column.search() !== this.value) {
                                column
                                    .search(this.value)
                                    .draw();
                            }
                        });
                });
            }
        });

        //Android Remove Download PDF and Print Button Datatables
        if (typeof Android !== "undefined" && Android !== null) {
            $('.dt-buttons').remove();
        }

        //mobile
        if ($(window).width() <= 595) {
            $('#th_kategori_aset').hide();
            $('#th_status_aset').hide();
            // table.columns([1, 4, 5, 6, 7]).visible(false);
            $('.section-body').css({
                "padding": "0px"
            });
        }

        //tab or mobile landscape
        if ($(window).width() < 1280 && $(window).width() > 480) {
            // table.columns([6, 7]).visible(false);
        }
    });
    /* open action button listener */
    // action listener button
    $(document).on("click", ".open-pinjam", function() {
        /* passing data dari view button detail ke modal */
        var id_aset = $(this).data('id');
        var nama_barang = $(this).data('nama');
        var kode_aset = $(this).data('kode');
        var jumlah = $(this).data('jumlah');
        $("#id-aset-pinjam").val(id_aset);
        $("#nama-barang-pinjam").val(nama_barang);
        $("#kode-aset-pinjam").val(kode_aset);
        $("#jumlah-pinjam").val(jumlah);
        $("#max-jumlah-pinjam").html(jumlah);
    });
    $(document).on("click", ".open-update", function() {
        /* passing data dari view button detail ke modal */
        var this_id = $(this).data('id');
        $(".modal-footer #id-update").val(this_id);
        var this_nama = $(this).data('nama');
        $("#nama-update").val(this_nama);
        var this_kategori = $(this).data('kategori');
        $("#kategori-update").val(this_kategori);
        $('#kategori-update').select2({
            dropdownParent: $('#updateModal')
        });
        var this_lokasi = $(this).data('lokasi');
        $("#lokasi-update").val(this_lokasi);
        $('#lokasi-update').select2({
            dropdownParent: $('#updateModal')
        });
        var this_jumlah = $(this).data('jumlah');
        $("#jumlah-update").val(this_jumlah);
        var this_harga_satuan = $(this).data('harga_satuan');
        $("#harga_satuan-update").val(this_harga_satuan);
        //autoNumeric
        $(".harga").autoNumeric('update', {
            aSep: '.',
            aDec: ',',
            aSign: 'Rp. ',
            mDec: '0'
        });
    });
    $(document).on("click", ".open-perbaikan", function() {
        /* passing data dari view button detail ke modal */
        var id_aset = $(this).data('id');
        var nama_barang = $(this).data('nama');
        var kode_aset = $(this).data('kode');
        var jumlah = $(this).data('jumlah');
        $("#id-aset-perbaikan").val(id_aset);
        $("#nama-barang-perbaikan").val(nama_barang);
        $("#kode-aset-perbaikan").val(kode_aset);
        $("#jumlah-perbaikan").val(jumlah);
        $("#max-jumlah-perbaikan").html(jumlah);
    });
    $(document).on("click", ".open-lepas", function() {
        /* passing data dari view button detail ke modal */
        var id_aset = $(this).data('id');
        var nama_barang = $(this).data('nama');
        var kode_aset = $(this).data('kode');
        var jumlah = $(this).data('jumlah');
        $("#id-aset-lepas").val(id_aset);
        $("#nama-barang-lepas").val(nama_barang);
        $("#kode-aset-lepas").val(kode_aset);
        $("#jumlah-lepas").val(jumlah);
        $("#max-jumlah-lepas").html(jumlah);
    });

    /* close action button listener */

    $(document).on("click", "#filter-btn", function() {
        $('#filter-box').show();
    });

    //autoNumeric
    $(".td_nilai_aset").autoNumeric('init', {
        aSep: '.',
        aDec: ',',
        aSign: 'Rp. ',
        mDec: '0'
    });
</script>
@include('layouts.footer')