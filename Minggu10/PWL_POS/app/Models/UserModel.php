<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\LevelModel;
use Illuminate\Foundation\Auth\User as Authenticatable; //implementasi class Authenticatable

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';       // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id';  // Mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = ['username', 'password', 'nama', 'level_id', 'created_ad', 'updated_ad', 'profile_photo']; // Mendefinisikan field yang dapat diisi saat melakukan insert atau update data
    protected $hidden = ['password']; // Mendefinisikan field yang tidak akan ditampilkan saat
    protected $casts = ['password' => 'hashed']; //casting password agar otomatis di hash 
    
    //relasi ke tabel level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    //Mendapatkan nama role 
    public function getRoleName(){
        return $this->level->level_nama;
    }

    //Cek apakah user memeliki role tertentu
    public function hasRole($role){
        return $this->level->level_id == $role;
    }

    //Mendapatkan kode role 
    public function getRole(){
        return $this->level->level_kode;
    }
}