<?php

namespace App\Http\Resources\API\User;

use App\Models\Setting;
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
        $yearStart = Carbon::now()->startOfYear();
        $yearEnd = Carbon::now()->endOfYear();
        $vacationSettings = $this->getVacationSettings();

        $employmentDuration  = Carbon::parse($this['join_date'])->diff(Carbon::now());
        return [
            'id'                        => $this['id'],
            'since_period'              => formatDate($this['join_date']),
            'year'                      => $employmentDuration ->y,
            'month'                     => $employmentDuration ->m,
            'day'                       => $employmentDuration ->d,
            'sick'                      => [
                'from_date'       => formatDate($yearStart),
                'end_date'        => formatDate($yearEnd),
                'up_to_end'       => $vacationSettings['sick'] - $this->getSickLeave(),
                'already_taken'   => $this->getSickLeave(),
            ],
            'annual'                    => [
                'from_date'       => formatDate($yearStart),
                'end_date'        => formatDate($yearEnd),
                'up_to_end'       => $vacationSettings['annual'] - $this->getAnnualLeave(),
                'already_taken'   => $this->getAnnualLeave(),
            ]

        ];
    }

    /**
     * Retrieve vacation settings for sick and annual leave.
     *
     * @return array
     */
    private function getVacationSettings()
    {
        return [
            'sick'   => Setting::where('key', 'vacation_sick')->value('value'),
            'annual' => Setting::where('key', 'vacation_annual')->value('value'),
        ];
    }
}
