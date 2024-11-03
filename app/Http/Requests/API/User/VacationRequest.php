<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\BaseRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VacationRequest extends BaseRequest
{
    private const ROUTE_VACATION_STORE          = 'api.user.vacation.store';
    private const ROUTE_VACATION_UPDATE         = 'api.user.vacation.update';

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
    private function vacationUpdateRequest()
    {
        return [
            'rules'   =>  [
                'start_date'                    => ['required' , 'date'],
                'end_date'                      => ['required' , 'date'],
                'reason'                        => ['required' ],
                'type_vacation_id'              => ['required' ,  'exists:lookups,id'  ],
                'doucument'                     => [ 'file'  ],
            ],
            'messages'  => [
                'start_date.required'           => getStatusText(START_DATE_REQUIRED_CODE),
                'start_date.date'               => getStatusText(START_DATE_DATE_CODE),
                'end_date.required'             => getStatusText(END_DATE_REQUIRED_CODE),
                'end_date.date'                 => getStatusText(END_DATE_DATE_CODE),
                'reason.required'               => getStatusText(REASON_REQUIRED_CODE),
                'type_vacation_id.required'     => getStatusText(TYPE_VACATION_ID_REQUIRED_CODE),
                'type_vacation_id.exists'       => getStatusText(TYPE_VACATION_ID_EXISTS_CODE),
                'doucument.file'                => getStatusText(DOCUMENT_FILE_CODE),

            ],
        ];
    }

    /**
     * Get the validation rules that store vacation to the request.
     *
     * @return array
     */
    private function vacationStoreRequest()
    {
        return [
            'rules'   =>  [
                'start_date'                    => ['required' , 'date'],
                'end_date'                      => ['required' , 'date'],
                'reason'                        => ['required' ],
                'type_vacation_id'              => ['required' ,  'exists:lookups,id'  ],
                'doucument'                     => ['required' ,  'file'  ],
            ],
            'messages'  => [
                'start_date.required'           => getStatusText(START_DATE_REQUIRED_CODE),
                'start_date.date'               => getStatusText(START_DATE_DATE_CODE),
                'end_date.required'             => getStatusText(END_DATE_REQUIRED_CODE),
                'end_date.date'                 => getStatusText(END_DATE_DATE_CODE),
                'reason.required'               => getStatusText(REASON_REQUIRED_CODE),
                'type_vacation_id.required'     => getStatusText(TYPE_VACATION_ID_REQUIRED_CODE),
                'type_vacation_id.exists'       => getStatusText(TYPE_VACATION_ID_EXISTS_CODE),
                'doucument.required'            => getStatusText(DOCUMENT_REQUIRED_CODE),
                'doucument.file'                => getStatusText(DOCUMENT_FILE_CODE),

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
                self::ROUTE_VACATION_STORE                => $this->vacationStoreRequest(),
                self::ROUTE_VACATION_UPDATE               => $this->vacationUpdateRequest(),

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
            self::ROUTE_VACATION_STORE  => [
                    $messages['start_date.required']           => START_DATE_REQUIRED_CODE,
                    $messages['start_date.date']               => START_DATE_DATE_CODE,
                    $messages['end_date.required']             => END_DATE_REQUIRED_CODE,
                    $messages['end_date.date']                 => END_DATE_DATE_CODE,
                    $messages['reason.required']               => REASON_REQUIRED_CODE,
                    $messages['type_vacation_id.required']     => TYPE_VACATION_ID_REQUIRED_CODE,
                    $messages['type_vacation_id.exists']       => TYPE_VACATION_ID_EXISTS_CODE,
                    $messages['doucument.required']            => DOCUMENT_REQUIRED_CODE,
                    $messages['doucument.file']                => DOCUMENT_FILE_CODE,

            ],
            self::ROUTE_VACATION_UPDATE => [
                    $messages['start_date.required']           => START_DATE_REQUIRED_CODE,
                    $messages['start_date.date']               => START_DATE_DATE_CODE,
                    $messages['end_date.required']             => END_DATE_REQUIRED_CODE,
                    $messages['end_date.date']                 => END_DATE_DATE_CODE,
                    $messages['reason.required']               => REASON_REQUIRED_CODE,
                    $messages['type_vacation_id.required']     => TYPE_VACATION_ID_REQUIRED_CODE,
                    $messages['type_vacation_id.exists']       => TYPE_VACATION_ID_EXISTS_CODE,
                    $messages['doucument.file']                => DOCUMENT_FILE_CODE,
            ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }


}
