<?php

namespace App\Http\Controllers\Shipper;

use App\Traits\FirebaseConnection;
use App\Traits\SMSTrait;
use App\Traits\UpdateRequestTracking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\RequestTracking;
use App\Entities\RequestShip;

class ReceiverTripController extends Controller
{
    use FirebaseConnection;
    use SMSTrait;
    use UpdateRequestTracking;

    public function update(Request $request, $requestShipId)
    {
        $rules = [
            'receiver_verification_code' => 'required|string',
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $requestShip = RequestShip::findOrFail($requestShipId);
        $requestShipOwner = $requestShip->user()->first();

        // Check verified package owner code before verifying OTP code
        if ($requestShip->isVerifiedReceiverCode()) {
            $message = array(
                'success' => false,
                'message' => "This code was verified",
                'code' => 403
            );
            return response()->json($message, 403);
        }

        // Verify code sent
        if ($requestShip['receiver_verification_code'] != $data['receiver_verification_code']) {
            $message = array(
                'success' => false,
                'message' => "Package owner verification code didnt match",
                'code' => 401
            );
            $status = 401;
        } else {
            // Prepare data for request tracking before insert
            $statusTrip = RequestTracking::COMPLETED_TRIP;
            $this->updateRequestTracking($requestShipOwner->id, $requestShip->id, $statusTrip);
            // Update status of receiver verification code
            $requestShip->verified_receiver_code = RequestShip::VERIFIED_RECEIVER_CODE;
            $requestShip->save();
            // Update request ship status on firebase
            $path = "package-owner/{$requestShipOwner->id}/request-ship/{$requestShip->id}";
            $requestT = $this->retrieveData($path);
            $requestT['status'] = $statusTrip;
            $this->deleteData($path);

            $path = "package-owner/{$requestShipOwner->id}/notification/{$requestShip->id}";
            $this->saveData($path, $requestT);

            $shipperId = $requestShip->trip()->first()->shipper_id;
            $path = "shipper/{$shipperId}/request-ship/{$requestShip->id}";
            $this->deleteData($path);

            $message = array(
                'success' => true,
                'message' => 'Receiver verification code was verified',
                'code' => 200
            );
            $status = 200;

        }
        return response()->json($message, $status);
    }
}
