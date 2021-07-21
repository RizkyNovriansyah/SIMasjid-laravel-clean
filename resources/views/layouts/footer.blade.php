<footer class="main-footer">
  <div class="footer-left">
    <!-- <button id="dark-mode-btn" class="btn btn-dark">Dark Mode</button><br> -->
    Copyright &copy; <?php echo date('Y'); ?> <div class="bullet"></div> SIMASJID Ibnu Sina Malang
  </div>
  <div class="footer-right">
    2.0.0
  </div>
</footer>
</div>
</div>

<!-- General JS Scripts -->
<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- key popper js  integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- key bootstrap js integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous" -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="{{ asset('dist/assets/js/stisla.js') }}"></script>

<!-- JS Libraries -->
<!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<!-- <script src="{{ asset('dist/cleave.js/dist/cleave.min.js') }}"></script> -->
<!-- <script src="{{ asset('dist/cleave.js/dist/addons/cleave-phone.us.js') }}"></script> -->
<script src="{{ asset('dist/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
<script src="{{ asset('dist/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- <script src="{{ asset('dist/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script> -->
<script src="{{ asset('dist/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('dist/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('dist/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('dist/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('dist/summernote/dist/summernote-bs4.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('dist/assets/js/scripts.js') }}"></script>
<!-- <script src="{{ asset('dist/assets/js/custom.js') }}"></script> -->

<!-- Page Specific JS File -->
<script type="text/javascript">
  //dark-mode
  $(document).on("click", "#dark-mode-switch", function() {
    $('body').toggleClass('dark-mode');
    $('.section-body').toggleClass('dark-mode');
    $('.section-header').toggleClass('dark-mode');
    $('.main-footer').toggleClass('white-font');
    $('tr').toggleClass('dark-mode');
    $('th').toggleClass('dark-mode');
    $('th').toggleClass('white-font');
    $('h1').toggleClass('white-font');
    $('table').toggleClass('dark-mode');
    // }
  });
  $(document).ready(function() {

    // $("#dark-mode-btn").toggle(function() {
    //   alert("First handler for .toggle() called.");
    // }, function() {
    //   alert("Second handler for .toggle() called.");
    // });
    // if ($('#checkbox-dark-mode').prop("checked") == true) {
    //   $('body').addClass('dark-mode');
    //   $('.section-body').addClass('dark-mode');
    //   $('.section-header').addClass('dark-mode');
    //   $('.main-footer').addClass('white-font');
    //   $('tr').addClass('dark-mode');
    //   $('th').addClass('dark-mode');
    //   $('th').addClass('white-font');
    //   $('h1').addClass('white-font');
    //   $('table').addClass('dark-mode');
    //   $('table').css('background-color', '#6c757d !important');
    // }
    // $('body').addClass('dark-mode');
    // $('.section-body').addClass('dark-mode');
    // $('.section-header').addClass('dark-mode');
    // $('.main-footer').addClass('white-font');
    // $('tr').addClass('dark-mode');
    // $('th').addClass('dark-mode');
    // $('th').addClass('white-font');
    // $('h1').addClass('white-font');
    // $('table').addClass('dark-mode');
    // $('table').css('background-color', '#6c757d !important');
    //
  });
</script>
<script>
    $( "#createPekerjaanBtn" ).click(function() {
        console.log("click")
        createPekerjaan();
    });

    $( "#select_pekerjaan" ).click(function() {
        console.log("click")
        add_to_list();
    });

    $( "#submit-notulensi" ).click(function() {
        console.log("click")
        submit_notulensi();
    });

    $( "#cari-notulensi" ).click(function() {
        console.log("click")
        cari_notulensi();
    });

    $(document).on('click', '.delete-progress', function () {
      console.log("click")
      let id_delete = $(this).data("id-delete")
      deleting_list(id_delete)
    });

    function submit_notulensi() {
      let kehadiran_musyawarah = $("#kehadiran_musyawarah").select2("val")
      kehadiran_musyawarah = kehadiran_musyawarah.join(",")
      $("#all_kehadiran_id").val(kehadiran_musyawarah)
      $("#form_notulensi").submit()
    }

    function cari_notulensi() {
      let judul_musyawarah = $("#judul_musyawarah").val()
      let kata_kunci = $("#kata_kunci").val()

      let judul_musyawarah = $("#judul_musyawarah").val()
      let kata_kunci = $("#kata_kunci").val()
      
      let url = "{{route('musyawarahCariQuery')}}"
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
              console.log("data",data)
          }
      });   

    }

    let already_inserted_id = []

    function deleting_list(id_delete) {
      for (var i = already_inserted_id.length - 1; i >= 0; i--) {
        if (already_inserted_id[i] == id_delete) {
          already_inserted_id.splice(i, 1);
        }
      }
      $( '.flag-id-'+id_delete ).remove();
    }

    function add_to_list() {
      let option_pekerjaan_value = $( "#option_pekerjaan option:selected" ).val();

      var exist = already_inserted_id.includes(option_pekerjaan_value);
      if(exist){
        alert("Sudah dipilih sebelumnya");
        return
      } 
      already_inserted_id.push(option_pekerjaan_value);
      let option_pekerjaan_text = $( "#option_pekerjaan option:selected" ).text();
      console.log("option_pekerjaan_text", option_pekerjaan_text)
      console.log("option_pekerjaan_value", option_pekerjaan_value)
      add_card(option_pekerjaan_text,option_pekerjaan_value,"","","","")

      $('#selectPekerjaan').modal('toggle');
      $( '.modal-backdrop' ).remove();
    }

    function add_card(option_pekerjaan_text,option_pekerjaan_value,value_input_progress,value_input_masukkan,value_input_keputusan,id_progress) {
      let progress_html;
      if (id_progress != ""){
        progress_html = '<input type="text" name="id_progress[]" class="form-control" required="" value="'+id_progress+'" hidden>'
        $( "#body_progress" ).append(progress_html);
        progress_html = '<div class="section-title mt-0 flag-id-'+option_pekerjaan_value+'">'+option_pekerjaan_text+' </div></div><div class="form-group flag-id-'+option_pekerjaan_value+'"><textarea name="progress[]" class="form-control custom-textarea">'+value_input_progress+'</textarea> <input name="pekerjaan_id[]" type="text" value="'+option_pekerjaan_value+'" hidden></div>'
      } else {
        progress_html = '<div class="section-title mt-0 flag-id-'+option_pekerjaan_value+'">'+option_pekerjaan_text+' <button data-id-delete="'+option_pekerjaan_value+'" style="float:right" class="btn btn-icon btn-sm btn-warning delete-progress"><i class="fas fa-times"></i></button> </div></div><div class="form-group flag-id-'+option_pekerjaan_value+'"><textarea name="progress[]" class="form-control custom-textarea">'+value_input_progress+'</textarea> <input name="pekerjaan_id[]" type="text" value="'+option_pekerjaan_value+'" hidden></div>'
      }
      $( "#body_progress" ).append(progress_html);
      
      let masukkan_html = '<div class="section-title mt-0 flag-id-'+option_pekerjaan_value+'">'+option_pekerjaan_text+'</div><div class="form-group flag-id-'+option_pekerjaan_value+'"><textarea name="masukkan[]" class="form-control custom-textarea">'+value_input_masukkan+'</textarea></div>'
      $( "#body_masukkan" ).append(masukkan_html);
      let keputusan_html = '<div class="section-title mt-0 flag-id-'+option_pekerjaan_value+'">'+option_pekerjaan_text+'</div><div class="form-group flag-id-'+option_pekerjaan_value+'"><textarea name="keputusan[]" class="form-control custom-textarea">'+value_input_keputusan+'</textarea></div>'
      $( "#body_keputusan" ).append(keputusan_html);
    }

    function getProgressNotulensi(id) {
      let url = "{{route('musyawarahGetNotulensi', 'id_notulensi')}}"
      url = url.replace("id_notulensi", id);
        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {   
                console.log("data", data)
                data.forEach(element => {
                  already_inserted_id.push(element.id_pekerjaan);
                  console.log("element.keterangan", element.keterangan)
                  add_card(element.id_notulensi,element.id_pekerjaan,element.keterangan,element.masukkan,element.keputusan,element.id)
                });
                
            }
        });   
    }
    
    function createPekerjaan() {
        let nama_pekerjaan = $("#nama_pekerjaan").val()
        let deskripsi_pekerjaan = $("#deskripsi_pekerjaan").val()
        $.ajax({
            url: "pekerjaan/store",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
              nama_pekerjaan: nama_pekerjaan,
              deskripsi_pekerjaan: deskripsi_pekerjaan
            },
            success: function (data) {   
                console.log("data", data)
                let option_html = '<option value="'+data.id+'">'+data.nama+'</option>'
                $("#option_pekerjaan").append(option_html)
                
                $("#nama_pekerjaan").val("")
                $("#deskripsi_pekerjaan").val("")
            }
        });   
    }
</script>
</body>

</html>