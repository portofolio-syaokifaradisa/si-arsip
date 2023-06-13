@extends('app.app', [
    'title' => 'Laporan Data Penerima BLT',
    'titlePage' => 'Halaman Laporan Data Penerima BLT',
    'sectionTitle' => "Laporan Data Penerima BLT",
    'sectionSubTitle' => 'Laporan data-data keseluruhan Penerima BLT'
])

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success mb-2">{{ Session::get('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header row">
            <h4 class="col">Tabel Penerima BLT</h4>
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
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Desa</th>
                            <th class="text-center">Penerima</th>
                            <th class="text-center">Tanggal<br>Lahir</th>
                            <th class="text-center">RT</th>
                            <th class="text-center">RW</th>
                            <th class="text-center">Mekanisme<br>Pembayaran</th>
                            <th class="text-center">Jumlah<br>Bantuan (Rp)</th>
                            <th class="text-center">Bukti Terima</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <th id="no">No.</th>
                        <th id="tahun">Tahun</th>
                        <th id="desa">Desa</th>
                        <th id="penerima">Penerima</th>
                        <th id="ttl">Tanggal Lahir</th>
                        <th id="rt">RT</th>
                        <th id="rw">RW</th>
                        <th id="mekanisme_pembayaran">Mekanisme Pembayaran</th>
                        <th id="jumlah">Jumlah Bantuan</th>
                        <th id="bukti_terima">Bukti Terima</th>
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
                const forms = ['tahun', 'penerima', 'rt', 'rw', 'mekanisme_pembayaran', 'desa', 'ttl', 'jumlah'];
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
        });
    </script>
@endsection