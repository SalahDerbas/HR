<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\BaseRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DocumentRequest extends BaseRequest
{
    private const ROUTE_DOCUMENT_STORE          = 'api.user.document.store';
    private const ROUTE_DOCUMENT_UPDATE         = 'api.user.document.update';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @author Salah Derbas
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that update leave to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function documentUpdateRequest()
    {
        return [
            'rules'   =>  [
                'note'                          => ['required' ],
                'type_document_id'              => ['required' ,  'exists:lookups,id'  ],
                'document'                      => ['required' ,  'file'  ],
            ],
            'messages'  => [
                'note.required'                 => getStatusText(NOTE_REQUIRED_CODE),
                'type_document_id.required'     => getStatusText(TYPE_DOCUMENT_ID_REQUIRED_CODE),
                'type_document_id.exists'       => getStatusText(TYPE_DOCUMENT_ID_EXISTS_CODE),
                'document.required'             => getStatusText(DOCUMENT_REQUIRED_CODE),
                'document.file'                 => getStatusText(DOCUMENT_FILE_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules that store leave to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function documentStoreRequest()
    {
        return [
            'rules'   =>  [
                'note'                          => ['required' ],
                'type_document_id'              => ['required' ,  'exists:lookups,id'  ],
                'document'                      => ['required' ,  'file'  ],
            ],
            'messages'  => [
                'note.required'                 => getStatusText(NOTE_REQUIRED_CODE),
                'type_document_id.required'     => getStatusText(TYPE_DOCUMENT_ID_REQUIRED_CODE),
                'type_document_id.exists'       => getStatusText(TYPE_DOCUMENT_ID_EXISTS_CODE),
                'document.required'             => getStatusText(DOCUMENT_REQUIRED_CODE),
                'document.file'                 => getStatusText(DOCUMENT_FILE_CODE),
            ],
        ];
    }
    /**
     * Get requested data based on the current route.
     *
     * @param string $key
     * @return mixed
     * @author Salah Derbas
     */
    private function requested($key)
    {
        $route = $this->route()->getName();
        $data  = match ($route) {
                self::ROUTE_DOCUMENT_STORE                   => $this->documentStoreRequest(),
                self::ROUTE_DOCUMENT_UPDATE                  => $this->documentUpdateRequest(),

                default => [ 'rules' => [], 'messages' => []  ]
        };
        return $data[$key];

    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    /**
     * Get the validation rules for the request.
     *
     * @return array
     * @author Salah Derbas
     */
    public function rules()
    {
        return $this->requested('rules');
    }

    /**
     * Get the validation messages for the request.
     *
     * @return array
     * @author Salah Derbas
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
     * @author Salah Derbas
     */
    protected function failedValidation(Validator $validator)
    {
        $route      = $this->route()->getName();
        $messages   = $this->messages();

        $errorMap = match ($route) {
            self::ROUTE_DOCUMENT_STORE  => [
                $messages['note.required']                 => NOTE_REQUIRED_CODE,
                $messages['type_document_id.required']     => TYPE_DOCUMENT_ID_REQUIRED_CODE,
                $messages['type_document_id.exists']       => TYPE_DOCUMENT_ID_EXISTS_CODE,
                $messages['document.required']             => DOCUMENT_REQUIRED_CODE,
                $messages['document.file']                 => DOCUMENT_FILE_CODE,
            ],
            self::ROUTE_DOCUMENT_UPDATE => [
                $messages['note.required']                 => NOTE_REQUIRED_CODE,
                $messages['type_document_id.required']     => TYPE_DOCUMENT_ID_REQUIRED_CODE,
                $messages['type_document_id.exists']       => TYPE_DOCUMENT_ID_EXISTS_CODE,
                $messages['document.required']             => DOCUMENT_REQUIRED_CODE,
                $messages['document.file']                 => DOCUMENT_FILE_CODE,
        ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }
}
