<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\API\User\DashboardResource;

class DashboardController extends Controller
{
    public function index()
    {
        try{
            $user = User::findOrFail(Auth::id());
            return $user->getSickLeave();
            return new DashboardResource($user);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
}
