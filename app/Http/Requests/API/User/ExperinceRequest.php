<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\BaseRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExperinceRequest extends BaseRequest
{
    private const ROUTE_EXPERINCE_STORE          = 'api.user.experince.store';
    private const ROUTE_EXPERINCE_UPDATE         = 'api.user.experince.update';

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
    private function experinceUpdateRequest()
    {
        return [
            'rules'   =>  [
                'company_name'                  => ['required'],
                'company_phone'                 => ['required'],
                'company_location'              => ['required'],
                'start_date'                    => ['required' , 'date'],
                'end_date'                      => ['required' , 'date'],
                'note'                          => ['required' ],
                'leave_reason'                  => ['required'],
                'document'                      => [ 'file'  ],
            ],
            'messages'  => [
                'company_name'                  => getStatusText(COMPANY_NAME_REQUIRED_CODE),
                'company_phone'                 => getStatusText(COMPANY_PHONE_REQUIRED_CODE),
                'company_location'              => getStatusText(COMPANY_LOCATION_REQUIRED_CODE),
                'leave_reason.required'         => getStatusText(LEAVE_REASON_REQUIRED_CODE),
                'note.required'                 => getStatusText(NOTE_REQUIRED_CODE),
                'start_date.required'           => getStatusText(START_DATE_REQUIRED_CODE),
                'start_date.date'               => getStatusText(START_DATE_DATE_CODE),
                'end_date.required'             => getStatusText(END_DATE_REQUIRED_CODE),
                'end_date.date'                 => getStatusText(END_DATE_DATE_CODE),
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
    private function experinceStoreRequest()
    {
        return [
            'rules'   =>  [
                'company_name'                  => ['required'],
                'company_phone'                 => ['required'],
                'company_location'              => ['required'],
                'start_date'                    => ['required' , 'date'],
                'end_date'                      => ['required' , 'date'],
                'note'                          => ['required' ],
                'leave_reason'                  => ['required'],
                'document'                      => ['required' ,  'file'  ],
            ],
            'messages'  => [
                'company_name'                  => getStatusText(COMPANY_NAME_REQUIRED_CODE),
                'company_phone'                 => getStatusText(COMPANY_PHONE_REQUIRED_CODE),
                'company_location'              => getStatusText(COMPANY_LOCATION_REQUIRED_CODE),
                'leave_reason.required'         => getStatusText(LEAVE_REASON_REQUIRED_CODE),
                'note.required'                 => getStatusText(NOTE_REQUIRED_CODE),
                'start_date.required'           => getStatusText(START_DATE_REQUIRED_CODE),
                'start_date.date'               => getStatusText(START_DATE_DATE_CODE),
                'end_date.required'             => getStatusText(END_DATE_REQUIRED_CODE),
                'end_date.date'                 => getStatusText(END_DATE_DATE_CODE),
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
                self::ROUTE_EXPERINCE_STORE                => $this->experinceStoreRequest(),
                self::ROUTE_EXPERINCE_UPDATE               => $this->experinceUpdateRequest(),

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
            self::ROUTE_EXPERINCE_STORE  => [

                    $messages['company_name']                  => COMPANY_NAME_REQUIRED_CODE,
                    $messages['company_phone']                 => COMPANY_PHONE_REQUIRED_CODE,
                    $messages['company_location']              => COMPANY_LOCATION_REQUIRED_CODE,
                    $messages['leave_reason.required']         => LEAVE_REASON_REQUIRED_CODE,
                    $messages['note.required' ]                => NOTE_REQUIRED_CODE,
                    $messages['start_date.required']           => START_DATE_REQUIRED_CODE,
                    $messages['start_date.date']               => START_DATE_DATE_CODE,
                    $messages['end_date.required']             => END_DATE_REQUIRED_CODE,
                    $messages['end_date.date']                 => END_DATE_DATE_CODE,
                    $messages['reason.required']               => REASON_REQUIRED_CODE,
                    $messages['document.required']             => DOCUMENT_REQUIRED_CODE,
                    $messages['document.file']                 => DOCUMENT_FILE_CODE,


            ],
            self::ROUTE_EXPERINCE_UPDATE => [
                    $messages['company_name']                  => COMPANY_NAME_REQUIRED_CODE,
                    $messages['company_phone']                 => COMPANY_PHONE_REQUIRED_CODE,
                    $messages['company_location']              => COMPANY_LOCATION_REQUIRED_CODE,
                    $messages['leave_reason.required']         => LEAVE_REASON_REQUIRED_CODE,
                    $messages['note.required' ]                => NOTE_REQUIRED_CODE,
                    $messages['start_date.required']           => START_DATE_REQUIRED_CODE,
                    $messages['start_date.date']               => START_DATE_DATE_CODE,
                    $messages['end_date.required']             => END_DATE_REQUIRED_CODE,
                    $messages['end_date.date']                 => END_DATE_DATE_CODE,
                    $messages['reason.required']               => REASON_REQUIRED_CODE,
                    $messages['document.file']                 => DOCUMENT_FILE_CODE,
        ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }

}
