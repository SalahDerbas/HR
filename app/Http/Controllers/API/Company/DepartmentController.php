<?php

namespace App\Http\Controllers\API\Company;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\Company\DepartmentRequest;
use App\Http\Resources\API\Company\DepartmentResource;
use App\Models\Department;

class DepartmentController extends Controller
{

    /**
     * Display a listing of the user's Department's.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Department::all();

            if($data->isEmpty())
                return responseSuccess('', getStatusText(DEPATMENT_EMPTY_CODE), DEPATMENT_EMPTY_CODE);

            return responseSuccess(DepartmentResource::collection($data) , getStatusText(DEPATMENTS_SUCCESS_CODE)  , DEPATMENTS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Store a newly created Department in storage.
     *
     * @param  \App\Http\Requests\API\User\DepartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        try{
            $data                    = $request->all();

            Department::create($data);
            return responseSuccess('' , getStatusText(STORE_DEPATMENT_SUCCESS_CODE)  , STORE_DEPATMENT_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Display the specified Department.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = Department::findOrFail($id);

            if(is_null($data))
                return responseSuccess('', getStatusText(DEPATMENT_EMPTY_CODE), DEPATMENT_EMPTY_CODE);

            return responseSuccess(new DepartmentResource($data) , getStatusText(DEPATMENTS_SUCCESS_CODE)  , DEPATMENTS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Update the specified Department in storage.
     *
     * @param  \App\Http\Requests\API\User\DepartmentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, $id)
    {
        try{
            $data                    = $request->all();

            Department::findOrFail($id)->update($data);
            return responseSuccess('' , getStatusText(UPDATE_DEPATMENT_SUCCESS_CODE)  , UPDATE_DEPATMENT_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Remove the specified Department from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Department::findOrFail($id)->delete();
            return responseSuccess('', getStatusText(DELETE_DEPATMENT_CODE), DELETE_DEPATMENT_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

}
