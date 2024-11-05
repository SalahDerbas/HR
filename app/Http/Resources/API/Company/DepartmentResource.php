<?php

namespace App\Http\Resources\API\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'id'      => $this['id'],
            'name'    => (config('app_header.lang') == 'ar') ? $this['name_ar'] : $this['name_en'],
            'title'   => (config('app_header.lang') == 'ar') ? $this['title_ar'] : $this['title_en'],
        ];
    }
}
