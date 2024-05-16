<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Colors;
use App\Models\Groups;
use App\Models\Modules;
use App\Models\Category;
use App\Models\Products;
use App\Models\Materials;
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
    }
}
