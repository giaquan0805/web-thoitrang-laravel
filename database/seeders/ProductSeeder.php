<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo categories
        $nam = Category::create(['name' => 'Nam', 'slug' => 'nam', 'description' => 'Thời trang nam']);
        $nu = Category::create(['name' => 'Nữ', 'slug' => 'nu', 'description' => 'Thời trang nữ']);

        // Sản phẩm Nam
        $p1 = Product::create([
            'category_id' => $nam->id,
            'name' => 'Áo Thun Basic White',
            'tag' => 'Mới',
            'description' => 'Áo thun 100% cotton co giãn 4 chiều, thấm hút mồ hôi cực tốt.',
            'price' => 150000,
            'thumbnail_url' => 'images/products/sp-1/main.jpg',
        ]);
        ProductImage::insert([
            ['product_id' => $p1->id, 'image_url' => 'images/products/sp-1/main.jpg'],
            ['product_id' => $p1->id, 'image_url' => 'images/products/sp-1/back.jpg'],
        ]);
        ProductVariant::insert([
            ['product_id' => $p1->id, 'size' => 'S', 'color' => 'Trắng', 'stock_quantity' => 10],
            ['product_id' => $p1->id, 'size' => 'M', 'color' => 'Trắng', 'stock_quantity' => 15],
            ['product_id' => $p1->id, 'size' => 'L', 'color' => 'Trắng', 'stock_quantity' => 10],
            ['product_id' => $p1->id, 'size' => 'XL', 'color' => 'Trắng', 'stock_quantity' => 5],
        ]);

        $p2 = Product::create([
            'category_id' => $nam->id,
            'name' => 'Quần Jean Slimfit',
            'tag' => 'Bán chạy',
            'description' => 'Quần jean chất liệu bền bỉ, form dáng hiện đại.',
            'price' => 350000,
            'thumbnail_url' => 'images/products/sp-2/main.jpg',
        ]);
        ProductImage::insert([
            ['product_id' => $p2->id, 'image_url' => 'images/products/sp-2/main.jpg'],
            ['product_id' => $p2->id, 'image_url' => 'images/products/sp-2/back.jpg'],
            ['product_id' => $p2->id, 'image_url' => 'images/products/sp-2/side.jpg'],
        ]);
        ProductVariant::insert([
            ['product_id' => $p2->id, 'size' => '29', 'color' => 'Xanh', 'stock_quantity' => 10],
            ['product_id' => $p2->id, 'size' => '30', 'color' => 'Xanh', 'stock_quantity' => 10],
            ['product_id' => $p2->id, 'size' => '31', 'color' => 'Xanh', 'stock_quantity' => 8],
            ['product_id' => $p2->id, 'size' => '32', 'color' => 'Xanh', 'stock_quantity' => 5],
        ]);

        $p3 = Product::create([
            'category_id' => $nam->id,
            'name' => 'Áo Polo Công Sở',
            'tag' => 'Bán chạy',
            'description' => 'Phong cách lịch lãm, phù hợp đi làm và đi chơi.',
            'price' => 280000,
            'thumbnail_url' => 'images/products/sp-3/main.jpg',
        ]);
        ProductImage::insert([
            ['product_id' => $p3->id, 'image_url' => 'images/products/sp-3/main.jpg'],
            ['product_id' => $p3->id, 'image_url' => 'images/products/sp-3/back.jpg'],
            ['product_id' => $p3->id, 'image_url' => 'images/products/sp-3/detail.jpg'],
        ]);
        ProductVariant::insert([
            ['product_id' => $p3->id, 'size' => 'M', 'color' => 'Đen', 'stock_quantity' => 10],
            ['product_id' => $p3->id, 'size' => 'L', 'color' => 'Đen', 'stock_quantity' => 10],
            ['product_id' => $p3->id, 'size' => 'XL', 'color' => 'Đen', 'stock_quantity' => 8],
        ]);

        // Sản phẩm Nữ
        $p4 = Product::create([
            'category_id' => $nu->id,
            'name' => 'Áo Croptop',
            'tag' => 'Sale',
            'description' => 'Thời trang cá tính cho nữ, dễ dàng phối đồ.',
            'price' => 180000,
            'thumbnail_url' => 'images/products/sp-4/main.jpg',
        ]);
        ProductImage::insert([
            ['product_id' => $p4->id, 'image_url' => 'images/products/sp-4/main.jpg'],
            ['product_id' => $p4->id, 'image_url' => 'images/products/sp-4/detail.jpg'],
        ]);
        ProductVariant::insert([
            ['product_id' => $p4->id, 'size' => 'S', 'color' => 'Hồng', 'stock_quantity' => 10],
            ['product_id' => $p4->id, 'size' => 'M', 'color' => 'Hồng', 'stock_quantity' => 10],
        ]);

        $p5 = Product::create([
            'category_id' => $nu->id,
            'name' => 'Quần Legging',
            'tag' => 'Sale',
            'description' => 'Chất vải dày dặn, ôm sát, phù hợp tập gym.',
            'price' => 220000,
            'thumbnail_url' => 'images/products/sp-5/main.jpg',
        ]);
        ProductImage::insert([
            ['product_id' => $p5->id, 'image_url' => 'images/products/sp-5/main.jpg'],
            ['product_id' => $p5->id, 'image_url' => 'images/products/sp-5/back.jpg'],
            ['product_id' => $p5->id, 'image_url' => 'images/products/sp-5/detail.jpg'],
        ]);
        ProductVariant::insert([
            ['product_id' => $p5->id, 'size' => 'S', 'color' => 'Đen', 'stock_quantity' => 10],
            ['product_id' => $p5->id, 'size' => 'M', 'color' => 'Đen', 'stock_quantity' => 10],
            ['product_id' => $p5->id, 'size' => 'L', 'color' => 'Đen', 'stock_quantity' => 8],
        ]);

        $p6 = Product::create([
            'category_id' => $nu->id,
            'name' => 'Áo Sơ Mi Oxford',
            'tag' => 'Sale',
            'description' => 'Vải oxford dày dặn, đứng form, ít nhăn.',
            'price' => 320000,
            'thumbnail_url' => 'images/products/sp-6/main.jpg',
        ]);
        ProductImage::insert([
            ['product_id' => $p6->id, 'image_url' => 'images/products/sp-6/main.jpg'],
            ['product_id' => $p6->id, 'image_url' => 'images/products/sp-6/detail.jpg'],
        ]);
        ProductVariant::insert([
            ['product_id' => $p6->id, 'size' => 'M', 'color' => 'Trắng', 'stock_quantity' => 10],
            ['product_id' => $p6->id, 'size' => 'L', 'color' => 'Trắng', 'stock_quantity' => 10],
            ['product_id' => $p6->id, 'size' => 'XL', 'color' => 'Trắng', 'stock_quantity' => 5],
        ]);
    }
}