@empty($penjualan)
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal">
                <span>×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">Data tidak ditemukan.</div>
        </div>
    </div>
</div>
@else
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Data Penjualan</h5>
            <button type="button" class="close" data-dismiss="modal">
                <span>×</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-sm">
                <tr>
                    <th width="30%">Kode Penjualan</th>
                    <td>{{ $penjualan->penjualan_kode }}</td>
                </tr>
                <tr>
                    <th>Petugas/Kasir</th>
                    <td>{{ $penjualan->user->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Pembeli</th>
                    <td>{{ $penjualan->pembeli }}</td>
                </tr>
                <tr>
                    <th>Tanggal Penjualan</th>
                    <td>{{ $penjualan->penjualan_tanggal }}</td>
                </tr>
            </table>
            <h5>Detail Barang</h5>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan->details as $detail)
                        <tr>
                            <td>{{ $detail->barang->barang_nama ?? '-' }}</td>
                            <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-success" onclick="window.print()">Cetak Struk</button>
        </div>
    </div>
</div>
@endempty

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .modal-content, .modal-content * {
            visibility: visible;
        }
        .modal-content {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .modal-footer {
            display: none;
        }
    }
</style>