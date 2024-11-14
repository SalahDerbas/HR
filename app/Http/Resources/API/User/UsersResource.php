<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     * @author Salah Derbas
     */
    public function toArray($request)
    {
        parent::toArray($request);
        $data      = getUserWithRelations($this->email);

        return [
            'id'                      => $data->id,
            'email'                   => $data->email,
            'usrename'                => $data->usrename,
            'name'                    => (config('app_header.lang') == 'ar') ? $data->name_ar : $data->name_en,
            'location'                => (config('app_header.lang') == 'ar') ? $data->location_ar : $data->location_en,
            'phone'                   => $data->phone,
            'ID_code'                 => $data->ID_code,
            'passport_code'           => $data->passport_code,
            'salary'                  => $data->salary,
            'date_of_brith'           => formatDate($data->date_of_brith) ,
            'join_date'               => formatDate($data->join_date),
            'country_id'              => $data->country_id,
            'gender_id'               => $data->gender_id,
            'gender_name'             => isset($data->gender_id) ? ((config('app_header.lang') == 'ar') ? $data->getGender->value_ar :$data->getGender->value_en) : NULL,
            'reigon_id'               => $data->reigon_id,
            'reigon_name'             => isset($data->reigon_id) ? ((config('app_header.lang') == 'ar') ? $data->getReigon->value_ar :$data->getReigon->value_en) : NULL,
            'material_status_id'      => $data->material_status_id,
            'material_status_name'    => isset($data->material_status_id) ? ((config('app_header.lang') == 'ar') ? $data->getMaterialStatus->value_ar :$data->getMaterialStatus->value_en) :NULL,
            'work_type_id'            => $data->work_type_id,
            'work_type_name'          => isset($data->work_type_id) ? ((config('app_header.lang') == 'ar') ? $data->getWorkType->value_ar :$data->getWorkType->value_en) :NULL,
            'contract_type_id'        => $data->contract_type_id,
            'contract_type_name'      => isset($data->contract_type_id) ? ((config('app_header.lang') == 'ar') ? $data->getContractType->value_ar :$data->getContractType->value_en) : NULL ,
            'status_user_id'          => $data->status_user_id,
            'status_user_name'        => isset($data->status_user_id) ? ((config('app_header.lang') == 'ar') ? $data->getStatusUser->value_ar :$data->getStatusUser->value_en) : NULL ,
            'directory_id'            => $data->directory_id,
            'department_id'           => $data->department_id,
            'department_name'         => isset($data->department_id) ? ((config('app_header.lang') == 'ar') ? $data->getDepartment->name_ar :$data->getDepartment->name_en) : NULL ,
            'photo'                   => $data->photo,
            'is_directory'            => (boolean)$data->is_directory,
            'last_login'              => formatDate($data->last_login),
            'enable_notification'     => $data->enable_notification,
            'verify'                  => is_null($data->email_verified_at) ? False : True,

        ];
    }
}
