document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('print').addEventListener('click', function(){
        var params = '?';
        const forms = ['tahun', 'penerima', 'rt', 'rw', 'mekanisme_pembayaran', 'desa', 'ttl', 'jumlah'];
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
            { 
                data: 'penerima', 
                name: 'penerima',
                render: function(_, type, blt, meta){
                    return `
                        ${blt.nama}<br>
                        ${blt.nik}
                    `;
                }
            },
            { data: 'tanggal_lahir', name: 'tanggal_lahir'},
            { data: 'rt', name: 'rt'},
            { data: 'rw', name: 'rw'},
            { data: 'mekanisme_pembayaran', name: 'mekanisme_pembayaran'},
            { data: 'jumlah', name: 'jumlah'},
            {
                data: 'bukti_terima',
                name: 'bukti_terima',
                render: function(bukti_terima, type, blt, meta){
                    return `
                        <a href="${bukti_terima}" target="_blank">
                            <img src="${bukti_terima}" style="width:70px">
                        <a/>
                    `;
                }
            }
        ], 
        createdRow: function( row, data, dataIndex ){
            for(var i = 1; i <= 11; i++){
                if([4, 5].includes(i)){
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
    }

    // Pembuatan Individual Search Pada Bagian Footer
    $('#datatable tfoot th').each(async function (index) {
        var name = $(this).attr('id');
    
        if(['tahun', 'penerima', 'rt', 'rw', 'mekanisme_pembayaran', 'jumlah'].includes(name)){
            $(this).html(`
                <div class="form-group mb-0">
                    <input type="text" class="form-control text-center" name="${name}" placeholder="Cari ${$(this).html()}" id="${name}-form" data-index="${index}">
                </div>
            `);
        }else if(name === "desa"){
            const url = window.location.href;

            const response = await fetch(`${url.substring(0, url.lastIndexOf('/'))}/desa/onlyDesaJson`);
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
        }else if(name == "ttl"){
            $(this).html(`
                <div class="form-group">
                    <input type="date" class="form-control" name="${name}" id="${name}-form" data-index="${index}">
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
                    "Konfirmasi Penghapusan Data Penerima BLT",
                    "Apakah Anda Yakin ingin Menghapus Data Penerima BLT?",
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