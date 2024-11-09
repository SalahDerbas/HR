<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
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
            'id'                        => $this->id,
            'title'                     => (config('requestheaders.lang') == 'ar') ? $this->title_ar : $this->title_en,
            'description'               => (config('requestheaders.lang') == 'ar') ? $this->description_ar : $this->description_en,
            'photo'                     => $this->photo,
        ];
    }
}
