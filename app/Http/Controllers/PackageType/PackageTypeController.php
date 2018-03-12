<?php

namespace App\Http\Controllers\PackageType;

use App\Entities\PackageType;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class PackageTypeController extends ApiController
{
    public function getOptionalPackageTypes()
    {
        $optionPackages = PackageType::where('optional_package', PackageType::OPTIONAL_PACKAGE)
            ->get();
        return $this->showAll($optionPackages);
    }

    public function getNormalPackageTypes()
    {
        $optionPackages = PackageType::where('optional_package', PackageType::NORMAL_PACKAGE)
            ->get();
        return $this->showAll($optionPackages);
    }

}
