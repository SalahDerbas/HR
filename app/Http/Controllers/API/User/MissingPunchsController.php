<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\User\MissingPunchRequest;
use App\Http\Resources\API\User\MissinPunchesResource;
use App\Models\MissingPunch;

class MissingPunchsController extends Controller
{

    /**
     * Display a listing of the user's MissingPunchs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = MissingPunch::where([ 'user_id' => Auth::id() ])->with(['getMissingPunchType'])->get();

            if($data->isEmpty())
                return responseSuccess('', getStatusText(MISSING_PUNCH_EMPTY_CODE), MISSING_PUNCH_EMPTY_CODE);

            return responseSuccess(MissinPunchesResource::collection($data) , getStatusText(MISSING_PUNCHS_SUCCESS_CODE)  , MISSING_PUNCHS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Store a newly created MissingPunch in storage.
     *
     * @param  \App\Http\Requests\API\User\MissingPunchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MissingPunchRequest $request)
    {
        try{
            $MissingPunchData             = $request->all();
            $MissingPunchData['user_id']  = Auth::id();

            if ($request->file('document'))
                $MissingPunchData['document']  = UploadPhotoUser($request->file('document'), 'store');

            MissingPunch::create($MissingPunchData);
            return responseSuccess('' , getStatusText(STORE_MISSING_PUNCH_SUCCESS_CODE)  , STORE_MISSING_PUNCH_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Display the specified MissingPunchs.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = MissingPunch::with(['getMissingPunchType'])->findOrFail($id);

            if(is_null($data))
                return responseSuccess('', getStatusText(MISSING_PUNCH_EMPTY_CODE), MISSING_PUNCH_EMPTY_CODE);

            return responseSuccess(new MissinPunchesResource($data) , getStatusText(MISSING_PUNCHS_SUCCESS_CODE)  , MISSING_PUNCHS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Update the specified MissingPunchs in storage.
     *
     * @param  \App\Http\Requests\API\User\MissingPunchRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MissingPunchRequest $request, $id)
    {
        try{
            $MissingPunchData             = $request->all();

            if ($request->file('document'))
                $MissingPunchData['document']  = UploadPhotoUser($request->file('document'), 'update');

            MissingPunch::findOrFail($id)->update($MissingPunchData);
            return responseSuccess('' , getStatusText(UPDATE_MISSING_PUNCH_SUCCESS_CODE)  , UPDATE_MISSING_PUNCH_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Remove the specified MissingPunch from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            MissingPunch::findOrFail($id)->delete();
            return responseSuccess('', getStatusText(DELETE_MISSING_PUNCH_CODE), DELETE_MISSING_PUNCH_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
}
