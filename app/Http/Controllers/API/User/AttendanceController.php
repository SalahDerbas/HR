<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\API\User\AttendanceRequest;

use App\Http\Resources\API\User\AttendanceResource;

use App\Models\Attendance;
class AttendanceController extends Controller
{
    /**
     * Display a listing of the user's Attendance's.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Attendance::where(['user_id' => Auth::id() ])->with(['getAttendanceStatusType'])->get();

            if($data->isEmpty())
                return responseSuccess('', getStatusText(ATTENDANCE_EMPTY_CODE), ATTENDANCE_EMPTY_CODE);

            return responseSuccess(AttendanceResource::collection($data) , getStatusText(ATTENDANCES_SUCCESS_CODE)  , ATTENDANCES_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Store a newly created Attendance in storage.
     *
     * @param  \App\Http\Requests\API\User\AttendanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceRequest $request)
    {
        try{
            $AttendanceData                    = $request->all();
            $AttendanceData['user_id']         = Auth::id();


            Attendance::create($AttendanceData);
            return responseSuccess('' , getStatusText(STORE_ATTENDANCE_SUCCESS_CODE)  , STORE_ATTENDANCE_SUCCESS_CODE);
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
            $data = Attendance::with(['getAttendanceStatusType'])->findOrFail($id);

            if(is_null($data))
                return responseSuccess('', getStatusText(ATTENDANCE_EMPTY_CODE), ATTENDANCE_EMPTY_CODE);

            return responseSuccess(new AttendanceResource($data) , getStatusText(ATTENDANCES_SUCCESS_CODE)  , ATTENDANCES_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Update the specified Attendance in storage.
     *
     * @param  \App\Http\Requests\API\User\AttendanceRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceRequest $request, $id)
    {
        try{
            $AttendanceData                    = $request->all();
            $AttendanceData['user_id']         = Auth::id();

            Attendance::findOrFail($id)->update($AttendanceData);
            return responseSuccess('' , getStatusText(UPDATE_ATTENDANCE_SUCCESS_CODE)  , UPDATE_ATTENDANCE_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Remove the specified Attendance from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Attendance::findOrFail($id)->delete();
            return responseSuccess('', getStatusText(DELETE_ATTENDANCE_CODE), DELETE_ATTENDANCE_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

}
