<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class LeavesResource extends JsonResource
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
            'id'                               => $this['id'],
            'start_time'                       => $this['start_time'],
            'end_time'                         => $this['end_time'],
            'doucument'                        => $this['doucument'],
            'user_id'                          => $this['user_id'],
            'reason_leave_id'                  => $this['reason_leave_id'],
            'reason_leave_type'                => isset($this['reason_leave_id']) ? ((config('app_header.lang') == 'ar') ? $this['getReasonLeave']['value_ar'] :$this['getReasonLeave']['value_en']) : NULL,
            'status_leave_id'                  => $this['reason_leave_id'],
            'status_leave_type'                => isset($this['status_leave_id']) ? ((config('app_header.lang') == 'ar') ? $this['getStatusLeave']['value_ar'] :$this['getStatusLeave']['value_en']) : NULL,

        ];
    }
}
