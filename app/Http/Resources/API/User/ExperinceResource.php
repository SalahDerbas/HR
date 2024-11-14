<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ExperinceResource extends JsonResource
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
            'id'                                => $this['id'],
            'company_name'                      => $this['company_name'],
            'company_phone'                     => $this['company_phone'],
            'company_location'                  => $this['company_location'],
            'start_date'                        => formatDate($this['start_date']),
            'end_date'                          => formatDate($this['end_date']),
            'doucument'                         => $this['doucument'],
            'note'                              => $this['note'],
            'user_id'                           => $this['user_id'],
            'leave_reason'                      => $this['leave_reason'],
        ];
    }
}
