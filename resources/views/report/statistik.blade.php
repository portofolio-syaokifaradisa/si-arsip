@extends('app.app', [
    'title' => 'Laporan Statistik Desa/Kelurahan',
    'titlePage' => 'Halaman Laporan Data Statistik Desa/Kelurahan',
    'sectionTitle' => "Laporan Statistik Desa/Kelurahan",
    'sectionSubTitle' => 'Laporan data-data keseluruhan Statistik Desa/Kelurahan'
])

@section('content')
    <div class="card">
        <div class="card-header row">
            <h4 class="col">Tabel Statistik Desa/Kelurahan</h4>
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
                            <th class="text-center" style="width: 80px">Tahun</th>
                            <th class="text-center">Desa/Kelurahan</th>
                            <th class="text-center" style="width: 80px">Luas (Km&sup2;)</th>
                            <th class="text-center" style="width: 80px">Jumlah<br>Laki-laki</th>
                            <th class="text-center" style="width: 80px">Jumlah<br>Perempuan</th>
                            <th class="text-center" style="width: 80px">Jumlah<br>Warga</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <th id="no">No.</th>
                        <th id="tahun">Tahun</th>
                        <th id="desa">Desa</th>
                        <th id="wilayah">Luas (Km&sup2;)</th>
                        <th id="lk">Jumlah Laki-laki</th>
                        <th id="lp">Jumlah Perempuan</th>
                        <th id="jumlah">Jumlah</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js-extends')
    <script>
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
            
                    window.open(`${window.location.href.replace("/report", "")}/print${params}`, '_blank');
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
                    { data: 'tahun', name: 'tahun'},
                    { data: 'desa', name: 'desa'},
                    { data: 'wilayah', name: 'wilayah'},
                    { data: 'lk', name: 'lk'},
                    { data: 'lp', name: 'lp'},
                    { data: 'jumlah', name: 'jumlah'},
                ], 
                createdRow: function( row, data, dataIndex ){
                    for(var i = 1; i <= 7; i++){
                        if(i === 3){
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