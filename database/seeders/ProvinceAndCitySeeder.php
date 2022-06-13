<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceAndCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Province::all()->count() == 0) {
            ini_set('memory_limit', '-1');
            DB::unprepared( file_get_contents( "database/seeders/dump.sql" ) );
        }
    }
}
