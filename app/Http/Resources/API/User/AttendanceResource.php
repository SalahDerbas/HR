<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'date'                             => formatDate($this['date']),
            'time'                             => $this['time'],
            'location'                         => $this['location'],
            'user_id'                          => $this['user_id'],
            'status_attendance_id'             => $this['status_attendance_id'],
            'status_attendance_type'           => isset($this['status_attendance_id']) ? ((config('app_header.lang') == 'ar') ? $this['getAttendanceStatusType']['value_ar'] :$this['getAttendanceStatusType']['value_en']) : NULL,
        ];
    }
}
