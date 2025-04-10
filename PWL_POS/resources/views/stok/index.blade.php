@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Stok</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/stok/import') }}')" class="btn btn-info"><i
                        class="fa fa-file-excel"></i> Import Stok (.xlsx)</button>
                <a href="{{ url('/stok/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export
                    Stok (.xlsx)</a>
                <a href="{{ url('/stok/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export Stok
                    (.pdf)</a>
                <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-success"> + Tambah
                    Data</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <!-- constraint - jika barang sudah ada dalam tabel,tidak bisa tambah stok  -->
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> Catatan: Data stok untuk barang yang sama tidak boleh duplikat. Jika sudah
                ada, silakan edit data yang sudah ada.
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="barang_id" id="barang_id" class="form-control" required>
                                <option value="">- Semua Barang -</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Nama Barang</small>
                        </div>
                        <div class="col-3">
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">- Semua User -</option>
                                @foreach ($user as $item)
                                    <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Diupdate oleh</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
                    <thead>
                        <tr>
                            <th data-priority="1">ID</th>
                            <th data-priority="2">Kode Barang</th>
                            <th data-priority="3">Nama Barang</th>
                            <th data-priority="4">Petugas Update</th>
                            <th data-priority="5">Jumlah</th>
                            <th data-priority="6">Tanggal Stok</th>
                            <th data-priority="1">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
    <style>
        /* Pastikan tabel tidak melebihi lebar layar */
        .table-responsive {
            overflow-x: hidden !important;
            /* Hilangkan scroll horizontal */
            width: 100%;
        }

        #table_stok_wrapper {
            width: 100%;
            max-width: 100%;
        }

        #table_stok {
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Batasi teks panjang agar tidak memanjang */
        #table_stok td,
        #table_stok th {
            white-space: normal;
            /* wrap text*/
            word-wrap: break-word;
            /* Pecah kata jika terlalu panjang */
            max-width: 150px;
            /* Batasi lebar maksimum kolom */
        }

        /* Atur lebar kolom untuk layar kecil */
        @media (max-width: 768px) {

            #table_stok td,
            #table_stok th {
                max-width: 100px;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function (response, status, xhr) {
                if (status == "error") {
                    // Jika gagal memuat konten
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal memuat data: ' + xhr.status + ' ' + xhr.statusText,
                        confirmButtonText: 'OK'
                    });
                    $('#myModal').modal('hide'); // Sembunyikan modal jika gagal
                } else {
                    $('#myModal').modal('show'); // Tampilkan modal jika berhasil
                }
            });
        }

        $(document).ready(function () {
            var dataStok = $('#table_stok').DataTable({
                responsive: true, // fitur responsif
                autoWidth: false, // Nonaktifkan autoWidth agar lebar kolom lebih fleksibel
                scrollX: false, // Nonaktifkan scroll horizontal
                serverSide: true,
                ajax: {
                    "url": "{{ url('stok/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.barang_id = $('#barang_id').val();
                        d.user_id = $('#user_id').val();
                    }
                },
                columns: [
                    {
                        data: "stok_id",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                        responsivePriority: 1 
                    },
                    {
                        data: "barang_kode",
                        className: "",
                        orderable: true,
                        searchable: true,
                        responsivePriority: 2
                    },
                    {
                        data: "barang.barang_nama",
                        className: "",
                        orderable: true,
                        searchable: true,
                        responsivePriority: 3
                    },
                    {
                        data: "user.nama",
                        className: "",
                        orderable: true,
                        searchable: true,
                        responsivePriority: 4
                    },
                    {
                        data: "jumlah",
                        className: "",
                        orderable: true,
                        searchable: true,
                        responsivePriority: 5
                    },
                    {
                        data: "stok_tanggal",
                        className: "",
                        orderable: true,
                        searchable: true,
                        responsivePriority: 6
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false,
                        responsivePriority: 1
                    }
                ]
            });

            $('#barang_id, #user_id').on('change', function () {
                dataStok.ajax.reload();
            });

            // Perbarui tabel saat ukuran layar berubah
            $(window).on('resize', function () {
                dataStok.columns.adjust().responsive.recalc();
            });
        });
    </script>
@endpush