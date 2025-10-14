<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder {
  public function run(): void {
    foreach (['Ultrabook','Gaming','Business','Student','Creator','Workstation'] as $n) {
      Category::firstOrCreate(['name'=>$n]);
    }
  }
}
