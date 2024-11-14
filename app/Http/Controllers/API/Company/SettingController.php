<?php

namespace App\Http\Controllers\API\Company;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Resources\API\Company\SettingResource;

class SettingController extends Controller
{

    /**
     * Retrieve and return all settings as a key-value pair array in a success response format.
     *
     * @param int $code The status code for the response.
     * @return \Illuminate\Http\JsonResponse A success response with all settings data.
     * @author Salah Derbas
     */
    private function successSetting($code){
        $collection = Setting::all();
            $data       = $collection->flatMap(function ($collection) {
                return [$collection->key => $collection->value];
            });
        return responseSuccess(new SettingResource($data) , getStatusText($code)  , $code);
    }

    /**
     * Display a listing of all settings.
     *
     * @return \Illuminate\Http\JsonResponse A success response containing all settings.
     * @author Salah Derbas
     */
    public function index()
    {
        try{
            return $this->successSetting( SETTING_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Update specific settings based on the request data.
     *
     * @param \Illuminate\Http\Request $request The request containing settings data to update.
     * @return \Illuminate\Http\JsonResponse A success response after updating settings.
     * @author Salah Derbas
     */
    public function update(Request $request)
    {
        try{
            $data = $request->except('logo');
            foreach ($data as $key=> $value)
                Setting::where('key', $key)->update(['value' => $value]);

            if($request->file('logo')) {
                $logo = handleFileUpload($request->file('logo'), 'update' , 'Setting' , Setting::where('key','logo')->value('value'));
                Setting::where('key', 'logo')->update(['value' => $logo]);
            }
            return $this->successSetting( UPDATE_SETTING_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
}
