<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;   // << สำคัญ ต้องมีบรรทัดนี้

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Acer','Asus','Dell','HP','Lenovo','MSI'] as $n) {
            Brand::firstOrCreate(['name' => $n]);
        }
    }
}
