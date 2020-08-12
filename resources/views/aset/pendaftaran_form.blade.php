@include('layouts.header')
@include('layouts.navbar')

<div class="main-content">
  <section class="section">
    <div class="row">
      <div>
        <ol class="breadcrumb float-sm-left" style="margin-bottom: 10px; margin-left: 15px;">
          <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-mosque"></i> Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('asetIndex') }}">Manajemen Aset</a></li>
          <li class="breadcrumb-item active">Pendaftaran</li>
          <!-- <li class="breadcrumb-item active">Usulan</li> -->
        </ol>
      </div>
    </div>
    @include('aset.menu_aset')
    <div class="row">
      <div class="col-12">
        <div class="section-header">
          <h1 style="margin:auto;"><i class="fa fa-edit"></i> Pendaftaran</h1>
          <div></div>
        </div>
        <div class="section-body" style="min-height: 250px;">
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <form method="post" action="{{ route('asetCreateHasil') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-sm-12 col-lg-4 col-md-4">
                <div class="form-group">
                  <label class="d-block">Jenis Pendaftaran</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis" id="radio_tunggal" value="Tunggal" checked>
                    <label class="form-check-label" for="radio_aset_tetap">
                      Tunggal
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis" id="radio_jamak" value="Jamak">
                    <label class="form-check-label" for="radio_jamak">
                      Jamak
                    </label>
                  </div>
                </div>
                <div class="form-group" id="div_jumlah">
                  <label>Jumlah</label>
                  <input id="input_jumlah" name="jumlah" type="number" class="form-control" placeholder="Jumlah Barang" disabled>
                </div>
                <div class="form-group">
                  <label class="d-block">Apakah nama barang aset pernah didaftarkan?</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="masuk_katalog" value="Ya" checked>
                    <label class="form-check-label" for="dengan_katalog">
                      Ya
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="masuk_katalog" value="Tidak">
                    <label class="form-check-label" for="dengan_katalog">
                      Tidak
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-8">
                <div class="form-group">
                  <label>Nama Barang</label>
                  <select name="id_katalog" id="nama_dengan_katalog" class="form-control select2" style="width:100%;" required>
                    @foreach ($katalogGroup as $katalog)
                    <option value="{{ $katalog->id }}">{{ $katalog->nama_barang }}</option>
                    @endforeach
                  </select>
                  <input name="nama_barang" id="nama_tanpa_katalog" type="text" class="form-control" placeholder="Nama Barang" hidden disabled>
                </div>
                <div class="form-group" id="div_katalog">
                  <label>Kategori</label>
                  <select id="select_kategori" name="id_kategori" class="form-control select2" style="width:100%;" disabled>
                    @foreach ($kategoriGroup as $kategori)
                    <option value="{{ $kategori->id }}"> {{ $kategori->kode }} | {{ $kategori->nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Merek</label>
                  <input name="merek" id="nama_tanpa_katalog" type="text" class="form-control" placeholder="Merek">
                </div>
                <div class="form-group">
                  <label>Tipe/Model</label>
                  <input name="tipe" id="nama_tanpa_katalog" type="text" class="form-control" placeholder="Tipe/Model">
                </div>
                <div class="form-group">
                  <label>Lokasi</label>
                  <select name="id_lokasi" class="form-control select2" style="width:100%;" required>
                    @foreach ($lokasiGroup as $lokasi)
                    <option value="{{ $lokasi->id }}">{{ $lokasi->nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Sumber</label>
                  <select name="sumber" class="form-control" required>
                    <option value="Pengadaan">Pengadaan</option>
                    <option value="Hibah">Hibah</option>
                    <option value="Produksi">Produksi</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Status Kondisi</label>
                  <select name="status" class="form-control" required>
                    <option value="Baik">Baik</option>
                    <option value="Rusak">Rusak</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea name="keterangan" type="text" class="form-control" style="height: 112px;"></textarea>
                </div>
                <div class="form-group">
                  <label>Harga Perolehan</label>
                  <input id="harga_satuan" name="harga_satuan" type="text" class="form-control currency" required>
                </div>
                <div class="form-group">
                  <span id="img_uploaded" style="text-align: center;" class="img-thumbnail rounded mx-auto d-block">
                    <img src="{{ route('home') }}/public/storage/foto_aset/not-available.jpg" id="blah" alt="foto profil" style="max-width:250px; overflow: hidden;" required><br>
                  </span>
                  <label>Foto Aset</label>
                  <input type="file" required name="file" id="fileChooser" accept="image/*" class="form-control" onchange="return ValidateFileUpload()">
                </div>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-lg btn-info btn-primary">Submit</button>
            </div>
          </form>
          </br>
        </div>
      </div>
    </div>
  </section>
</div>
@include('layouts.footer')
<script type="text/javascript">
  //JS halaman aktif
  $("body").addClass("sidebar-mini");
  $("#menu_pencatatan").addClass("active");
  $("#aset-link").addClass("active");

  $("#div_jumlah").hide();
  $("input:radio[name=jenis]").on("change", function() {
    if ($("input[name='jenis']:checked").val() == "Tunggal") {
      $("#input_jumlah").prop("disabled", true);
      $("#input_jumlah").prop("required", false);
      $("#div_jumlah").hide();
    }
    if ($("input[name='jenis']:checked").val() == "Jamak") {
      $("#input_jumlah").prop("disabled", false);
      $("#input_jumlah").prop("required", true);
      $("#div_jumlah").show();
    }
  });

  //penentuan katalog atau tidak
  var data = "{{ json_encode($katalogJSON) }}";
  var katalogGroup = JSON.parse(data.replace(/&quot;/g, '"'));
  var katalogObject;
  $("#div_katalog").hide();
  $("input:radio[name=masuk_katalog]").on("change", function() {
    if ($("input[name='masuk_katalog']:checked").val() == "Ya") {
      $('#nama_dengan_katalog').next(".select2-container").show();
      $("#nama_dengan_katalog").prop("required", true);
      $("#nama_dengan_katalog").prop("disabled", false);
      $("#nama_tanpa_katalog").prop("hidden", true);
      $("#nama_tanpa_katalog").prop("disabled", true);
      $("#nama_tanpa_katalog").prop("required", false);
      $("#select_kategori").select2().prop("disabled", true);
      $("#select_kategori").select2().prop("required", false);
      $("#ket_kategori").prop("hidden", false);
      $("#div_katalog").hide();
    }
    if ($("input[name='masuk_katalog']:checked").val() == "Tidak") {
      $("#nama_tanpa_katalog").prop("hidden", false);
      $("#nama_tanpa_katalog").prop("disabled", false);
      $("#nama_tanpa_katalog").prop("required", true);
      $('#nama_dengan_katalog').next(".select2-container").hide();
      $("#nama_dengan_katalog").prop("required", false);
      $("#nama_dengan_katalog").prop("disabled", true);
      $("#select_kategori").select2().prop("disabled", false);
      $("#select_kategori").select2().prop("required", true);
      $("#div_katalog").show();
    }
  });

  $(document).ready(function() {
    $('#harga_satuan').autoNumeric('init', {
      aSep: '.',
      aDec: ',',
      aSign: 'Rp. ',
      mDec: '0'
    });

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
  });


  function ValidateFileUpload() {
    var fuData = document.getElementById('fileChooser');
    var FileUploadPath = fuData.value;

    //To check if user upload any file
    if (FileUploadPath == '') {
      alert("Silakan pilih dan upload gambar");

    } else {
      var Extension = FileUploadPath.substring(
        FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

      //The file uploaded is an image

      if (Extension == "gif" || Extension == "png" || Extension == "bmp" ||
        Extension == "jpeg" || Extension == "jpg") {

        // To Display
        if (fuData.files && fuData.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
            var loadingImage = loadImage(
              fuData.files[0],
              function(img) {
                // $('#blah').remove();
                $('#img_uploaded').html(img);
              }, {
                maxWidth: $('#img_uploaded').width(),
                orientation: true
              }
            );

            // $('#blah').attr('src', e.target.result);
          }

          reader.readAsDataURL(fuData.files[0]);
        }
      }

      //The file upload is NOT an image
      else {
        alert("Format foto yang diperbolehkan hanya GIF, PNG, JPG, JPEG dan BMP. ");
      }
    }
  }
</script>