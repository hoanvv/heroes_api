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
        $userIds = DB::table('package_owners')->limit(15)->pluck('user_id');

        $records = [
            [
                "id" => 1,
                "user_id" => $userIds[0],
                "promo_code_id" => 1,
                "package_type_id" => 1,
                "receiver_name" => "Vo Van Hoan",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\":16.073671, \"longitude\":108.152005}",// 16.073671, 108.152005
                "destination" => "{\"latitude\": 16.078196, \"longitude\": 108.170124}", //16.078196, 108.170124
                "price" => 15000.00,
                "distance" => 3.20,
                "duration" => 540,
                "size" => "{\"length\": 15, \"width\": 20, \"height\": 15}",
                "note" => "Nothing",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "32 Ngô Sĩ Liên, Hòa Khánh Bắc, Liên Chiểu, Đà Nẵng",
                "destination_address" => "25 Phùng Hưng, Thanh Khê, Liên Chiểu, Đà Nẵng",
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
                "pickup_location" => "{\"latitude\":16.069953, \"longitude\":108.152850}", // 16.069953, 108.152850
                "destination" => "{\"latitude\": 16.072399, \"longitude\": 108.193332}",
                "price" => 20000.00,
                "distance" => 5.60,
                "duration" => 650,
                "size" => null,
                "note" => "It is easy to break",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "27 Ngô Thì Nhậm, Hòa Khánh Bắc, Liên Chiểu, Đà Nẵng",
                "destination_address" => "893 Đương Nguyễn Tất Thành, Xuân Hà, Thanh Khê, Đà Nẵng",
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
                "pickup_location" => "{\"latitude\": 16.076494, \"longitude\": 108.146072}", // 16.076494, 108.146072
                "destination" => "{\"latitude\": 16.072399, \"longitude\": 108.193332}",
                "price" => 25000.00,
                "distance" => 6.90,
                "duration" => 700,
                "size" => "{\"length\": 30, \"width\": 30, \"height\": 45}",
                "note" => "Nothing",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "24 Lạc Long Quân, Hòa Khánh Bắc, Liên Chiểu, Đà Nẵng",
                "destination_address" => "893 Đương Nguyễn Tất Thành, Xuân Hà, Thanh Khê, Đà Nẵng",
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
                "pickup_location" => "{\"latitude\":16.076997, \"longitude\":108.148226}", //16.076997, 108.148226
                "destination" => "{\"latitude\":16.069304, \"longitude\":108.154953}", // 16.069304, 108.154953
                "price" => 10000.00,
                "distance" => 1.40,
                "duration" => 140,
                "size" => "{\"length\": 15, \"width\": 20, \"height\": 15}",
                "note" => "Nothing",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "171 Nguyễn Lương Bằng, Hòa Khánh Bắc, Liên Chiểu, Đà Nẵng",
                "destination_address" => "29 Mộc bài 4, Hòa Khánh Nam, Liên Chiểu, Đà Nẵng",
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
                "pickup_location" => "{\"latitude\":16.074530, \"longitude\":108.158064}", // 16.074530, 108.158064
                "destination" => "{\"latitude\":16.0685564, \"longitude\":108.1545659}", // 16.0685564,108.1545659
                "price" => 10000.00,
                "distance" => 1.0,
                "duration" => 120,
                "size" => "{\"length\": 15, \"width\": 20, \"height\": 15}",
                "note" => "Nothing",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "246 Hồ Tùng Mậu, Hòa Minh, Liên Chiểu, Đà Nẵng",
                "destination_address" => "18 Hà Văn Tính, Hòa Khánh Nam, Liên Chiểu, Đà Nẵng",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
            [
                "id" => 6,
                "user_id" => $userIds[2],
                "promo_code_id" => 1,
                "package_type_id" => 5,
                "receiver_name" => "Nghi Nhan",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\":16.067972,\"longitude\":108.150147}", // 16.067972, 108.150147
                "destination" => "{\"latitude\":16.056149,\"longitude\":108.166066}", // 16.056149, 108.166066
                "price" => 15000.00,
                "distance" => 2.5,
                "duration" => 400,
                "size" => null,
                "note" => "Nothing",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "37 Đặng Tất, Hòa Khánh Nam, Liên Chiểu, Đà Nẵng",
                "destination_address" => "21 Đường Hoàng Văn Thái, Hòa Minh, Liên Chiểu, Đà Nẵng",
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
                "pickup_location" => "{\"latitude\":16.071548,\"longitude\":108.158577}", // 16.071548, 108.158577
                "destination" => "{\"latitude\":16.070100,\"longitude\":108.145264}", // 16.070100, 108.145264
                "price" => 10000.00,
                "distance" => 1.7,
                "duration" => 300,
                "size" => null,
                "note" => "Nothing",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "15 Phú Thạnh 7, Hòa Minh, Liên Chiểu, Đà Nẵng",
                "destination_address" => "174 Âu Cơ, Hòa Khánh Bắc, Liên Chiểu, Đà Nẵng",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
            [
                "id" => 8,
                "user_id" => $userIds[6],
                "promo_code_id" => 1,
                "package_type_id" => 8,
                "receiver_name" => "Nghi Ho",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\":16.071241,\"longitude\":108.150480}", //16.071241, 108.150480
                "destination" => "{\"latitude\":16.071074,\"longitude\":108.217616}", //16.071074, 108.217616
                "price" => 30000.00,
                "distance" => 9,
                "duration" => 1200,
                "size" => null,
                "note" => "Nothing",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "743 Tôn Đức Thắng, Hòa Khánh Bắc, Liên Chiểu, Đà Nẵng",
                "destination_address" => "80 Lê Duẩn, Hải Châu, Đà Nẵng, Vietnam",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
            [
                "id" => 9,
                "user_id" => $userIds[8],
                "promo_code_id" => 1,
                "package_type_id" => 9,
                "receiver_name" => "Harley Davidson",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\":16.085132,\"longitude\":108.151275}", //16.085132, 108.151275
                "destination" => "{\"latitude\":16.072169,\"longitude\":108.173576}", //16.072169, 108.173576
                "price" => 14000.00,
                "distance" => 3.8,
                "duration" => 400,
                "size" => null,
                "note" => "Nothing",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "129 Nguyễn Chánh, Hòa Khánh Bắc, Liên Chiểu, Đà Nẵng, Vietnam",
                "destination_address" => "10 Kinh Dương Vương, Hòa Minh, Liên Chiểu, Đà Nẵng, Vietnam",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
            [
                "id" => 10,
                "user_id" => $userIds[10],
                "promo_code_id" => 1,
                "package_type_id" => 8,
                "receiver_name" => "Nghi Ho",
                "receiver_phone" => "0984617351",
                "pickup_location" => "{\"latitude\":16.079307,\"longitude\":108.169674}", //16.079307, 108.169674
                "destination" => "{\"latitude\":16.082541,\"longitude\":108.148126}", //16.082541, 108.148126
                "price" => 14000.00,
                "distance" => 3.1,
                "duration" => 800,
                "size" => null,
                "note" => "Nothing",
                "created_at" => \Carbon\Carbon::now(),
                "pickup_location_address" => "1775 Đương Nguyễn Tất Thành, Thanh Khê, Đà Nẵng",
                "destination_address" => "43 Nguyễn Chánh, Hòa Khánh Bắc, Liên Chiểu, Đà Nẵng",
                "po_verification_code" => RequestShip::randomCode(),
                "receiver_verification_code" => RequestShip::randomCode()
            ],
        ];

        $this->insertIgnoreRecords('request_ships', $records);
    }
}
