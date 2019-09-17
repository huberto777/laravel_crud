<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(AlbumsTableSeeder::class);
        // $this->call(CommentsTableSeeder::class);
        //$this->call(PhotosTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(TaggablesTableSeeder::class);
        $this->call(VideosTableSeeder::class);
        $this->call(LikeablesTableSeeder::class);
    }
}
