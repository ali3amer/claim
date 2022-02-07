<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['هواتف', 'مكتبه'];
        for ($i = 0;$i < count($categories);$i++)
        {
            \App\Category::create([
                'name'      =>  $categories[$i],
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            $user = \App\Category::create([
                'name'      =>  'category'.$i,
            ]);
        }
    }
}
