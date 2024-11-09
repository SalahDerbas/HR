<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class VacationsResource extends JsonResource
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
            'id'                         => $this['id'],
            'start_date'                 => formatDate($this['start_date']),
            'end_date'                   => formatDate($this['end_date']),
            'doucument'                  => $this['doucument'],
            'reason'                     => $this['reason'],
            'user_id'                    => $this['user_id'],
            'type_vacation_id'           => $this['type_vacation_id'],
            'vacation_type'              => isset($this['type_vacation_id']) ? ((config('app_header.lang') == 'ar') ? $this['getVacationType']['value_ar'] :$this['getVacationType']['value_en']) : NULL,





        ];
    }
}
