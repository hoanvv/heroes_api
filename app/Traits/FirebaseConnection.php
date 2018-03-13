<?php

namespace App\Traits;


use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Factory;

trait FirebaseConnection
{
    protected function registerService()
    {
        return ServiceAccount::fromJsonFile(__DIR__.'/heroes-4875a-firebase-adminsdk-ll17y-5d14066fd1.json');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $path
     * @param $value
     * @return void
     */
    protected function saveDataWithoutAuthentication($path, $value)
    {
        $firebase = (new Factory())
            ->withServiceAccount($this->registerService())
            ->create();
        $db = $firebase->getDatabase();

        $db->getReference($path)
            ->set($value);
    }
}