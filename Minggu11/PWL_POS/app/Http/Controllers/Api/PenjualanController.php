<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    // Menampilkan daftar semua transaksi penjualan 
    public function index()
    {
        $data = PenjualanModel::with(['user', 'details.barang'])->get();
        return response()->json($data);
    }
    
    // Menampilkan detail transaksi penjualan berdasarkan ID 
    public function show($transaksi)
    {
        $penjualan = PenjualanModel::with(['user', 'details.barang'])->findOrFail($transaksi);
        return response()->json($penjualan);
    }

    // Menyimpan transaksi penjualan baru ke database
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'user_id'           => 'required|exists:m_user,user_id',
            'pembeli'           => 'required|string|max:100',
            'penjualan_kode'    => 'required|string|unique:t_penjualan,penjualan_kode',
            'penjualan_tanggal' => 'required|date_format:Y-m-d H:i:s',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($v->fails()) {
            return response()->json(['success'=>false,'errors'=>$v->errors()], 422);
        }

        $transaksi = PenjualanModel::create($v->validated());

        if ($request->hasFile('image')) {
            $fn = time().'.'.$request->image->extension();
            $request->image->storeAs('public/transaksi', $fn);
            $transaksi->update(['image'=>$fn]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'penjualan' => $transaksi,
                'image_url' => $transaksi->image ? asset('storage/transaksi/'.$transaksi->image) : null,
            ],
        ], 201);        
    }

    // Memperbarui data transaksi penjualan berdasarkan ID
    public function update(Request $request, $transaksi)
    {
        $transaksi = PenjualanModel::findOrFail($transaksi);

        $v = Validator::make($request->all(), [
            'pembeli'           => 'sometimes|required|string|max:100',
            'penjualan_kode'    => 'sometimes|required|string|unique:t_penjualan,penjualan_kode,'.$transaksi.',penjualan_id',
            'penjualan_tanggal' => 'sometimes|required|date',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($v->fails()) {
            return response()->json(['success'=>false,'errors'=>$v->errors()], 422);
        }

        $transaksi->update($v->validated());

        if ($request->hasFile('image')) {
            if ($transaksi->image) {
                Storage::delete('public/transaksi/'.$transaksi->image);
            }
            $fn = time().'.'.$request->image->extension();
            $request->image->storeAs('public/transaksi', $fn);
            $transaksi->update(['image'=>$fn]);
        }

        return response()->json($transaksi);
    }

    // Menghapus transaksi penjualan dari database berdasarkan ID
    public function destroy($transaksi)
    {
        $transaksi = PenjualanModel::findOrFail($transaksi);
        
        if ($transaksi->image && Storage::exists('public/transaksi/'.$transaksi->image)) {
            Storage::delete('public/transaksi/'.$transaksi->image);
        }        
        $transaksi->delete();
        return response()->json(['success'=>true,'message'=>'Transaksi dihapus']);
    }
}