<?php

use Illuminate\Database\Seeder;
use App\Entities\RequestShip;

class RequestShipsTableSeeder extends Seeder
{
    use MasterTableTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = DB::table('package_owners')->limit(10)->pluck('user_id');

        $records = [
            [
                "id" => 1,
                "user_id" => $userIds[0],
                "promo_code_id" => 1,
                "package_type_id" => 1,
                "receiver_name" => "Vo Van Hoan",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\":16.065007, \"longitude\":108.219038}",
                "destination" => "{\"latitude\": 16.065801, \"longitude\": 108.192216}",
                "price" => 12000.00,
                "distance" => 3.00,
                "duration" => 600,
                "size" => "{\"length\": 15, \"width\": 20, \"height\": 15}",
                "note" => "Hoan dep trai",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "27 Hoàng Diệu, Q. Hải Châu, Đà Nẵng, Vietnam",
                "destination_address" => "Điện Biên Phủ, Thanh Khê, Đà Nẵng, Vietnam",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
            [
                "id" => 2,
                "user_id" => $userIds[1],
                "promo_code_id" => 1,
                "package_type_id" => 6,
                "receiver_name" => "Nguyen Van Hung",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\":16.0511501, \"longitude\":108.22090109999999}",
                "destination" => "{\"latitude\": 16.072399, \"longitude\": 108.193332}",
                "price" => 20000.00,
                "distance" => 5.00,
                "duration" => 800,
                "size" => "null",
                "note" => "string",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "59/19 Núi Thành, Hòa Thuận Đông, Q. Hải Châu, Đà Nẵng, Vietnam",
                "destination_address" => "907 Đương Nguyễn Tất Thành, Xuân Hà, Thanh Khê, Đà Nẵng, Vietnam",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
            [
                "id" => 3,
                "user_id" => $userIds[2],
                "promo_code_id" => 1,
                "package_type_id" => 2,
                "receiver_name" => "Le Hai Nghi",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\": 16.064597, \"longitude\": 108.218756}",
                "destination" => "{\"latitude\": 16.072399, \"longitude\": 108.193332}",
                "price" => 15000.00,
                "distance" => 3.00,
                "duration" => 600,
                "size" => "{\"length\": 30, \"width\": 30, \"height\": 45}",
                "note" => "Nghi de thuiong",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "69-47 Hoàng Diệu, Hải Châu, Đà Nẵng, Vietnam",
                "destination_address" => "907 Đương Nguyễn Tất Thành, Xuân Hà, Thanh Khê, Đà Nẵng, Vietnam",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
            [
                "id" => 4,
                "user_id" => $userIds[3],
                "promo_code_id" => 1,
                "package_type_id" => 3,
                "receiver_name" => "Le Nhi Nhi",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\":16.066697, \"longitude\":108.232925}",
                "destination" => "{\"latitude\":16.071524, \"longitude\":108.213193}",
                "price" => 20000.00,
                "distance" => 4.00,
                "duration" => 880,
                "size" => "{\"length\": 15, \"width\": 20, \"height\": 15}",
                "note" => "string",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "538-540 QL14B, An Hải Tây, Sơn Trà, Đà Nẵng, Vietnam",
                "destination_address" => "203-179 Ông Ích Khiêm, Hải Châu, Đà Nẵng, Vietnam",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
            [
                "id" => 5,
                "user_id" => $userIds[4],
                "promo_code_id" => 1,
                "package_type_id" => 3,
                "receiver_name" => "Ngo Nghi Nghi",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\":16.066697, \"longitude\":108.232925}",
                "destination" => "{\"latitude\":16.071524, \"longitude\":108.213193}",
                "price" => 19000.00,
                "distance" => 4.00,
                "duration" => 880,
                "size" => "{\"length\": 15, \"width\": 20, \"height\": 15}",
                "note" => "string",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "538-540 QL14B, An Hải Tây, Sơn Trà, Đà Nẵng, Vietnam",
                "destination_address" => "203-179 Ông Ích Khiêm, Hải Châu, Đà Nẵng, Vietnam",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
            [
                "id" => 6,
                "user_id" => $userIds[2],
                "promo_code_id" => 1,
                "package_type_id" => 7,
                "receiver_name" => "Nghi Nhan",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\":16.049318000000003,\"longitude\":108.21979499999999}",
                "destination" => "{\"latitude\":16.060581,\"longitude\":108.21453299999999}",
                "price" => 10000.00,
                "distance" => 1.78,
                "duration" => 437,
                "size" => null,
                "note" => "string",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "10 Duy Tân",
                "destination_address" => "80 Nguyễn Văn Linh",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
            [
                "id" => 7,
                "user_id" => $userIds[5],
                "promo_code_id" => 1,
                "package_type_id" => 7,
                "receiver_name" => "Nghi Ong",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\":16.049318000000003,\"longitude\":108.21979499999999}",
                "destination" => "{\"latitude\":16.051433,\"longitude\":108.22056099999999}",
                "price" => 10000.00,
                "distance" => 0.46,
                "duration" => 114,
                "size" => null,
                "note" => "string",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "10 Duy Tân",
                "destination_address" => "80 Núi Thành",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
            [
                "id" => 10,
                "user_id" => $userIds[6],
                "promo_code_id" => 1,
                "package_type_id" => 7,
                "receiver_name" => "Nghi Ho",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\":16.049318000000003,\"longitude\":108.21979499999999}",
                "destination" => "{\"latitude\":16.051433,\"longitude\":108.22056099999999}",
                "price" => 10000.00,
                "distance" => 0.46,
                "duration" => 114,
                "size" => null,
                "note" => "string",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "10 Duy Tân",
                "destination_address" => "80 Núi Thành",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
        ];

        $this->insertIgnoreRecords('request_ships', $records);
    }
}
