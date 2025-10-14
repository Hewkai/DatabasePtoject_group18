<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Product,Brand,Category,ProductImage};
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder {
  public function run(): void
  {
    // ใช้ array ชัด ๆ
    $brand = Brand::pluck('id','name')->toArray();     // ['MSI'=>6, ...]
    $cats  = Category::pluck('id','name')->toArray();  // ['Gaming'=>?, 'Ultrabook'=>?, ...]

    // helper กัน null ออกจาก array
    $onlyIds = fn(array $arr) => array_values(array_filter($arr, fn($v)=>!is_null($v)));

    // ฟังก์ชันตั้ง primary image ให้เหลือ 1 รูป
    $setPrimary = function(Product $p, string $url) {
        // เคลียร์ทั้งหมดก่อน
        ProductImage::where('product_id', $p->id)->update(['is_primary' => false]);
        // อัปเดต/สร้างรูปนี้เป็น primary
        ProductImage::updateOrCreate(
            ['product_id'=>$p->id, 'url'=>$url],
            ['is_primary'=>true, 'sort_order'=>0]
        );
    };

    DB::transaction(function() use ($brand, $cats, $onlyIds, $setPrimary) {

        // MSI Katana 15
        $p1 = Product::updateOrCreate(
          ['brand_id'=>$brand['MSI'] ?? array_values($brand)[0] ?? 1, 'model'=>'Katana 15'],
          ['cpu_brand'=>'Intel','cpu_model'=>'i7-13620H','ram_gb'=>16,'storage_gb'=>512,'gpu'=>'RTX 4060','price'=>39990]
        );
        $p1->categories()->syncWithoutDetaching($onlyIds([Arr::get($cats,'Gaming')]));
        $setPrimary($p1, 'https://example.com/img/msi-katana15-main.jpg');

        // Acer Aspire 5
        $p2 = Product::updateOrCreate(
          ['brand_id'=>$brand['Acer'] ?? array_values($brand)[0] ?? 1, 'model'=>'Aspire 5'],
          ['cpu_brand'=>'Intel','cpu_model'=>'i5-1240P','ram_gb'=>16,'storage_gb'=>512,'gpu'=>null,'price'=>22990]
        );
        $p2->categories()->syncWithoutDetaching($onlyIds([Arr::get($cats,'Student'), Arr::get($cats,'Business')]));
        $setPrimary($p2, 'https://example.com/img/acer-aspire5-main.jpg');

        // Lenovo Slim 7
        $p3 = Product::updateOrCreate(
          ['brand_id'=>$brand['Lenovo'] ?? array_values($brand)[0] ?? 1, 'model'=>'Slim 7'],
          ['cpu_brand'=>'AMD','cpu_model'=>'Ryzen 7 7840U','ram_gb'=>16,'storage_gb'=>512,'gpu'=>null,'price'=>35990]
        );
        $p3->categories()->syncWithoutDetaching($onlyIds([Arr::get($cats,'Ultrabook'), Arr::get($cats,'Creator')]));
        $setPrimary($p3, 'https://example.com/img/lenovo-slim7-main.jpg');
    });
  }
}
