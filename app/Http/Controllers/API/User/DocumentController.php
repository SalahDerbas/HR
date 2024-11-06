<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\User\DocumentRequest;
use App\Http\Resources\API\User\DocumentResource;
use App\Models\Document;

class DocumentController extends Controller
{
    /**
     * Display a listing of the user's Document's.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Document::where(['user_id' => Auth::id() ])->with(['getDocumentType'])->get();

            if($data->isEmpty())
                return responseSuccess('', getStatusText(DOCUMENT_EMPTY_CODE), DOCUMENT_EMPTY_CODE);

            return responseSuccess(DocumentResource::collection($data) , getStatusText(DOCUMENTS_SUCCESS_CODE)  , DOCUMENTS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Store a newly created Document in storage.
     *
     * @param  \App\Http\Requests\API\User\DocumentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        try{
            $DocumentData                    = $request->all();
            $DocumentData['user_id']         = Auth::id();

            if ($request->file('document'))
                $DocumentData['document']       = UploadPhotoUser($request->file('document'), 'store');

            Document::create($DocumentData);
            return responseSuccess('' , getStatusText(STORE_DOCUMENT_SUCCESS_CODE)  , STORE_DOCUMENT_SUCCESS_CODE);
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
            $data = Document::with(['getDocumentType'])->findOrFail($id);

            if(is_null($data))
                return responseSuccess('', getStatusText(DOCUMENT_EMPTY_CODE), DOCUMENT_EMPTY_CODE);

            return responseSuccess(new DocumentResource($data) , getStatusText(DOCUMENTS_SUCCESS_CODE)  , DOCUMENTS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Update the specified Document in storage.
     *
     * @param  \App\Http\Requests\API\User\DocumentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentRequest $request, $id)
    {
        try{
            $DocumentData                    = $request->all();
            $DocumentData['user_id']         = Auth::id();

            if ($request->file('document'))
                $DocumentData['document']      = UploadPhotoUser($request->file('document'), 'update');

            Document::findOrFail($id)->update($DocumentData);
            return responseSuccess('' , getStatusText(UPDATE_DOCUMENT_SUCCESS_CODE)  , UPDATE_DOCUMENT_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Remove the specified Document from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Document::findOrFail($id)->delete();
            return responseSuccess('', getStatusText(DELETE_DOCUMENT_CODE), DELETE_DOCUMENT_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }


}
