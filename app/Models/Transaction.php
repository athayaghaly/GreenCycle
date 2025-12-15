<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // --- BAGIAN INI YANG HARUS DITAMBAHKAN ---
    protected $fillable = [
        'user_id',
        'admin_id',
        'trash_type_id',
        'weight_kg',
        'total_price',
        'status',
    ];
    // ------------------------------------------

    // Relasi ke User (Nasabah)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Admin (Petugas)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Relasi ke Jenis Sampah
    public function trashType()
    {
        return $this->belongsTo(TrashType::class);
    }
}