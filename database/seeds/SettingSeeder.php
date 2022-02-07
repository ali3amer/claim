<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Setting::create([
            'name' => 'store',
            'telephones' => '099999999',
            'location' => 'Dongola'
        ]);
    }
}
