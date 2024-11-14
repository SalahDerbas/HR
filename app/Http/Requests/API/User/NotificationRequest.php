<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\API\BaseRequest;

class NotificationRequest extends BaseRequest
{
    private const ROUTE_NOTIFICATION_SEND     = 'api.company.notification.send';

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function notificationSendRequest()
    {
        return [
            'rules'   =>  [
                    'title_en'                    => ['required'],
                    'title_ar'                    => ['required'],
                    'body_en'                     => ['required'],
                    'body_ar'                     => ['required'],
                    'ids'                         => ['string']   ,
        ],
            'messages'  => [
                    'title_en.required'           =>  getStatusText(TITLE_EN_REQUIRED_CODE),
                    'title_ar.required'           =>  getStatusText(TITLE_AR_REQUIRED_CODE) ,
                    'body_en.required'            =>  getStatusText(BODY_EN_REQUIRED_CODE),
                    'body_ar.required'            =>  getStatusText(BODY_AR_REQUIRED_CODE),
                    'ids.string'                  =>  getStatusText(USERS_STRING_CODE),
            ],
        ];

    }

    /**
     * Retrieve requested validation data based on the current route.
     *
     * @param string $key
     * @return mixed
     * @author Salah Derbas
     */
    private function requested($key)
    {
        $route = $this->route()->getName();
        $data = match ($route) {
                self::ROUTE_NOTIFICATION_SEND         => $this->notificationSendRequest(),
            default => []
        };
        return $data[$key];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    public function rules()
    {
        return $this->requested('rules');
    }

    /**
     * Get the validation messages that apply to the request.
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
        $route             =  $this->route()->getName();
        $messages          = $this->messages();

        $errorMap = match ($route) {
            self::ROUTE_NOTIFICATION_SEND => [
                    $messages['title_en.required']           => TITLE_EN_REQUIRED_CODE ,
                    $messages['title_ar.required']           => TITLE_AR_REQUIRED_CODE,
                    $messages['body_en.required']            => BODY_EN_REQUIRED_CODE,
                    $messages['body_ar.required']            => BODY_AR_REQUIRED_CODE,
                    $messages['ids.string']                  => USERS_STRING_CODE,
                ],
                default => []
            };

        $this->handleFailedValidation($validator, $errorMap);
    }
}
