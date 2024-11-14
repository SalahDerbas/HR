<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\User\LeaveRequest;
use App\Http\Resources\API\User\LeavesResource;
use App\Models\Leave;

class LeaveController extends Controller
{
    /**
     * Constructor to initialize the default notification data for Leave.
    * @author Salah Derbas
     */
    protected $messageStore;
    protected $messageApprove;
    protected $messageReject;
    public function __construct()
    {
        $this->messageStore = [
            'title_en' => 'This is Title (Store Leave)',
            'title_ar' => 'This is Title (Store Leave)',
            'body_en'  => 'This is Body  (Store Leave)',
            'body_ar'  => 'This is Body  (Store Leave)',
        ];

        $this->messageApprove = [
            'title_en' => 'This is Title (Approve Leave)',
            'title_ar' => 'This is Title (Approve Leave)',
            'body_en'  => 'This is Body  (Approve Leave)',
            'body_ar'  => 'This is Body  (Approve Leave)',
        ];

        $this->messageReject = [
            'title_en' => 'This is Title (Reject Leave)',
            'title_ar' => 'This is Title (Reject Leave)',
            'body_en'  => 'This is Body  (Reject Leave)',
            'body_ar'  => 'This is Body  (Reject Leave)',
        ];
    }

    /**
     * Display a listing of the user's leave's.
     *
     * @return \Illuminate\Http\Response
     * @author Salah Derbas
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
     * @author Salah Derbas
     */
    public function store(LeaveRequest $request)
    {
        try{
            $data                    = $request->all();
            $data['user_id']         = Auth::id();
            $data['status_leave_id'] = getIDLookups('SL-Pending');

            if ($request->file('doucument'))
                $data['doucument']  = handleFileUpload($request->file('doucument'), 'store' , 'Leave' , NULL);

            Leave::create($data);
            SendNotificationForDirectory($this->messageStore , Auth::user()->directory_id);
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
     * @author Salah Derbas
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
     * @author Salah Derbas
     */
    public function update(LeaveRequest $request, $id)
    {
        try{
            $data                        = $request->all();
            $Leave                       = Leave::findOrFail($id);

            if ($request->file('doucument'))
                $data['doucument']  = handleFileUpload($request->file('doucument'), 'update' , 'Leave' , $Leave->doucument);

            $Leave->update($data);
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
     * @author Salah Derbas
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

    /**
     * Approves the Leave record by updating the status to "Approved".
     *
     * @param int $id The ID of the Leave record to approve.
     * @return \Illuminate\Http\JsonResponse A success response if approval is successful, or an error response if an exception occurs.
     * @author Salah Derbas
     */
    public function approve($id)
    {
        try{
            $data = Leave::findOrFail($id);
            $data->update(['status_leave_id' =>  getIDLookups('SL-Approve') ]);
            SendNotificationForDirectory($this->messageApprove , $data->user_id);

            return responseSuccess('', getStatusText(APPROVE_SUCCESS_CODE), APPROVE_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Rejects the Leave record by updating the status to "Rejected".
     *
     * @param int $id The ID of the Leave record to reject.
     * @return \Illuminate\Http\JsonResponse A success response if rejection is successful, or an error response if an exception occurs.
     * @author Salah Derbas
     */
    public function reject($id)
    {
        try{
            $data = Leave::findOrFail($id);
            $data->update(['status_leave_id' =>  getIDLookups('SL-Rejected') ]);
            SendNotificationForDirectory($this->messageReject , $data->user_id);

            return responseSuccess('', getStatusText(REJECTED_SUCCESS_CODE), REJECTED_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
}
