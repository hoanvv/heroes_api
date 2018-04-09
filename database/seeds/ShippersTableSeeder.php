<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippersTableSeeder extends Seeder
{
    use \App\Traits\FirebaseConnection;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shippers = DB::table('shippers')->select('id', 'latitude', 'longitude')->get();

        foreach ($shippers as $shipper) {
            $path = "shipper/{$shipper->id}/tracking/";
            $data['latitude'] = $shipper->latitude;
            $data['longitude'] = $shipper->longitude;

            $this->saveData($path, $data);
        }
    }
}
