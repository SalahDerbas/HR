<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\API\BaseRequest;

class ContentRequest extends BaseRequest
{
    private const ROUTE_CONTACT_US     = 'api.content.contact_us';

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
     * Get the validation rules for the contact us request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function contactUsRequest()
    {
        return [
            'rules'   =>  [
                'name'                            => ['required'],
                'email'                           => ['required' , 'email'],
                'subject'                         => ['required'],
                'message'                         => ['required'],
            ],
            'messages'  => [
                'name.required'                   => getStatusText(NAME_REQUIRED_CODE),
                'email.email'                     => getStatusText(EMAIL_EMAIL_CODE),
                'email.required'                  => getStatusText(EMAIL_REQUIRED_CODE) ,
                'subject.required'                => getStatusText(SUBJECT_REQUIRED_CODE),
                'message.required'                => getStatusText(MESSAGE_REQUIRED_CODE),
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
                self::ROUTE_CONTACT_US                => $this->contactUsRequest(),
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
                self::ROUTE_CONTACT_US => [
                        $messages['name.required']          => NAME_REQUIRED_CODE ,
                        $messages['email.required']         => EMAIL_REQUIRED_CODE,
                        $messages['email.email']            => EMAIL_EMAIL_CODE,
                        $messages['subject.required']       => SUBJECT_REQUIRED_CODE,
                        $messages['message.required']       => MESSAGE_REQUIRED_CODE,
        ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }

}
