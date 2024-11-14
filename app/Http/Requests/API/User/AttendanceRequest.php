<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\BaseRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AttendanceRequest extends BaseRequest
{
    private const ROUTE_ATTENDANCE_STORE          = 'api.user.attendance.store';
    private const ROUTE_ATTENDANCE_UPDATE         = 'api.user.attendance.update';

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
    private function attendanceUpdateRequest()
    {
        return [
            'rules'   =>  [
                'date'                          => ['required' , 'date' ],
                'time'                          => ['required' ],
                'status_attendance_id'          => ['required' ,  'exists:lookups,id'  ],
                'location'                      => ['required' ],
            ],
            'messages'  => [
                'date.date'                     => getStatusText(DATE_DATE_CODE),
                'date.required'                 => getStatusText(DATE_REQUIRED_CODE),
                'time.required'                 => getStatusText(TIME_REQUIRED_CODE),
                'status_attendance_id.required' => getStatusText(STATUS_ATTENDANCE_ID_REQUIRED_CODE),
                'status_attendance_id.exists'   => getStatusText(STATUS_ATTENDANCE_ID_EXISTS_CODE),
                'location.required'             => getStatusText(LOCATION_EN_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules that store leave to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function attendanceStoreRequest()
    {
        return [
            'rules'   =>  [
                'date'                          => ['required' , 'date' ],
                'time'                          => ['required' ],
                'status_attendance_id'          => ['required' ,  'exists:lookups,id'  ],
                'location'                      => ['required' ],
            ],
            'messages'  => [
                'date.date'                     => getStatusText(DATE_DATE_CODE),
                'date.required'                 => getStatusText(DATE_REQUIRED_CODE),
                'time.required'                 => getStatusText(TIME_REQUIRED_CODE),
                'status_attendance_id.required' => getStatusText(STATUS_ATTENDANCE_ID_REQUIRED_CODE),
                'status_attendance_id.exists'   => getStatusText(STATUS_ATTENDANCE_ID_EXISTS_CODE),
                'location.required'             => getStatusText(LOCATION_EN_CODE),
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
                self::ROUTE_ATTENDANCE_STORE                   => $this->attendanceStoreRequest(),
                self::ROUTE_ATTENDANCE_UPDATE                  => $this->attendanceUpdateRequest(),

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
            self::ROUTE_ATTENDANCE_STORE  => [
                $messages['date.date']                     => DATE_DATE_CODE,
                $messages['date.required']                 => DATE_REQUIRED_CODE,
                $messages['time.required']                 => TIME_REQUIRED_CODE,
                $messages['status_attendance_id.required'] => STATUS_ATTENDANCE_ID_REQUIRED_CODE,
                $messages['status_attendance_id.exists']   => STATUS_ATTENDANCE_ID_EXISTS_CODE,
                $messages['location.required']             => LOCATION_EN_CODE,
            ],
            self::ROUTE_ATTENDANCE_UPDATE => [
                $messages['date.date']                     => DATE_DATE_CODE,
                $messages['date.required']                 => DATE_REQUIRED_CODE,
                $messages['time.required']                 => TIME_REQUIRED_CODE,
                $messages['status_attendance_id.required'] => STATUS_ATTENDANCE_ID_REQUIRED_CODE,
                $messages['status_attendance_id.exists']   => STATUS_ATTENDANCE_ID_EXISTS_CODE,
                $messages['location.required']             => LOCATION_EN_CODE,
        ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }
}
