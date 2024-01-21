<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Product;
use App\Models\Sale;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $companies = Company::factory(10)->create();
        $products = Product::factory(20)->recycle($companies)->create();
        Sale::factory(25)->recycle($products)->create();
    }
}
