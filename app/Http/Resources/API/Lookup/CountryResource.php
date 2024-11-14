<?php

namespace App\Http\Resources\API\Lookup;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
        return [
            'id'              =>    $this->id,
            'name'            =>    $this->name,
            'code'            =>    $this->code,
            'country_code'    =>    $this->country_code,
        ];
    }
}
