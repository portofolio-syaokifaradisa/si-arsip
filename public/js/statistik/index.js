document.addEventListener("DOMContentLoaded", function(){
    function setPrintButtonEvent(){
        document.getElementById('print').addEventListener('click', function(){
            var params = '?';
            const forms = ['wilayah', 'lk', 'lp', 'jumlah', 'tahun', 'desa'];
            for(var name of forms){
                var formValue = document.getElementById(`${name}-form`).value;
                params += `${name}=${formValue}`;
                if(forms.indexOf(name) !== (forms.length - 1)){
                    params += '&';
                }
            }
    
            window.open(`${window.location.href}/print${params}`, '_blank');
        });
    }

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
                render: function(_, type, kegiatan, meta){
                    return `
                        <div class="btn-group dropright px-0 pr-2">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropright">
                                <a class="dropdown-item has-icon" href="${window.location.href}/${kegiatan.id}/edit">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item has-icon delete-button" id="kegiatan-${kegiatan.id}" href="#">
                                    <i class="fas fa-trash-alt"></i>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    `;
                }
            },
            { data: 'tahun', name: 'tahun'},
            { data: 'desa', name: 'desa'},
            { data: 'wilayah', name: 'wilayah'},
            { data: 'lk', name: 'lk'},
            { data: 'lp', name: 'lp'},
            { data: 'jumlah', name: 'jumlah'},
        ], 
        createdRow: function( row, data, dataIndex ){
            for(var i = 1; i <= 8; i++){
                if(i === 4){
                    $(row).children(`:nth-child(${i})`).addClass(`align-middle`);
                }else{
                    $(row).children(`:nth-child(${i})`).addClass(`text-center align-middle`);
                }
            }
        },
        initComplete: function () {
            resetFooterFormEvent();
        }
    }); 

    function resetFooterFormEvent(){
        table.api().columns().every(function () {
            var table = this;

            // Event Form Input
            $('input', this.footer()).on('keyup change clear', function () {
                table.search(this.value).draw();
            });

            // Event Form Dropdown
            $('select', this.footer()).on('keyup change clear', function () {
                table.search(this.value).draw();
            });
        });

        setPrintButtonEvent();
    }

    // Pembuatan Individual Search Pada Bagian Footer
    $('#datatable tfoot th').each(async function (index) {
        var name = $(this).attr('id');
    
        if(['wilayah', 'lk', 'lp', 'jumlah', 'tahun'].includes(name)){
            $(this).html(`
                <div class="form-group mb-0">
                    <input type="text" class="form-control text-center" name="${name}" placeholder="Cari ${$(this).html()}" id="${name}-form" data-index="${index}">
                </div>
            `);
        }else if(name === "desa"){
            const url = window.location.href;

            const response = await fetch(`${url.substring(0, url.lastIndexOf('/'))}/desa/json`);
            const desa = await response.json();

            var desaOptions = '';
            for(var i = 0; i < desa.length; i++){
                desaOptions += `<option value="${desa[i].id}"> ${desa[i].nama_desa} </option>`;
            }

            $(this).html(`
                <div class="form-group mb-0" style="width: 100%">
                    <select class="form-control select2 category-select" name="${name}" id="${name}-form" data-index="${index}">
                        <option value="">Semua</option>
                        ${desaOptions}
                    </select>
                </div>
            `);

            resetFooterFormEvent();
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
                    "Konfirmasi Penghapusan Data Statistik Desa",
                    "Apakah Anda Yakin ingin Menghapus Data Statistik Desa?",
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