<?php

use Illuminate\Database\Seeder;

class LikeablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pl_PL');

        for ($i = 1; $i <= 100; $i++) {

            DB::table('likeables')->insert([
                'user_id' => $faker->numberBetween(1, 10),
                'likeable_id' => $faker->numberBetween(1, 30),
                'likeable_type' => $faker->randomElement(['App\Article', 'App\Video'])
            ]);
        }
    }
}
