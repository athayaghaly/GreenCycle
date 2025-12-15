<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrashType;

class TrashTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Data Sampah Anorganik
        TrashType::create([
            'category' => 'anorganik',
            'name' => 'Botol Plastik Bersih',
            'price_per_kg' => 3000,
        ]);
        
        TrashType::create([
            'category' => 'anorganik',
            'name' => 'Kardus Bekas',
            'price_per_kg' => 2500,
        ]);

        TrashType::create([
            'category' => 'anorganik',
            'name' => 'Kertas HVS/Buku',
            'price_per_kg' => 1500,
        ]);

        TrashType::create([
            'category' => 'anorganik',
            'name' => 'Kaleng Alumunium',
            'price_per_kg' => 12000,
        ]);

        // Data Sampah Organik
        TrashType::create([
            'category' => 'organik',
            'name' => 'Sisa Makanan (Maggot)',
            'price_per_kg' => 500,
        ]);

        TrashType::create([
            'category' => 'organik',
            'name' => 'Daun Kering Kompos',
            'price_per_kg' => 200,
        ]);

        // Data Sampah B3
        TrashType::create([
            'category' => 'b3',
            'name' => 'Sampah Elektronik Kecil',
            'price_per_kg' => 5000,
        ]);
    }
}
