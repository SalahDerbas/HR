<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Vacation;

use App\Http\Resources\API\User\VacationsResource;

use App\Http\Requests\API\User\VacationRequest;

class VacationController extends Controller
{

    /**
     * Display a listing of the user's vacations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Vacation::where([ 'user_id' => Auth::id() ])->with(['getVacationType'])->get();

            if($data->isEmpty())
                return responseSuccess('', getStatusText(VACATION_EMPTY_CODE), VACATION_EMPTY_CODE);

            return responseSuccess(VacationsResource::collection($data) , getStatusText(VACATIONS_SUCCESS_CODE)  , VACATIONS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Store a newly created vacation in storage.
     *
     * @param  \App\Http\Requests\API\User\VacationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VacationRequest $request)
    {
        try{
            $vacationData             = $request->all();
            $vacationData['user_id']  = Auth::id();

            if ($request->file('doucument'))
                $vacationData['doucument']  = UploadPhotoUser($request->file('doucument'), 'store');

            Vacation::create($vacationData);
            return responseSuccess('' , getStatusText(STORE_VACATION_SUCCESS_CODE)  , STORE_VACATION_SUCCESS_CODE);
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
            $data = Vacation::with(['getVacationType'])->findOrFail($id);

            if(is_null($data))
                return responseSuccess('', getStatusText(VACATION_EMPTY_CODE), VACATION_EMPTY_CODE);

            return responseSuccess(new VacationsResource($data) , getStatusText(VACATIONS_SUCCESS_CODE)  , VACATIONS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Update the specified vacation in storage.
     *
     * @param  \App\Http\Requests\API\User\VacationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VacationRequest $request, $id)
    {
        try{
            $vacationData             = $request->all();

            if ($request->file('doucument'))
                $vacationData['doucument']  = UploadPhotoUser($request->file('doucument'), 'store');

            Vacation::findOrFail($id)->update($vacationData);
            return responseSuccess('' , getStatusText(UPDATE_VACATION_SUCCESS_CODE)  , UPDATE_VACATION_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Remove the specified vacation from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Vacation::findOrFail($id)->delete();
            return responseSuccess('', getStatusText(DELETE_VACATION_CODE), DELETE_VACATION_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
}
