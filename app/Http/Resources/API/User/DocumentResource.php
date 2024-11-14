<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'id'                     => $this['id'],
            'note'                   => $this['note'],
            'document'               => $this['document'],
            'user_id'                => $this['user_id'],
            'type_document_id'       => isset($this['type_document_id']) ? ((config('app_header.lang') == 'ar') ? $this['getDocumentType']['value_ar'] :$this['getDocumentType']['value_en']) : NULL,

    ];

    }
}
