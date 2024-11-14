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
     * Constructor to initialize the default notification data for MissingPunch.
     */
    protected $messageStore;
    protected $messageApprove;
    protected $messageReject;
    public function __construct()
    {
        $this->messageStore = [
            'title_en' => 'This is Title (Store MissingPunch)',
            'title_ar' => 'This is Title (Store MissingPunch)',
            'body_en'  => 'This is Body  (Store MissingPunch)',
            'body_ar'  => 'This is Body  (Store MissingPunch)',
        ];

        $this->messageApprove = [
            'title_en' => 'This is Title (Approve MissingPunch)',
            'title_ar' => 'This is Title (Approve MissingPunch)',
            'body_en'  => 'This is Body  (Approve MissingPunch)',
            'body_ar'  => 'This is Body  (Approve MissingPunch)',
        ];

        $this->messageReject = [
            'title_en' => 'This is Title (Reject MissingPunch)',
            'title_ar' => 'This is Title (Reject MissingPunch)',
            'body_en'  => 'This is Body  (Reject MissingPunch)',
            'body_ar'  => 'This is Body  (Reject MissingPunch)',
        ];
    }

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
            $data                            = $request->all();
            $data['user_id']                 = Auth::id();
            $data['status_missing_punch_id'] = getIDLookups('SL-Pending');

            if ($request->file('document'))
                $data['document']  = handleFileUpload($request->file('document'), 'store' , 'MissingPunch' , NULL);

            MissingPunch::create($data);
            SendNotificationForDirectory($this->messageStore , Auth::user()->directory_id);
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
            $data                 = $request->all();
            $MissingPunch         = MissingPunch::findOrFail($id);

            if ($request->file('document'))
                $data['document']  = handleFileUpload($request->file('document'), 'update' , 'MissingPunch' , $MissingPunch->document);

            $MissingPunch->update($data);
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

    /**
     * Approves the MissingPunch record by updating the status to "Approved".
     *
     * @param int $id The ID of the MissingPunch record to approve.
     * @return \Illuminate\Http\JsonResponse A success response if approval is successful, or an error response if an exception occurs.
     */
    public function approve($id)
    {
        try{
            $data = MissingPunch::findOrFail($id);
            $data->update(['status_missing_punch_id' =>  getIDLookups('SL-Approve') ]);
            SendNotificationForDirectory($this->messageApprove , $data->user_id);

            return responseSuccess('', getStatusText(APPROVE_SUCCESS_CODE), APPROVE_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Rejects the MissingPunch record by updating the status to "Rejected".
     *
     * @param int $id The ID of the MissingPunch record to reject.
     * @return \Illuminate\Http\JsonResponse A success response if rejection is successful, or an error response if an exception occurs.
     */
    public function reject($id)
    {
        try{
            $data = MissingPunch::findOrFail($id);
            $data->update(['status_missing_punch_id' =>  getIDLookups('SL-Rejected') ]);
            SendNotificationForDirectory($this->messageReject , $data->user_id);

            return responseSuccess('', getStatusText(REJECTED_SUCCESS_CODE), REJECTED_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
}
