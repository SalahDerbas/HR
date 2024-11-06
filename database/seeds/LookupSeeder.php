<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LookupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lookups')->delete();

        DB::table('lookups')->insert([

            ['code' => 'U-Gender',           'key' => 'G-Male', 'value_ar' => 'ذكر', 'value_en' => 'Male'],
            ['code' => 'U-Gender',           'key' => 'G-Female', 'value_ar' => 'أنثى', 'value_en' => 'Female'],

            ['code' => 'U-Reigon',           'key' => 'R-Muslim', 'value_ar' => 'مسلم', 'value_en' => 'Muslim'],
            ['code' => 'U-Reigon',           'key' => 'R-Christian', 'value_ar' => 'مسيحي', 'value_en' => 'Christian'],
            ['code' => 'U-Reigon',           'key' => 'R-Other', 'value_ar' => 'غيرذلك', 'value_en' => 'Other'],

            ['code' => 'U-MaterialStatus',   'key' => 'MS-Single', 'value_ar' => 'أعزب', 'value_en' => 'Single'],
            ['code' => 'U-MaterialStatus',   'key' => 'MS-Married', 'value_ar' => 'متزوج', 'value_en' => 'Married'],
            ['code' => 'U-MaterialStatus',   'key' => 'MS-Sngaged', 'value_ar' => 'خاطب', 'value_en' => 'Sngaged'],

            ['code' => 'U-Worktype',         'key' => 'WT-Full_Time', 'value_ar' => 'دوام كامل', 'value_en' => 'Full Time'],
            ['code' => 'U-Worktype',         'key' => 'WT-Part_Time', 'value_ar' => 'دوام جزئي', 'value_en' => 'Part Time'],
            ['code' => 'U-Worktype',         'key' => 'WT-Hypred', 'value_ar' => 'مختلط', 'value_en' => 'Hypred'],
            ['code' => 'U-Worktype',         'key' => 'WT-Remotly', 'value_ar' => 'أونلاين', 'value_en' => 'Remotly'],

            ['code' => 'U-ContractType',     'key' => 'CT-Unlimeted', 'value_ar' => 'غير محدد', 'value_en' => 'Unlimeted'],
            ['code' => 'U-ContractType',     'key' => 'CT-Yearly', 'value_ar' => 'سنوي', 'value_en' => 'Yearly'],
            ['code' => 'U-ContractType',     'key' => 'CT-3_Year', 'value_ar' => '3 سنوات', 'value_en' => '3 Year']  ,

            ['code' => 'U-StatusUser',       'key' => 'SU-Enable', 'value_ar' => 'فعال', 'value_en' => 'Enable'],
            ['code' => 'U-StatusUser',       'key' => 'SU-Disable', 'value_ar' => 'غير فعال', 'value_en' => 'Disable'],

            ['code' => 'U-StatusAttendance', 'key' => 'SA-Check_In', 'value_ar' => ' تسجيل دخول ', 'value_en' => 'Check-In'],
            ['code' => 'U-StatusAttendance', 'key' => 'SA-Check_Out', 'value_ar' => ' تسجيل خروج ', 'value_en' => 'Check-Out'],

            ['code' => 'U-ReasonLeave',      'key' => 'RL-Annual', 'value_ar' => 'سنوي', 'value_en' => 'Annual'],
            ['code' => 'U-ReasonLeave',      'key' => 'RL-Sick', 'value_ar' => 'مرضي', 'value_en' => 'Sick'],
            ['code' => 'U-ReasonLeave',      'key' => 'RL-Unpaid', 'value_ar' => 'غير مدفوع', 'value_en' => 'Unpaid'],
            ['code' => 'U-ReasonLeave',      'key' => 'RL-Hajj', 'value_ar' => 'حج', 'value_en' => 'Hajj'],
            ['code' => 'U-ReasonLeave',      'key' => 'RL-Marriage', 'value_ar' => 'زواج', 'value_en' => 'Marriage'],
            ['code' => 'U-ReasonLeave',      'key' => 'RL-Bereavement_(_1_Degree_)', 'value_ar' => 'موت درجة أولى', 'value_en' =>  'Bereavement ( 1 Degree )'],
            ['code' => 'U-ReasonLeave',      'key' => 'RL-Bereavement_(_2_Degree_)', 'value_ar' => 'موت درجة ثانية', 'value_en' => 'Bereavement ( 2 Degree )'],
            ['code' => 'U-ReasonLeave',      'key' => 'RL-Bereavement_(_3_Degree_)', 'value_ar' => 'موت درجة ثالثة', 'value_en' => 'Bereavement ( 3 Degree )'],
            ['code' => 'U-ReasonLeave',      'key' => 'RL-Study', 'value_ar' => 'دراسة', 'value_en' => 'Study'],

            ['code' => 'U-StatusLeave',      'key' => 'SL-Pending', 'value_ar' => 'انتظار', 'value_en' => 'Pending'],
            ['code' => 'U-StatusLeave',      'key' => 'SL-Approve', 'value_ar' => 'موافقة', 'value_en' => 'Approve'],
            ['code' => 'U-StatusLeave',      'key' => 'SL-Rejected', 'value_ar' => 'مرفوض', 'value_en' => 'Rejected'],

            ['code' => 'U-TypeVacation',     'key' => 'TV-Personal', 'value_ar' => 'شخصي', 'value_en' => 'Personal'],
            ['code' => 'U-TypeVacation',     'key' => 'TV-Sick', 'value_ar' => 'مرضي', 'value_en' => 'Sick'],
            ['code' => 'U-TypeVacation',     'key' => 'TV-Business', 'value_ar' => 'عمل', 'value_en' => 'Business'],
            ['code' => 'U-TypeVacation',     'key' => 'TV-Travel', 'value_ar' => 'سفر', 'value_en' => 'Travel'],

            ['code' => 'U-TypeAsset',        'key' => 'TA-Laptop', 'value_ar' => 'لابتوب', 'value_en' => 'Laptop'],
            ['code' => 'U-TypeAsset',        'key' => 'TA-Mouse', 'value_ar' => 'ماوس', 'value_en' => 'Mouse'],
            ['code' => 'U-TypeAsset',        'key' => 'TA-Bus_line', 'value_ar' => 'خط باص', 'value_en' => 'Bus line'],
            ['code' => 'U-TypeAsset',        'key' => 'TA-Mobile', 'value_ar' => 'موبايل', 'value_en' => 'Mobile'],
            ['code' => 'U-TypeAsset',        'key' => 'TA-Sim_Card', 'value_ar' => 'بطاقة سيم', 'value_en' => 'Sim Card'],
            ['code' => 'U-TypeAsset',        'key' => 'TA-Car', 'value_ar' => 'سيارة', 'value_en' => 'Car'],
            ['code' => 'U-TypeAsset',        'key' => 'TA-Hard_Desk', 'value_ar' => 'هارد ديسك', 'value_en' => 'Hard Desk'],
            ['code' => 'U-TypeAsset',        'key' => 'TA-Office_Key', 'value_ar' => 'مفتاح الشركة', 'value_en' => 'Office Key'],

            ['code' => 'U-TypeMissingPunch', 'key' => 'TMP-Attendance', 'value_ar' => 'حضور', 'value_en' => 'Attendance'],
            ['code' => 'U-TypeMissingPunch', 'key' => 'TMP-Break', 'value_ar' => 'استراحة', 'value_en' => 'Break'],

            ['code' => 'U-TypeDocument',     'key' => 'TD-ID_Card', 'value_ar' => 'البطاقة الشخصية', 'value_en' => 'ID Card'],
            ['code' => 'U-TypeDocument',     'key' => 'TD-Passport', 'value_ar' => 'جواز السفر', 'value_en' => 'Passport'],
            ['code' => 'U-TypeDocument',     'key' => 'TD-Family_book', 'value_ar' => 'دفتر العيلة', 'value_en' => 'Family book'],
            ['code' => 'U-TypeDocument',     'key' => 'TD-CV', 'value_ar' => 'السيرة الذاتية', 'value_en' => 'CV'],

            ['code' => 'U-Content',          'key' => 'C-about_us', 'value_ar' => 'معلومات عنا', 'value_en' => 'About Us'],
            ['code' => 'U-Content',          'key' => 'C-privacy_policy', 'value_ar' => 'سياسة الخصوصية', 'value_en' => 'Privacy Policy'],
            ['code' => 'U-Content',          'key' => 'C-FAQ', 'value_ar' => 'أسئلة شائعة', 'value_en' => 'FAQ'],
            ['code' => 'U-Content',          'key' => 'C-terms_conditions', 'value_ar' => 'الشروط والأحكام', 'value_en' => 'Terms & Conditions'],
            ['code' => 'U-Content',          'key' => 'C-sliders', 'value_ar' => 'شرائح', 'value_en' => 'Sliders'],


            // ..............
        ]);
    }
}
