<?php

use Illuminate\Database\Seeder;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pl_PL');

        for ($i=1; $i<=30 ; $i++) { 

        	DB::table('videos')->insert([
        		'title' => $faker->text(20),
        		'url' => $faker->url,
        		'description' => $faker->text(500),
        		'user_id' => $faker->numberBetween(1,10),
        		'created_at' => $faker->dateTime
        	]);
        }
    }
}
