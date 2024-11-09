<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
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
            'amount'                   => $this['amount'],
            'note'                     => $this['note'],
            'document'                 => $this['document'],
            'user_id'                  => $this['user_id'],
            'type_asset_id'            => $this['type_asset_id'],
            'asset_type'               => isset($this['type_asset_id']) ? ((config('app_header.lang') == 'ar') ? $this['getAssetType']['value_ar'] :$this['getAssetType']['value_en']) : NULL,

        ];
    }
}
