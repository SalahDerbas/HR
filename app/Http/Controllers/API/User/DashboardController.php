<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\API\User\DashboardResource;

class DashboardController extends Controller
{
    /**
     * Retrieves the authenticated user's dashboard data and returns a success response.
     *
     * This function finds the user by their authenticated ID, formats the data using
     * a DashboardResource, and returns a successful response. If an error occurs during
     * the process, an error response is returned.
     *
     * @return \Illuminate\Http\JsonResponse The success or error JSON response.
     * @author Salah Derbas
     */
    public function index()
    {
        try{
            $user = User::findOrFail(Auth::id());
            return responseSuccess(new DashboardResource($user), getStatusText(DASHBOARD_SUCCESS_CODE), DASHBOARD_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
}
