<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\API\User\LeaveRequest;

use App\Http\Resources\API\User\LeavesResource;

use App\Models\Leave;

class LeaveController extends Controller
{
    /**
     * Display a listing of the user's leave's.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Leave::where([ 'user_id' => Auth::id() ])->with(['getReasonLeave' , 'getStatusLeave'])->get();

            if($data->isEmpty())
                return responseSuccess('', getStatusText(LEAVE_EMPTY_CODE), LEAVE_EMPTY_CODE);

            return responseSuccess(LeavesResource::collection($data) , getStatusText(LEAVES_SUCCESS_CODE)  , LEAVES_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Store a newly created Leave in storage.
     *
     * @param  \App\Http\Requests\API\User\LeaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveRequest $request)
    {
        try{
            $leaveData                    = $request->all();
            $leaveData['user_id']         = Auth::id();
            $leaveData['status_leave_id'] = getIDLookups('status_leave');

            if ($request->file('doucument'))
                $leaveData['doucument']  = UploadPhotoUser($request->file('doucument'), 'store');

            Leave::create($leaveData);
            return responseSuccess('' , getStatusText(STORE_LEAVE_SUCCESS_CODE)  , STORE_LEAVE_SUCCESS_CODE);
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
            $data = Leave::with(['getReasonLeave' , 'getStatusLeave'])->findOrFail($id);

            if(is_null($data))
                return responseSuccess('', getStatusText(LEAVE_EMPTY_CODE), LEAVE_EMPTY_CODE);

            return responseSuccess(new LeavesResource($data) , getStatusText(LEAVES_SUCCESS_CODE)  , LEAVES_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Update the specified Leave in storage.
     *
     * @param  \App\Http\Requests\API\User\LeaveRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeaveRequest $request, $id)
    {
        try{
            $leaveData                   = $request->all();

            if ($request->file('doucument'))
                $leaveData['doucument']  = UploadPhotoUser($request->file('doucument'), 'update');

            Leave::findOrFail($id)->update($leaveData);
            return responseSuccess('' , getStatusText(UPDATE_LEAVE_SUCCESS_CODE)  , UPDATE_LEAVE_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Remove the specified Leave from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Leave::findOrFail($id)->delete();
            return responseSuccess('', getStatusText(DELETE_LEAVE_CODE), DELETE_LEAVE_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

}
