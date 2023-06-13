@extends('app.app', [
    'title' => 'Laporan Perangkat Desa',
    'titlePage' => 'Halaman Laporan Data Perangkat Desa',
    'sectionTitle' => "Laporan Perangkat Desa",
    'sectionSubTitle' => 'Laporan data-data keseluruhan Perangkat Desa'
])

@section('content')
    <div class="card">
        <div class="card-header row">
            <h4 class="col">Tabel Perangkat Desa</h4>
            <div class="col">
                <button class="btn btn-outline-primary float-right" id="print">
                    <i class="fas fa-print mr-2"></i> Cetak Laporan
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="datatable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 15px">No</th>
                            <th class="text-center">Desa</th>
                            <th class="text-center">Nama Lengkap</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Kontak</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <th id="no">No.</th>
                        <th id="desa">Desa</th>
                        <th id="nama">nama</th>
                        <th id="jabatan">Jabatan</th>
                        <th id="kontak">Kontak</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js-extends')
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            document.getElementById('print').addEventListener('click', function(){
                var params = '?';
                const forms = ['nama', 'kontak', 'desa', 'jabatan'];
                for(var name of forms){
                    var formValue = document.getElementById(`${name}-form`).value;
                    params += `${name}=${formValue}`;
                    if(forms.indexOf(name) !== (forms.length - 1)){
                        params += '&';
                    }
                }

                window.open(`${window.location.href.replace("/report", "")}/print${params}`, '_blank');
            });

            const table = $("#datatable").dataTable({
                processing: true,
                serverSide: true,
                searching: true,
                dom: 'Brtip',
                ajax : `${window.location.href}/datatable`,
                columns: [
                    { data: 'no', name: 'no', orderable: false, searchable: false },
                    { data: 'desa', name: 'desa'},
                    { data: 'nama', name: 'nama'},
                    { data: 'jabatan', name: 'jabatan'},
                    { data: 'kontak', name: 'kontak'},
                ], 
                createdRow: function( row, data, dataIndex ){
                    for(var i = 1; i <= 6; i++){
                        if([3, 4, 5, 6].includes(i)){
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
            
                if(['nama', 'kontak'].includes(name)){
                    $(this).html(`
                        <div class="form-group mb-0">
                            <input type="text" class="form-control text-center" name="${name}" placeholder="Cari ${$(this).html()}" id="${name}-form" data-index="${index}">
                        </div>
                    `);
                }else if(name === "desa"){
                    var url = window.location.href;
                    url = url.substring(0, url.lastIndexOf('/'));

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
                }else if(name == 'jabatan'){
                    $(this).html(`
                        <div class="form-group mb-0" style="width: 100%">
                            <select class="form-control select2 category-select text-center" name="${name}" id="${name}-form" data-index="${index}">
                                <option value="SEMUA">Semua</option>
                                <option value="Sekretaris Desa">Sekretaris Desa</option>
                                <option value="Kaur Umum">Kaur Umum</option>
                                <option value="Kaur Perencanaan Keuangan">Kaur Perencanaan Keuangan</option>
                                <option value="Kasi Pemerintahan">Kasi Pemerintahan</option>
                                <option value="Kasi Pelayanan dan Kesejahteraan">Kasi Pelayanan dan Kesejahteraan</option>
                            </select>
                        </div>
                    `);
                }else{
                    $(this).html('');
                }
            });
        });
    </script>
@endsection