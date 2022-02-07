<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {


        \App\Order::create([
            'client_id' => '1',
//            'status' => 0
        ]);

        for ($i = 0; $i < 3; $i++)
        {
            \App\Order_Detail::create([
                'order_id'      =>  '1',
                'product_id'      =>  $i + 1,
                'sale_price'      =>  random_int(10, 20),
                'paid_price'      =>  random_int(10, 20),
                'quantity'      =>  random_int(1, 5),
                'discount'      =>  random_int(2, 5),

            ]);
        }

    }
}
