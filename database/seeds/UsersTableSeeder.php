<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pl_PL');

        for ($i = 1; $i <= 10; $i++) {

            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => bcrypt('qwerty'),
                // 'path' => $faker->imageUrl(250, 175),
                'path' => null,
                'remember_token' => Str::random(32)
            ]);
        }
    }
}
