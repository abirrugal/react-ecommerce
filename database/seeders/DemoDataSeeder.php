<?php

namespace Database\Seeders;

use App\Enums\AddressTypes;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\FlashSale;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderAttribute;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\Region;
use App\Models\Review;
use App\Models\Setting;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        $this->flashSale();
        $this->categories();
        $this->paymentMethod();
        $this->users();
        $this->userAddress();
        $this->address();
        $this->banner();
        $this->brand();
        $this->reviews();
        $this->notification();
        $this->setting();
    }

    public function users()
    {
        User::create([
            'username' => 'Admin',
            'first_name' => 'Mr',
            'last_name' => 'Admin',
            'phone' => '01234567890',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'role' => 1,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'username' => 'User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone' => '01111111111',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'role' => 2,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        User::factory(100)->create();
    }

    private function categories()
    {
        $categories = [
            'bag', 'dress', 'pand', 'shirt',
            'shoe', 'sunglass', 'wallet', 'watch'
        ];

        $icons = [
            '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M160 112c0-35.3 28.7-64 64-64s64 28.7 64 64v48H160V112zm-48 48H48c-26.5 0-48 21.5-48 48V416c0 53 43 96 96 96H352c53 0 96-43 96-96V208c0-26.5-21.5-48-48-48H336V112C336 50.1 285.9 0 224 0S112 50.1 112 112v48zm24 48a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm152 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"/></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M211.8 0c7.8 0 14.3 5.7 16.7 13.2C240.8 51.9 277.1 80 320 80s79.2-28.1 91.5-66.8C413.9 5.7 420.4 0 428.2 0h12.6c22.5 0 44.2 7.9 61.5 22.3L628.5 127.4c6.6 5.5 10.7 13.5 11.4 22.1s-2.1 17.1-7.8 23.6l-56 64c-11.4 13.1-31.2 14.6-44.6 3.5L480 197.7V448c0 35.3-28.7 64-64 64H224c-35.3 0-64-28.7-64-64V197.7l-51.5 42.9c-13.3 11.1-33.1 9.6-44.6-3.5l-56-64c-5.7-6.5-8.5-15-7.8-23.6s4.8-16.6 11.4-22.1L137.7 22.3C155 7.9 176.7 0 199.2 0h12.6z"/></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M120 0h80c13.3 0 24 10.7 24 24V64H96V24c0-13.3 10.7-24 24-24zM32 151.7c0-15.6 9-29.8 23.2-36.5l24.4-11.4c11-5.1 23-7.8 35.1-7.8h90.6c12.1 0 24.1 2.7 35.1 7.8l24.4 11.4c14.1 6.6 23.2 20.8 23.2 36.5c0 14.4-7.5 27-18.9 34.1c11.5 8.8 18.9 22.6 18.9 38.2c0 16.7-8.5 31.4-21.5 40c12.9 8.6 21.5 23.3 21.5 40s-8.5 31.4-21.5 40c12.9 8.6 21.5 23.3 21.5 40s-8.5 31.4-21.5 40c12.9 8.6 21.5 23.3 21.5 40c0 26.5-21.5 48-48 48H80c-26.5 0-48-21.5-48-48c0-16.7 8.5-31.4 21.5-40C40.5 415.4 32 400.7 32 384s8.5-31.4 21.5-40C40.5 335.4 32 320.7 32 304s8.5-31.4 21.5-40C40.5 255.4 32 240.7 32 224c0-15.6 7.4-29.4 18.9-38.2C39.5 178.7 32 166.1 32 151.7zM96 240c0 8.8 7.2 16 16 16h96c8.8 0 16-7.2 16-16s-7.2-16-16-16H112c-8.8 0-16 7.2-16 16zm16 112c-8.8 0-16 7.2-16 16s7.2 16 16 16h96c8.8 0 16-7.2 16-16s-7.2-16-16-16H112z"/></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M112 0C85.5 0 64 21.5 64 48V96H16c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 272c8.8 0 16 7.2 16 16s-7.2 16-16 16H64 48c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 240c8.8 0 16 7.2 16 16s-7.2 16-16 16H64 16c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 208c8.8 0 16 7.2 16 16s-7.2 16-16 16H64V416c0 53 43 96 96 96s96-43 96-96H384c0 53 43 96 96 96s96-43 96-96h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V288 256 237.3c0-17-6.7-33.3-18.7-45.3L512 114.7c-12-12-28.3-18.7-45.3-18.7H416V48c0-26.5-21.5-48-48-48H112zM544 237.3V256H416V160h50.7L544 237.3zM160 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96zm272 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0z"/></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M190.5 68.8L225.3 128H224 152c-22.1 0-40-17.9-40-40s17.9-40 40-40h2.2c14.9 0 28.8 7.9 36.3 20.8zM64 88c0 14.4 3.5 28 9.6 40H32c-17.7 0-32 14.3-32 32v64c0 17.7 14.3 32 32 32H480c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32H438.4c6.1-12 9.6-25.6 9.6-40c0-48.6-39.4-88-88-88h-2.2c-31.9 0-61.5 16.9-77.7 44.4L256 85.5l-24.1-41C215.7 16.9 186.1 0 154.2 0H152C103.4 0 64 39.4 64 88zm336 0c0 22.1-17.9 40-40 40H288h-1.3l34.8-59.2C329.1 55.9 342.9 48 357.8 48H360c22.1 0 40 17.9 40 40zM32 288V464c0 26.5 21.5 48 48 48H224V288H32zM288 512H432c26.5 0 48-21.5 48-48V288H288V512z"/></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M88 0C74.7 0 64 10.7 64 24c0 38.9 23.4 59.4 39.1 73.1l1.1 1C120.5 112.3 128 119.9 128 136c0 13.3 10.7 24 24 24s24-10.7 24-24c0-38.9-23.4-59.4-39.1-73.1l-1.1-1C119.5 47.7 112 40.1 112 24c0-13.3-10.7-24-24-24zM32 192c-17.7 0-32 14.3-32 32V416c0 53 43 96 96 96H288c53 0 96-43 96-96h16c61.9 0 112-50.1 112-112s-50.1-112-112-112H352 32zm352 64h16c26.5 0 48 21.5 48 48s-21.5 48-48 48H384V256zM224 24c0-13.3-10.7-24-24-24s-24 10.7-24 24c0 38.9 23.4 59.4 39.1 73.1l1.1 1C232.5 112.3 240 119.9 240 136c0 13.3 10.7 24 24 24s24-10.7 24-24c0-38.9-23.4-59.4-39.1-73.1l-1.1-1C231.5 47.7 224 40.1 224 24z"/></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M220.6 121.2L271.1 96 448 96v96H333.2c-21.9-15.1-48.5-24-77.2-24s-55.2 8.9-77.2 24H64V128H192c9.9 0 19.7-2.3 28.6-6.8zM0 128V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H271.1c-9.9 0-19.7 2.3-28.6 6.8L192 64H160V48c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16l0 16C28.7 64 0 92.7 0 128zM168 304a88 88 0 1 1 176 0 88 88 0 1 1 -176 0z"/></svg>'
        ];

        // $mens_product_images = [
        //     'back.png', 'black_glass.png', 'black_shoe.png',
        //     'brown_shoe.png', 'ladies_bag.png', 'mens_black_watch.png', 'mens_watch.png', 'polarized_glass.png', 'wallet.png', 'wallet2.png'
        // ];

        $faker = Faker::create();

        foreach ($categories as $key => $category) {
            $new_category = Category::create([
                'name' => ucfirst($category),
                'slug' => $category,
                'image' => 'demo_products/' . $key . '.png',
                'icon' => $icons[rand(0, 6)],
            ]);

            $men_subcat = SubCategory::create([
                'category_id' => $new_category->id,
                'name' => 'Men',
                'slug' => 'men',
                'image' => 'demo_products/' . $key . '.png',
                'icon' => $icons[rand(0, 6)],
            ]);

            $women_subcat = SubCategory::create([
                'category_id' => $new_category->id,
                'name' => 'Women',
                'slug' => 'women',
                'image' => 'demo_products/' . $key . '.png',
                'icon' => $icons[rand(0, 6)],
            ]);

            for ($i = 1; $i <= 14; $i++) {

                $product_name = $faker->name;

                $mens_product = Product::create([
                    'name' => $product_name,
                    'slug' => Str::slug($product_name),
                    'category_id' => $new_category->id,
                    'subcategory_id' => $men_subcat->id,
                    'description' => $faker->text(200),
                    'price' => rand(111, 999),
                    'stock_in' => rand(111, 999),
                    'stock_out' => rand(11, 99),
                    'discount' => rand(0, 99),
                    'rating' => rand(1, 5),
                    'image' => 'demo_products/' . $i . '.jpg',
                    'flash_sale_id' => 1
                ]);

                for ($j = 1; $j < 5; $j++) {
                    ProductImage::create([
                        'product_id' => $mens_product->id,
                        'image' => 'demo_products/' . rand(1, 13) . '.jpg'
                    ]);
                }

                $this->setAttr('size', ['S', 'M', 'L', 'XL'], $mens_product->id);
                $this->setAttr('color', ['White', 'Black', 'Blue', 'Green'], $mens_product->id);

                $product_name = $faker->name;

                $women_product = Product::create([
                    'name' => $product_name,
                    'slug' => Str::slug($product_name),
                    'category_id' => $new_category->id,
                    'subcategory_id' => $women_subcat->id,
                    'description' => $faker->text(200),
                    'price' => rand(111, 999),
                    'stock_in' => rand(111, 999),
                    'stock_out' => rand(11, 99),
                    'discount' => rand(0, 99),
                    'rating' => rand(1, 5),
                    'image' => 'demo_products/' . rand(1, 13) . '.jpg',
                    // 'flash_sale_id' => 1
                ]);


                for ($k = 1; $k < 5; $k++) {
                    ProductImage::create([
                        'product_id' => $women_product->id,
                        'image' => 'demo_products/' . rand(1, 13) . '.jpg'
                    ]);
                }

                $this->setAttr('size', ['S', 'M', 'L', 'XL'], $women_product->id);
                $this->setAttr('color', ['White', 'Black', 'Blue', 'Pink'], $women_product->id);
            }
        }
    }

    public function setAttr($name, $values, $product_id)
    {
        foreach ($values as $value) {

            ProductAttribute::create([
                'name' => $name,
                'value' => $value,
                'additional_price' => rand(10, 50),
                'product_id' => $product_id,
            ]);
        }
    }

    public function setOrderAttr($order_id, $attr_id)
    {
        $attr = ProductAttribute::find($attr_id);

        OrderAttribute::create([
            'name' => $attr->name,
            'value' => $attr->value,
            'additional_price' => $attr->price,
            'product_id' => $attr->product_id,
            'order_id'   => $order_id,
            'product_attribute_id' => $attr_id,
        ]);
    }

    public function paymentMethod()
    {
        $paymentMethods = ['Bkash', 'Rocket', 'Nagad'];

        foreach ($paymentMethods as $key => $paymentMethod) {
            PaymentMethod::create([
                'name' => $paymentMethod,
            ]);
        }
    }



    public function userAddress()
    {
        UserAddress::create([
            'address' => 'Mirpur 1,Dhaka',
            'region' => 'Dhaka',
            'city' => 'Dhaka',
            'area' => 'Mirpur',
            'phone' => '01234567890',
            'address_type' => AddressTypes::HOME,
            'user_id' => 1,
        ]);
        UserAddress::create([
            'address' => 'Mirpur 2,Dhaka',
            'region' => 'Dhaka',
            'city' => 'Dhaka',
            'area' => 'Mirpur',
            'phone' => '01234567890',
            'address_type' => AddressTypes::OFFICE,
            'user_id' => 1,
        ]);
    }

    public function order()
    {
        for ($i = 0; $i < 10; $i++) {
            $order = Order::create([
                'user_id' => 2,
                'payment_method_id' => PaymentMethod::latest()->first()->id,
                'delivery_charge' => rand(60, 70),
                'order_id' => 'Inv' . time(),
                'status' => mt_rand(0, 2),
            ]);

            $order->detail()->create([
                'order_id' => $order->id,
                'first_name' => 'test ' . $i,
                'last_name' => 'test ' . $i,
                'phone' => fake()->phoneNumber(),
                'email' => fake()->unique()->safeEmail(),
                'user_address_id' => UserAddress::latest()->first()->id,
            ]);

            $productId = mt_rand(1, 9);
            $product = Product::find($productId);
            $order->items()->create([
                'product_id' => $productId,
                'name' => $product->name,
                'quantity' => 8,
                'price' => $product->price,
            ]);

            $attrId = Arr::random(ProductAttribute::pluck('id')->toArray(), 1)[0];

            $this->setOrderAttr($order->id, $attrId);
        }
    }

    public function brand()
    {
        for ($i = 0; $i < 10; $i++) {
            Brand::create([
                'name' => 'Test Brand' . $i,
                'slug' => 'test_brand' . $i,
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore illum voluptates ipsa asperiores alias, debitis eius! Mollitia, culpa autem? Vero necessitatibus labore placeat atque tenetur consequatur, incidunt illo minus quidem!',
                'image' => 'demo_products/' . $i . '.png',
            ]);
        }
    }

    public function reviews()
    {
        $users = User::get();

        foreach ($users as $key => $user) {
            $review =  Review::create([
                'review' => 'Test Brand' . $key,
                'user_id' => $user->id,
                'product_id' => rand(1, 5),
                'rating' => rand(1, 5),
            ]);

            $review->images()->create([
                'image' => 'demo_products/' . rand(1, 13) . '.jpg'
            ]);
        }
    }

    public function notification()
    {
        $users = User::get();

        foreach ($users as $user) {
            for ($i = 0; $i < 10; $i++) {
                Notification::create([
                    'title' => 'Test Notification Title' . $i,
                    'user_id' => $user->id,
                    'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore illum voluptates ipsa asperiores alias',
                    'read' => rand(0, 1),
                ]);
            }
        }
    }

    public function banner()
    {
        for ($i = 0; $i < 6; $i++) {
            Banner::create([
                'image' => 'demo_products/' . rand(1, 13) . '.jpg'
            ]);
        }
    }

    public function setting()
    {
        Setting::create([
            'inside_dhaka' => 60,
            'outside_dhaka' => 70,
            'logo' => 'demo_products/' . rand(1, 13) . '.jpg',
            'app_title' => 'Ecommerce'
        ]);
    }

    public function address()
    {

        $regions = ['Barishal', 'Chattogram', 'Dhaka', 'Khulna', 'Rajshahi', 'Rangpur', 'Mymensingh', 'Sylhet'];

        foreach ($regions as $region) {
            Region::create([
                'name' => $region,
            ]);
        }

        $cities = ['Dhaka', 'Faridpur', 'Gazipur', 'Gopalganj', 'Jamalpur', 'Kishoreganj', 'Madaripur', 'Manikganj', 'Munshiganj', 'Mymensingh', 'Narayanganj', 'Narsingdi', 'Netrokona'];

        foreach ($cities as $city) {
            City::create([
                'name' => $city,
                'region_id' => rand(1, 8),
            ]);
        }
    }

    public function flashSale()
    {
        $names = ['Winter Flash Sale', 'Eid Flash Sale'];

        FlashSale::create([
            'name' => 'Summer Flash Sale',
            'start_at' => Carbon::now()->subDays(10),
            'expired_at' => Carbon::now()->addDays(10),
            'status' => 1
        ]);

        foreach ($names as $name) {
            FlashSale::create([
                'name' => $name,
                'start_at' => Carbon::now()->subDays(10),
                'expired_at' => Carbon::now()->addDays(10),
                'status' => 0
            ]);
        }
    }
}
