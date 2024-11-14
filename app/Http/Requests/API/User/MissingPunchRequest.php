<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\BaseRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MissingPunchRequest extends BaseRequest
{
    private const ROUTE_MISSIONG_PUNCH_STORE          = 'api.user.missing_punches.store';
    private const ROUTE_MISSIONG_PUNCH_UPDATE         = 'api.user.missing_punches.update';

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
    private function missingPunchUpdateRequest()
    {
        return [
            'rules'   =>  [
                'date'                          => ['required' , 'date'],
                'time'                          => ['required' ],
                'reason'                        => ['required' ],
                'type_missing_punch_id'         => ['required' ,  'exists:lookups,id'  ],
                'document'                     => [ 'file'  ],
            ],
            'messages'  => [
                'date.required'                 => getStatusText(DATE_REQUIRED_CODE),
                'date.date'                     => getStatusText(DATE_DATE_CODE),
                'time.required'                 => getStatusText(TIME_REQUIRED_CODE),
                'reason.required'               => getStatusText(REASON_REQUIRED_CODE),
                'type_missing_punch_id.required'=> getStatusText(TYPE_MISSINGPUNCH_ID_REQUIRED_CODE),
                'type_missing_punch_id.exists'  => getStatusText(TYPE_MISSINGPUNCH_ID_EXISTS_CODE),
                'document.file'                => getStatusText(DOCUMENT_FILE_CODE),

            ],
        ];
    }

    /**
     * Get the validation rules that store vacation to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function missingPunchStoreRequest()
    {
        return [
            'rules'   =>  [
                'date'                          => ['required' , 'date'],
                'time'                          => ['required' ],
                'reason'                        => ['required' ],
                'type_missing_punch_id'         => ['required' ,  'exists:lookups,id'  ],
                'document'                      => ['required' ,  'file'  ],
            ],
            'messages'  => [
                'date.required'                 => getStatusText(DATE_REQUIRED_CODE),
                'date.date'                     => getStatusText(DATE_DATE_CODE),
                'time.required'                 => getStatusText(TIME_REQUIRED_CODE),
                'reason.required'               => getStatusText(REASON_REQUIRED_CODE),
                'type_missing_punch_id.required'=> getStatusText(TYPE_MISSINGPUNCH_ID_REQUIRED_CODE),
                'type_missing_punch_id.exists'  => getStatusText(TYPE_MISSINGPUNCH_ID_EXISTS_CODE),
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
                self::ROUTE_MISSIONG_PUNCH_STORE                => $this->missingPunchStoreRequest(),
                self::ROUTE_MISSIONG_PUNCH_UPDATE               => $this->missingPunchUpdateRequest(),

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
            self::ROUTE_MISSIONG_PUNCH_STORE  => [

                $messages['date.required']                  => DATE_REQUIRED_CODE,
                $messages['date.date']                      => DATE_DATE_CODE,
                $messages['time.required']                  => TIME_REQUIRED_CODE,
                $messages['reason.required']                => REASON_REQUIRED_CODE,
                $messages['type_missing_punch_id.required'] => TYPE_MISSINGPUNCH_ID_REQUIRED_CODE,
                $messages['type_missing_punch_id.exists']   => TYPE_MISSINGPUNCH_ID_EXISTS_CODE,
                $messages['document.required']              => DOCUMENT_REQUIRED_CODE,
                $messages['document.file']                  => DOCUMENT_FILE_CODE,


            ],
            self::ROUTE_MISSIONG_PUNCH_UPDATE => [
                $messages['date.required']                  => DATE_REQUIRED_CODE,
                $messages['date.date']                      => DATE_DATE_CODE,
                $messages['time.required']                  => TIME_REQUIRED_CODE,
                $messages['reason.required']                => REASON_REQUIRED_CODE,
                $messages['type_missing_punch_id.required'] => TYPE_MISSINGPUNCH_ID_REQUIRED_CODE,
                $messages['type_missing_punch_id.exists']   => TYPE_MISSINGPUNCH_ID_EXISTS_CODE,
                $messages['document.file']                  => DOCUMENT_FILE_CODE,
            ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }
}
