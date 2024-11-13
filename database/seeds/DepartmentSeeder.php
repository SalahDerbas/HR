<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->delete();

        DB::table('departments')->insert([
            ['name_ar' => 'تقنية',  'name_en' => 'Technical', 'title_ar' => 'قسم برمجة والتقانات الحاسوبية', 'title_en' => 'Computer Technical and Development Section' ],
            ['name_ar' => 'مبيعات', 'name_en' => 'Sales',     'title_ar' => 'قسم المبيعات والمرابح',         'title_en' => 'Sales Section' ],
        ]);

    }
}
