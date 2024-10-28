<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NotificationResource extends JsonResource
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
                'id'              =>   $this->id,
                'title'           =>   (config('app_header.lang') == 'ar') ? $this->title_ar : $this->title_en,
                'body'            =>   (config('app_header.lang') == 'ar') ? $this->body_ar : $this->body_en,
                'user_id'         =>   $this->user_id,
                'created_at'      =>   formatDate($this->created_at) ,
                'updated_at'      =>   formatDate($this->updated_at) ,
        ];
    }
}
