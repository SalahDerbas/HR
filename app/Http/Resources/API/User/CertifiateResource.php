<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class CertifiateResource extends JsonResource
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
                'id'                     => $this['id'],
                'start_date'             => formatDate($this['start_date']),
                'end_date'               => formatDate($this['end_date']),
                'note'                   => $this['note'],
                'document'               => $this['document'],
                'user_id'                => $this['user_id'],
        ];
    }
}
