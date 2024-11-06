<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\User\ExperinceRequest;
use App\Http\Resources\API\User\ExperinceResource;
use App\Models\Experince;

class ExperinceController extends Controller
{
    /**
     * Display a listing of the user's Experince's.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Experince::where([ 'user_id' => Auth::id() ])->get();

            if($data->isEmpty())
                return responseSuccess('', getStatusText(EXPERINCE_EMPTY_CODE), EXPERINCE_EMPTY_CODE);

            return responseSuccess(ExperinceResource::collection($data) , getStatusText(EXPERINCES_SUCCESS_CODE)  , EXPERINCES_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Store a newly created Experince in storage.
     *
     * @param  \App\Http\Requests\API\User\ExperinceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExperinceRequest $request)
    {
        try{
            $ExperinceData                    = $request->all();
            $ExperinceData['user_id']         = Auth::id();

            if ($request->file('document'))
                $ExperinceData['document']    = UploadPhotoUser($request->file('document'), 'store');

            Experince::create($ExperinceData);
            return responseSuccess('' , getStatusText(STORE_EXPERINCE_SUCCESS_CODE)  , STORE_EXPERINCE_SUCCESS_CODE);
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
            $data = Experince::findOrFail($id);

            if(is_null($data))
                return responseSuccess('', getStatusText(EXPERINCE_EMPTY_CODE), EXPERINCE_EMPTY_CODE);

            return responseSuccess(new ExperinceResource($data) , getStatusText(EXPERINCES_SUCCESS_CODE)  , EXPERINCES_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Update the specified Experince in storage.
     *
     * @param  \App\Http\Requests\API\User\ExperinceRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExperinceRequest $request, $id)
    {
        try{
            $ExperinceData                   = $request->all();

            if ($request->file('document'))
                $ExperinceData['document']  = UploadPhotoUser($request->file('document'), 'update');

            Experince::findOrFail($id)->update($ExperinceData);
            return responseSuccess('' , getStatusText(UPDATE_EXPERINCE_SUCCESS_CODE)  , UPDATE_EXPERINCE_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Remove the specified Experince from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Experince::findOrFail($id)->delete();
            return responseSuccess('', getStatusText(DELETE_EXPERINCE_CODE), DELETE_EXPERINCE_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

}
