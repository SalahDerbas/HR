<?php

namespace App\Http\Resources\API\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'company_name'               => $this['company_name'],
            'company_location'           => $this['company_location'],
            'company_phone'              => $this['company_phone'],
            'owner'                      => $this['owner'],
            'website_url'                => $this['website_url'],
            'linkedin_url'               => $this['linkedin_url'],
            'facebook_url'               => $this['facebook_url'],
            'youtube_url'                => $this['youtube_url'],
            'logo'                       => $this['logo'],
            'note'                       => $this['note'],
            'created_date'               => formatDate($this['created_date']),
            'vacation_sick'              => (int)$this['vacation_sick'],
            'vacation_annual'            => (int)$this['vacation_annual'],
            'Holiday_day_Satarday'       => (boolean)$this['Holiday_day_Satarday'],
            'Holiday_day_Sunday'         => (boolean)$this['Holiday_day_Sunday'],
            'Holiday_day_Monday'         => (boolean)$this['Holiday_day_Monday'],
            'Holiday_day_Thursday'       => (boolean)$this['Holiday_day_Thursday'],
            'Holiday_day_Wednesday'      => (boolean)$this['Holiday_day_Wednesday'],
            'Holiday_day_Tuesday'        => (boolean)$this['Holiday_day_Tuesday'],
            'Holiday_day_Friday'         => (boolean)$this['Holiday_day_Friday'],

        ];
    }
}
