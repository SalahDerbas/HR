<?php

use Illuminate\Database\Seeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\LookupSeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\DepartmentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LookupSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
