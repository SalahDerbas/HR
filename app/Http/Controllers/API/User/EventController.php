<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\User\EventRequest;
use App\Http\Resources\API\User\EventResource;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the user's Event's.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Event::all();

            if($data->isEmpty())
                return responseSuccess('', getStatusText(EVENT_EMPTY_CODE), EVENT_EMPTY_CODE);

            return responseSuccess(EventResource::collection($data) , getStatusText(EVENTS_SUCCESS_CODE)  , EVENTS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Store a newly created Event in storage.
     *
     * @param  \App\Http\Requests\API\User\EventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        try{
            $data                    = $request->all();

            if ($request->file('photo'))
                $data['photo']       = handleFileUpload($request->file('photo'), 'store' , 'Event' , NULL);

            Event::create($data);
            return responseSuccess('' , getStatusText(STORE_EVENT_SUCCESS_CODE)  , STORE_EVENT_SUCCESS_CODE);
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
            $data = Event::findOrFail($id);

            if(is_null($data))
                return responseSuccess('', getStatusText(EVENT_EMPTY_CODE), EVENT_EMPTY_CODE);

            return responseSuccess(new EventResource($data) , getStatusText(EVENTS_SUCCESS_CODE)  , EVENTS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Update the specified Event in storage.
     *
     * @param  \App\Http\Requests\API\User\EventRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        try{
            $data                   = $request->all();
            $Event                       = Event::findOrFail($id);

            if ($request->file('photo'))
                $data['photo']      = handleFileUpload($request->file('photo'), 'update' , 'Event' , $Event->photo);

            Event::findOrFail($id)->update($data);
            return responseSuccess('' , getStatusText(UPDATE_EVENT_SUCCESS_CODE)  , UPDATE_EVENT_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Remove the specified Event from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Event::findOrFail($id)->delete();
            return responseSuccess('', getStatusText(DELETE_EVENT_CODE), DELETE_EVENT_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

}
