<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Price;
class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p1 = Product::create([
            'name' => 'Ristretto',
        ]);

         Price::create([
            'product_id' => $p1->id,
            'min_limit' => 0 ,
            'max_limit' => 50,
            'pence' => 2
        ]);
        Price::create([
            'product_id' => $p1->id,
            'min_limit' => 51 ,
            'max_limit' => 500,
            'pence' => 3
        ]);
        Price::create([
            'product_id' => $p1->id,
            'min_limit' => 501 ,
            'max_limit' => 999999,
            'pence' => 5
        ]);
        $p2 = Product::create([
            'name' => 'Espresso',
        ]);
        Price::create([
            'product_id' => $p2->id,
            'min_limit' => 0 ,
            'max_limit' => 50,
            'pence' => 4
        ]);
        Price::create([
            'product_id' => $p2->id,
            'min_limit' => 51 ,
            'max_limit' => 500,
            'pence' => 6
        ]);
        Price::create([
            'product_id' => $p2->id,
            'min_limit' => 501 ,
            'max_limit' => 999999,
            'pence' => 10
        ]);
        $p3 = Product::create([
        'name' => 'Lungo',
        ]);
        Price::create([
            'product_id' => $p3->id,
            'min_limit' => 0 ,
            'max_limit' =>50,
            'pence' => 6
        ]);
        Price::create([
            'product_id' => $p3->id,
            'min_limit' => 51 ,
            'max_limit' => 500,
            'pence' => 9
        ]);
        Price::create([
            'product_id' => $p3->id,
            'min_limit' => 501 ,
            'max_limit' => 999999,
            'pence' => 15
        ]);
    }
}
