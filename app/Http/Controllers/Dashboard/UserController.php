<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Dashboard\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UpdateInformationUser;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'Users'   => User::with('roles')->get(),
            'roles'   => Role::pluck('name', 'name')->all(),
        ];

        return view('Dashboard.Pages.Users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $Users = new User();
            $Users->name           = $request->name;
            $Users->password       = Hash::make($request->password);
            $Users->gender         = $request->gender;
            $Users->material_status = $request->material_status;
            $Users->status         = $request->status;
            $Users->firstname      = $request->firstname;
            $Users->lastname       = $request->lastname;
            $Users->email          = $request->email;
            $Users->phone          = $request->phone;

            if ($request->file('photo'))
                $Users->photo = UploadPhotoUser($request->file('photo'), 'store');

            $Users->save();
            $Users->assignRole($request->input('roles_name'));

            return redirect()->route('Dashboard.Users.index')->with('message', 'Data added Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function activate($id)
    {
        try {
            $User =  User::findOrFail($id);
            $User->status = ($User->status === "Active") ? "Inactive" : "Active";
            $User->save();

            return redirect()->route('Dashboard.Users.index')->with('message', 'User Updated Status Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
        try {
            $Users = User::findOrFail($request->id);

            $Users->name           = $request->name;
            $Users->password       = Hash::make($request->password);
            $Users->gender         = $request->gender;
            $Users->material_status = $request->material_status;
            $Users->status         = $request->status;
            $Users->firstname      = $request->firstname;
            $Users->lastname       = $request->lastname;
            $Users->email          = $request->email;
            $Users->phone          = $request->phone;
            if ($request->file('photo'))
                $Users->photo = UploadPhotoUser($request->file('photo'), 'update');

            $Users->save();

            DB::table('model_has_roles')->where('model_id', $Users->id)->delete();
            $Users->assignRole($request->input('roles'));

            return redirect()->route('Dashboard.Users.index')->with('info', 'Data update Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRequest $request)
    {
        try {
            User::findOrFail($request->id)->delete();
            return redirect()->route('Dashboard.Users.index')->with('warning', 'Data delete Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updateProfile(UserRequest $request)
    {
        $Users                 =  User::findOrFail(Auth::id());
        $Users->name           = $request->name;
        $Users->gender         = $request->gender;
        $Users->material_status = $request->material_status;
        $Users->firstname      = $request->firstname;
        $Users->lastname       = $request->lastname;
        $Users->email          = $request->email;
        $Users->phone          = $request->phone;

        if ($request->file('photo'))
            $Users->photo = UploadPhotoUser($request->file('photo'), 'update');

        $Users->save();

        Notification::send($Users, new UpdateInformationUser($Users));

        return redirect()->route('Dashboard.Users.getProfile')->with('info', 'Data update Successfully');
    }



    public function getProfile()
    {
        return view('Dashboard.Pages.Users.profile');
    }

    public function resetPassword()
    {
        return view('Dashboard.Pages.Users.changepassword');
    }
    public function updatePassword(UserRequest $request)
    {
        try {
            User::whereId(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
            return back()->with('message', 'Password updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
