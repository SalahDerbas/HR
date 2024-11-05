<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\BaseRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class AssetRequest extends BaseRequest
{
    private const ROUTE_ASSET_STORE          = 'api.user.asset.store';
    private const ROUTE_ASSET_UPDATE         = 'api.user.asset.update';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that update vacation to the request.
     *
     * @return array
     */
    private function assetUpdateRequest()
    {
        return [
            'rules'   =>  [
                'amount'                        => ['required'],
                'note'                          => ['required' ],
                'type_asset_id'                 => ['required' ,  'exists:lookups,id' ],
                'document'                      => [ 'file'  ],
            ],
            'messages'  => [
                'amount.required'                 => getStatusText(AMOUNT_REQUIRED_CODE),
                'note.required'                   => getStatusText(NOTE_REQUIRED_CODE),
                'type_asset_id.required'          => getStatusText(TYPE_ASSET_ID_REQUIRED_CODE),
                'type_asset_id.exists'            => getStatusText(TYPE_ASSET_ID_EXISTS_CODE),
                'document.file'                   => getStatusText(DOCUMENT_FILE_CODE),

            ],
        ];
    }

    /**
     * Get the validation rules that store vacation to the request.
     *
     * @return array
     */
    private function assetStoreRequest()
    {
        return [
            'rules'   =>  [
                'amount'                        => ['required'],
                'note'                          => ['required' ],
                'type_asset_id'                 => ['required' ,  'exists:lookups,id' ],
                'document'                      => ['required' ,  'file'  ],
            ],
            'messages'  => [
                'amount.required'                 => getStatusText(AMOUNT_REQUIRED_CODE),
                'note.required'                   => getStatusText(NOTE_REQUIRED_CODE),
                'type_asset_id.required'          => getStatusText(TYPE_ASSET_ID_REQUIRED_CODE),
                'type_asset_id.exists'            => getStatusText(TYPE_ASSET_ID_EXISTS_CODE),
                'document.required'               => getStatusText(DOCUMENT_REQUIRED_CODE),
                'document.file'                   => getStatusText(DOCUMENT_FILE_CODE),

            ],
        ];
    }
    /**
     * Get requested data based on the current route.
     *
     * @param string $key
     * @return mixed
     */
    private function requested($key)
    {
        $route = $this->route()->getName();
        $data  = match ($route) {
                self::ROUTE_ASSET_STORE                => $this->assetStoreRequest(),
                self::ROUTE_ASSET_UPDATE               => $this->assetUpdateRequest(),

                default => [ 'rules' => [], 'messages' => []  ]
        };
        return $data[$key];

    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    /**
     * Get the validation rules for the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->requested('rules');
    }

    /**
     * Get the validation messages for the request.
     *
     * @return array
     */
    public function messages()
    {
        return $this->requested('messages');
    }
    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $route      = $this->route()->getName();
        $messages   = $this->messages();

        $errorMap = match ($route) {
            self::ROUTE_ASSET_STORE  => [

                $messages['amount.required'       ]          => AMOUNT_REQUIRED_CODE,
                $messages['note.required'         ]          => NOTE_REQUIRED_CODE,
                $messages['type_asset_id.required']          => TYPE_ASSET_ID_REQUIRED_CODE,
                $messages['type_asset_id.exists'  ]          => TYPE_ASSET_ID_EXISTS_CODE,
                $messages['document.file'         ]          => DOCUMENT_FILE_CODE,
                $messages['document.required'  ]             => DOCUMENT_REQUIRED_CODE,

            ],
            self::ROUTE_ASSET_UPDATE => [
                $messages['amount.required'       ]          => AMOUNT_REQUIRED_CODE,
                $messages['note.required'         ]          => NOTE_REQUIRED_CODE,
                $messages['type_asset_id.required']          => TYPE_ASSET_ID_REQUIRED_CODE,
                $messages['type_asset_id.exists'  ]          => TYPE_ASSET_ID_EXISTS_CODE,
                $messages['document.file'         ]          => DOCUMENT_FILE_CODE,
        ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }
}
