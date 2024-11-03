<?php

namespace App\Http\Controllers\API\Lookup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\Lookup;
use App\Http\Resources\API\Lookup\LookupResource;
use App\Http\Resources\API\Lookup\CountryResource;

class LookupController extends Controller
{

    /**
     * Returns a collection of countries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function countries()
    {
        try{
            $countries    = Country::all();
            return responseSuccess( CountryResource::collection($countries) , getStatusText(LOOKUPS_SUCCESS_CODE)  , LOOKUPS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Returns a collection of gender lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function genders()
    {
        try{
            return $this->fetchLookupByCode('U-Gender');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Returns a collection of region lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function regions()
    {
        try{
            return $this->fetchLookupByCode('U-Reigon');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Returns a collection of material status lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function materialStatus()
    {
        try{
            return $this->fetchLookupByCode('U-MaterialStatus');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Returns a collection of work type lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function workTypes()
    {
        try{
            return $this->fetchLookupByCode('U-Worktype');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Returns a collection of contract type lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function contractTypes()
    {
        try{
            return $this->fetchLookupByCode('U-ContractType');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Returns a collection of user status lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function statusUser()
    {
        try{
            return $this->fetchLookupByCode('U-StatusUser');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Returns a collection of Attendance status lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function statusAttendance()
    {
        try{
            return $this->fetchLookupByCode('U-StatusAttendance');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
     /**
     * Returns a collection of reason leave lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function reasonLeave()
    {
        try{
            return $this->fetchLookupByCode('U-ReasonLeave');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
     /**
     * Returns a collection of leave status lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function statusLeave()
    {
        try{
            return $this->fetchLookupByCode('U-StatusLeave');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
     /**
     * Returns a collection of asset Types lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function assetTypes()
    {
        try{
            return $this->fetchLookupByCode('U-TypeAsset');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
     /**
     * Returns a collection of vacation Types lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function vacationTypes()
    {
        try{
            return $this->fetchLookupByCode('U-TypeVacation');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
     /**
     * Returns a collection of missingPunch Types lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function missingPunchTypes()
    {
        try{
            return $this->fetchLookupByCode('U-TypeMissingPunch');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
     /**
     * Returns a collection of document Types lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function documentTypes()
    {
        try{
            return $this->fetchLookupByCode('U-TypeDocument');
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Fetches lookup data by a specific code.
     *
     * @param string $code The lookup code.
     * @return \Illuminate\Database\Eloquent\Collection The collection of lookup items.
     */
    private function fetchLookupByCode(string $code)
    {
        $data  =  Lookup::where('code', $code)->get();
        return responseSuccess( LookupResource::collection($data) , getStatusText(LOOKUPS_SUCCESS_CODE)  , LOOKUPS_SUCCESS_CODE );
    }

}
