<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\API\User\ContentResource;
use App\Models\Content;
use App\Http\Requests\API\User\ContentRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendContactUsMail;



class ContentController extends Controller
{
    /**
     * Retrieve content data based on the specified key.
     *
     * @param string $key The key representing the content type.
     * @return \Illuminate\Http\JsonResponse The JSON response with content data or an error message.
     */
    private function getContentData($key)
    {
        $typeID = getIDLookups($key);

        $data = Content::where(['type_id' => $typeID, 'status' => 1])->first();
        if (is_null($data))
            return responseSuccess('', getStatusText(CONTENT_EMPTY_CODE), CONTENT_EMPTY_CODE);

        return responseSuccess(new ContentResource($data), getStatusText(CONTENT_SUCCESS_CODE), CONTENT_SUCCESS_CODE);
    }

    /**
     * Get the Terms and Conditions content.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response with Terms and Conditions content.
     */
    public function getTermsConditions()
    {
        try{
            return $this->getContentData('terms_conditions');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Get the Privacy Policy content.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response with Privacy Policy content.
     */
    public function getPrivacyPolicy()
    {
        try{
            return $this->getContentData('privacy_policy');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Get the About Us content.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response with About Us content.
     */
    public function getAboutUs()
    {
        try{
            return $this->getContentData('about_us');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Get the FAQ content.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response with FAQ content.
     */
    public function getFAQ()
    {
        try{
            return $this->getContentData('FAQ');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Get the Sliders content.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response with Sliders content.
     */
    public function getSliders()
    {
        try{
            return $this->getContentData('sliders');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * send email for contact us content.
     *
     * @return a success response indicating the email was sent successfully
     */

    public function contactUs(ContentRequest $request)
    {
        try{
            $data =  $request->all();
            Mail::to( env('MAIL_HOST_SUPPORT') )->send(new SendContactUsMail($data));

            return responseSuccess('', getStatusText(CONTACT_US_SUCCESS_CODE), CONTACT_US_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
}
