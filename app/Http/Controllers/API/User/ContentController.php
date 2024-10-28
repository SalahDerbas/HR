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
        // Lookup the type ID using the provided key
        $typeID = getIDLookups($key);

        // Fetch the content based on type ID and status
        $data = Content::where(['type_id' => $typeID, 'status' => 1])->first();

        // If no content is found, return an appropriate success response with an empty message
        if (is_null($data)) {
            return responseSuccess('', getStatusText(CONTENT_EMPTY_CODE), CONTENT_EMPTY_CODE);
        }

        // Return the found content wrapped in a resource, along with success status
        return responseSuccess(new ContentResource($data), getStatusText(CONTENT_SUCCESS_CODE), CONTENT_SUCCESS_CODE);
    }

    /**
     * Get the Terms and Conditions content.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response with Terms and Conditions content.
     */
    public function getTermsConditions()
    {
        return $this->getContentData('terms_conditions');
    }

    /**
     * Get the Privacy Policy content.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response with Privacy Policy content.
     */
    public function getPrivacyPolicy()
    {
        return $this->getContentData('privacy_policy');
    }

    /**
     * Get the About Us content.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response with About Us content.
     */
    public function getAboutUs()
    {
        return $this->getContentData('about_us');
    }

    /**
     * Get the FAQ content.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response with FAQ content.
     */
    public function getFAQ()
    {
        return $this->getContentData('FAQ');
    }

    /**
     * Get the Sliders content.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response with Sliders content.
     */
    public function getSliders()
    {
        return $this->getContentData('sliders');
    }

    /**
     * send email for contact us content.
     *
     * @return a success response indicating the email was sent successfully
     */

    public function contactUs(ContentRequest $request)
    {
        $data =  $request->all();
        Mail::to( env('MAIL_HOST_SUPPORT') )->send(new SendContactUsMail($data));

        return responseSuccess('', getStatusText(CONTACT_US_SUCCESS_CODE), CONTACT_US_SUCCESS_CODE);
    }
}
