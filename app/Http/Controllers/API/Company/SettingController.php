<?php

namespace App\Http\Controllers\API\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Resources\API\Company\SettingResource;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{
    public function index()
    {
        try{
            $collection = Setting::all();
            $data       = $collection->flatMap(function ($collection) {
                return [$collection->key => $collection->value];
            });

            return responseSuccess($data , getStatusText(SETTING_SUCCESS_CODE)  , SETTING_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }

    }
    public function update(Request $request)
    {
        try{
            $data = $request->except('logo');
            foreach ($data as $key=> $value)
                Setting::where('key', $key)->update(['value' => $value]);

            if($request->file('logo'))
            {
                $logo = UploadPhotoUser($request->file('logo'), 'update');
                Setting::where('key', 'logo')->update(['value' => $logo]);
            }

            $collection = Setting::all();
            $data       = $collection->flatMap(function ($collection) {
                return [$collection->key => $collection->value];
            });
            return responseSuccess($data , getStatusText(UPDATE_SETTING_SUCCESS_CODE)  , UPDATE_SETTING_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
}
