<?php

namespace App\Http\Controllers\PackageOwner;

use App\Entities\RequestShip;
use App\Entities\RequestTracking;
use App\Http\Controllers\ApiController;
use App\Traits\FirebaseConnection;
use App\Traits\SMSTrait;
use App\Traits\UpdateRequestTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageOwnerTripController extends ApiController
{
    use UpdateRequestTracking;
    use SMSTrait;
    use FirebaseConnection;

    public function update(Request $request, $requestShipId)
    {
        $rules = [
            'verification_code' => 'required|string',
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $requestShip = RequestShip::findOrFail($requestShipId);
        $requestShipOwner = $requestShip->user()->first();

        // Verify code sent
        $response = $this->verifyCodeSent($requestShipOwner->phone, $data['verification_code']);
        $responseObject = json_decode($response);
        if (!$responseObject->success) {
            $message = array(
                'success' => false,
                'message' => $responseObject->message,
                'code' => 401
            );
            return response()->json($message, 401);
        }

        // Send verification code to receiver
        $receiverPhone = $requestShip->receiver_phone;
        $response = $this->sendVerifySMS($receiverPhone);
        $responseObject = json_decode($response);
        if (!$responseObject->success) {
            $message = array(
                'success' => false,
                'message' => $responseObject->message,
                'code' => 500
            );
            return response()->json($message, 500);
        }

        // Prepare data for request tracking before insert
        $status = RequestTracking::DELIVERING_TRIP;
        $this->updateRequestTracking($requestShipOwner->id, $requestShip->id, $status);

        // Update request ship status on firebase
        $path = "package/package-owner/{$requestShipOwner->id}/{$requestShip->id}/status";
        $this->saveData($path, $status);

        $shipperId = Auth::user()->id;
        $path = "package/shipper/{$shipperId}/{$requestShip->id}/status";
        $this->saveData($path, $status);

        $message = array(
            'success' => true,
            'message' => 'The request ship was confirmed by package owner successfully',
            'code' => 200
        );
        return response()->json($message, 200);
    }
}
