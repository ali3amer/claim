<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $user = \App\User::create([
//            'name'      =>  'admin',
//            'email'     =>  'admin@test.com',
//            'password'  =>  Hash::make('123456')
//        ]);
//        $user->attachRole('super_admin');
//        $user->syncPermissions([1]);

//        for ($i = 0; $i < 10; $i++) {
//            $user = \App\User::create([
//                'name'      =>  'user'. $i,
//                'email'     =>  'admin@test.com'.$i,
//                'password'  =>  Hash::make('123456')
//            ]);
//        }

        $user = \App\User::create([
            'name'      =>  'admin',
//            'email'     =>  'admin@test.com',
            'password'  =>  Hash::make('123456'),
            'power' => 'manger',
            'state_id' => 2
        ]);


    }
}
