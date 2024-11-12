<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();

        DB::table('settings')->insert([

            ['key' => 'company_name',             'value' => 'SD-Softwares'],
            ['key' => 'company_location',         'value' => 'Amman - Jordan'],
            ['key' => 'company_phone',            'value' => '0785204657'],
            ['key' => 'owner',                    'value' => 'Salah Derbas'],
            ['key' => 'website_url',              'value' => 'https://sd-softwares.vercel.app/'],
            ['key' => 'linkedin_url',             'value' => 'https://www.linkedin.com/in/salah-derbas/'],
            ['key' => 'facebook_url',             'value' => 'https://www.facebook.com/salah.drbas.1'],
            ['key' => 'youtube_url',              'value' => 'https://www.youtube.com/channel/UCEYTgaou2YKbymbC0mUnAhw'],
            ['key' => 'logo',                     'value' => env('APP_URL') . '/assets/images/Logo SD1.png'],
            ['key' => 'note',                     'value' => 'This is note'],
            ['key' => 'created_date',             'value' => '2023-04-01'],
            ['key' => 'vacation_sick',            'value' => '14'],
            ['key' => 'vacation_annual',          'value' => '14'],
            ['key' => 'Holiday_day_Satarday',     'value' => '1' ],
            ['key' => 'Holiday_day_Sunday',       'value' => '0' ],
            ['key' => 'Holiday_day_Monday',       'value' => '0' ],
            ['key' => 'Holiday_day_Thursday',     'value' => '0' ],
            ['key' => 'Holiday_day_Wednesday',    'value' => '0' ],
            ['key' => 'Holiday_day_Tuesday',      'value' => '0' ],
            ['key' => 'Holiday_day_Friday',       'value' => '1' ],

        ]);
    }
}
