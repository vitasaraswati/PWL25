<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use App\DataTables\KategoriDataTable;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        KategoriModel::create([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
        ]);

        return redirect('/kategori');
    }

    public function edit($id)
    {
        $data = KategoriModel::findOrFail($id);
        return view('kategori.edit', ['kategori' => $data]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kodeKategori' => 'required',
            'namaKategori' => 'required'
        ]);

        //cari data berdasarkan id
        $kategori = KategoriModel::findOrFail($id);

        //update data
        $kategori->kategori_kode = $request->kodeKategori;
        $kategori->kategori_nama = $request->namaKategori;
        $kategori->save();

        return redirect('/kategori');
    }

    public function delete($id){
        KategoriModel::where('kategori_id', $id)->delete();
        return redirect('/kategori');

    }
}