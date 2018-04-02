<?php

use Illuminate\Database\Seeder;

use App\Entities\RequestTracking;
use App\Traits\FirebaseConnection;
use App\Entities\RequestShip;

class RequestTrackingTableSeeder extends Seeder
{
    use MasterTableTrait;
    use FirebaseConnection;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $requestShips = RequestShip::all();
        $records = [];
        $i = 1;
        foreach ($requestShips as $requestShip) {
            $temp['id'] = $i++;
            $temp['user_id'] = $requestShip->user_id;
            $temp['request_ship_id'] = $requestShip->id;
            $temp['status'] = RequestTracking::WAITING_REQUEST;
            $temp['changed_at'] = $requestShip->created_at;

            array_push($records, $temp);
            // Insert data for request package into firebase
            $path = "package/available/{$requestShip->id}";

            $pickup_location = $requestShip->pickup_location;
            $pickup_location_array = json_decode($pickup_location, true);
            $pickup_location_array['pickup_latitude'] = $pickup_location_array['latitude'];
            unset($pickup_location_array['latitude']);
            $pickup_location_array['pickup_longitude'] = $pickup_location_array['longitude'];
            unset($pickup_location_array['longitude']);

            $destination = $requestShip->destination;
            $destination_array = json_decode($destination, true);
            $destination_array['destination_latitude'] = $destination_array['latitude'];
            unset($destination_array['latitude']);
            $destination_array['destination_longitude'] = $destination_array['longitude'];
            unset($destination_array['longitude']);

            $extraData = $requestShip->only(['distance', 'destination_address', 'pickup_location_address', 'price', 'id']);

            $status = [
                'status' => $temp['status'],
                'is_shown' => 1
            ];
            $data = array_merge($pickup_location_array, $destination_array, $extraData, $status);

            $this->saveData($path, $data);
            unset($data);
            unset($temp);
        }

        $this->insertIgnoreRecords('request_trackings', $records);

    }
}
