<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\BaseRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LeaveRequest extends BaseRequest
{
    private const ROUTE_LEAVE_STORE          = 'api.user.leave.store';
    private const ROUTE_LEAVE_UPDATE         = 'api.user.leave.update';

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
     * Get the validation rules that update leave to the request.
     *
     * @return array
     */
    private function leaveUpdateRequest()
    {
        return [
            'rules'   =>  [
                'start_time'                    => ['required' ],
                'end_time'                      => ['required' ],
                'reason_leave_id'               => ['required' ,  'exists:lookups,id'  ],
                'doucument'                     => [ 'file'  ],
            ],
            'messages'  => [
                'start_time.required'           => getStatusText(START_TIME_REQUIRED_CODE),
                'end_time.required'             => getStatusText(END_TIME_REQUIRED_CODE),
                'reason_leave_id.required'      => getStatusText(TYPE_REASON_LEAVE_ID_REQUIRED_CODE),
                'reason_leave_id.exists'        => getStatusText(TYPE_REASON_LEAVE_ID_EXISTS_CODE),
                'doucument.file'                => getStatusText(DOCUMENT_FILE_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules that store leave to the request.
     *
     * @return array
     */
    private function leaveStoreRequest()
    {
        return [
            'rules'   =>  [
                'start_time'                    => ['required' ],
                'end_time'                      => ['required' ],
                'reason_leave_id'               => ['required' ,  'exists:lookups,id'  ],
                'doucument'                     => ['required' ,  'file'  ],
            ],
            'messages'  => [
                'start_time.required'           => getStatusText(START_TIME_REQUIRED_CODE),
                'end_time.required'             => getStatusText(END_TIME_REQUIRED_CODE),
                'reason_leave_id.required'      => getStatusText(TYPE_REASON_LEAVE_ID_REQUIRED_CODE),
                'reason_leave_id.exists'        => getStatusText(TYPE_REASON_LEAVE_ID_EXISTS_CODE),
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
                self::ROUTE_LEAVE_STORE                   => $this->leaveStoreRequest(),
                self::ROUTE_LEAVE_UPDATE                  => $this->leaveUpdateRequest(),

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
            self::ROUTE_LEAVE_STORE  => [

                $messages['start_time.required']           => START_TIME_REQUIRED_CODE,
                $messages['end_time.required']             => END_TIME_REQUIRED_CODE,
                $messages['reason_leave_id.required']      => TYPE_REASON_LEAVE_ID_REQUIRED_CODE,
                $messages['reason_leave_id.exists']        => TYPE_REASON_LEAVE_ID_EXISTS_CODE,
                $messages['doucument.required']            => DOCUMENT_REQUIRED_CODE,
                $messages['doucument.file']                => DOCUMENT_FILE_CODE,
            ],
            self::ROUTE_LEAVE_UPDATE => [

                $messages['start_time.required']           => START_TIME_REQUIRED_CODE,
                $messages['end_time.required']             => END_TIME_REQUIRED_CODE,
                $messages['reason_leave_id.required']      => TYPE_REASON_LEAVE_ID_REQUIRED_CODE,
                $messages['reason_leave_id.exists']        => TYPE_REASON_LEAVE_ID_EXISTS_CODE,
                $messages['doucument.file']                => DOCUMENT_FILE_CODE,
        ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }
}
