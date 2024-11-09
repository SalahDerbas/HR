<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class DashboardResource extends JsonResource
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
        $date = Carbon::parse($this['join_date'])->diff(Carbon::now());
        return [
            'id'                        => $this['id'],
            'since_period'              => formatDate($this['join_date']),
            'year'                      => $date->y,
            'month'                     => $date->m,
            'day'                       => $date->d,

        ];
    }
}
