<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 100) as $index) { // استبدل 100 بالعدد المطلوب من المنتجات
            DB::table('products')->insert([
                'name' => $faker->words(2, true), // اسم المنتج
                'description' => $faker->sentence, // وصف المنتج
                'price' => $faker->randomFloat(2, 10, 1000), // سعر المنتج بين 10 و 1000
                'unit' => $faker->randomElement(['piece', 'box', 'kg', 'litre']), // الوحدة
                'barcode' => $faker->ean13, // كود باركود عشوائي
                'quantity' => $faker->numberBetween(1, 500), // الكمية بين 1 و 500
                'status' => $faker->randomElement(['active', 'inactive', 'onRequest']), // حالة المنتج
                'subcategory_id' => Subcategory::findOrFail(1)->id, // اختر أرقام عشوائية للفئات الفرعية
                'supplier_id' => Supplier::findOrFail(1)->id, // اختر أرقام عشوائية للموردين
                'tenant_id' => 1,
                'created_by' => 1, // المستخدم الذي أنشأ المنتج
                'updated_by' => null, // المستخدم الذي عدّل المنتج
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
