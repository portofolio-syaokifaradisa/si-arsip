@extends('app.app', [
    'title' => 'Laporan Pegawai',
    'titlePage' => 'Halaman Laporan Data Pegawai',
    'sectionTitle' => "Laporan Pegawai",
    'sectionSubTitle' => 'Laporan data-data keseluruhan pegawai'
])

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success mb-2">{{ Session::get('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header row">
            <h4 class="col">Tabel Pegawai</h4>
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
                            <th class="text-center">Nama Lengkap</th>
                            <th class="text-center">NIP</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Golongan</th>
                            <th class="text-center">Unit Kerja</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <th id="no">No.</th>
                        <th id="nama">Nama Lengkap</th>
                        <th id="nip">NIP</th>
                        <th id="jabatan">Jabatan</th>
                        <th id="golongan">Golongan</th>
                        <th id="unit_kerja">Unit Kerja</th>
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
            const forms = ['nama', 'nip', 'jabatan', 'golongan', 'unit_kerja'];
            for(var name of forms){
                var formValue = document.getElementById(`${name}-form`).value;
                params += `${name}=${formValue}`;
                if(forms.indexOf(name) !== (forms.length - 1)){
                    params += '&';
                }
            }

            window.open(`${window.location.href.replace("report", "superadmin")}/print${params}`, '_blank');
        });

        const table = $("#datatable").dataTable({
            processing: true,
            serverSide: true,
            searching: true,
            dom: 'Brtip',
            ajax : `${window.location.href}/datatable`,
            columns: [
                { data: 'no', name: 'no', orderable: false, searchable: false },
                { data: 'nama', name: 'nama'},
                { data: 'nip', name: 'nip'},
                { data: 'jabatan', name: 'jabatan'},
                { data: 'golongan', name: 'golongan'},
                { data: 'unit_kerja', name: 'unit_kerja'},
            ], 
            createdRow: function( row, data, dataIndex ){
                for(var i = 1; i <= 6; i++){
                    if([2, 3, 4].includes(i)){
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
    });
    </script>
@endsection