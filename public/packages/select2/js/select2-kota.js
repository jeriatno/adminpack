getCities();
    $('#cities').select2({
        placeholder: 'Pilih Kota',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "<a href='#' onclick='setCity()'>Tambah Data</a>"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });
function getCities(){
  $('#cities').empty()
  $('#cities').append('<option></option>')
  $.ajax({
      url : "/master/kota/show",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
          $.each(data, function(index, kota){
              if (kota.id == 1) {
                $('#cities').append("<option value='"+kota.id+"' selected>"+kota.name_of_city+"</option>")
              } else {
                $('#cities').append("<option value='"+kota.id+"'>"+kota.name_of_city+"</option>")
              }
          })
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert(errorThrown);
      }
  })
}
function setCities(){
  let kota = $('.select2-search__field').val();
  $.ajax({
      url : "/master/kota/save/"+kota,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
          getKota()
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert(errorThrown);
      }
  })
}
