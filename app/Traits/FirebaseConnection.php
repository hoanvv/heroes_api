<?php

namespace App\Traits;


use Kreait\Firebase\ServiceAccount;

trait FirebaseConnection
{
    protected function registerService()
    {
        return ServiceAccount::fromJsonFile(__DIR__.'/heroes-4875a-firebase-adminsdk-ll17y-5d14066fd1.json');
    }

}