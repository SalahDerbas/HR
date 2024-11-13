<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\API\User\VacationsResource;
use App\Http\Requests\API\User\VacationRequest;
use App\Models\Vacation;


class VacationController extends Controller
{

    /**
     * Constructor to initialize the default notification data for Vacation.
    */
    protected $array;
    public function __construct()
    {
        $this->array = [
            'title_en' => 'This is Title (Vacation)',
            'title_ar' => 'This is Title (Vacation)',
            'body_en'  => 'This is Body  (Vacation)',
            'body_ar'  => 'This is Body  (Vacation)',
        ];
    }

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
            $data                         = $request->all();
            $data['user_id']              = Auth::id();
            $data['status_vacation_id']   = getIDLookups('SL-Pending');

            if ($request->file('doucument'))
                $data['doucument']  = handleFileUpload($request->file('doucument'), 'store' , 'Vacation' , NULL);

            Vacation::create($data);
            SendNotificationForDirectory($this->array , Auth::user()->directory_id);
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
            $data                = $request->all();
            $Vacation            = Vacation::findOrFail($id);

            if ($request->file('doucument'))
                $data['doucument']  = handleFileUpload($request->file('doucument'), 'update' , 'Vacation' , $Vacation->doucument);

            $Vacation->update($data);
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
