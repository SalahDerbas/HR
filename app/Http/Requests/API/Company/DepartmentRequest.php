<?php

namespace App\Http\Requests\API\Company;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\BaseRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DepartmentRequest extends BaseRequest
{
    private const ROUTE_DEPARTMENT_STORE          = 'api.user.department.store';
    private const ROUTE_DEPARTMENT_UPDATE         = 'api.user.department.update';

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
    private function departmentUpdateRequest()
    {
        return [
            'rules'   =>  [
                'title_en'                    => ['required'],
                'title_ar'                    => ['required'],
                'name_en'                     => ['required'],
                'name_ar'                     => ['required'],
            ],
            'messages'  => [
                'title_en.required'           =>  getStatusText(TITLE_EN_REQUIRED_CODE),
                'title_ar.required'           =>  getStatusText(TITLE_AR_REQUIRED_CODE) ,
                'name_en.required'            =>  getStatusText(NAME_EN_CODE),
                'name_ar.required'            =>  getStatusText(NAME_AR_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules that store leave to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function departmentStoreRequest()
    {
        return [
            'rules'   =>  [
                'title_en'                    => ['required'],
                'title_ar'                    => ['required'],
                'name_en'                     => ['required'],
                'name_ar'                     => ['required'],
            ],
            'messages'  => [
                    'title_en.required'           =>  getStatusText(TITLE_EN_REQUIRED_CODE),
                    'title_ar.required'           =>  getStatusText(TITLE_AR_REQUIRED_CODE) ,
                    'name_en.required'            =>  getStatusText(NAME_EN_CODE),
                    'name_ar.required'            =>  getStatusText(NAME_AR_CODE),
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
                self::ROUTE_DEPARTMENT_STORE                   => $this->departmentStoreRequest(),
                self::ROUTE_DEPARTMENT_UPDATE                  => $this->departmentUpdateRequest(),

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
            self::ROUTE_DEPARTMENT_STORE  => [

                $messages['title_en.required']           =>  TITLE_EN_REQUIRED_CODE,
                $messages['title_ar.required']           =>  TITLE_AR_REQUIRED_CODE,
                $messages['name_en.required' ]           =>  NAME_EN_CODE,
                $messages['name_ar.required' ]           =>  NAME_AR_CODE,
            ],
            self::ROUTE_DEPARTMENT_UPDATE => [

                $messages['title_en.required']           =>  TITLE_EN_REQUIRED_CODE,
                $messages['title_ar.required']           =>  TITLE_AR_REQUIRED_CODE,
                $messages['name_en.required' ]           =>  NAME_EN_CODE,
                $messages['name_ar.required' ]           =>  NAME_AR_CODE,
        ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }
}
