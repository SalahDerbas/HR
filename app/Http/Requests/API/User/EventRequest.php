<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\BaseRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventRequest extends BaseRequest
{
    private const ROUTE_EVENT_STORE          = 'api.user.event.store';
    private const ROUTE_EVENT_UPDATE         = 'api.user.event.update';

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
    private function eventUpdateRequest()
    {
        return [
            'rules'   =>  [
                'name'                         => ['required' ],
                'from_time'                    => ['required' ],
                'to_time'                      => ['required' ],
                'photo'                        => [ 'file'  ],
            ],
            'messages'  => [
                'name.required'                 => getStatusText(NAME_REQUIRED_CODE),
                'from_time.required'            => getStatusText(START_TIME_REQUIRED_CODE),
                'to_time.required'              => getStatusText(END_TIME_REQUIRED_CODE),
                'photo.file'                    => getStatusText(DOCUMENT_FILE_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules that store leave to the request.
     *
     * @return array
     */
    private function eventStoreRequest()
    {
        return [
            'rules'   =>  [
                'name'                         => ['required' ],
                'from_time'                    => ['required' ],
                'to_time'                      => ['required' ],
                'photo'                        => [ 'file' , 'required' ],
            ],
            'messages'  => [
                'name.required'                 => getStatusText(NAME_REQUIRED_CODE),
                'from_time.required'            => getStatusText(START_TIME_REQUIRED_CODE),
                'to_time.required'              => getStatusText(END_TIME_REQUIRED_CODE),
                'photo.file'                    => getStatusText(DOCUMENT_FILE_CODE),
                'photo.required'                => getStatusText(DOCUMENT_REQUIRED_CODE),
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
                self::ROUTE_EVENT_STORE                   => $this->eventStoreRequest(),
                self::ROUTE_EVENT_UPDATE                  => $this->eventUpdateRequest(),

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
            self::ROUTE_EVENT_STORE  => [

                $messages['name.required']                 => getStatusText(NAME_REQUIRED_CODE),
                $messages['from_time.required']            => getStatusText(START_TIME_REQUIRED_CODE),
                $messages['to_time.required']              => getStatusText(END_TIME_REQUIRED_CODE),
                $messages['photo.file']                    => getStatusText(DOCUMENT_FILE_CODE),
                $messages['photo.required']                => getStatusText(DOCUMENT_REQUIRED_CODE),
            ],
            self::ROUTE_EVENT_UPDATE => [
                $messages['name.required']                 => getStatusText(NAME_REQUIRED_CODE),
                $messages['from_time.required']            => getStatusText(START_TIME_REQUIRED_CODE),
                $messages['to_time.required']              => getStatusText(END_TIME_REQUIRED_CODE),
                $messages['photo.file']                    => getStatusText(DOCUMENT_FILE_CODE),
        ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }
}
