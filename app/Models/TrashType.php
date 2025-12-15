<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashType extends Model
{
    use HasFactory;

    // --- BAGIAN INI YANG HARUS DITAMBAHKAN ---
    protected $fillable = [
        'category',
        'name',
        'price_per_kg',
    ];
    // ------------------------------------------
}