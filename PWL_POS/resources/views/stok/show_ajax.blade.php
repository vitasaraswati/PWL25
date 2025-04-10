<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Data Stok</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" class="form-control" value="{{ $stok->barang ? $stok->barang->barang_nama : 'Tidak ditemukan' }}" readonly>
            </div>
            <div class="form-group">
                <label>Petugas Update</label>
                <input type="text" class="form-control" value="{{ $stok->user ? $stok->user->nama : 'Tidak ditemukan' }}" readonly>
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" class="form-control" value="{{ $stok->jumlah ?? '0' }}" readonly>
            </div>
            <div class="form-group">
                <label>Tanggal Stok</label>
                <input type="text" class="form-control" value="{{ $stok->stok_tanggal ?? '-' }}" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Tutup</button>
        </div>
    </div>
</div>