$(document).ready(function() {
    getEmployee()
    $('#employee').select2({
        placeholder: 'Pilih Nama Pegawai',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "Data Tidak Ditemukan"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });
    // getJenkel()
    $('#jenkel').select2({
        placeholder: 'Pilih Jenis Kelamin',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "Data Tidak Ditemukan"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });

    getBank()
    $('#bank').select2({
        placeholder: 'Pilih Bank',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "<a onclick='setBank()' href='#'>Tambah Data</a>"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });

    getStatus()
    $('#status').select2({
        placeholder: 'Pilih Status Keluarga',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "<a onclick='setStatus()' href='#'>Tambah Data</a>"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });

    getDepartemen()
    $('#departemen').select2({
        placeholder: 'Pilih Status Departemen',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "<a onclick='setDepartemen()' href='#'>Tambah Data</a>"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });

    getAgama()
    $('#agama').select2({
        placeholder: 'Pilih Agama',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "<a onclick='setAgama()' href='#'>Tambah Data</a>"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });

    getPend()
    $('#pendidikan').select2({
        placeholder: 'Pilih Tingkat Pendidikan',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "<a onclick='setPend()' href='#'>Tambah Data</a>"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });

    getKantor()
    $('#kantor').select2({
        placeholder: 'Pilih Kantor Cabang',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "<a href='#' data-toggle='modal' data-target='#addKantor'>Tambah Data</a>"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });
    // getPosisi();
    $('#posisi').select2({
        placeholder: 'Pilih Posisi',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "<a href='#' onclick='setPosisi()'>Tambah Data</a>"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });
    // getAtasan();
    $('#atasan').select2({
        placeholder: 'Pilih Atasan',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "Data Tidak Ditemukan"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });
    getKota();
    $('#kota').select2({
        placeholder: 'Pilih Kota',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "<a href='#' onclick='setKota()'>Tambah Data</a>"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });
    $('#city').select2({
        placeholder: 'Pilih Kota Kelahiran',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "<a href='#' onclick='setKota()'>Tambah Data</a>"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });
    getRole();
    $('#role').select2({
        placeholder: 'Pilih Rule User',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "Data Tidak Ditemukan"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });

    // modal()
    $('#jabatan').select2({
        placeholder: 'Pilih Jabatan',
        closeOnSelect: false,
        width: '100%',
        "language":{
            "noResults": function(){
                return "<a href='#' data-toggle='modal' data-target='#addJabatan'>Tambah Data</a>"
            }
        },
        escapeMarkup: function(markup){
            return markup;
        }
    });
});
function getEmployee(){
    $.ajax({
        url : "/pegawai/manajemen/pegawai/show",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('#employee').empty()
            $('#employee').append('<option></option>')
            $.each(data, function(index, emp){
                $('#employee').append("<option value='"+emp.id+"'>"+emp.name+"</option>")
            })
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
// function setJenkel(){
//     let jenis = $('.select2-search__field').val();
//     $.ajax({
//         url : "/pegawai/master-data/jenis-kelamin/save/"+jenis,
//         type: "GET",
//         dataType: "JSON",
//         success: function(data)
//         {
//             getJenkel()
//         },
//         error: function (jqXHR, textStatus, errorThrown)
//         {
//             alert(errorThrown);
//         }
//     })
// }
function getBank(){
    $.ajax({
        url : "/pegawai/master-data/bank/show",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('#bank').empty()
            $('#bank').append('<option></option>')
            $.each(data, function(index, bank){
                $('#bank').append("<option value='"+bank.id+"'>"+bank.bank_name+"</option>")
            })
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
function setBank(){
    let bank = $('.select2-search__field').val();
    $.ajax({
        url : "/pegawai/master-data/bank/save/"+bank,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            getBank()
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
function getStatus(){
    $('#status').empty();
    $('#status').append('<option></option>')
    $.ajax({
        url : "/pegawai/master-data/status-keluarga/show",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $.each(data, function(index, status){
                $('#status').append("<option value='"+status.id+"'>"+status.family_status+"</option>")
            })
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
function setStatus(){
    let keluarga = $('.select2-search__field').val();
    $.ajax({
        url : "/pegawai/master-data/status-keluarga/save/"+keluarga,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            getStatus()
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
function getAgama(){
    $('#agama').empty();
    $('#agama').append('<option></option>')
    $.ajax({
        url : "/master/agama/show",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $.each(data, function(index, agama){
                $('#agama').append("<option value='"+agama.id+"'>"+agama.religion_name+"</option>")
            })
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
function setAgama(){
    let agama = $('.select2-search__field').val();
    $.ajax({
        url : "/master/agama/save/"+agama,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            getAgama()
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
function getPend(){
    $('#pendidikan').empty()
    $('#pendidikan').append('<option></option>')
    $.ajax({
        url : "/pegawai/master-data/pendidikan/show",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $.each(data, function(index, pend){
                $('#pendidikan').append("<option value='"+pend.id+"'>"+pend.education+"</option>")
            })
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
function setPend(){
    let pendidikan = $('.select2-search__field').val();
    $.ajax({
        url : "/pegawai/master-data/pendidikan/save/"+pendidikan,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            getPend()
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}

// function getPosisi(){
//     $.ajax({
//         url : "/main-menu/pegawai/master-data/posisi/show",
//         type: "GET",
//         dataType: "JSON",
//         success: function(data)
//         {
//             $.each(data, function(index, posisi){
//                 $('#posisi').append("<option value='"+posisi.id+"'>"+posisi.posisi+"</option>")
//             })
//         },
//         error: function (jqXHR, textStatus, errorThrown)
//         {
//             alert(errorThrown);
//         }
//     })
// }
// function setPosisi(){
//     let posisi = $('.select2-search__field').val();
//     $.ajax({
//         url : "/main-menu/pegawai/master-data/posisi/save/"+posisi,
//         type: "GET",
//         dataType: "JSON",
//         success: function(data)
//         {
//             $('#posisi').empty()
//             $('#posisi').append('<option></option>')
//             getPosisi()
//         },
//         error: function (jqXHR, textStatus, errorThrown)
//         {
//             alert(errorThrown);
//         }
//     })
// }

function getDepartemen(){
    $('#departemen').empty();
    $('#departemen').append('<option></option>')
    $.ajax({
        url : "/master/departemen/show",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $.each(data, function(index, departemen){
                $('#departemen').append("<option value='"+departemen.id+"'>"+departemen.department_name+"</option>")
            })
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
function setDepartemen(){
    let divisi = $('.select2-search__field').val();
    $.ajax({
        url : "/master/departemen/save/"+divisi,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            getDepartemen()
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
function myJabatan() {
    var departemen = document.getElementById('departemen').value
    $('#jabatan').empty()
        $.ajax({
            url : "/master/jabatan/detail/" + departemen,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#jabatan').append("<option></option")
                $.each(data, function(index, jabat){
                    $('#jabatan').append("<option value='"+jabat.id+"'>"+jabat.position_name+" "+jabat.level+"</option>")
                    $('#jabatan').selectpicker('refresh')
                    $('#jabatan').selectpicker('open')
                })
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert(errorThrown);
            }

        });
}
function myAtasan() {
    let departemen = document.getElementById('departemen').value,
        jabatan = document.getElementById('jabatan').value
        $('#atasan').empty()
        $('#atasan').append('<option></option>')
        $.ajax({
            url : "/pegawai/manajemen/pegawai/detail/" + departemen+"/"+jabatan,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $.each(data, function(index, atasan){
                    $('#atasan').append("<option value='"+atasan.id+"'>"+atasan.name+"</option>")
                })
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        })

}
function getKantor(){
    $('#kantor').empty();
    $('#kantor').append('<option></option>')
    $.ajax({
        url : "/master/kantor/show",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $.each(data, function(index, kantor){
                $('#kantor').append("<option value='"+kantor.id+"'>"+kantor.office_name+"</option>")
            })
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
function setKantor(){
    let kantor = $('.select2-search__field').val();
    $.ajax({
        url : "/master/kantor/save/"+kantor,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            getKantor()
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
function getKota(){
    $('#kota').empty()
    $('#kota').append('<option></option>')
    $('#city').empty()
    $('#city').append('<option></option>')
    $.ajax({
        url : "/master/kota/show",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $.each(data, function(index, kota){
                $('#kota').append("<option value='"+kota.id+"'>"+kota.name_of_city+"</option>")
                $('#city').append("<option value='"+kota.id+"'>"+kota.name_of_city+"</option>")
            })
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
function setKota(){
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
function getRole(){
    $.ajax({
        url : "/app/users/roles/show",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $.each(data, function(index, rule){
                $('#role').append("<option value='"+rule.id+"'>"+rule.label+"</option>")
            })
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
    })
}
