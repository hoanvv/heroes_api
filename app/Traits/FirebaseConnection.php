<?php

namespace App\Traits;


use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Factory;

trait FirebaseConnection
{
    protected function registerServiceWithoutAuthentication()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/heroes-4875a-firebase-adminsdk-ll17y-5d14066fd1.json');
//        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/heroes-demo-6e61e-firebase-adminsdk-puc6r-1826563424.json');
        $firebase = (new Factory())
            ->withServiceAccount($serviceAccount)
            ->create();
        $db = $firebase->getDatabase();

        return $db;
    }

    /**
     * Retrieve data from firebase real time database .
     *
     * @param $path
     * @return mixed $value
     */
    protected function retrieveData($path)
    {
        $db = $this->registerServiceWithoutAuthentication();

        $reference = $db->getReference($path);
        $snapshot = $reference->getSnapshot();

        $value = $snapshot->getValue();

        return $value;
    }

    /**
     * Insert data into firebase real time database .
     *
     * @param $path
     * @param $value
     * @return void
     */
    protected function saveData($path, $value)
    {
        $db = $this->registerServiceWithoutAuthentication();

        $db->getReference($path)
            ->set($value);
    }

    /**
     * delete data from firebase real time database .
     *
     * @param $path
     * @return void
     */
    protected function deleteData($path)
    {
        $db = $this->registerServiceWithoutAuthentication();

        $db->getReference($path)
            ->remove();
    }
}