<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pl_PL');

        for ($i = 1; $i <= 30; $i++) {
            $title = $faker->text(20);
            DB::table('articles')->insert([
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => $faker->text(500),
                'path' => null, //$faker->imageUrl(275,150),
                'user_id' => 1,
                'category_id' => $faker->numberBetween(1, 5),
                'created_at' => $faker->dateTime
            ]);
        }
    }
}
