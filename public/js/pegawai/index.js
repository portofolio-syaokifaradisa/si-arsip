document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('print').addEventListener('click', function(){
        var params = '?';
        const forms = ['nama', 'nip', 'jabatan', 'golongan', 'unit_kerja'];
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
                render: function(_, type, pegawai, meta){
                    return `
                        <div class="btn-group dropright px-0 pr-2">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropright">
                                <a class="dropdown-item has-icon" href="${window.location.href}/${pegawai.id}/edit">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item has-icon delete-button" id="pegawai-${pegawai.id}" href="#">
                                    <i class="fas fa-trash-alt"></i>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    `;
                }
            },
            { data: 'nama', name: 'nama'},
            { data: 'nip', name: 'nip'},
            { data: 'jabatan', name: 'jabatan'},
            { data: 'golongan', name: 'golongan'},
            { data: 'unit_kerja', name: 'unit_kerja'},
        ], 
        createdRow: function( row, data, dataIndex ){
            for(var i = 1; i <= 7; i++){
                if([3, 4, 5].includes(i)){
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
            });
        }
    }); 

    // Pembuatan Individual Search Pada Bagian Footer
    $('#datatable tfoot th').each(function (index) {
        var name = $(this).attr('id');
    
        if(['nama', 'nip', 'jabatan', 'golongan', 'unit_kerja'].includes(name)){
            $(this).html(`
                <div class="form-group mb-0">
                    <input type="text" class="form-control text-center" name="${name}" placeholder="Cari ${$(this).html()}" id="${name}-form" data-index="${index}">
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
            console.log(deleteButton);
            deleteButton.addEventListener('click', function(e){
                e.preventDefault();
    
                var orderId = e.target.id.split('-')[1];

                confirmAlert(
                    "Konfirmasi Penghapusan Data Pegawai",
                    "Apakah Anda Yakin ingin Menghapus Data pegawai?",
                    async function(){
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