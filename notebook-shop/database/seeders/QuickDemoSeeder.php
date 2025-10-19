<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class QuickDemoSeeder extends Seeder
{
    public function run(): void
    {
        // detect column names
        $catName = $this->firstExisting('categories', ['name','title','category_name','label']) ?? 'name';
        $pName   = $this->firstExisting('products',   ['name','title','product_name']) ?? 'name';
        $pPrice  = $this->firstExisting('products',   ['price','unit_price','sale_price','amount']) ?? 'price';

        if (!DB::table('categories')->count()) {
            DB::table('categories')->insert([
                [$catName => 'Laptops'],
                [$catName => 'Gaming'],
                [$catName => 'Business'],
            ]);
        }

        if (!DB::table('products')->count()) {
            $now = now();
            DB::table('products')->insert([
                [$pName=>'Acer Swift X',    $pPrice=>29990, 'created_at'=>$now, 'updated_at'=>$now],
                [$pName=>'Asus ROG',        $pPrice=>45990, 'created_at'=>$now, 'updated_at'=>$now],
                [$pName=>'Lenovo ThinkPad', $pPrice=>38900, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
        }
    }

    private function firstExisting(string $table, array $cands): ?string
    {
        foreach ($cands as $c) {
            if (Schema::hasColumn($table, $c)) return $c;
        }
        return null;
    }
}
