<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
{
    User::factory(5)->create();

    User::factory()->create(['email' => 'mmbujijosameneza@gmail.com', 'password' => bcrypt('enockjosam')]);

    Product::insert([
        ['name'=>'Wireless Mouse','description'=>'Ergonomic mouse','price'=>15000,'created_at'=>now(),'updated_at'=>now()],
        ['name'=>'Keyboard','description'=>'Mechanical keyboard','price'=>45000,'created_at'=>now(),'updated_at'=>now()],
        ['name'=>'Monitor','description'=>'24 inch monitor','price'=>250000,'created_at'=>now(),'updated_at'=>now()],
    ]);
}
}
