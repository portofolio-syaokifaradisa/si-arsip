@extends('app.app', [
    'title' => 'Laporan Desa/Kelurahan',
    'titlePage' => 'Halaman Laporan Data Desa/Kelurahan',
    'sectionTitle' => "Laporan Desa/Kelurahan",
    'sectionSubTitle' => 'Laporan data-data keseluruhan Desa/Kelurahan'
])

@section('content')
    <div class="card">
        <div class="card-header row">
            <h4 class="col">Tabel Desa/Kelurahan</h4>
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
                            <th class="text-center">Kode</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-center">Desa/Kelurahan</th>
                            <th class="text-center">Kabupaten</th>
                            <th class="text-center">Kecamatan</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Kepala<br>Desa/Lurah</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <th id="no">No.</th>
                        <th id="kode">Kode Desa/Kelurahan</th>
                        <th id="tipe">Tipe</th>
                        <th id="desa">Desa/Kelurahan</th>
                        <th id="kabupaten">Kabupaten</th>
                        <th id="kecamatan">Kecamatan</th>
                        <th id="alamat">Alamat</th>
                        <th id="kepala_desa">Kepala Desa/Lurah</th>
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
                const forms = ['kode', 'desa', 'alamat', 'kepala_desa', 'kabupaten', 'kecamatan', 'tipe'];
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
                    for(var i = 1; i <= 7; i++){
                        if([4, 5, 6, 7].includes(i)){
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
        });
    </script>
@endsection