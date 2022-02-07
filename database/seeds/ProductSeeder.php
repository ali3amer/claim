<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $products = [
            ['barcode' => '11112',
                'name' => 'htc',
                'category_id' => '1'
            ],
            ['barcode' => '11113',
                'name' => 'samsung',
                'category_id' => '1'],
            ['barcode' => '11114',
                'name' => 'huawei',
                'category_id' => '1'],

        ];
        foreach ($products as $product)
        {
            \App\Product::create([
                'barcode'      =>  $product['barcode'],
                'name'      =>  $product['name'],
                'category_id'      =>  $product['category_id']
            ]);
        }

        for ($i = 0; $i < 5; $i++)
        {
            $detail = \App\Product_Detail::create([
                'product_id'      =>  '1',
                'stock'      =>  random_int(15, 40),
                'purchase_price'      =>  random_int(10, 20),
                'sale_price'      =>  random_int(10, 20),
                'discount'      =>  random_int(1, 5),
                'user_id'      =>  '1'
            ]);

            \App\Product::where('id', $detail->product_id)->update([
                'sale_price'=> $detail->sale_price,
                'discount' => $detail->discount
                ]);
        }

        for ($i = 0; $i < 10; $i++) {
            \App\Product::create([
                'barcode'      =>  random_int(15, 40),
                'name'      =>  'product'.$i,
                'category_id'      =>  random_int(1,9)
            ]);
        }
    }
}
