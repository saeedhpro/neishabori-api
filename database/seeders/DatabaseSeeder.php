<?php

namespace Database\Seeders;

use App\Models\User;
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
        // \App\Models\User::factory(10)->create();
//        $this->call(ProvinceAndCitySeeder::class);
//        $this->call(UserSeeder::class);
//        $this->call(CategorySeeder::class);
//        $this->call(SkillSeeder::class);
//        $this->call(ServiceSeeder::class);
//        $this->call(ArticleSeeder::class);
//        $this->call(RoleSeeder::class);
        foreach(User::all() as $user) {
            if ($user->cart === null) {
                $user->cart()->create();
            }
        }
    }
}
