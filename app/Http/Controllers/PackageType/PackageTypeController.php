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

        $otherPackage = collect([
            "id" => 0,
            "name" => "Others",
            "description" => null,
            "optional_package" => 0,
            "start_weight" => null,
            "end_weight" => null,
            "price" => null,
            "created_at" => null,
            "updated_at" => null
        ]);
        $optionPackages->push($otherPackage);

        return $this->showAll($optionPackages);
    }

}
