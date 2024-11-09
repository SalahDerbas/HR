<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            'name_ar'                       =>   'صلاح درباس',
            'name_en'                       =>   'Salah Derbas',
            'is_directory'                  =>   false,
            'email'                         =>   'admin@admin.com',
            'email_verified_at'             =>   now(),
            'usrename'                      =>   'SalahDerbas',
            'password'                      =>   Hash::make('12345678'),
            'phone'                         =>    987654321,
            'ID_code'                       =>   "99745456101",
            'passport_code'                 =>   "2353545245",
            'salary'                        =>   32425435,
            'location_ar'                   =>   'عمان',
            'location_en'                   =>   'Amman',
            'date_of_brith'                 =>   now(),
            'join_date'                     =>   now(),
            'country_id'                    =>   1,
            'gender_id'                     =>   1,
            'reigon_id'                     =>   3,
            'material_status_id'            =>   6,
            'work_type_id'                  =>   9,
            'contract_type_id'              =>   13,
            'status_user_id'                =>   16,
            'fcm_token'                     =>   Null,
            'photo'                         =>   env('APP_URL') . '/assets/images/Logo SD1.png',
        ]);

    }
}
