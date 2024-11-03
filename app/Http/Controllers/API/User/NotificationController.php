<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pushnotification;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\API\User\NotificationResource;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\API\User\NotificationRequest;

class NotificationController extends Controller
{
    /**
     * Display the push notifications for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try{
            $data = Pushnotification::where('user_id' , Auth::id())->get();

            if($data->isEmpty())
                return responseSuccess('', getStatusText(NOTIFICATION_EMPTY_CODE), NOTIFICATION_EMPTY_CODE);

            return responseSuccess(NotificationResource::collection($data) , getStatusText(NOTIFICATIONS_SUCCESS_CODE)  , NOTIFICATIONS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Toggle the notification setting for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEnable()
    {
        try{
            $user = User::find(Auth::id())->whereNotNull('fcm_token')->first();
            if (is_null($user))
                return responseError(getStatusText(USER_NOT_FOUND_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,USER_NOT_FOUND_CODE);

            $user->enable_notification = !$user->enable_notification;
            $user->save();
            return responseSuccess((boolean)$user->enable_notification, getStatusText(ENABLED_NOTIFICATION_SUCCESS_CODE)  , ENABLED_NOTIFICATION_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }


    /**
     * Stores the notification in the database.
     *
     * @param object $data The notification data.
     * @param string $firebaseToken The user's FCM token.
     * @return void
     */
    private function storeNotification($data, $firebaseToken)
    {
        Pushnotification::create([
            'title_en'        =>   $data->title_en,
            'title_ar'        =>   $data->title_ar,
            'body_en'         =>   $data->body_en,
            'body_ar'         =>   $data->body_ar,
            'user_id'         =>   User::where('fcm_token', $firebaseToken)->pluck('id')->first()
        ]);
    }

    /**
     * Sends push notifications to the specified FCM tokens.
     *
     * @param array $fcmTokens Array of FCM tokens.
     * @param object $data The notification data.
     * @return void
     */
    private function pushNotificationByFirebase($fcmTokens, $data)
    {
        foreach ($fcmTokens as $firebaseToken) {
            $payload = json_encode([
                "registration_ids" => [$firebaseToken],
                "notification"     => [
                        "title"        => $data->title_en,
                        "body"         => $data->body_en,
                        "created_at"   => date('Y-m-d H:i:s'),
                ]
            ]);

            $headers = [
                'Authorization: key=' . env('SERVER_API_KEY'),
                'Content-Type: application/json',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            $response = curl_exec($ch);

            $this->storeNotification($data, $firebaseToken);
        }
    }

    /**
     * Sends notifications to users based on the provided request.
     *
     * @param NotificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(NotificationRequest $request)
    {
        try{
            $userIds = explode(',', $request->ids);
            $fcmTokens = User::whereIn('id', $userIds)->where('fcm_token', '!=', null)->where('enable_notification', true)->pluck('fcm_token')->toArray();

            if (collect($fcmTokens)->isEmpty())
                return responseSuccess([], getStatusText(NOTIFICATION_EMPTY_CODE), NOTIFICATION_EMPTY_CODE);

            $this->pushNotificationByFirebase($fcmTokens, $request);

            return responseSuccess('', getStatusText(SEND_NOTIFICATION_SUCCESS_CODE), SEND_NOTIFICATION_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }


}
