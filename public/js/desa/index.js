document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('print').addEventListener('click', function(){
        var params = '?';
        const forms = ['kode', 'desa', 'alamat', 'kepala_desa', 'kabupaten', 'kecamatan', 'tipe'];
        for(var name of forms){
            var formValue = document.getElementById(`${name}-form`).value;
            params += `${name}=${formValue}`;
            if(forms.indexOf(name) !== (forms.length - 1)){
                params += '&';
            }
        }

        window.open(`${window.location.href}/print${params}`, '_blank');
    });

    const table = $("#datatable").dataTable({
        processing: true,
        serverSide: true,
        searching: true,
        dom: 'Brtip',
        ajax : `${window.location.href}/datatable`,
        columns: [
            { data: 'no', name: 'no', orderable: false, searchable: false },
            { 
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false,
                render: function(_, type, desa, meta){
                    console.log(desa);
                    return `
                        <div class="btn-group dropright px-0 pr-2">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropright">
                                <a class="dropdown-item has-icon" href="${window.location.href}/${desa.id}/edit">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item has-icon delete-button" id="desa-${desa.id}" href="#">
                                    <i class="fas fa-trash-alt"></i>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    `;
                }
            },
            { data: 'kode', name: 'kode'},
            { data: 'tipe', name: 'tipe'},
            { data: 'desa', name: 'desa'},
            { data: 'kabupaten', name: 'kabupaten'},
            { data: 'kecamatan', name: 'kecamatan'},
            { data: 'alamat', name: 'alamat'},
            { 
                data: 'kepala_desa', 
                name: 'kepala_desa',
                render: function(_, type, desa, meta){
                    return `
                        ${desa.kepala_desa} <br>
                        ${desa.kontak_kepala_desa}
                    `;
                }
            },
        ], 
        createdRow: function( row, data, dataIndex ){
            for(var i = 1; i <= 8; i++){
                if([5, 6, 7, 8].includes(i)){
                    $(row).children(`:nth-child(${i})`).addClass(`align-middle`);
                }else{
                    $(row).children(`:nth-child(${i})`).addClass(`text-center align-middle`);
                }
            }
        },
        initComplete: function () {
            this.api().columns().every(function () {
                var table = this;
                $('input', this.footer()).on('keyup change clear', function () {
                    table.search(this.value).draw();
                });
                $('select', this.footer()).on('keyup change clear', function () {
                    table.search(this.value).draw();
                });
            });
        }
    }); 

    // Pembuatan Individual Search Pada Bagian Footer
    $('#datatable tfoot th').each(function (index) {
        var name = $(this).attr('id');
    
        if(['kode', 'desa', 'alamat', 'kepala_desa', 'kabupaten', 'kecamatan'].includes(name)){
            $(this).html(`
                <div class="form-group mb-0">
                    <input type="text" class="form-control text-center" name="${name}" placeholder="Cari ${$(this).html()}" id="${name}-form" data-index="${index}">
                </div>
            `);
        }else if(name === "tipe"){
            $(this).html(`
                <div class="form-group mb-0" style="width: 100%">
                    <select class="form-control select2 category-select" name="${name}" id="${name}-form" data-index="${index}">
                        <option value="Semua">Semua</option>
                        <option value="Desa">Desa</option>
                        <option value="Kelurahan">Kelurahan</option>
                    </select>
                </div>
            `);
        }else{
            $(this).text('');
        }
    });

    // Inisialisasi Ulang Ketika Datatable di Refresh
    $('#datatable').on('draw.dt', function (datatable) {
        const deleteButtons = datatable.target.getElementsByClassName('delete-button');
        for(let deleteButton of deleteButtons){
            deleteButton.addEventListener('click', function(e){
                e.preventDefault();

                confirmAlert(
                    "Konfirmasi Penghapusan Data Desa",
                    "Apakah Anda Yakin ingin Menghapus Data Desa?",
                    async function(){
                        var orderId = e.target.id.split('-')[1];

                        const response = await fetch(
                            `${window.location.href}/${orderId}/delete`,
                            { method: "GET", headers: {'Content-Type': 'application/json'}}
                        );
            
                        const json = await response.json();
                        Swal.fire({icon: json.status, title: json.title, text: json.message});
                        if(json.status == 'success'){
                            table.api().ajax.reload(null, false);
                        }
                    }
                );
            });
        }
    });
});