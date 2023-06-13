@extends('app.app', [
    'title' => 'Laporan Kegiatan Desa',
    'titlePage' => 'Halaman Laporan Data Kegiatan Desa',
    'sectionTitle' => "Laporan Kegiatan Desa",
    'sectionSubTitle' => 'Laporan data-data keseluruhan Kegiatan Desa'
])

@section('content')
    <div class="card">
        <div class="card-header row">
            <h4 class="col">Tabel Kegiatan Desa</h4>
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
                            <th class="text-center">Tahun<br>Kegiatan</th>
                            <th class="text-center">Desa</th>
                            <th class="text-center">Nama Kegiatan</th>
                            <th class="text-center">Pagu (Rp)</th>
                            <th class="text-center">Realisasi (Rp)</th>
                            <th class="text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <th id="no">No.</th>
                        <th id="tahun">Tahun Kegiatan</th>
                        <th id="desa">Desa</th>
                        <th id="nama">Nama Kegiatan</th>
                        <th id="pagu">Pagu (Rp)</th>
                        <th id="realisasi">Realisasi (Rp)</th>
                        <th id="keterangan">Keterangan</th>
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
                const forms = ['tahun', 'nama', 'pagu', 'realisasi', 'keterangan', 'desa'];
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
                    { data: 'tahun', name: 'tahun'},
                    { data: 'desa', name: 'desa'},
                    { data: 'nama', name: 'nama'},
                    { data: 'pagu', name: 'pagu'},
                    { data: 'realisasi', name: 'realisasi'},
                    { data: 'keterangan', name: 'keterangan'},
                ], 
                createdRow: function( row, data, dataIndex ){
                    for(var i = 1; i <= 7; i++){
                        if([4, 5, 6].includes(i)){
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
            
                if(['tahun', 'nama', 'pagu', 'realisasi', 'keterangan'].includes(name)){
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
                }else{
                    $(this).text('');
                }
            });
        });
    </script>
@endsection