<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pushnotification;

class NotificationController extends Controller
{
    public function list()
    {
        $Notifcations = NotifcationsFile::where('user_id' , auth::id())->get();

        if($Notifcations->isEmpty())
            return responseSuccess([], getStatusText(NOTIFICATION_USER_EMPTY), NOTIFICATION_USER_EMPTY);

        return responseSuccess($Notifcations, getStatusText(LIST_NOTIFICATIONS_SUCCESS_CODE)  , LIST_NOTIFICATIONS_SUCCESS_CODE );

    }
}
