<?php

namespace Modules\Location\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Location\App\Contracts\LocationRepositoryInterface;

class LocationController extends Controller
{
    private $locationRepo;

    public function __construct(LocationRepositoryInterface $locationRepo)
    {
        $this->locationRepo = $locationRepo;
    }

    //get country list
    public function getCountryList()
    {
        $countryDetails = $this->locationRepo->getCountryList();
        return $this->apiResponse($countryDetails, 200, true, 'country details retrieved successfully');
    }

    //get province list
    public function getProvinceList()
    {
        $provinceDetails = $this->locationRepo->getProvinceList();
        return $this->apiResponse($provinceDetails, 200, true, 'province details retrieved successfully');
    }

    //get district list by province id
    public function getDistrictByProvinceId($provinceId)
    {
        if ($provinceId) {
            $districtDetails = $this->locationRepo->getDistrictByProvinceId($provinceId);
            return $this->apiResponse($districtDetails, 200, true, 'district details retrieved successfully');
        }
    }
}
