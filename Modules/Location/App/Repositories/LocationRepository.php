<?php

namespace Modules\Location\App\Repositories;

use App\Models\Country;
use App\Models\District;
use App\Models\Province;
use Illuminate\Contracts\Container\Container;
use App\Repositories\MainRepository;
use Modules\Location\App\Contracts\LocationRepositoryInterface;

class LocationRepository extends MainRepository implements LocationRepositoryInterface
{
    protected $app;
    public function __construct(Container $app)
    {
        $this->app = $app; // Store the container instance
    }

    /**
     * Get the model associated with the repository.
     *
     * @return string The fully qualified class name of the model.
     */
    function model()
    {
        return 'App\Models\Country';
    }

    //get country list
    public function getCountryList()
    {
        return Country::select('*')->get();
    }

    //get province list
    public function getProvinceList()
    {
        return Province::select('*')->get();
    }

    //get district list by province id
    public function getDistrictByProvinceId($provinceId)
    {
        return District::select('*')->where('province_id', $provinceId)->get();
    }
}
