<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
              'id'                    => $this['id'],
              'from_time'             => $this['from_time'],
              'to_time'               => $this['to_time'],
              'photo'                 => $this['photo'],
              'created_at'            => formatDate($this['created_at']),
        ];
    }
}
