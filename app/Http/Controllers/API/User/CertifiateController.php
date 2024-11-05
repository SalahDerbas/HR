<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\API\User\CertifiateRequest;

use App\Http\Resources\API\User\CertifiateResource;

use App\Models\Certifiate;

class CertifiateController extends Controller
{
    /**
     * Display a listing of the user's Certifiate's.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Certifiate::where(['user_id' => Auth::id() ])->get();

            if($data->isEmpty())
                return responseSuccess('', getStatusText(CERTIFIATE_EMPTY_CODE), CERTIFIATE_EMPTY_CODE);

            return responseSuccess(CertifiateResource::collection($data) , getStatusText(CERTIFIATES_SUCCESS_CODE)  , CERTIFIATES_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Store a newly created Certifiate in storage.
     *
     * @param  \App\Http\Requests\API\User\CertifiateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CertifiateRequest $request)
    {
        try{
            $CertifiateData                    = $request->all();
            $CertifiateData['user_id']         = Auth::id();

            if ($request->file('document'))
                $CertifiateData['document']    = UploadPhotoUser($request->file('document'), 'store');

            Certifiate::create($CertifiateData);
            return responseSuccess('' , getStatusText(STORE_CERTIFIATE_SUCCESS_CODE)  , STORE_CERTIFIATE_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Display the specified vacation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = Certifiate::findOrFail($id);

            if(is_null($data))
                return responseSuccess('', getStatusText(CERTIFIATE_EMPTY_CODE), CERTIFIATE_EMPTY_CODE);

            return responseSuccess(new CertifiateResource($data) , getStatusText(CERTIFIATES_SUCCESS_CODE)  , CERTIFIATES_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Update the specified Certifiate in storage.
     *
     * @param  \App\Http\Requests\API\User\CertifiateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CertifiateRequest $request, $id)
    {
        try{
            $CertifiateData                    = $request->all();
            $CertifiateData['user_id']         = Auth::id();

            if ($request->file('document'))
                $CertifiateData['document']      = UploadPhotoUser($request->file('document'), 'update');

            Certifiate::findOrFail($id)->update($CertifiateData);
            return responseSuccess('' , getStatusText(UPDATE_CERTIFIATE_SUCCESS_CODE)  , UPDATE_CERTIFIATE_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Remove the specified Certifiate from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Certifiate::findOrFail($id)->delete();
            return responseSuccess('', getStatusText(DELETE_CERTIFIATE_CODE), DELETE_CERTIFIATE_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

}
