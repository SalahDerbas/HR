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
        $countries    = Country::all();
        return responseSuccess( CountryResource::collection($countries) , getStatusText(LOOKUPS_SUCCESS_CODE)  , LOOKUPS_SUCCESS_CODE );
    }

    /**
     * Returns a collection of gender lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function genders()
    {
        return $this->fetchLookupByCode('U-Gender');
    }

    /**
     * Returns a collection of region lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function regions()
    {
        return $this->fetchLookupByCode('U-Reigon');
    }

    /**
     * Returns a collection of material status lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function materialStatus()
    {
        return $this->fetchLookupByCode('U-MaterialStatus');
    }

    /**
     * Returns a collection of work type lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function workTypes()
    {
        return $this->fetchLookupByCode('U-Worktype');
    }

    /**
     * Returns a collection of contract type lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function contractTypes()
    {
        return $this->fetchLookupByCode('U-ContractType');
    }

    /**
     * Returns a collection of user status lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function statusUser()
    {
        return $this->fetchLookupByCode('U-StatusUser');
    }

    /**
     * Returns a collection of Attendance status lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function statusAttendance()
    {
        return $this->fetchLookupByCode('U-StatusAttendance');
    }
     /**
     * Returns a collection of reason leave lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function reasonLeave()
    {
        return $this->fetchLookupByCode('U-ReasonLeave');
    }
     /**
     * Returns a collection of leave status lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function statusLeave()
    {
        return $this->fetchLookupByCode('U-StatusLeave');
    }
     /**
     * Returns a collection of asset Types lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function assetTypes()
    {
        return $this->fetchLookupByCode('U-TypeAsset');
    }
     /**
     * Returns a collection of vacation Types lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function vacationTypes()
    {
        return $this->fetchLookupByCode('U-TypeVacation');
    }
     /**
     * Returns a collection of missingPunch Types lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function missingPunchTypes()
    {
        return $this->fetchLookupByCode('U-TypeMissingPunch');
    }
     /**
     * Returns a collection of document Types lookups.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function documentTypes()
    {
        return $this->fetchLookupByCode('U-TypeDocument');
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
