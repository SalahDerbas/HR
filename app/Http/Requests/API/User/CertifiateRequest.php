<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\BaseRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CertifiateRequest extends BaseRequest
{
    private const ROUTE_CERTIFICATE_STORE          = 'api.user.experince.store';
    private const ROUTE_CERTIFICATE_UPDATE         = 'api.user.experince.update';

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
     * Get the validation rules that update vacation to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function certificateUpdateRequest()
    {
        return [
            'rules'   =>  [
                'name'                          => ['required'],
                'start_date'                    => ['required' , 'date'],
                'end_date'                      => ['required' , 'date'],
                'note'                          => ['required' ],
                'document'                      => [ 'file'  ],
            ],
            'messages'  => [
                'name.required'                 => getStatusText(NAME_REQUIRED_CODE),
                'start_date.required'           => getStatusText(START_DATE_REQUIRED_CODE),
                'start_date.date'               => getStatusText(START_DATE_DATE_CODE),
                'end_date.required'             => getStatusText(END_DATE_REQUIRED_CODE),
                'end_date.date'                 => getStatusText(END_DATE_DATE_CODE),
                'note.required'                 => getStatusText(NOTE_REQUIRED_CODE),
                'document.file'                 => getStatusText(DOCUMENT_FILE_CODE),

            ],
        ];
    }

    /**
     * Get the validation rules that store vacation to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function certificateStoreRequest()
    {
        return [
            'rules'   =>  [
                'name'                          => ['required'],
                'start_date'                    => ['required' , 'date'],
                'end_date'                      => ['required' , 'date'],
                'note'                          => ['required' ],
                'document'                      => ['required' ,  'file'  ],
            ],
            'messages'  => [
                'name.required'                 => getStatusText(NAME_REQUIRED_CODE),
                'start_date.required'           => getStatusText(START_DATE_REQUIRED_CODE),
                'start_date.date'               => getStatusText(START_DATE_DATE_CODE),
                'end_date.required'             => getStatusText(END_DATE_REQUIRED_CODE),
                'end_date.date'                 => getStatusText(END_DATE_DATE_CODE),
                'note.required'                 => getStatusText(NOTE_REQUIRED_CODE),
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
                self::ROUTE_CERTIFICATE_STORE                => $this->certificateStoreRequest(),
                self::ROUTE_CERTIFICATE_UPDATE               => $this->certificateUpdateRequest(),

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
            self::ROUTE_CERTIFICATE_STORE  => [

                $messages['name.required'      ]           =>NAME_REQUIRED_CODE,
                $messages['start_date.required']           =>START_DATE_REQUIRED_CODE,
                $messages['start_date.date'    ]           =>START_DATE_DATE_CODE,
                $messages['end_date.required'  ]           =>END_DATE_REQUIRED_CODE,
                $messages['end_date.date'      ]           =>END_DATE_DATE_CODE,
                $messages['note.required'      ]           =>NOTE_REQUIRED_CODE,
                $messages['document.required'  ]           =>DOCUMENT_REQUIRED_CODE,
                $messages['document.file'      ]           =>DOCUMENT_FILE_CODE,

            ],
            self::ROUTE_CERTIFICATE_UPDATE => [
                $messages['name.required'      ]           =>NAME_REQUIRED_CODE,
                $messages['start_date.required']           =>START_DATE_REQUIRED_CODE,
                $messages['start_date.date'    ]           =>START_DATE_DATE_CODE,
                $messages['end_date.required'  ]           =>END_DATE_REQUIRED_CODE,
                $messages['end_date.date'      ]           =>END_DATE_DATE_CODE,
                $messages['note.required'      ]           =>NOTE_REQUIRED_CODE,
                $messages['document.file'      ]           =>DOCUMENT_FILE_CODE,
        ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }

}
