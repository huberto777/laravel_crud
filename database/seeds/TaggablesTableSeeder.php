<?php

use Illuminate\Database\Seeder;

class TaggablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pl_PL');

        for ($i = 1; $i <= 50; $i++) {

            DB::table('taggables')->insert([
                'tag_id' => $faker->numberBetween(1, 30),
                'taggable_id' => $faker->numberBetween(1, 30),
                'taggable_type' => $faker->randomElement(['App\Article', 'App\Video'])
            ]);
        }
    }
}
