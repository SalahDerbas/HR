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

            ['code' => 'U-Gender', 'key' => 'gender', 'value_ar' => 'ذكر', 'value_en' => 'Male'],
            ['code' => 'U-Gender', 'key' => 'gender', 'value_ar' => 'أنثى', 'value_en' => 'Female'],

            ['code' => 'U-Reigon', 'key' => 'reigon', 'value_ar' => 'مسلم', 'value_en' => 'Muslim'],
            ['code' => 'U-Reigon', 'key' => 'reigon', 'value_ar' => 'مسيحي', 'value_en' => 'Christian'],
            ['code' => 'U-Reigon', 'key' => 'reigon', 'value_ar' => 'غيرذلك', 'value_en' => 'Other'],

            ['code' => 'U-MaterialStatus', 'key' => 'material_status', 'value_ar' => 'أعزب', 'value_en' => 'Single'],
            ['code' => 'U-MaterialStatus', 'key' => 'material_status', 'value_ar' => 'متزوج', 'value_en' => 'Married'],
            ['code' => 'U-MaterialStatus', 'key' => 'material_status', 'value_ar' => 'خاطب', 'value_en' => 'Sngaged'],

            ['code' => 'U-Worktype', 'key' => 'work_type', 'value_ar' => 'دوام كامل', 'value_en' => 'Full Time'],
            ['code' => 'U-Worktype', 'key' => 'work_type', 'value_ar' => 'دوام جزئي', 'value_en' => 'Part Time'],
            ['code' => 'U-Worktype', 'key' => 'work_type', 'value_ar' => 'مختلط', 'value_en' => 'Hypred'],
            ['code' => 'U-Worktype', 'key' => 'work_type', 'value_ar' => 'أونلاين', 'value_en' => 'Remotly'],

            ['code' => 'U-ContractType', 'key' => 'contract_type', 'value_ar' => 'غير محدد', 'value_en' => 'Unlimeted'],
            ['code' => 'U-ContractType', 'key' => 'contract_type', 'value_ar' => 'سنوي', 'value_en' => 'Yearly'],
            ['code' => 'U-ContractType', 'key' => 'contract_type', 'value_ar' => '3 سنوات', 'value_en' => '3 Year'],

            ['code' => 'U-StatusUser', 'key' => 'status_user', 'value_ar' => 'فعال', 'value_en' => 'Enable'],
            ['code' => 'U-StatusUser', 'key' => 'status_user', 'value_ar' => 'غير فعال', 'value_en' => 'Disable'],

            ['code' => 'U-StatusAttendance', 'key' => 'status_attendance', 'value_ar' => ' تسجيل دخول ', 'value_en' => 'Check-In'],
            ['code' => 'U-StatusAttendance', 'key' => 'status_attendance', 'value_ar' => ' تسجيل خروج ', 'value_en' => 'Check-Out'],

            ['code' => 'U-ReasonLeave', 'key' => 'reason_leave', 'value_ar' => 'سنوي', 'value_en' => 'Annual'],
            ['code' => 'U-ReasonLeave', 'key' => 'reason_leave', 'value_ar' => 'مرضي', 'value_en' => 'Sick'],
            ['code' => 'U-ReasonLeave', 'key' => 'reason_leave', 'value_ar' => 'غير مدفوع', 'value_en' => 'Unpaid'],
            ['code' => 'U-ReasonLeave', 'key' => 'reason_leave', 'value_ar' => 'حج', 'value_en' => 'Hajj'],
            ['code' => 'U-ReasonLeave', 'key' => 'reason_leave', 'value_ar' => 'زواج', 'value_en' => 'Marriage'],
            ['code' => 'U-ReasonLeave', 'key' => 'reason_leave', 'value_ar' => 'موت درجة أولى', 'value_en' =>  'Bereavement ( 1 Degree )'],
            ['code' => 'U-ReasonLeave', 'key' => 'reason_leave', 'value_ar' => 'موت درجة ثانية', 'value_en' => 'Bereavement ( 2 Degree )'],
            ['code' => 'U-ReasonLeave', 'key' => 'reason_leave', 'value_ar' => 'موت درجة ثالثة', 'value_en' => 'Bereavement ( 3 Degree )'],
            ['code' => 'U-ReasonLeave', 'key' => 'reason_leave', 'value_ar' => 'دراسة', 'value_en' => 'Study'],

            ['code' => 'U-StatusLeave', 'key' => 'status_leave', 'value_ar' => 'انتظار', 'value_en' => 'Pending'],
            ['code' => 'U-StatusLeave', 'key' => 'status_leave', 'value_ar' => 'موافقة', 'value_en' => 'Approve'],
            ['code' => 'U-StatusLeave', 'key' => 'status_leave', 'value_ar' => 'مرفوض', 'value_en' => 'Rejected'],

            ['code' => 'U-TypeVacation', 'key' => 'type_vacation', 'value_ar' => 'شخصي', 'value_en' => 'Personal'],
            ['code' => 'U-TypeVacation', 'key' => 'type_vacation', 'value_ar' => 'مرضي', 'value_en' => 'Sick'],
            ['code' => 'U-TypeVacation', 'key' => 'type_vacation', 'value_ar' => 'عمل', 'value_en' => 'Business'],
            ['code' => 'U-TypeVacation', 'key' => 'type_vacation', 'value_ar' => 'سفر', 'value_en' => 'Travel'],

            ['code' => 'U-TypeAsset', 'key' => 'type_asset', 'value_ar' => 'لابتوب', 'value_en' => 'Laptop'],
            ['code' => 'U-TypeAsset', 'key' => 'type_asset', 'value_ar' => 'ماوس', 'value_en' => 'Mouse'],
            ['code' => 'U-TypeAsset', 'key' => 'type_asset', 'value_ar' => 'خط باص', 'value_en' => 'Bus line'],
            ['code' => 'U-TypeAsset', 'key' => 'type_asset', 'value_ar' => 'موبايل', 'value_en' => 'Mobile'],
            ['code' => 'U-TypeAsset', 'key' => 'type_asset', 'value_ar' => 'بطاقة سيم', 'value_en' => 'Sim Card'],
            ['code' => 'U-TypeAsset', 'key' => 'type_asset', 'value_ar' => 'سيارة', 'value_en' => 'Car'],
            ['code' => 'U-TypeAsset', 'key' => 'type_asset', 'value_ar' => 'هارد ديسك', 'value_en' => 'Hard Desk'],
            ['code' => 'U-TypeAsset', 'key' => 'type_asset', 'value_ar' => 'مفتاح الشركة', 'value_en' => 'Office Key'],

            ['code' => 'U-TypeMissingPunch', 'key' => 'type_missing_punch', 'value_ar' => 'حضور', 'value_en' => 'Attendance'],
            ['code' => 'U-TypeMissingPunch', 'key' => 'type_missing_punch', 'value_ar' => 'استراحة', 'value_en' => 'Break'],

            ['code' => 'U-TypeDocument', 'key' => 'type_document_id', 'value_ar' => 'البطاقة الشخصية', 'value_en' => 'ID Card'],
            ['code' => 'U-TypeDocument', 'key' => 'type_document_id', 'value_ar' => 'جواز السفر', 'value_en' => 'Passport'],
            ['code' => 'U-TypeDocument', 'key' => 'type_document_id', 'value_ar' => 'دفتر العيلة', 'value_en' => 'Family book'],
            ['code' => 'U-TypeDocument', 'key' => 'type_document_id', 'value_ar' => 'السيرة الذاتية', 'value_en' => 'CV'],



            // ..............
        ]);
    }
}
