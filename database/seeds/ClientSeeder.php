<?php

use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Client::create([
            'name'      =>  'random',
            'telephone'     =>  ''
        ]);
//        for ($i = 0; $i < 10; $i++) {
//            \App\Client::create([
//                'name'      =>  'random'.$i,
//                'telephone'     =>  '0912345678'
//            ]);
//        }
    }
}
