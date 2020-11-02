<?php

use Illuminate\Database\Seeder;

class categoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->insert([
            'cat_name'=> 'أجهزه 1',
        ]);
        DB::table('categories')->insert([
            'cat_name'=> 'Storage Devices 1',
        ]);
    }
}
