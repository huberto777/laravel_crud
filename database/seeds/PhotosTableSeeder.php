<?php

use Illuminate\Database\Seeder;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pl_PL');

        for ($i=1; $i<=200; $i++) { 

        	DB::table('photos')->insert([
        		'path' => $faker->imageUrl(1200,800),
        		'album_id' => $faker->numberBetween(1,10)
        	]);
        }

    }
}
