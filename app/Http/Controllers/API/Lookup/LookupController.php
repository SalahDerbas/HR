<?php

namespace App\Http\Controllers\API\Lookup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\Lookup;
use App\Http\Resources\API\Lookup\LookupResource;

class LookupController extends Controller
{
    public function countries()
    {
        $countries    = Country::all();
        return $countries;
    }
    /**
     * Fetches lookup data based on the provided code.
     *
     * @param string $code The lookup code.
     * @return \Illuminate\Database\Eloquent\Collection The collection of lookup items.
     */
    private function getLookup(string $code)
    {
        $data  =  Lookup::where('code', $code)->get();
        return responseSuccess( LookupResource::collection($data) , getStatusText(LOOKUPS_SUCCESS_CODE)  , LOOKUPS_SUCCESS_CODE );
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
     * Fetches lookup data by a specific code.
     *
     * @param string $code The lookup code.
     * @return \Illuminate\Database\Eloquent\Collection The collection of lookup items.
     */
    private function fetchLookupByCode(string $code)
    {
        return $this->getLookup($code);
    }


}
