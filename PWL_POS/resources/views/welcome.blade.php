@extends('layouts.template')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Halo, {{ Auth::user()->username }}! ✨</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            Yuk, mulai kelola penjualan! 🚀 <br>
            Cek menu kiri untuk fitur-fitur yang bikin data rapi dan efisien.
        </div>
    </div>
@endsection