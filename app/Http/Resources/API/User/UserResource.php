<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        parent::toArray($request);
        return [
            'id'                      => $this->id,
            'email'                   => $this->email,
            'usrename'                => $this->usrename,
            'name'                    => (config('app_header.lang') == 'ar') ? $this->name_ar : $this->name_en,
            'location'                => (config('app_header.lang') == 'ar') ? $this->location_ar : $this->location_en,
            'phone'                   => $this->phone,
            'ID_code'                 => $this->ID_code,
            'passport_code'           => $this->passport_code,
            'salary'                  => $this->salary,
            'date_of_brith'           => !is_null($this->date_of_brith) ? Carbon::parse($this->date_of_brith)->format('Y-m-d') : NULL ,
            'join_date'               => !is_null($this->join_date) ? Carbon::parse($this->join_date)->format('Y-m-d') : NULL,
            'country_id'              => $this->country_id,
            'gender_id'               => $this->gender_id,
            'gender_name'             => (config('app_header.lang') == 'ar') ? $this->getGender->value_ar :$this->getGender->value_en,
            'reigon_id'               => $this->reigon_id,
            'reigon_name'             => (config('app_header.lang') == 'ar') ? $this->getReigon->value_ar :$this->getReigon->value_en,
            'material_status_id'      => $this->material_status_id,
            'material_status_name'    => (config('app_header.lang') == 'ar') ? $this->getMaterialStatus->value_ar :$this->getMaterialStatus->value_en,
            'work_type_id'            => $this->work_type_id,
            'work_type_name'          => (config('app_header.lang') == 'ar') ? $this->getWorkType->value_ar :$this->getWorkType->value_en,
            'contract_type_id'        => $this->contract_type_id,
            'contract_type_name'      => (config('app_header.lang') == 'ar') ? $this->getContractType->value_ar :$this->getContractType->value_en,
            'status_user_id'          => $this->status_user_id,
            'status_user_name'        => (config('app_header.lang') == 'ar') ? $this->getStatusUser->value_ar :$this->getStatusUser->value_en,
            'directory_id'            => $this->directory_id,
            'photo'                   => $this->photo,
            'is_directory'            => (boolean)$this->is_directory,
            'last_login'              => !is_null($this->last_login) ? Carbon::parse($this->last_login)->format('Y-m-d') : NULL,
            'enable_notification'     => $this->enable_notification,
            'fcm_token'               => $this->fcm_token,
            'verify'                  => is_null($this->email_verified_at) ? False : True,
            'access_token'            => auth()->user()->createToken('hr_api')->accessToken
        ];
    }
}
