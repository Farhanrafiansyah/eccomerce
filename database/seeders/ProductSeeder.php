<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone XR 64GB IBOX',
                'price' => 2600000,
                'stock' => 10,
                'image' => null // Will use smart placeholder
            ],
            [
                'name' => 'iPhone XS 256 GB',
                'price' => 3000000,
                'stock' => 8,
                'image' => null
            ],
            [
                'name' => 'iPhone 13 128GB INTER',
                'price' => 5600000,
                'stock' => 5,
                'image' => null
            ],
            [
                'name' => 'Samsung Galaxy S23',
                'price' => 4200000,
                'stock' => 12,
                'image' => null
            ],
            [
                'name' => 'Samsung Galaxy A54',
                'price' => 2800000,
                'stock' => 15,
                'image' => null
            ],
            [
                'name' => 'MacBook Air M2',
                'price' => 18000000,
                'stock' => 3,
                'image' => null
            ],
            [
                'name' => 'Dell Laptop Inspiron',
                'price' => 8500000,
                'stock' => 7,
                'image' => null
            ],
            [
                'name' => 'iPad Pro 11 inch',
                'price' => 12000000,
                'stock' => 6,
                'image' => null
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
