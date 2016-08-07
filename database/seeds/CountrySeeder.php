<?php

use Illuminate\Database\Seeder;

/**
 * Class CountrySeeder
 *
 * @subpackage CountrySeeder
 */
class CountrySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('DELETE FROM countries');

        $sql = file_get_contents(__DIR__ . '/sql/countries.sql');

        DB::statement($sql);
    }
}
