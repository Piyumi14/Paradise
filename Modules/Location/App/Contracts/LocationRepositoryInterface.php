<?php

namespace Modules\Location\App\Contracts;

use App\Contracts\MainRepositoryInterface;

interface LocationRepositoryInterface extends MainRepositoryInterface
{
    public function getCountryList();
    public function getProvinceList();
    public function getDistrictByProvinceId($provinceId);
}
