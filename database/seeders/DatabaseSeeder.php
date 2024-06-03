<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use App\Models\Colors;
use App\Models\Groups;
use App\Models\Orders;
use App\Models\Modules;
use App\Models\Category;
use App\Models\Products;
use App\Models\Wishlist;
use App\Models\Materials;
use App\Models\OrderDetail;
use App\Models\PaymentType;
use App\Models\UserAddress;
use App\Models\UserPayment;
use App\Models\UserReviews;
use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Groups::insert(["group_name"=>"Customer"]);
        // Groups::insert(["group_name"=>"Staff"]);
        //     Groups::insert(["group_name"=>"Administrator"]);

        //     User::factory()->count(10)->create();
        //     User::factory()->count(10)->create();
        // Category::insert(["category_name"=>"Sofa Metal" , "parent_category_id"=>3]);
        // Products::insert([
        //     'product_name'=>'Chair Master',
        //     'price'=>215,
        //     'product_theme'=> 'wd-furniture-chair-prod-12-1-430x491.jpg',
        //     'category_id'=>2,
        //     'product_description'=>"Et maiores nisi. Excepturi ut perferendis ut consectetur ea deserunt magnam numquam laboriosam. Asperiores sed sint voluptates dolores veniam totam. Vitae eos sapiente laboriosam ratione totam autem. Sint et culpa modi eligendi et consectetur."

        // ]);
        // Colors::insert(['color_name'=>'Yellow' , 'color_value'=>'#FFEC9E']);
        // Materials::insert(['material_value'=>'Leather']);

        // Modules::insert(['module_name'=>'productVariant'  , 'module_action'=>'["forceDelte", "add", "delete"]']);

        // PaymentType::insert(['payment_name'=>'Paypal']);
        // ShippingMethod::insert(['shipping_name'=>'Standard Delivery', 'fee'=>'15']);
        // Cart::insert(['user_id'=>'1' , 'product_variant_id'=> '6']);
        // Cart::insert(['user_id'=>'1' , 'product_variant_id'=> '8']);
        // UserAddress::insert(['user_id'=>'1' , 'detail_address'=>'Home Number 44' , 'city'=>'New York' , 'country'=>'Ameria' ,'is_default'=>1]);
        // UserAddress::insert(['user_id'=>'1' , 'detail_address'=>'Floor 2, Lanmark 81' , 'city'=>'Ho Chi Minh City' , 'country'=>'Viet Nam' ,'is_default'=>0]);
        // UserAddress::insert(['user_id'=>'1' , 'detail_address'=>'64 Wall Street' , 'city'=>'New York' , 'country'=>'Ameria' ,'is_default'=>0]);

        // UserPayment::insert(['user_id'=>'1' , 'payment_id'=>'1' , 'card_number'=>'0344847295']);
        // UserPayment::insert(['user_id'=>'1' , 'payment_id'=>'2' , 'card_number'=>'0344847295']);

        // Orders::insert(['address' => 'Home Number 44, New York , New York', 'user_id' => '1', 'shipping_id' => '1','user_payment_id'=>'1' , 'total'=>'255' , 'status'=>'0']);
        // Orders::insert(['address' => 'XXXX', 'user_id' => '1', 'shipping_id' => '1','user_payment_id'=>'1' , 'total'=>'38' , 'status'=>'0']);

        // OrderDetail::insert(['order_id' => '1', 'product_id' => '24', 'color_id' => '1' , 'material_id' => '1' , 'product_variant_img'=>'Ảnh chụp màn hình 2024-05-07 211545.png' , 'price'=>'2222', 'quantity'=>'2']);
        // OrderDetail::insert(['order_id' => '1', 'product_id' => '24', 'color_id' => '2' , 'material_id' => '3' , 'product_variant_img'=>'wd-furniture-chair-prod-1-3.jpg' , 'price'=>'123', 'quantity'=>'1']);


        // Wishlist::insert(['user_id' => '1', 'product_id'=>'1']);
        UserReviews::insert(['user_id' => '1' , 'product_id' => '24', 'stars'=>5, 'comment' => 'Good GOood']);
    }
}
