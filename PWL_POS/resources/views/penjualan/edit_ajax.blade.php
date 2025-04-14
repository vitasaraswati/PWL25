@empty($penjualan)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data tidak ditemukan.
            </div>
        </div>
    </div>
</div>
@else
<form action="{{ url('/penjualan/' . $penjualan->penjualan_id . '/update_ajax') }}" method="POST" id="form-edit">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input value="{{ $penjualan->penjualan_kode }}" type="text" name="penjualan_kode" class="form-control">
                    <small id="error-penjualan_kode" class="error-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Petugas/Kasir</label>
                    <select name="user_id" class="form-control">
                        <option value="">- Pilih Petugas -</option>
                        @foreach($user as $u)
                            <option value="{{ $u->user_id }}" {{ $u->user_id == $penjualan->user_id ? 'selected' : '' }}>
                                {{ $u->nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-user_id" class="error-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Pembeli</label>
                    <input value="{{ $penjualan->pembeli }}" type="text" name="pembeli" class="form-control">
                    <small id="error-pembeli" class="error-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input value="{{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('Y-m-d') }}"
                           type="date" name="penjualan_tanggal" class="form-control">
                    <small id="error-penjualan_tanggal" class="error-text text-danger"></small>
                </div>
                <div class="form-group">
                    <h5>Detail Barang</h5>
                    <table class="table table-bordered" id="barangTable">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan->details as $detail)
                                <tr>
                                    <td>
                                        <select name="barang_id[]" class="form-control" required>
                                            <option value="">Pilih Barang</option>
                                            @foreach($barangs as $barang)
                                                <option value="{{ $barang->barang_id }}" {{ $detail->barang_id == $barang->barang_id ? 'selected' : '' }}>
                                                    {{ $barang->barang_nama }} (Rp {{ number_format($barang->harga_jual, 0, ',', '.') }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="error-barang_id text-danger"></small>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah[]" class="form-control" min="1" value="{{ $detail->jumlah }}" required>
                                        <small class="error-jumlah text-danger"></small>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success btn-sm" id="addRow">Tambah Barang</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Tambah baris barang
        $('#addRow').click(function() {
            let row = `
                <tr>
                    <td>
                        <select name="barang_id[]" class="form-control" required>
                            <option value="">Pilih Barang</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->barang_id }}">{{ $barang->barang_nama }} (Rp {{ number_format($barang->harga_jual, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                        <small class="error-barang_id text-danger"></small>
                    </td>
                    <td>
                        <input type="number" name="jumlah[]" class="form-control" min="1" required>
                        <small class="error-jumlah text-danger"></small>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                    </td>
                </tr>`;
            $('#barangTable tbody').append(row);
        });

        // Hapus baris barang
        $(document).on('click', '.remove-row', function() {
            if ($('#barangTable tbody tr').length > 1) {
                $(this).closest('tr').remove();
            }
        });

        // Validasi form
        $("#form-edit").validate({
            rules: {
                penjualan_kode: {
                    required: true,
                    minlength: 3
                },
                user_id: {
                    required: true
                },
                pembeli: {
                    required: true,
                    minlength: 3
                },
                penjualan_tanggal: {
                    required: true,
                    date: true
                },
                "barang_id[]": {
                    required: true
                },
                "jumlah[]": {
                    required: true,
                    min: 1
                }
            },
            messages: {
                penjualan_kode: {
                    required: "Kode penjualan wajib diisi",
                    minlength: "Kode penjualan minimal 3 karakter"
                },
                pembeli: {
                    required: "Nama pembeli wajib diisi",
                    minlength: "Nama pembeli minimal 3 karakter"
                },
                penjualan_tanggal: {
                    required: "Tanggal penjualan wajib diisi",
                    date: "Format tanggal tidak valid"
                },
                user_id: {
                    required: "Petugas/Kasir wajib dipilih"
                },
                "barang_id[]": {
                    required: "Barang wajib dipilih"
                },
                "jumlah[]": {
                    required: "Jumlah wajib diisi",
                    min: "Jumlah minimal 1"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: 'PUT', // Menggunakan POST sesuai implementasi controller
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            tablePenjualan.ajax.reload();
                        } else {
                            $('.error-text, .error-barang_id, .error-jumlah').text('');
                            if (response.msgField) {
                                $.each(response.msgField, function(prefix, val) {
                                    if (prefix.startsWith('barang_id')) {
                                        $(`#barangTable tbody tr:eq(${prefix.split('.')[1]}) .error-barang_id`).text(val[0]);
                                    } else if (prefix.startsWith('jumlah')) {
                                        $(`#barangTable tbody tr:eq(${prefix.split('.')[1]}) .error-jumlah`).text(val[0]);
                                    } else {
                                        $('#error-' + prefix).text(val[0]);
                                    }
                                });
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menyimpan data'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endempty