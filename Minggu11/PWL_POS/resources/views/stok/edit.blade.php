@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @if (empty($stok))
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <form action="{{ url('/stok/' . $stok->stok_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <select name="barang_id" id="barang_id" class="form-control" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->barang_id }}" {{ $stok->barang_id == $item->barang_id ? 'selected' : '' }}>
                                    {{ $item->barang_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama User</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">- Pilih User -</option>
                            @foreach ($user as $item)
                                <option value="{{ $item->user_id }}" {{ $stok->user_id == $item->user_id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ $stok->jumlah }}" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Stok</label>
                        <input type="date" name="stok_tanggal" id="stok_tanggal" class="form-control" value="{{ $stok->stok_tanggal }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('stok') }}" class="btn btn-default">Kembali</a>
                </form>
            @endif
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush