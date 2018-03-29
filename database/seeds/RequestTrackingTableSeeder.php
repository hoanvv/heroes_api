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

            $pickup_location = $requestShip->only('pickup_location');
            $data = json_decode($pickup_location['pickup_location'], true);
            $extraData = $requestShip->only(['distance', 'destination_address', 'price', 'id']);
            $data = array_merge($data, $extraData);

            $status = [
                'status' => $temp['status'],
                'is_shown' => 1
            ];
            $data = array_merge($data, $status);

            $this->saveData($path, $data);
            unset($temp);
            unset($data);
        }

        $this->insertIgnoreRecords('request_trackings', $records);

    }
}
