<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Ajax CRUD</title>
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/materialize.min.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
          url: '{{ url('ajax/get') }}',
          type: 'GET',
          data: { index: true },
          success: function(data) {
            if (data.success = 1) {
              $("#tbody").html('');
              var i = 1;
              $.each(data.data, function(key, value) {
                $("#tbody").append('<tr id="tr-'+value.id+'"><td>'+i+'.</td><td id="td-nama-'+value.id+'">'+value.nama+'</td><td id="td-nomor_handphone-'+value.id+'">'+value.nomor_handphone+'</td><td id="td-opsi-'+value.id+'"><a href="javascript:void(0)" onclick="ubahKontak('+value.id+')"><div class="chip">UBAH</div></a><a href="javascript:void(0)" onclick="hapusKontak('+value.id+')"><div class="chip red white-text">HAPUS</div></a></td></tr>');
                i++;
              });
            }
          }
        });
      });
    </script>
  </head>
  <body>
    <div class="row">
      <div class="col s12 m3">
        <form id="data_kontak">
          <div class="input-field">
            <input type="text" name="nama" id="nama">
            <label for="nama">Nama</label>
          </div>
          <div class="input-field">
            <input type="text" name="nomor_handphone" id="nomor_handphone">
            <label for="nomor_handphone">Nomor Handphone</label>
          </div>
          <button type="submit" class="btn" style="width: 100%;">simpan</button>
        </form>
      </div>
      <div class="col s12 m9">
        <table>
          <thead>
            <tr>
              <th>No.</th>
              <th>Nama</th>
              <th>Nomor Handphone</th>
            </tr>
          </thead>
          <tbody id="tbody">
          </tbody>
        </table>
      </div>
    </div>

    <script type="text/javascript">
      function getKontak() {
        $.ajax({
          url: '{{ url('ajax/get') }}',
          type: 'GET',
          data: { index: true },
          success: function(data) {
            if (data.success = 1) {
              $("#tbody").html('');
              var i = 1;
              $.each(data.data, function(key, value) {
                $("#tbody").append('<tr id="tr-'+value.id+'"><td>'+i+'.</td><td id="td-nama-'+value.id+'">'+value.nama+'</td><td id="td-nomor_handphone-'+value.id+'">'+value.nomor_handphone+'</td><td id="td-opsi-'+value.id+'"><a href="javascript:void(0)" onclick="ubahKontak('+value.id+')"><div class="chip">UBAH</div></a><a href="javascript:void(0)" onclick="hapusKontak('+value.id+')"><div class="chip red white-text">HAPUS</div></a></td></tr>');
                i++;
              });
            }
          }
        });
      }

      function hapusKontak(id) {
        if (confirm("Hapus data?")) {
          $.ajax({
            url: '{{ url('ajax/delete') }}/'+id,
            type: 'POST',
            success: function(data) {
              if (data.success == 0) {
                alert(data.message);
              }
              else {
                alert(data.message);
                getKontak();
              }
            }
          });

        }
      }

      function ubahKontak(id) {
        getKontak();
        $.ajax({
          url: '{{ url('ajax/get') }}',
          type: 'POST',
          data: { id: ''+id+'' },
          success: function(data) {
            $("#td-nama-"+id).html('<div class="input-field"><input id="ubah_nama" type="text" name="nama" value="'+data.data.nama+'"></div>');

            $("#td-nomor_handphone-"+id).html('<div class="input-field"><input id="ubah_nomor_handphone" type="text" name="nomor_handphone" value="'+data.data.nomor_handphone+'"></div>');

            $("#td-opsi-"+id).html('<div class="col s12"><div class="col s6"><button onclick="updateKontak('+data.data.id+')" type="submit" class="btn" style="width: 100%;">simpan</button></div><div class="col s6"><button type="submit" class="btn red" style="width: 100%;" onclick="getKontak()">batal</button></div></div>');
          }
        });
      }

      function updateKontak(id) {
        var nama = $("#ubah_nama").val();
        var nomor_handphone = $("#ubah_nomor_handphone").val();

        if (nama.length == 0 || nomor_handphone.length == 0) {
          alert('masih ada data yang kosong');
        }
        else {
          $.ajax({
            url: '{{ url('ajax/update') }}',
            type: 'POST',
            data: {
              id: ''+id+'',
              nama: ''+nama+'',
              nomor_handphone: ''+nomor_handphone+''
            },
            success: function(data) {
              if (data.success==0) {
                alert(data.message);
              }
              else {
                alert(data.message);
                getKontak();
              }
            }
          });
        }
      }

      $(function() {
        $("#data_kontak").submit(function(e) {
          var nama = $("#nama").val();
          var nomor_handphone = $("#nomor_handphone").val();

          if (nama.length == 0 || nomor_handphone.length == 0) {
            alert('masih ada data yang kosong');
          }
          else {
            $.ajax({
              url: '{{ url('ajax/store') }}',
              type: 'POST',
              data:  $("#data_kontak").serializeArray(),
              success: function(data) {
                if (data.success = 0) {
                  alert(data.message);
                }
                else {
                  alert(data.message);
                  $("#tbody").html('');
                  getKontak();

                  $("#data_kontak").trigger("reset");
                }
              }
            });
          }
          e.preventDefault();
        });
      });
    </script>
  </body>
</html>
