<?php

use Illuminate\Database\Seeder;

class AlbumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pl_PL');

        for ($i=1; $i<=10; $i++) { 
        	
        	DB::table('albums')->insert([
        		'name' => $faker->text(10),
        		'user_id' => 1
        	]);
        }
    }
}
