<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenjualanModel extends Model
{
    use HasFactory;

    protected $table = 't_penjualan_detail';
    protected $primaryKey = 'detail_id';
    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'harga',
        'jumlah'
    ];

    // Relasi ke header transaksi
    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(PenjualanModel::class, 'penjualan_id', 'penjualan_id');
    }

    // Relasi ke data barang
    public function barang(): BelongsTo
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }

    // untuk menampilkan subtotal 
    public function getSubtotalAttribute()
    {
        return $this->harga * $this->jumlah;
    }
}