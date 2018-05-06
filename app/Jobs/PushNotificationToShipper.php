<?php

namespace App\Jobs;
ini_set('max_execution_time', 180);
use App\Entities\RequestShip;
use App\Entities\Shipper;
use App\Entities\Trip;
use App\Traits\DistanceMatrixServiceCustom;
use App\Traits\FirebaseConnection;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PushNotificationToShipper implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use FirebaseConnection;
    use DistanceMatrixServiceCustom;

    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shippers = Shipper::where([
            ['is_online', Shipper::ONLINE_SHIP],
            ['is_default', Shipper::STATUS_NORMAL_SHIPPER]
        ])->get()->toArray();
        $pickup = [
            'latitude' => $this->data['pickup_latitude'],
            'longitude' => $this->data['pickup_longitude']
        ];
        $pickupLocation = $this->getCoordinateFromArray($pickup);

        $filteredShippers = [];
        foreach ($shippers as $key => $shipper) {
            $shipperLocation = $this->getCoordinateFromArray([
                'latitude' => $shipper['latitude'],
                'longitude' => $shipper['longitude']
            ]);
            $distanceMatrix = $this->getDistanceMatrix($pickupLocation, $shipperLocation);
            $distance = $this->getDistanceFromResponse($distanceMatrix);

            $shippers[$key]['distance'] = $distance;

        }
        usort($shippers, function ($shipper1, $shipper2)
        {
            $rating = $shipper2['rating'] - $shipper1['rating'];
            if (floor($rating) == 0) {
                return $shipper2['distance'] - $shipper1['distance'];
            }
            return $rating;
        });

        $delayTime = 5;
        $temp = current($shippers);
        $previousRating = $temp['rating'];
        foreach ($shippers as $shipper) {
            $rating = $previousRating - $shipper['rating'];
            if (floor($rating) != 0) {
                $previousRating = $shipper['rating'];
                sleep($delayTime);
                $delayTime += 0;
                $existedTrip = Trip::where('request_ship_id', $this->data['id'])->first();
                if ($existedTrip) { break; }
            }

            $path = "shipper/{$shipper['id']}/notification/{$this->data['id']}";
            $this->saveData($path, $this->data);
        }
    }

}
