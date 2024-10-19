<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pushnotification;
use App\Http\Requests\Dashboard\PushNotificationRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PushNotificationController extends Controller
{
    public function index()
    {
        $data = [
            'Pushnotifications' => Pushnotification::orderBy('id', 'DESC')->get() ,
            'Users'             => User::whereNotNull('fcm_token')->get()         ,
        ];
        return view('Dashboard.Pages.PushNotifications.index', compact('data'));
    }


    private function push_notification($fcm_token, $title, $body)
    {
        $notification = [
            "registration_ids" => $fcm_token,
            "notification" => [
                "title"       => $title,
                "body"        => $body,
                "created_at"  => Carbon::now(),
            ]
        ];
        $dataString = json_encode($notification);
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_exec($ch);

        return true;
    }

    public function store(PushNotificationRequest $request)
    {
        $users = User::select('id', 'fcm_token')->whereIn('id', $request->users)->whereNotNull('fcm_token')->get();
        foreach ($users as $user) {
            $this->push_notification($user->fcm_token, $request->title, $request->body);
            Pushnotification::create([
                'title'   => $request->title,
                'body'    => $request->body,
                'user_id' =>  $user->id,
            ]);
        }

        return back()->with('message', 'Data added Successfully');
    }


       // read notification by id
       public function readNotification($id)
       {
           if ($id )
           {
               Auth::user()->unreadNotifications->where('id', $id)->markAsRead();
           }
           return redirect()->route('Dashboard.Users.getProfile')->with('message','Notification is readed');

       }
}
