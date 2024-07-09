<?php

namespace Database\Seeders;

use App\Models\Core\Package;
use App\Models\Inventory\Brand;
use App\Models\Inventory\Category;
use App\Models\Inventory\Unit;
use App\Models\Logistic\Branch;
use App\Models\Logistic\Warehouse;
use App\Models\Settings\Currency;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // User::factory(10)->create();
        Branch::create([
            "name"=>"Main Branch"
        ]);
        Branch::create([
            "name"=>"Second Branch"
        ]);
        Branch::create([
            "name"=>"Third Branch"
        ]);
        Warehouse::create([
            "name"=>"Main Warehouse"
        ]);
        Warehouse::create([
            "name"=>"Second Warehouse"
        ]);
        Warehouse::create([
            "name"=>"Third Warehouse"
        ]);
        $branch = Branch::find(1);
        $warehouse = Warehouse::find(1);
        User::factory()->create([
            'name' => 'Developer',
            'email' => 'developer@admin.com',
            "password" => bcrypt("123mmmnnn")
        ]);
        User::factory()->create([
            'name' => 'Main Branch',
            'email' => 'main@branch.com',
            "password" => bcrypt("123mmmnnn"),
            "ownerable_id" => $branch->id,
            "ownerable_type" => get_class($branch)
        ]);
        User::factory()->create([
            'name' => 'Main Warehouse',
            'email' => 'main@warehouse.com',
            "password" => bcrypt("123mmmnnn"),
            "ownerable_id" => $warehouse->id,
            "ownerable_type" => get_class($warehouse)
        ]);

        Category::create([
            "name" => "General",
            "ownerable_id" => $branch->id,
            "ownerable_type" => get_class($branch)

        ]);
        Brand::create([
            "name" => "General",
            "ownerable_id" => $branch->id,
            "ownerable_type" => get_class($branch)
        ]);
        Unit::create([
            "name" => "Pcs",
            "ownerable_id" => $branch->id,
            "ownerable_type" => get_class($branch)
        ]);
        Unit::create([
            "name" => "Darzan",
            "ownerable_id" => $branch->id,
            "ownerable_type" => get_class($branch)
        ]);
        Currency::create([
            "name" => "USD",
            "symbol" => "$",
            "rate" => 145000,
            "base" => 1,
            "decimal" => 2,
        ]);
        Currency::create([
            "name" => "IQD",
            "symbol" => "د.ع",
            "rate" => 145000,
            "base" => 0,
            "decimal" => 0,
        ]);
        Currency::create([
            "name" => "Turkish Lira",
            "symbol" => "TL",
            "rate" => 3228.80,
            "base" => 0,
            "decimal" => 2,
        ]);
        Package::create([
            'name' => 'HR',
            'description' => 'Human Resource Management',
            'color' => 'bg-blue-500 text-white',
            'price'=>0,
            'type'=>'primary',
            'version'=>'1.0.0',
            'image'=>1
        ]);
        Package::create([
            'name' => 'Inventory',
            'description' => 'Inventory',
            'color' => 'bg-blue-500 text-white',
            'price'=>0,
            'type'=>'primary',
            'version'=>'1.0.0',
            'image'=>1
        ]);
        Package::create([
            'name' => 'Logistic',
            'description' => 'Logistic',
            'color' => 'bg-blue-500 text-white',
            'price'=>0,
            'type'=>'primary',
            'version'=>'1.0.0',
            'image'=>1
        ]);


    }
}
