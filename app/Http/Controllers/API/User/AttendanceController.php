<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\User\AttendanceRequest;
use App\Http\Resources\API\User\AttendanceResource;
use App\Models\Attendance;

class AttendanceController extends Controller
{

    /**
     * Constructor to initialize the default notification data for attendance.
     */
    protected $array;
    public function __construct()
    {
        $this->array = [
            'title_en' => 'This is Title (Attendance)',
            'title_ar' => 'This is Title (Attendance)',
            'body_en'  => 'This is Body  (Attendance)',
            'body_ar'  => 'This is Body  (Attendance)',
        ];
    }

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
            $data                         = $request->all();
            $data['user_id']              = Auth::id();
            $data['status_attendance_id'] = getIDLookups('SL-Pending');

            Attendance::create($data);
            SendNotificationForDirectory($this->array , Auth::user()->directory_id);
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
            $data                    = $request->all();
            $data['user_id']         = Auth::id();

            Attendance::findOrFail($id)->update($data);
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

    public function approve($id)
    {
        try{
            $data = Attendance::findOrFail($id)->update(['status_attendance_id' =>  getIDLookups('SL-Approve') ]);
            return responseSuccess('', getStatusText(APPROVE_SUCCESS_CODE), APPROVE_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
}
