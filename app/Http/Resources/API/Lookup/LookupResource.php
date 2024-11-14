<?php

namespace App\Http\Resources\API\Lookup;

use Illuminate\Http\Resources\Json\JsonResource;

class LookupResource extends JsonResource
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
            'id'           => $this->id,
            'key'          => $this->key,
            'value'        => (config('app_header.lang') == 'ar') ? $this->value_ar : $this->value_en,

        ];
    }
}
